<?php

class Install extends CI_Controller {

	function __construct()
    {
         parent::__construct();
    }

	function complete()
	{

		require(FCPATH . DIRECTORY_SEPARATOR . 'app' .
							DIRECTORY_SEPARATOR . 'koken' .
							DIRECTORY_SEPARATOR . 'schema.php');

		require(FCPATH . DIRECTORY_SEPARATOR . 'storage' .
							DIRECTORY_SEPARATOR . 'configuration' .
							DIRECTORY_SEPARATOR . 'database.php');

		$this->load->dbforge();
		foreach($koken_tables as $table_name => $info)
		{
			if (!isset($info['no_id']))
			{
				$this->dbforge->add_field('id');
			}
			$this->dbforge->add_field($info['fields']);
			foreach($info['keys'] as $key)
			{
				$primary = false;
				if ($key == 'id')
				{
					$primary = true;
				}
				$this->dbforge->add_key($key, $primary);
			}
			$this->dbforge->create_table($KOKEN_DATABASE['prefix'] . "$table_name");
		}

		$fullname = $_POST['first_name'] . ' ' . $_POST['last_name'];

		$settings = array(
			'site_timezone' => $_POST['timezone'],
			'console_show_notifications' => 'yes',
			'console_enable_keyboard_shortcuts' => 'yes',
			'uploading_default_license' => 'all',
			'uploading_default_visibility' => 'public',
			'uploading_default_max_download_size' => 'none',
			'site_title' => $fullname,
			'site_tagline' => 'Your site tagline',
			'site_copyright' => '© ' . $fullname,
			'site_description' => '',
			'site_keywords' => 'photography, ' . $fullname,
			'site_date_format' => 'F j, Y',
			'site_time_format' => 'g:i a',
			'site_privacy' => 'public',
			'site_hidpi' => 'true',
			'site_url' => 'default',
			'uuid' => md5($_SERVER['HTTP_HOST'] . uniqid('', true)),
		);

		foreach($settings as $name => $value)
		{
			$u = new Setting;
			$u->name = $name;
			$u->value = $value;
			$u->save();
		}

		$u = new User();
		$u->password = $_POST['password'];
		$u->email = $_POST['email'];
		$u->first_name = $_POST['first_name'];
		$u->last_name = $_POST['last_name'];
		$u->permissions = 4;
		$u->save();

		$theme = new Draft;
		$theme->path = 'elementary';
		$theme->current = 1;
		$theme->draft = 1;
		$theme->init_draft_nav();
		$theme->live_data = $theme->data;
		$theme->save();

		$h = new History();
		$h->message = 'system:install';
		$h->save($u->id);

		if (ENVIRONMENT === 'development')
		{
			$app = new Application();
			$app->token = '69ad71aa4e07e9338ac49d33d041941b';
			$app->role = 'read-write';
			$app->save();
		}

		copy(FCPATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'signin.jpg', FCPATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'wallpaper' . DIRECTORY_SEPARATOR . 'signin.jpg');

		$path = str_replace('api.php', 'app/application/httpd', $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']);
		$ch = curl_init($path);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$c = curl_exec($ch);

		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($code != 500 && $code != 403)
		{
			$htaccess = create_htaccess();
			file_put_contents(FCPATH . DIRECTORY_SEPARATOR . '.htaccess', $htaccess);
		}

		$base_folder = trim(preg_replace('/\/api\.php(.*)?$/', '', $_SERVER['SCRIPT_NAME']), '/');

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, KOKEN_STORE_URL . '/register?domain=' . $_SERVER['HTTP_HOST'] .
			'&path=/' . $base_folder .
			'&uuid=' . $settings['uuid'] .
			'&php=' . PHP_VERSION .
			'&version=' . KOKEN_VERSION .
			'&ip=' . $_SERVER['SERVER_ADDR'] .
			'&subscribe=' . (isset($_POST['subscribe']) ? $_POST['subscribe'] : '') .
			'&first=' . $_POST['first_name'] .
			'&last=' . $_POST['last_name']);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$r = curl_exec($curl);
		curl_close($curl);

		header('Content-type: application/json');
		die( json_encode(array('success' => true)) );
	}
}

/* End of file install.php */
/* Location: ./system/application/controllers/install.php */