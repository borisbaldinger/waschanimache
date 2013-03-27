<?php

class Koken {
	public static $site;
	public static $settings = array();
	public static $profile;
	public static $location = array();
	public static $current_token;
	public static $rss;
	public static $categories;
	public static $page_class = false;
	public static $template_path;
	public static $fallback_path;
	public static $navigation_home_path = false;
	public static $original_url;
	public static $cache_path;
	public static $routed_variables;
	public static $draft;
	public static $preview;
	public static $rewrite;
	public static $pjax;
	public static $source;
	public static $template_variable_keys = array();
	public static $template_variables = array();
	public static $root_path;
	public static $protocol;
	public static $main_load_token = false;

	private static $last;
	private static $level = 0;
	private static $depth;
	public static $tokens = array();
	public static $url_replacements = array();
	public static $last_load_url;

	public static function parse($template)
	{

		$output = preg_replace_callback('/(<|\s)(\/)?koken\:([a-z_\-]+)([\=|\s][^\/].+?")?(\s+\/)?>/', array('Koken', 'callback'), $template);

		foreach(self::$url_replacements as $arr)
		{
			preg_match('/' . str_replace('$', '\$', $arr['url']) . ' = ([^;]+);/', $output, $match);
			list($full, $url) = $match;

			$new = "{$arr['param']}:{$arr['val']}";
			$reg = '/' . $arr['param'] . ':([^\/\']+)/';
			preg_match($reg, $url, $matches);

			if (empty($matches))
			{
				$url .= " . '/$new'";
			}
			else
			{
				if (is_numeric($arr['val']) && $matches[1] < $arr['val'])
				{
					$url = preg_replace('/' . $arr['param'] . ':[^\/\']+/', $new, $url);
				}
			}

			$output = str_replace($full, $arr['url'] . ' = ' . $url . ';', $output);
		}

		$output = preg_replace('/\{\{\s*([^\}]+)\s*\}\}/', '<?php echo Koken::out(\'$1\'); ?>', $output);

		return $output;
	}

	private static function attr_callback($matches)
	{
		$name = $matches[1];

		$value = preg_replace_callback("/{([a-z._\(\)\,\|\s\'\/\[\]0-9]+)([\s\*\-\+0-9]+)?}/", array('Koken', 'attr_replace'), $matches[2]);
		$value = trim($value, '" . ');
		$value = str_replace('"str_replace(', 'str_replace(', $value);

		if (!preg_match('/^(\((Koken::)?\$|str_replace\(|\(?empty\()/', $value))
		{
			$value = '"' . $value;
		}
		if (substr_count($value, '"') % 2 !== 0)
		{
			$value .= '"';
		}
		$value = str_replace('. "" .', '.', $value);
		if ($name === 'href')
		{
			$value = "<?php echo ( strpos($value, '/') === 0 ? Koken::\$location['root'] . $value : $value ) . ( Koken::\$preview ? '&preview=' . Koken::\$preview : '' ); ?>";
		}
		else
		{
			$value = "<?php echo $value; ?>";
		}
		return "$name=\"$value\"";
	}

	private function attr_replace($matches)
	{
		$t = new Tag();

		if (strpos($matches[1], '.replace(') !== false)
		{
			preg_match('/(.*)\.replace\((.*)\)/', $matches[1], $r_matches);
			$data = $t->field_to_keys($r_matches[1]);
			return 'str_replace(' . $r_matches[2] . ', ' . $data . ')';
		}

		$modifier = isset($matches[2]) ? $matches[2] : '';
		return '" . (' . $t->field_to_keys($matches[1]) . $modifier . ') . "';
	}

	private static function callback($matches)
	{
		$out = '';
		list($full, $start, $closing, $action) = $matches;
		$closing = $closing === '/';
		$attr = $start !== '<';

		if (isset($matches[4]))
		{
			preg_match_all('/([:a-z_\-]+)="([^"]+?)?"/', $matches[4], $param_matches);
			$parameters = array();
			$parameters['api'] = array();

			foreach($param_matches[1] as $index => $key)
			{
				if (strpos($key, 'api:') === 0)
				{
					$key = str_replace('api:', '', $key);
					$parameters['api'][$key] = $param_matches[2][$index];
				}
				else
				{
					$parameters[$key] = $param_matches[2][$index];
				}
			}

			if (empty($parameters['api']))
			{
				unset($parameters['api']);
			}
		}
		else
		{
			$parameters = array();
		}

		if (isset($matches[5]))
		{
			$self_closing = trim($matches[5]) === '/';
		}
		else
		{
			$self_closing = false;
		}

		if ($attr)
		{
			$out = preg_replace_callback('/koken:([a-z\-]+)="([^"]+?)"/', array('Koken', 'attr_callback'), $full);
		}
		else if ($action === 'else')
		{
			$else_tag = self::$last[self::$level-1];
			$out .= $else_tag->do_else();
			if ($else_tag->untokenize_on_else)
			{
				array_shift(self::$tokens);
				$else_tag->tokenize = false;
			}
		}
		else
		{
			$action = preg_replace_callback(
				'/_([a-zA-Z])/',
				create_function(
					'$matches',
					'return strtoupper($matches[1]);'
				),
				$action
			);

			if ($action === 'not')
			{
				$action = 'if';
				$parameters['_not'] = true;
			}
			else if ($action === 'pop')
			{
				$action = 'shift';
				$parameters['_pop'] = true;
			}
			else if ($action === 'permalink')
			{
				$action = 'link';
				$parameters['echo'] = true;
			} else if ($action === 'previous')
			{
				$action = 'next';
				$parameters['_prev'] = true;
			}

			$klass = 'Tag' . ucwords($action);
			$t = new $klass($parameters);

			if (!$closing)
			{
				if (!$self_closing)
				{
					self::$last[self::$level] = $t;
				}

				if ($t->tokenize)
				{
					$token = md5(uniqid());
					array_unshift(self::$tokens, $token);
				}

				$out .= trim($t->generate());

				if ($t->tokenize)
				{
					$out .= "<?php Koken::\$current_token = \$value$token; ?>";
				}
			}

			if ($self_closing || $closing)
			{
				if (!$self_closing && isset(self::$last[self::$level-1]) && method_exists(self::$last[self::$level-1], 'close'))
				{
					$close_tag = self::$last[self::$level-1];
					$out .= $close_tag->close();

					if ($close_tag->tokenize)
					{
						array_shift(self::$tokens);
						if (count(self::$tokens))
						{
							$out .= '<?php Koken::$current_token = $value' . self::$tokens[0] . '; ?>';
						}
					}
				}
				else if (method_exists($t, 'close'))
				{
					$out .= $t->close();

					if ($t->tokenize && !$t->untokenize_on_else)
					{
						array_shift(self::$tokens);
						if (count(self::$tokens))
						{
							$out .= '<?php Koken::$current_token = $value' . self::$tokens[0] . '; ?>';
						}
					}
				}

				if ($closing)
				{
					self::$level--;
				}
			}
			else
			{
				self::$level++;
			}
		}

		return $out;
	}

	public static function api($url)
	{
		$api_cache_dir = self::$root_path .
							DIRECTORY_SEPARATOR . 'storage' .
							DIRECTORY_SEPARATOR . 'cache' .
							DIRECTORY_SEPARATOR . 'api';
		$stamp = $api_cache_dir . DIRECTORY_SEPARATOR . 'stamp';
		$cache_file = $api_cache_dir . DIRECTORY_SEPARATOR . md5($url) . '.cache';

		if (file_exists($cache_file) && filemtime($cache_file) >= filemtime($stamp))
		{
			$data = file_get_contents($cache_file);
		}
		else
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, self::$protocol . '://' . $_SERVER['HTTP_HOST'] . self::$location['real_root_folder'] . '/api.php' . $url);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			$data = curl_exec($curl);
			curl_close($curl);
		}

		return json_decode($data, true);
	}

	public static function get_path($relative_path)
	{
		$primary = self::$template_path . DIRECTORY_SEPARATOR . $relative_path;
		$backup = self::$fallback_path . DIRECTORY_SEPARATOR . $relative_path;

		if (file_exists($primary))
		{
			return $primary;
		}
		else if (file_exists($backup))
		{
			return $backup;
		}
		return false;
	}

	public static function render($raw)
	{
		ob_start();
		eval('?>' . $raw);
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	public static function cache($contents)
	{

		$buster = self::$root_path . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'no-site-cache';

		if (isset(self::$cache_path) && error_reporting() == 0 && !file_exists($buster))
		{
			function make_child_dir($path)
			{
				// No need to continue if the directory already exists
				if (is_dir($path)) return true;

				// Make sure parent exists
				$parent = dirname($path);
				if (!is_dir($parent))
				{
					make_child_dir($parent);
				}

				$created = false;
				$old = umask(0);

				// Try to create new directory with parent directory's permissions
				$permissions = substr(sprintf('%o', fileperms($parent)), -4);
				if (mkdir($path, octdec($permissions), true))
				{
					$created = true;
				}
				// If above doesn't work, chmod to 777 and try again
				else if (	$permissions == '0755' &&
							chmod($parent, 0777) &&
							mkdir($path, 0777, true)
						)
				{
					$created = true;
				}
				umask($old);
				return $created;
			}

			if (make_child_dir( dirname(self::$cache_path) ))
			{
				file_put_contents(self::$cache_path, $contents);
			}
		}
	}

	public static function out($key)
	{
		$parameters = array();
		if (preg_match('/([a-z_]+)="([^"]+)"/', $key, $matches))
		{
			$key = str_replace($matches[0], '', $key);
			$parameters[$matches[1]] = $matches[2];
		}
		$key = str_replace(' ', '', $key);
		$count = false;
		if (strpos($key, '|') === false)
		{
			$globals = array(
				'site', 'location', 'profile', 'source', 'settings', 'routed_variables', 'page_variables', 'pjax'
			);

			if (strpos($key, '.length') !== false)
			{
				$key = str_replace('.length', '', $key);
				$count = true;
			}

			if (preg_match('/_on$/', $key))
			{
				$key .= '.timestamp';
				if (!isset($parameters['date_format']))
				{
					if (isset($parameters['date_only']))
					{
						$parameters['date_format'] = self::$site['date_format'];
					}
					else if (isset($parameters['time_only'])) {
						$parameters['date_format'] = self::$site['time_format'];
					}
					else
					{
						$parameters['date_format'] = self::$site['date_format'] . ' ' . self::$site['time_format'];
					}
				}
			}

			$keys = explode('.', $key);

			if (in_array($keys[0], $globals))
			{
				$return = self::$$keys[0];
				array_shift($keys);
			}
			else if (in_array($key, self::$template_variable_keys))
			{
				return self::$template_variables[$key];
			}
			else
			{
				$return = self::$current_token;
			}

			while(count($keys))
			{
				$return = $return[array_shift($keys)];
			}
		}
		else
		{
			$candidates = explode('|', $key);
			$return = '';
			while(empty($return) && count($candidates))
			{
				$return = self::out(array_shift($candidates));
			}
		}

		if ($count)
		{
			return count($return);
		}
		else
		{

			if (isset($parameters['truncate']))
			{
				$return = self::truncate($return, $parameters['truncate'], isset($parameters['after_truncate']) ? $parameters['after_truncate'] : '…');
			}

			if (isset($parameters['case']))
			{
				switch ($parameters['case']) {
					case 'lower':
						$return = strtolower($return);
						break;

					case 'upper':
						$return = strtoupper($return);
						break;

					case 'title':
						$return = ucwords($return);
						break;

					case 'sentence':
						$return = ucfirst($return);
						break;
				}
			}

			if (isset($parameters['paragraphs']))
			{
				$return = self::format_paragraphs($return);
			}

			if (isset($parameters['date_format']))
			{
				$return = date($parameters['date_format'], $return);
			}

			return $return;
		}
	}

	public static function form_link($obj, $ctx, $lightbox)
	{
		if (isset($obj['link']))
		{
			return $obj['link'];
		}
		$defaults = self::$location['defaults'];
		if (isset($obj['__koken__override']))
		{
			$type = $obj['__koken__override'];
		}
		else
		{
			if (isset($obj['album']))
			{
				$obj = $obj['album'];
			}
			$type = $obj['__koken__'] . ( $lightbox ? '_lightbox' : '' );
		}

		$url = '';

		if ($type === 'album' && $obj['album_type'] === 'set')
		{
			$type = 'set';
		}

		if (isset($defaults[$type]))
		{
			if (!$defaults[$type] && $type === 'set')
			{
				$type = 'album';
			}
			else if ($ctx && isset($ctx['id']))
			{
				if ($type === 'content' && $defaults['content_in_album'])
				{
					$type = 'content_in_album';
 				}
 				else if ($type === 'content_lightbox')
 				{
 					$type = 'content_in_album_lightbox';
 				}
			}

			if ($defaults[$type])
			{
				if (strpos($type, 'tag') === 0)
				{
					$obj['id'] = $obj['title'];
				}

				if (isset($obj['internal_id']))
				{
					$obj['id'] = $obj['internal_id'];
				}

				if (isset($obj['title']))
				{
					$obj['slug'] = preg_replace('/[^a-z0-9-]/', '-', strtolower($obj['title']));
				}

				if (isset($ctx['id']) && is_numeric($ctx['id']))
				{
					$obj['album_id'] = $ctx['id'];
				}

				$url = $defaults[$type];

				preg_match_all('/:([a-z_]+)/', $url, $matches);

				foreach($matches[1] as $magic)
				{
					$url = str_replace(':' . $magic, urlencode($obj[$magic]), $url);
				}
			}
		}

		return $url;
	}

	public static function render_nav($data, $list, $root = false, $klass = '')
	{
		$pre = $wrap_pre = $wrap_post = '';
		$post = '&nbsp;';
		if ($list)
		{
			$wrap_pre = '<ul class="k-nav-list' . ($root ? ' k-nav-root' : '') . ' ' . $klass . '">';
			$wrap_post = '</ul>';
			$pre = '<li>';
			$post = '</li>';
		}

		$o = $wrap_pre;
		foreach($data as $key => $value)
		{
			if ($value['path'] === self::$navigation_home_path)
			{
				$value['path'] = '/';
			}
			if ($value['path'] == '/')
			{
				$current = self::$location['here'] === '/';
			}
			else
			{
				$current = preg_match('/^' . str_replace('/', '\\/', $value['path']) . '(\\/.*)?$/', self::$location['here']);
			}
			$o .= $pre . '<a';
			if (isset($value['target']))
			{
				$o .= ' target="' . $value['target'] . '"';
			}
			$classes = array();
			if ($current){
				$classes[] = 'k-nav-current';
			}
			if (isset($value['set']))
			{
				$classes[] = 'k-nav-set';
			}
			if (count($classes))
			{
				$o .= ' class="' . join(' ', $classes) . '"';
			}

			$root = $value['path'] === '/' ? preg_replace( '/\/index.php$/', '', self::$location['root'] ) : self::$location['root'];
			$o .= ' href="' . ( strpos($value['path'], 'http') === false && strpos($value['path'], 'mailto:') !== 0 ? $root : '' ) . $value['path'] . ( self::$preview ? '?preview=' . self::$preview : '') . '">' . $value['label'] . '</a>';

			if (isset($value['items']) && !empty($value['items']))
			{
				$o .= self::render_nav($value['items'], $list);
			}
			$o .= $post;
		}
		return $o . $wrap_post;
	}

	static public function output_img($content, $options = array(), $params = '')
	{
		$defaults = array(
			'width' => 0,
			'height' => 0,
			'crop' => false,
			'quality' => 85,
			'sharpening' => 1,
			'hidpi' => self::$site['hidpi']
		);

		$options = array_merge($defaults, $options);

		$attr = array(
			$options['width'],
			$options['height'],
			$options['quality'],
			$options['sharpening']
		);

		$w = $options['width'];
		$h = $options['height'];

		if ($w ==0 && $h == 0)
		{
			// Responsive
			// return;
			// $w = '100%';
		}

		if (isset($content['url']) === false)
		{
			if (!$options['crop'])
			{
				if ($options['width'] == 0)
				{
					$w = round(($h*$content['width'])/$content['height']);
				}
				else if ($options['height'] == 0)
				{
					$h = round(($w*$content['height'])/$content['width']);
				}
				else
				{
					$original_aspect = $content['aspect_ratio'];
					$target_aspect = $w/$h;
					if ($original_aspect >= $target_aspect)
					{
						if ($w > $content['width'])
						{
							$w = $content['width'];
							$h = $content['height'];
						}
						else
						{
							$h = round(($w*$content['height'])/$content['width']);
						}
					}
					else
					{
						if ($h > $content['height'])
						{
							$w = $content['width'];
							$h = $content['height'];
						}
						else
						{
							$w = round(($h*$content['width'])/$content['height']);
						}
					}
				}
			}

			$url = $content['cache_path']['prefix'] . ',' . join('.', $attr);
			if ($options['crop'])
			{
				$url .= '.crop';
			}
			if ($options['hidpi'])
			{
				$url .= '.2x';
			}
			$url .= '.' . $content['cache_path']['extension'];
		}
		else
		{
			if ($options['crop'])
			{
				$content = $content['cropped'];
			} else if ($w > 0 && $h > 0)
			{
				$original_aspect = $content['width'] / $content['height'];
				$target_aspect = $w/$h;
				if ($original_aspect >= $target_aspect)
				{
					$h = round(($w*$content['height'])/$content['width']);
				}
				else
				{
					$w = round(($h*$content['width'])/$content['height']);
				}
			}
			$url = $content['url'];
		}

		if ((isset($params['class']) && strpos($params['class'], 'k-lazy-load') !== false) || $options['hidpi'])
		{
			$params['data-src'] = $url;
			$noscript = true;
			$params['src'] = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
		}
		else
		{
			$noscript = false;
			$params['src'] = $url;
		}

		if ($w > 0)
		{
			$params['width'] = $w;
		}
		if ($h > 0)
		{
			$params['height'] = $h;
		}

		if ($noscript)
		{
			$noscript_params = $params;
			$noscript_params['src'] = $noscript_params['data-src'];
			unset($noscript_params['data-src']);
			$noscript = '<noscript><img ' . self::params_to_str($noscript_params) . ' /></noscript>';
		}
		else
		{
			$noscript = '';
		}

		return "$noscript<img " . self::params_to_str($params) . " />";
	}

	static private function params_to_str($params)
	{
		$arr = array();
		foreach($params as $key => $val)
		{
			$arr[] = "$key=\"$val\"";
		}
		return join(' ', $arr);
	}

	static public function truncate($str, $limit, $after = '…')
	{
		if (strlen($str) > $limit) {
			$str = trim(substr($str, 0, $limit)) . $after;
		}

		return $str;
	}

	static public function format_paragraphs($pee, $br = 1)
	{
		if ( trim($pee) === '' )
		return '';
		$pee = $pee . "\n"; // just to make things a little easier, pad the end
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		// Space things out a little
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
		if ( strpos($pee, '<object') !== false ) {
			$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
			$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
		}
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
		// make paragraphs, including one at the end
		$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
		$pee = '';
		foreach ( $pees as $tinkle )
			$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
		$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace

		return $pee;
	}
}