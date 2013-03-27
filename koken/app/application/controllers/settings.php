<?php

class Settings extends Koken_Controller {

	function __construct()
    {
        parent::__construct();
    }

	function index()
	{
		if (!$this->auth || $this->auth_role !== 'god')
		{
			$this->error('403', 'Forbidden');
		}

		$s = new Setting;
		$settings = $s->get_iterated();

		$data = array();
		$bools = array('site_hidpi');

		foreach($settings as $setting)
		{
			$value = $setting->value;
			if (in_array($setting->name, $bools))
			{
				$value = $value == 'true';
			}

			$data[ $setting->name ] = $value;
		}

		unset($data['uuid']);

		$disable_cache_file = FCPATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'no-site-cache';
		$data[ 'enable_site_cache' ] = !file_exists( $disable_cache_file );

		if ($this->method != 'get')
		{
			if (isset($_POST['signin_bg']))
			{
				$c = new Content;
				$c->get_by_id($_POST['signin_bg']);

				if ($c->exists())
				{
					$_c = $c->to_array();
					$large = array_pop($_c['presets']);
					// TODO: Error checking for permissions reject
					$f = $large['url'];
					$to = FCPATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'wallpaper' . DIRECTORY_SEPARATOR . 'signin.jpg';

					if (extension_loaded('curl')) {
						$cp = curl_init($f);
						$fp = fopen($to, "w+");
						if (!$fp) {
							curl_close($cp);
						} else {
							curl_setopt($cp, CURLOPT_FILE, $fp);
							curl_exec($cp);
							curl_close($cp);
							fclose($fp);
						}
					} elseif (ini_get('allow_url_fopen')) {
						copy($f, $to);
					}
				}
			}
			else
			{
				$this->load->helper('file');

				if (isset($_POST['enable_site_cache']))
				{
					if ($_POST['enable_site_cache'] === 'true')
					{
						@unlink($disable_cache_file);
					}
					else
					{
						touch($disable_cache_file);
						delete_files( dirname($disable_cache_file) . DIRECTORY_SEPARATOR . 'site', true, 1 );
					}
					unset($_POST['enable_site_cache']);
				}

				// TODO: Make sure new path is not inside real_base
				// TODO: Ensure that real_base is not deleted under any circumstances
				if (isset($_POST['site_url']) && $_POST['site_url'] !== $data['site_url'])
				{
					$_POST['site_url'] = strtolower(rtrim($_POST['site_url'], '/'));

					if (empty($_POST['site_url']))
					{
						$_POST['site_url'] = '/';
					}
					$target = $_SERVER['DOCUMENT_ROOT'] . $_POST['site_url'];
					$php_include_base = rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', FCPATH), '/');
					$real_base = $_SERVER['DOCUMENT_ROOT'];

					if (empty($php_include_base))
					{
						$real_base .= '/';
					}
					else
					{
						$real_base .= $php_include_base;
					}

					@$target_dir = dir($target);
					$real_base_dir = dir($real_base);

					function compare_paths($one, $two)
					{
						return rtrim($one, '/') === rtrim($two, '/');
					}

					if ($target_dir && compare_paths($target_dir->path, $real_base_dir->path))
					{
						$_POST['site_url'] = 'default';
					}
					else
					{
						if ($target_dir)
						{
							$reserved = array('admin', 'app', 'storage');
							foreach($reserved as $dir)
							{
								$_dir = dir(rtrim($real_base_dir->path, '/') .  "/$dir");
								if (compare_paths($target_dir->path, $_dir->path))
								{
									$this->error('400', "This directory is reserved for Koken core files. Please choose another location.");
								}
							}
						}

						if (!make_child_dir($target))
						{
							$this->error('500', "Koken was not able to create the Site URL directory. Make sure the path provided is writable by the web server and try again.");
						}

						$php = <<<OUT
<?php

	\$rewrite = false;
	\$real_base_folder = '$php_include_base';
	require \$_SERVER['DOCUMENT_ROOT'] . '$php_include_base/app' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'site.php';
OUT;

						$htaccess = create_htaccess($_POST['site_url']);

						if ($this->check_for_rewrite())
						{
							$file = "$target/.htaccess";
							$file_data = $htaccess;
						}
						else
						{
							$file = "$target/index.php";
							$file_data = $php;
						}

						if (file_exists($file))
						{
							rename($file, "$file.bkup");
						}

						if (!file_put_contents($file, $file_data))
						{
							$this->error('500', "Koken was not able to create the necessary files in the Site URL directory. Make sure that path has sufficient permissions so that Koken may write the files.");
						}
					}

					if ($data['site_url'] !== 'default')
					{
						$old = $_SERVER['DOCUMENT_ROOT'] . $data['site_url'];

						if ($this->check_for_rewrite())
						{
							$old_file = $old . '/.htaccess';
						}
						else
						{
							$old_file = $old . '/index.php';
						}

						unlink($old_file);

						$backup = $old_file . '.bkup';

						if (file_exists($backup))
						{
							rename($backup, $old_file);
						}

						// This will only remove the dir if it is empty
						@rmdir($old);
					}
				}

				$save = array();
				foreach($_POST as $key => $val)
				{
					if (isset($data[$key]) && $data[$key] !== $val)
					{
						$save[$key] = $val;
					}
				}

				foreach($save as $k => $v)
				{
					$s = new Setting;
					$s->where('name', $k)->update('value', $v);
				}
			}

			$this->redirect('/settings');
		}

		$this->set_response_data($data);
	}
}

/* End of file settings.php */
/* Location: ./system/application/controllers/settings.php */