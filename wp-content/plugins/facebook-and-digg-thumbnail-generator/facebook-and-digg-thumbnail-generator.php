<?php

/*
  Plugin Name: Fedmich's Facebook Open Graph Meta
  Plugin URI: http://fedmich.com/tools/facebook-and-digg-thumbnail-generator
  Description: This plugin will automatically add meta tags on the HEAD section of your posts. It will be used by different social media's share functionalities. <strong>Advance meta_tags</strong> like video embed and image urls can be automatically generated. Previously knowned as "Facebook and Digg Thumbnail generator" plugin.
  Author: Fedmich
  Author URI: http://fedmich.com/tools/facebook-and-digg-thumbnail-generator
  Version: 1.15.6
 */
define("FBTHU_VERSION", "1.15.6");

function fbthu_social_img() {
	global $post;
	if (is_single() or is_page()) {
		$post_id = $post->ID;
		$pcontent = $post->post_content;
		$use_img = 0;
		$image = get_post_meta($post_id, 'thumbnail', true);
		if ($image) {
			$use_img = 1;
		} else {
			$image = get_post_meta($post_id, 'post_image', true);
			$use_img = 1;
		}
		if (!$image) {
			preg_match_all('/<img.*src="(.*?)"/i', $pcontent, $m);
			if (isset($m[1])) {
				$images = $m[1];
				$images = array_unique($images);
				$image = $images[0];
			}
			$use_img = 1;
		}

		$meta_imgs = Array();
		$meta_vids = Array();

		//VIMEO videos
		preg_match_all('@(player.vimeo.com/video/|vimeo.com/)(\d.{2,}?)(&|\?|"|\#|\b)@i', $pcontent, $ms);
		if (!empty($ms[2])) {
			$vimeo_ids = $ms[2];
			$vimeo_ids = array_unique($vimeo_ids);

			foreach ($vimeo_ids as $vimeo_id) {

				$pkey = "vimeo_prev_$vimeo_id";

				$vim_thumb = get_post_meta($post_id, $pkey, true);

				if (!$vim_thumb) {
					$vim_url = "http://vimeo.com/$vimeo_id";

					$vim_response = wp_remote_get($vim_url);

					if (!is_wp_error($vim_response)) {

						if ($vim_response['response']['code'] == 200) {

							$vim_content = $vim_response['body'];

							if ($vim_content) {
								preg_match_all('@(<meta itemprop="thumbnailUrl" content=")(http.*)(&|\?|"|\#|\b)@i', $vim_content, $ms_vim);
								if (!empty($ms_vim[2][0])) {
									$vim_thumb = $ms_vim[2][0];
									add_post_meta($post_id, $pkey, $vim_thumb, TRUE);
								}
							}
						}
					}
				}

				$meta_vids[] = "http://vimeo.com/moogaloop_local.swf?clip_id=$vimeo_id&server=www.vimeo.com&autoplay=0&fullscreen=1"
					   . "&show_portrait=0&show_title=0&show_byline=0&hd_off=0%22";
				$meta_imgs[] = $vim_thumb;
			}
		}
		//VIMEO videos
		//Youtube videos
		preg_match('@www.(youtube-nocookie|youtube).com/(v|embed)/(.*?)(&|\?|")@i', $pcontent, $m);
		$yt_id = isset($m[3]) ? $m[3] : '';

		if (!$yt_id) {
			//new short link youtu.be
			preg_match('@(youtu.be)/(.*?)[\b"]@iu', $pcontent, $m);
			$yt_id = isset($m[2]) ? $m[2] : '';
		}

		if (!$yt_id) {
			// check pattern against a youtube image
			preg_match('@(\.ytimg\.com|img\.youtube\.com)/vi/(.*?)/.*\.jpg@i', $image, $m);
			$yt_id = isset($m[2]) ? $m[2] : '';
		}
		if (!$yt_id) {
			preg_match('@(www\.|)youtube.com/watch\?v=(.*?)(\[|&)@i', $pcontent, $m);
			$yt_id = isset($m[2]) ? $m[2] : '';
			$yt_id = trim($yt_id);
		}
		if (!$yt_id) {
			preg_match('@(www\.|)youtube.com/watch\?v=(.*)@i', $pcontent, $m);
			$yt_id = isset($m[2]) ? $m[2] : '';
			$yt_id = trim($yt_id);
		}

		if ($yt_id) {
			preg_match("/(.*)[\"'\?&]/", $yt_id, $ms);
			if (isset($ms[1])) {
				$yt_id = $ms[1];
			}
		}

		if ($yt_id) {
			$meta_vids[] = "http://www.youtube.com/v/$yt_id&hl=en&fs=1&rel=0&autoplay=1";
		} else {
			preg_match('@<object .*id="jtv_flash".*data="(http://.*?.justin.tv/.*?)"@i', $pcontent, $m);
			if (!empty($m[1])) {
				$meta_vids[] = $m[1];
			}
		}
		//Youtube videos


		if ($use_img) {
			if ($images) {
				foreach ($images as $img) {
					if (strstr($img, 'imgur.com')) {
						$img_lst = Array($img);
						$imgdr = dirname($img);

						$bs = explode('.', basename($img));
						$bs2a = $bs[0];
						$bs2b = $bs[1];

						$img_lst[] = "$imgdr/$bs2a" . 's' . ".$bs2b";
						$img_lst[] = "$imgdr/$bs2a" . 's' . ".$bs2b";
						$img_lst[] = "$imgdr/$bs2a" . 'b' . ".$bs2b";

						$meta_imgs = array_merge($meta_imgs, $img_lst);
					} else if (strstr($img, 'tinypic.com')) {
						$img = str_replace('.jpg', '_th.jpg', $img);
						$meta_imgs[] = $img;
					} else if (strstr($img, 'imgjoe.com')) {
						$img = str_replace('/x/', '/thumbs/', $img);
						$meta_imgs[] = $img;
					} else {
						$meta_imgs[] = $img;
					}
				}
			} elseif ($image) {
				$meta_imgs[] = $image;
			}
		}

		if ($yt_id) {
			$image = "http://i4.ytimg.com/vi/$yt_id/default.jpg";
			$meta_imgs[] = $image;
		}

		$chkd = get_settings('fbthu_add_other') ? 0 : 1;
		if ($chkd) {
			if ($yt_id) {
				$image = "http://i4.ytimg.com/vi/$yt_id/0.jpg";
				$meta_imgs[] = $image;
				$image = "http://i4.ytimg.com/vi/$yt_id/1.jpg";
				$meta_imgs[] = $image;
				$image = "http://i4.ytimg.com/vi/$yt_id/2.jpg";
				$meta_imgs[] = $image;
			}
		}

		$return_code = array();
		$return_code[] = "<!-- Fedmich facebook/digg thumbnail v" . FBTHU_VERSION . " -->";

		if (is_home() || is_front_page() ) {
			$fbthu_title = get_bloginfo( 'name' );
		} else {
			$fbthu_title = get_the_title();
		}
		$return_code[] = '<meta property="og:title" content="' . esc_attr($fbthu_title) . '">';
		$return_code[] = '<meta property="og:site_name" content="' . get_bloginfo('name') . '">';
		
		$chkd = get_settings('fbthu_add_metaog') ? 0 : 1;
		if ($chkd) {
			$return_code[] = '<meta property="og:url" content="' . esc_attr(get_permalink()) . '">';
		}
		
		//optional items
		$chkd = get_settings('fbthu_add_metalocale') ? 0 : 1;
		if ($chkd) {
			$return_code[] = '<meta property="og:locale" content="' . esc_attr(strtolower(get_locale())) . '">';
		}
		if (get_settings('fbthu_add_metadesc')) {
			$post_excerpt = get_the_excerpt();
			if(! $post_excerpt){
				$post_excerpt = $pcontent;
			}
			
			$post_excerpt = preg_replace("/(\n|<br ?\/?>){1,}/", "\n", $post_excerpt);
			$post_excerpt = preg_replace("/( |\t){1,}/", ' ', $post_excerpt);
	
			$post_excerpt = strip_tags(strip_shortcodes($post_excerpt));
			
			$excerpt_wordlength = 35;
			$excerpt_words = explode(' ', $post_excerpt, $excerpt_wordlength + 1);

		    if(count($excerpt_words) > $excerpt_wordlength){
        		array_pop($excerpt_words);
        		array_push($excerpt_words, '...');
        		$post_excerpt = implode(' ', $excerpt_words);
    		}
			
			$post_excerpt = str_replace("\n", '<br />', $post_excerpt );
			
			$return_code[] = '<meta property="og:description" content="' . esc_attr($post_excerpt) . '">';
		}
		
		
		$meta_imgs = array_unique($meta_imgs);
		if ($meta_imgs) {
			$return_code[] = '<link rel="image_src" href="' . $meta_imgs[0] . '" />';

			foreach ($meta_imgs as $img) {
				$return_code[] = '<meta property="og:image" content="' . $img . '" />';
			}
		}

		$chkd = get_settings('fbthu_embed_yt') ? 0 : 1;
		if ($chkd) {
			if ($meta_vids) {
				$return_code[] =  '<link rel="video_src" href="' . $meta_vids[0] . '" />';
				foreach ($meta_vids as $video_src) {
					$return_code[] = '<meta property="og:video" content="' . $video_src . '">';
				}
			}
		}

		$return_code[] = "<!-- /Fedmich facebook/digg thumbnail -->";
		
		$return_code = implode("\n",$return_code);
		echo $return_code . "\r\n";
	}
}

add_action('wp_head', 'fbthu_social_img');

function fbthu_set_plugin_meta($links, $file) {
	$plugin = plugin_basename(__FILE__);
	if ($file == $plugin) {
		return array_merge($links, array(
				  sprintf('<a target="_blank" href="options-general.php?page=fbthu-options.php">%s</a>', __('Settings'))
				  , sprintf('<a target="_blank" href="http://fedmich.com/tools/facebook-and-digg-thumbnail-generator">%s</a>', __('Help and FAQ'))
				  , sprintf(' <a target="_blank" href="http://wordpress.org/extend/plugins/facebook-and-digg-thumbnail-generator/">%s</a>'
						, __('Plugin Directory')
				  )
					 )
		);
	}
	return $links;
}

add_filter('plugin_row_meta', 'fbthu_set_plugin_meta', 10, 2);

function fbthu_namespace($htmlcode){
	return "$output xmlns:og=\"http://ogp.me/ns#\"";
}
add_filter('language_attributes','fbthu_namespace');

include dirname(__FILE__) . "/fbthu-options.php";
