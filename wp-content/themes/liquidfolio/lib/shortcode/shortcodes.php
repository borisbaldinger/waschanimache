<?php

define('SHORTCODE_URL', get_template_directory_uri().'/lib/shortcode/');
add_filter('mce_external_plugins', "qd_ed_register");
add_filter('mce_buttons_3', 'qd_ed_add_buttons', 0);
add_filter('widget_text', 'do_shortcode');

locate_template( array('/lib/shortcode/contact-form.php'), true, true	);

function qd_ed_add_buttons($buttons)
{
	array_push($buttons, "highlight", "list", "qd_table", "notifications", "buttons", "divider",
						"toggle", "tabs", "contactForm",'social_link', 'social_button', 'columns');
	
	return $buttons;	
	
}



function qd_ed_register($plugin_array)
{
	$url = get_template_directory_uri() . "/lib/shortcode/shortcodes.js";

	$plugin_array["qd_buttons"] = $url;
	return $plugin_array;
}




function qd_cleanup_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'qd_cleanup_shortcodes');


//Columns
function col_one_half($atts, $content = null)
{
	extract(shortcode_atts(array(
				'last' => ''
					), $atts));
	$out = "<div class='one_half " . $last . "' >" . do_shortcode($content) . "</div>";
	return $out;
}
add_shortcode('one_half', 'col_one_half');

function col_one_third($atts, $content = null)
{
	extract(shortcode_atts(array(
				'last' => ''
					), $atts));
	$out = "<div class='one_third ". $last . "' >" . do_shortcode($content)."</div>";
	return $out;
}
add_shortcode('one_third', 'col_one_third');

function col_one_fourth($atts, $content = null)
{
	extract(shortcode_atts(array(
				'last' => ''
					), $atts));
	$out = "<div class='one_fourth ".$last."'>".do_shortcode($content)."</div>";
	return $out;
}
add_shortcode('one_fourth', 'col_one_fourth');

function col_two_third($atts, $content = null)
{
	extract(shortcode_atts(array(
				'last' => ''
					), $atts));
	$out = "<div class='two_third ".$last."'>".do_shortcode($content)."</div>";
	return $out;
}
add_shortcode('two_third', 'col_two_third');

function col_three_fourth($atts, $content = null)
{
	extract(shortcode_atts(array(
				'last' => ''
					), $atts));
	$out = "<div class='three_fourth ".$last."'>".do_shortcode($content)."</div>";
	return $out;
}
add_shortcode('three_fourth', 'col_three_fourth');

function col_clear($atts, $content = null)
{
	return "<div class='clearfix'></div>";
}
add_shortcode('clear', 'col_clear');

///Highlight
function highlight($atts, $content = null)
{
	extract(shortcode_atts(array(
					), $atts));

	$out = "<span class='hdark' >" . do_shortcode($content) . "</span>";

	return $out;
}
add_shortcode('highlight', 'highlight');

///Buttons
function button($atts, $content = null)
{
	extract(shortcode_atts(array(
				'type' => '',
				'url' => '',
				'button_color_fon'	=> '',
				'target' => ''
					), $atts));
	if ($target != '') : $target = "target='_blank'";
	endif;
	
	$class = '';
	if(preg_match('/btn_xlarge$/', $type))
	{
		$class = 'style="background-color: '.$button_color_fon. '"';
		$out = "<a class='" . $type . " '  href='" . $url . "' " . $target . "><b style='background-color: ".$button_color_fon.";'></b><span>" . do_shortcode($content) . "</span></a>";
	}
	else
	{
		$out = "<a class='" . $type . " ' style='background-color: " . $button_color_fon . "' href='" . $url . "' " . $target . "  ><span>" . do_shortcode($content) . "</span></a>";
	}

	return $out;
}

add_shortcode('button', 'button');


function contactForm($atts, $content = null)
{
	return '';
}
add_shortcode('contactForm', 'contactForm');

///Notifications
function notification($atts, $content = null)
{
	extract(shortcode_atts(array(
				'type' => '',
					), $atts));

	$out = "<div class='qd_notification " . $type . "' >" . do_shortcode($content) . "</div>";

	return $out;
}

add_shortcode('notification', 'notification');

//Toggles
function toggle_shortcode($atts, $content = null)
{
	wp_enqueue_script('jquery-ui-core');
	
	extract(shortcode_atts(
					array(
				'title' => ''				
					), $atts));
	return '<div class="toggle"><h4 class="trigger"><span class="t_ico"></span><a href="#">' . $title . '</a></h4><div class="toggle_container">' . do_shortcode($content) . '</div></div>';
	
}
add_shortcode('toggle', 'toggle_shortcode');

///Tabs
add_shortcode('tabgroup', 'jquery_tab_group');

function jquery_tab_group($atts, $content)
{
	wp_enqueue_script('jquery-ui-tabs');

	extract(shortcode_atts(array(
				'type' => ''
					), $atts));

	$GLOBALS['tab_count'] = 0;

	do_shortcode($content);

	if (is_array($GLOBALS['tabs']))
	{
		$int = '1';
		foreach ($GLOBALS['tabs'] as $tab)
		{
			$tabs[] = '

  <li><a href="#tabs-' . $int . '">' . $tab['title'] . '</a></li>

';
			$panes[] = '
<div id="tabs-' . $int . '">
' . $tab['content'] . '

</div>
';
			$int++;
		}
		$return = "\n" . '
<div class="tabgroup ' . $type . '" data-script="jquery-ui-core,jquery-ui-widget,jquery-ui-tabs">
<ul class="tabs">' . implode("\n", $tabs) . '</ul>
' . "\n" . ' ' . implode("\n", $panes) . '

</div><script>jQuery(document).ready(function(){initTabGroup()});</script>
' . "\n";
	}
	return $return;
}
add_shortcode('tab', 'jquery_tab');

function jquery_tab($atts, $content)
{
	extract(shortcode_atts(array(
				'title' => 'Tab %d'
					), $atts));

	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array('title' => sprintf($title, $GLOBALS['tab_count']), 'content' => do_shortcode($content));

	$GLOBALS['tab_count']++;
}

///
function refresh_mce($ver)
{
	$ver += 3;
	return $ver;
}

add_filter('tiny_mce_version', 'refresh_mce');

function html_editor()
{

	if (basename($_SERVER['SCRIPT_FILENAME']) == 'post-new.php' || basename($_SERVER['SCRIPT_FILENAME']) == 'post.php')
	{

		echo "<style type='text/css'>#ed_toolbar input#one_half, #ed_toolbar input#one_third, #ed_toolbar input#one_fourth, #ed_toolbar input#two_third, #ed_toolbar input#one_half_last, #ed_toolbar input#one_third_last, #ed_toolbar input#one_fourth_last, #ed_toolbar input#two_third_last, #ed_toolbar input#clear {font-weight:700;color:#2EA2C8;text-shadow:1px 1px white}
#ed_toolbar input#one_half_last, #ed_toolbar input#one_third_last, #ed_toolbar input#one_fourth_last, #ed_toolbar input#two_third_last, #ed_toolbar input#three_fourth, #ed_toolbar input#three+fourth_last {color:#888;text-shadow:1px 1px white}
#ed_toolbar input#raw {color:red;text-shadow:1px 1px white;font-weight:700;}</style>";
	}
}

add_action('admin_head', 'html_editor');

function custom_quicktags()
{
	if (basename($_SERVER['SCRIPT_FILENAME']) == 'post-new.php' || basename($_SERVER['SCRIPT_FILENAME']) == 'post.php')
	{
		wp_enqueue_script('custom_quicktags', get_template_directory_uri() . '/lib/shortcode/shortcodes/quicktags.js', array('quicktags'), '1.0.0');
	}
}

add_action('admin_print_scripts', 'custom_quicktags');



function qd_social_link($atts, $content = null)
{
	extract(shortcode_atts(array(
				'url' => '#',
				'type' => '',
				'target'=>'',
					), $atts));
	
	if($target)
	{
		$target = 'target="_blank"';
	}
	/**
	 * @todo add  correct classes
	 */
	return '<a class="social_links '.$type.'" href="'.$url.'" '.$target.'>'.$type.'</a>';
	
	
}
add_shortcode('social_link', 'qd_social_link');

/**
 * Insert social buttons(google+, facebook, twitter)
 */
function qd_social_button($atts, $content = null)
{
	$default_values = array(
				'button'		=> '',
				'gurl'			=> in_the_loop()?get_permalink():'', // google
				'gsize'			=> '',
				'gannatation'	=> '',
				'ghtml5'		=> '',
				'turl'			=> in_the_loop()?get_permalink():'', //twitter
				'ttext'			=> in_the_loop()?get_the_title():'',
				'tcount'		=> '',
				'tsize'			=> '',
				'tvia'			=> '',
				'trelated'		=> '',
				'furl'			=> in_the_loop()?get_permalink():'', //facebook
				'flayout'		=> '',
				'fsend'			=> '',
				'fshow_faces'	=> '',
				'fwidth'		=> 450,
				'faction'		=> '',
				'fcolorsheme'	=> '',
				'purl'			=> in_the_loop()?get_permalink():'', // pinterest
				'pmedia'		=> wp_get_attachment_url(get_post_thumbnail_id()),
				'ptext'			=> in_the_loop()?get_the_title():'',
				'pcount'		=> '',
					);
	
	$shortcode_html = $shortcode_js = ''; 
	extract(shortcode_atts($default_values, $atts));
	
	switch($button) 
	{
		/**
		 * insert google+ button
		 */
		case 'google':
			$shortcode_js = "<script type='text/javascript'>(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script>";
			if($ghtml5)
			{
				$shortcode_html = sprintf('<div class="g-plusone" data-size="%s" data-annotation="%s" data-href="%s"></div>', $gsize, $gannatation, $gurl);
			}
			else
			{
				$shortcode_html= sprintf('<g:plusone size="%s" annotation="%s" href="%url"></g:plusone>', $gsize, $gannatation, $gurl);
			}
			break;
		/**
		 * Insert Twitter follow button
		 */
		case 'twitter':
			$shortcode_js = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			$template = '<a href="https://twitter.com/share" class="twitter-share-button"  data-url="%s"	data-text="%s" data-count="%s" data-size="%s" data-via="%s" data-related="%s" data-lang="">Tweet</a>';
			$shortcode_html = sprintf($template,
					$turl,
					$ttext,
					$tcount,
					$tsize,
					$tvia,
					$trelated);
			break;
		/**
		 * Insert facebook button. 
		 */
		case 'facebook':
			$shortcode_js = <<<JS
					<div id="fb-root"></div>
				  <script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					fjs.parentNode.insertBefore(js, fjs);
				  }(document, 'script', 'facebook-jssdk'));</script>
JS;
			$template = <<<HTML
				<div class="fb-like" data-href="%s" data-send="%s" data-layout="%s" data-width="%d" data-show-faces="%s" data-action="%s" data-colorscheme="%s"></div>
HTML;
			$shortcode_html = sprintf($template,
					$furl,
					($fsend)?'true':'false',
					$flayout,
					$fwidth,
					($fshow_faces)?'true':'false',
					$faction,
					$fcolorsheme
					);
			break;
		case 'pinterest':
			$query_params = $template = '';
			$filtered_params = array();
			
			$params = array('url'			=>$purl,	
							'media'			=>$pmedia,
							'description'	=>$ptext);
			
			$filtered_params = array_filter($params);
			
			
			$query_params = http_build_query($filtered_params);
			
			if(strlen($query_params))
			{
				$query_params = '?'.$query_params;
			}
			
			$template = '<a href="http://pinterest.com/pin/create/button/%s" class="pin-it-button" count-layout="%s"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
			
			$shortcode_html = sprintf($template, $query_params, $pcount);
			$shortcode_js = '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
			
			break;
	}
	return $shortcode_html.$shortcode_js;
}
add_shortcode('social_button', 'qd_social_button');


function qd_audio($atts, $title = null)
{
	if(!isset($GLOBALS['audio_iterator']))
	{
		$GLOBALS['audio_iterator'] = 1;
	}

	extract(shortcode_atts(array(
				'href' => '',
				'hide_title' => '',
					), $atts));

	if(filter_var($href, FILTER_VALIDATE_URL))
	{
			wp_enqueue_script('jplayer');

			switch(pathinfo($href, PATHINFO_EXTENSION))
			{
				case 'mp3':  //mp3
					$media = "{mp3: '$href'}";
					$supplied = 'supplied: "mp3",';
					break;
				case 'm4a':  //mp4
					$media = "{m4a: '$href'}";
					$supplied = 'supplied: "m4a, mp3",';
					break;
				case 'ogg': //ogg
					$media = "{oga: '$href'}";
					$supplied = 'supplied: "oga, ogg, mp3",';
					break;
				case 'oga': //oga
					$media = "{oga: '$href'}";
					$supplied = 'supplied: "oga, ogg, mp3",';
					break;
				case 'webma': //webma
					$media = "{webma: '$href'}";
					$supplied = 'supplied: "webma, mp3",';
					break;
				case 'webm': //webma
					$media = "{webma: '$href'}";
					$supplied = 'supplied: "webma, mp3",';
					break;
				case 'wav':
					$media = "{wav: '$href'}";
					$supplied = 'supplied: "wav, mp3",';
					break;
				default:
					// not supporteg audio format
					return;
					break;


			}


			$html = <<<HTML
			<div id="jquery_jplayer_{$GLOBALS['audio_iterator']}" class="jp-jplayer"></div>
			<div id="jp_container_{$GLOBALS['audio_iterator']}" class="jp-audio">
            <div class="jp-type-single"><div class="jp-control"><a href="javascript:;" class="jp-play" tabindex="1">play</a><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></div> <div class="jp-gui jp-interface"><div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div><div class="jp-volume"><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div></div>
                </div>
HTML;
			if (!$hide_title) {
			$html .= <<<HTML
                <div class="jp-title"><strong>{$title}</strong> -  <span class="jp-current-time"></span> / <span class="jp-duration"></span></div>
HTML;
			}
			$html .= <<<HTML
                <div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.</div></div></div>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				jQuery.jPlayer.timeFormat.showHour = true;
				jQuery("#jquery_jplayer_{$GLOBALS['audio_iterator']}").jPlayer({
					ready: function(event) {
						jQuery(this).jPlayer("setMedia", {$media});
					},
					play: function() {
						jQuery(this).jPlayer("pauseOthers");
					},
					swfPath: THEME_URI+"/swf",
					solution: "html, flash",
					preload: "metadata",
					wmode: "window",
					{$supplied}
					cssSelectorAncestor: '#jp_container_{$GLOBALS['audio_iterator']}'
				});
			});
		</script>
HTML;
		$GLOBALS['audio_iterator'] = $GLOBALS['audio_iterator'] +1;
		return $html;
	}
}
add_shortcode('thaudio', 'qd_audio');

//List
add_shortcode('qd_list', 'qd_list');
	function qd_list( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
				'type'	=> 'qd_list'			
					), $atts));
	
	$content = str_replace('<ul>', '<ul class='.$type.'>', do_shortcode($content));
	$content = str_replace('<li>', '<li>', do_shortcode($content));
	
	return $content;	
}

//Table
add_shortcode('qd_table', 'qd_table');
	function qd_table( $atts, $content = null ) {
	
	
	$content = str_replace('<table>', '<table class="qd_table">', do_shortcode($content));
	
	
	return $content;
	
}
?>