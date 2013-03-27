<?php

class Draft extends DataMapper {

	/**
	 * Constructor: calls parent constructor
	 */
	function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	function default_templates($templates_indexed, $routes)
	{
		$default_links = $default_templates = array(
			'content' => false,
			'content_in_album' => false,
			'content_lightbox' => false,
			'content_in_album_lightbox' => false,
			'album' => false,
			'album_lightbox' => false,
			'set' => false,
			'essay' => false,
			'page' => false,
			'tag_contents' => false,
			'tag_albums' => false,
			'tag_essays' => false,
			'category_contents' => false,
			'category_albums' => false,
			'category_essays' => false,
			'archive_contents' => false,
			'archive_albums' => false,
			'archive_essays' => false,
			'albums' => false,
			'contents' => false,
			'essays' => false,
			'tags' => false,
			'archives' => false,
			'categories' => false,
		);

		foreach($routes as $info)
		{
			if (!isset($info['source']))
			{
				$info['source'] = $templates_indexed[$info['template']]['source'];
			}

			if (!isset($info['template']))
			{
				$info['template'] = $templates_indexed[$info['template']]['template'];
			}

			if (strpos($info['path'], ':id') !== false || ( strpos($info['path'], ':month') !== false && $info['source'] === 'archive'))
			{

				if (strpos($info['path'], ':album_id') !== false && $info['source'] === 'content')
				{
					$default_links['content_in_album'] = $info['path'];
					$default_templates['content_in_album'] = $info['template'];

				}
				else if ( in_array($info['source'], array( 'tag', 'category', 'archive')) && isset($info['filters']) )
				{
					$f = $info['filters'];
					$s = $info['source'];
					if (in_array("members=contents", $f))
					{
						$m = 'contents';
					}
					else if (in_array("members=albums", $f))
					{
						$m = 'albums';
					}
					else if (in_array("members=essays", $f))
					{
						$m = 'essays';
					}

					if ($m && isset($default_links["tag_$m"]))
					{
						$default_links["{$s}_$m"] = $info['path'];
						$default_templates["{$s}_$m"] = $info['template'];
					}
				}
				else if (isset($default_links[$info['source']]) && !$default_links[$info['source']] && strpos($info['path'], '.rss') === false)
				{
					$default_links[$info['source']] = $info['path'];
					$default_templates[$info['source']] = $info['template'];
				}
			}
			else if (in_array($info['source'], array('tags', 'categories', 'albums', 'contents', 'essays', 'archives')) && !$default_links[$info['source']])
			{
				if ($info['template'] === 'index')
				{
					$backup = $info;
				}
				else
				{
					$default_links[$info['source']] = $info['path'];
					$default_templates[$info['source']] = $info['template'];
				}
			}
		}

		if (isset($backup) && !$default_links[$backup['source']])
		{
			$default_links[$backup['source']] = $backup['path'];
			$default_templates[$backup['source']] = $backup['template'];
		}

		if ($default_links['content'])
		{
			$default_links['content_lightbox'] = $default_links['content'] . '/lightbox';
		}
		else
		{
			$default_links['content_lightbox'] = '/content/:id/lightbox';
		}

		if ($default_links['content_in_album'])
		{
			$default_links['content_in_album_lightbox'] = $default_links['content_in_album'] . '/lightbox';
		}
		else
		{
			$default_links['content_in_album_lightbox'] = '/content/:id/in_album/:album_id/lightbox';
		}

		if ($default_links['album'])
		{
			$default_links['album_lightbox'] = $default_links['album'] . '/lightbox';
		}
		else
		{
			$default_links['album_lightbox'] = '/albums/:id/lightbox';
		}

		return array( $default_templates, $default_links );
	}

	function init_draft_nav($refresh = true)
	{
		if ($refresh === 'nav')
		{
			$this->data = json_decode($this->data, true);
		}
		else
		{
			$this->data = array();
		}

		$ds = DIRECTORY_SEPARATOR;
		$template_path = FCPATH . 'storage' . $ds . 'themes' . $ds;
		$defaults = json_decode( file_get_contents( FCPATH . 'app' . $ds . 'site' . $ds . 'defaults.json' ), true );
		$theme_root = $template_path . $this->path . $ds;
		$template_info = json_decode( file_get_contents( $theme_root . 'info.json'), true );

		$routes = $defaults['routes'];

		if (isset($template_info['routes']))
		{
			$ci = get_instance();
			$ci->load->helper('koken');
			$routes = array_merge_custom( $defaults['routes'], $template_info['routes'] );
		}

		if (isset($template_info['templates']))
		{
			$defaults['templates'] = array_merge_custom( $defaults['templates'], $template_info['templates'] );
		}

		foreach($defaults['templates'] as $path => $info)
		{
			if ( !file_exists($theme_root . $path . '.lens') )
			{
				unset($defaults['templates'][$path]);
			}
		}

		$this->data['navigation'] = array( 'items' => array() );
		$this->data['navigation']['groups'] = $groups = array();

		$routes_for_defaults = array();

		foreach($routes as $path => $arr)
		{
			if (!isset($defaults['templates'][$arr['template']]))
			{
				unset($routes[$path]);
			}
			else
			{
				$routes_for_defaults[] = array_merge( array('path' => $path ), $arr);

				if (isset($arr['navigation']))
				{
					$to_add = array(
						'label' => $arr['navigation']['label'],
						'path' => $path,
						'front' => isset($arr['navigation']['front']) && $arr['navigation']['front']
					);
					if (isset($arr['navigation']['in_primary']) && $arr['navigation']['in_primary'] && !in_array($to_add, $this->data['navigation']['items']))
					{
						$this->data['navigation']['items'][] = $to_add;
					}
				}
			}
		}

		if (isset($template_info['navigation_groups']))
		{
			foreach($template_info['navigation_groups'] as $key => $info)
			{
				$items = array();
				if (isset($info['defaults']))
				{
					foreach($info['defaults'] as $def)
					{
						$to_add = false;
						if (is_array($def))
						{
							$to_add = array(
								'label' => $def['label'],
								'path' => $def['url']
							);
						}
						else
						{
							if (array_key_exists($def, $routes))
							{
								$to_add = array(
									'label' => $routes[$def]['navigation']['label'],
									'path' => $def
								);
							}
						}

						if ($to_add && !in_array($to_add, $items))
						{
							$items[] = $to_add;
						}
					}
				}

				$this->data['navigation']['groups'][] = array(
					'key' => $key,
					'label' => $info['label'],
					'items' => $items
				);
			}
		}

		if ($refresh === 'nav')
		{
			$this->data['routes'] = $routes;
		}
		else
		{
			$p = new Draft;
			$p->where('current', 1)->get();
			$pub_data = json_decode( $p->live_data, true);

			list($default_templates,) = $p->default_templates($defaults['templates'], $routes_for_defaults);

			if (isset($pub_data['routes']) && isset($pub_data['navigation']))
			{
				$tmp = array();
				foreach($pub_data['navigation']['items'] as $n)
				{
					if (isset($n['custom']))
					{
						$this->data['navigation']['items'][] = $n;
					}
					else if (isset($pub_data['routes'][$n['path']]))
					{
						$r = $pub_data['routes'][$n['path']];
						if (isset($r['source']) && array_key_exists($r['source'], $default_templates))
						{
							$this->data['navigation']['items'][] = $n;
							$r['template'] = $default_templates[$r['source']];
							$this->data['routes'][$n['path']] = $r;
						}

					}
				}
			}
		}

		$this->data = json_encode( $this->data );
	}

}

/* End of file category.php */
/* Location: ./application/models/draft.php */