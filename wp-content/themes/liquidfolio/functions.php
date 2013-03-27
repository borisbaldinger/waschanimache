<?php
$customize_iterator = 1;
//Defines
define('SHORTNAME', 'lf');   // Required!!
define('THEMENAME', 'LiquidFolio'); // Required!!
define('TEXTDOMAIN', 'liquidfolio'); // Required!!

define('ICL_AFFILIATE_ID', 7410);
define('ICL_AFFILIATE_KEY', '52286484063b643175cdfd8e743f1448');
defined('CLASS_DIR_PATH') || define('CLASS_DIR_PATH', get_template_directory() . '/classes/'); // Path to classes folder in Theme


include "wpml-integration.php";
$themename = "LiquidFolio";

$adminmenuname = "Theme Options";

spl_autoload_register('wp_auto_loader');

$themeicon = get_template_directory_uri() . '/backend/img/favicon.ico';

//*** THEME ADMIN OBJECT ****//

$admin_menu = new Admin_Theme_Menu('LiquidFolio');
$admin_menu->setMenuSlug(SHORTNAME . '_general')
		->setAdminMenuName($adminmenuname)
		->setIconUrl($themeicon);

// Load admin options
locate_template(array('backend/setup.php'), true, true);

// Load metabox
locate_template(array('lib/metabox/functions.php'), true, true);
// Load gallery lightbox
locate_template(array('lib/gallerylightbox.php'), true, true);
locate_template(array('lib/gallerysmall_lightbox.php'), true, true);

locate_template(array('lib/shortcode/shortcodes.php'), true, true);
locate_template(array('lib/tweaks.php'), true, true);
locate_template(array('customize.php'), true, true);



/**
 * Custom images size
 */
$theme_images_size = new Custom_Thumbnail(); // varible name use in theme_post_thumbnail function
$theme_images_size->addThemeImageSize('recent_posts', 75, 51, Custom_Thumbnail::REMOVE_ON_CHANGE)
		->addThemeImageSize('blog_double', 533, 999999, Custom_Thumbnail::REMOVE_ON_CHANGE)
		->addThemeImageSize('blog_small', 460, 999999, Custom_Thumbnail::REMOVE_ON_CHANGE)
		->addThemeImageSize('single', 853, 999999, Custom_Thumbnail::REMOVE_ON_CHANGE)
		->addThemeImageSize('gallery_widget', 144, 134, Custom_Thumbnail::REMOVE_ON_CHANGE);

/**
 * adding custom page type
 */

	$gallery = new Custom_Posts_Type_Gallery();
	$gallery->run();




	/**
	 * Adding custom meta box to post category.
	 */
	$custom_category_meta = new Custom_MetaBox_Item_Category();
	$custom_category_meta->run();

	/**
	 * Adding custom meta box to post tag.
	 */

	$custom_tag_met = new Custom_MetaBox_Item_Tag();
	$custom_tag_met->run();


add_action('init', 'qd_flush_rewrite_rules');

//theme update check
$envato_username = get_option(SHORTNAME."_envato_nick");
$envato_api = get_option(SHORTNAME."_envato_api");

if($envato_username && $envato_api)
{
	Envato_Theme_Updater::init($envato_username,$envato_api,'QuelDorei');
}

function qd_session_admin_init()
{

	if (get_option(SHORTNAME."_preview") && !session_id())
	{
		session_start();
		if(isset($_POST['use_session_values']) && $_POST['use_session_values'] == 1)
		{
			foreach ($_POST as $name => $value)
			{
				$_SESSION[$name] = $value;
			}
		}
		elseif(isset($_POST['reset_session_values']) && $_POST['reset_session_values'] == 1)
		{
			session_unset();
		}
	}
}

add_action('init', 'qd_session_admin_init');
/**
 * Do flush_rewrite_rules if slug of custom post type was changed.
 */
function qd_flush_rewrite_rules()
{
	if (get_option(SHORTNAME . '_need_flush_rewrite_rules'))
	{
		flush_rewrite_rules();
		delete_option(SHORTNAME . '_need_flush_rewrite_rules');
	}
}
add_filter('get_avatar','change_avatar_css');

function change_avatar_css($class) {
$class = str_replace("class='avatar", "class='imgborder ", $class) ;
return $class;
}

/**
 * Remove width & height from avatr html
 */
add_filter('get_avatar', 'qd_get_avatar', 10, 5);

function qd_get_avatar($avatar, $id_or_email, $size, $default, $alt)
{
	$avatar = preg_replace(array('/\swidth=("|\')\d+("|\')/', '/\sheight=("|\')\d+("|\')/'), '', $avatar);
	return $avatar;
}

add_filter('image_send_to_editor', 'qd_image_send_to_editor', 10, 5);

function qd_image_send_to_editor($html)
{
	$html = preg_replace(array('/\swidth=("|\')\d+("|\')/', '/\sheight=("|\')\d+("|\')/'), '', $html);
	
//	$html =  preg_replace_callback(
//		'/(.*)(<img\s[^>]*)(width=\"\d*\")([^>]*\/>)(.*)/',
//		'qd_remove_image_size',
//		$html);
//
//	$html =  preg_replace_callback(
//		'/(.*)(<img\s[^>]*)(height=\"\d*\")([^>]*\/>)(.*)/',
//		'qd_remove_image_size',
//		$html);
	
	return $html;
}

function qd_remove_image_size($matches) {
	
	if(is_array($matches) && count($matches) == 6 && preg_match('/(width|height)/', $matches[3]))
	{
		$matches[0] = '';
		$matches[3] = '';
		return implode('', $matches);
	}
	return $matches[0];
}

$locationMap = new Locate_Map();
// Custom menus
add_theme_support('menus'); // sidebar

//Post formats
add_theme_support( 'post-formats', array( 'gallery', 'link', 'aside', 'image', 'quote', 'video', 'audio', 'status' ) );

/**
 * Register all theme widgets
 */
add_action('widgets_init', array('Widget', 'run'));

// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
add_theme_support('post-thumbnails');

//
load_theme_textdomain('liquidfolio', get_template_directory());

//

add_theme_support('automatic-feed-links');

//


add_editor_style();

//

if (!isset($content_width))
	$content_width = 912;

//


function qd_register_menus()
{
	register_nav_menus(
			array(
				'main-menu' => __('Main Menu', 'liquidfolio'),
			)
	);
}

add_action('init', 'qd_register_menus');

// Print styles
function qd_add_styles()
{
	if (!is_admin())
	{

		wp_enqueue_style('reset', get_template_directory_uri() . '/css/reset.css', '', null, 'all');
		wp_enqueue_style('typography', get_template_directory_uri() . '/css/typography.css', '', null, 'all');
		wp_enqueue_style('layout', get_template_directory_uri() .  '/css/layout.css', '', null, 'all');
		wp_enqueue_style('form', get_template_directory_uri() .  '/css/form.css', '', null, 'all');
		wp_enqueue_style('widget', get_template_directory_uri() .  '/css/widget.css', '', null, 'all');




		wp_enqueue_style('main', get_template_directory_uri() . '/css/main.css', '', null, 'all');
		if (!get_option(SHORTNAME."_responsive")){
			wp_enqueue_style('media.querias', get_template_directory_uri() . '/css/media.queires.css', '', null, 'all');
		}

		

		wp_enqueue_style('fancybox', get_template_directory_uri() .  '/css/jquery.fancybox.css', '', null, 'all');
		
		$custom_stylesheet = new Custom_CSS_Style();
		$custom_stylesheet->run();
		
		wp_enqueue_style('default', get_template_directory_uri() .  '/style.css', '', null, 'all');
	}


}

add_action('wp_print_styles', 'qd_add_styles');

/**
 * Add to DB default settings of theme admin page and
 * try to create custom css/skin.css file if dir is writable
 * @global Admin_Theme_Menu $admin_menu
 */
function qd_theme_switch()
{
	global $admin_menu;
	$admin_menu->themeActivation();

	$custom_stylesheet = new Custom_CSS_Style();
	$custom_stylesheet->themeSetup();
}

add_action('after_switch_theme', 'qd_theme_switch');

//print scripts

function qd_register_scripts()
{
	wp_register_script('modernizer', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', array('jquery'), null);

//	wp_register_script('qd_scripts', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
//	spriting in fly
	// ToDo : remove from production
//	$spriter = new Spriter_JS(array('sef' => false));
//	$filename = $spriter->get( wp_get_theme()->get_template_directory() . '/js/scripts');
	$filename = 'sprite.js';
	wp_register_script('qd_scripts', get_template_directory_uri() . '/js/scripts/' . $filename, array('jquery'), null, true);


	wp_register_script('superfish', get_template_directory_uri() . '/js/superfish/superfish.js', array('jquery'), null, true);
	wp_register_script('validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), null, true); 
	wp_register_script('sharrre', get_template_directory_uri() . '/js/jquery.sharrre-1.3.4.min.js', array('jquery'), null, true);

			wp_register_script('fancybox', get_template_directory_uri() .'/js/jquery.fancybox.js', array('jquery'), null,true);


			wp_register_script('cycleall', get_template_directory_uri() .'/js/jquery.cycle.all.js', array('jquery'), null,true);
			wp_register_script('maximage', get_template_directory_uri() .'/js/jquery.maximage.js', array('jquery', 'cycleall'), null,true);
	
			
	wp_register_script('metaboxes_gallery', get_template_directory_uri() . '/backend/js/metaboxes/metaboxes_gallery.js', array('jquery'), null, true);
	wp_register_script('metaboxes_post', get_template_directory_uri() . '/backend/js/metaboxes/metaboxes_post.js', array('jquery'), null, true);
	wp_register_script('metaboxes_page', get_template_directory_uri() . '/backend/js/metaboxes/metaboxes_page.js', array('jquery'), null, true);

	
	wp_register_script('isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery'), null, true);  // isotope filterable gallery
	wp_register_script('infinite', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'), null, true);  // infinite scroll
	wp_register_script('jplayer', get_template_directory_uri() . '/js/jquery.jplayer.min.js', array('jquery'), null, true);  // audio jPlayer
	wp_register_script('preview', get_template_directory_uri() .'/js/preview.js', array('jquery'), null,true);
	wp_register_script('fitvids', get_template_directory_uri() .'/js/jquery.fitvids.js', array('jquery'), null,true);


	wp_register_script('qd_colorpicker', get_template_directory_uri() .'/backend/js/mColorPicker/javascripts/mColorPicker.js', array('jquery'), null, true);

	wp_register_script('qd_frogoloop', get_template_directory_uri().'/js/froogaloop.js', array('jquery'), null, true);

	if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')))
	{
		wp_enqueue_script('modernizer');
		wp_enqueue_script('superfish');
		wp_enqueue_script('isotope');
		wp_enqueue_script('sharrre');
		wp_enqueue_script('qd_scripts');
		

		
		wp_localize_script( 'qd_scripts', 'theme', array(
													'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
													'nonce'		=> wp_create_nonce('liquid-folio-nonce'),													
			) );
		wp_localize_script( 'qd_scripts', 'THEME_URI', get_template_directory_uri() );


		
		if( get_option(SHORTNAME."_preview")) {
			wp_enqueue_script('preview');
			wp_enqueue_script('qd_colorpicker');
		}
	}


}

add_action('wp_ajax_double_gallery_thumbnail', 'ajax_double_gallery_thumbnail');
add_action('wp_ajax_nopriv_double_gallery_thumbnail', 'ajax_double_gallery_thumbnail');

function ajax_double_gallery_thumbnail()
{
	set_time_limit(60);

	$html			= '';
	$gallery_id		= isset($_POST['gallery_id'])?$_POST['gallery_id']:false;
	$page_height	= isset($_POST['page_height'])?$_POST['page_height']:false;
	$page_width		= isset($_POST['page_width'])?$_POST['page_width']:false;
	$gallery_page_id = isset($_POST['gallery_page_id'])?$_POST['gallery_page_id']:false;

	if($gallery_id !== false && $page_height!== false && $page_width!== false )
	{
		ob_start();
		get_gallery_thumbnail($gallery_id, $page_width, $page_height, $gallery_page_id);
		$html = ob_get_clean();
	}
	header('Content-Type: text/html');
	die(json_encode($html));
}

add_action('init', 'qd_register_scripts');
add_action('init', 'localize_register_scripts', 9999);

function localize_register_scripts() {
		//used scripts in theme registrd in WP core
		$used_wp_script = array(
			'jquery-ui-core',
			'jquery-ui-tabs',
			'jquery-ui-widget',
			'jquery-effects-core',
			'swfobject',
//			'qd_frogoloop'
		);
		
		
		$handle_src_list  = array();
		global $wp_scripts;
		if($wp_scripts instanceof WP_Dependencies)
		{
			foreach ($wp_scripts->registered as $handle => $dependency)
			{
				if(isset($dependency->src))
				{
					
					if(strpos($dependency->src,  get_template_directory_uri()) !== false
						|| in_array($handle, $used_wp_script))
					{
						$handle_src_list[] = array($handle=>$dependency->src);
					}
				}
			}
		}
		wp_localize_script('qd_scripts', 'qd_scriptData', $handle_src_list);
}

// WPML.org integration

wpml_register_string('liquidfolio', 'copyright', stripslashes(get_option(SHORTNAME . "_copyright")));

/**
 *
 */
function language_selector_flags()
{
	if (function_exists('icl_get_languages'))
	{
		$languages = icl_get_languages('skip_missing=0');
		if (!empty($languages))
		{
			?>
			<ul class="languages">
				<?php
				foreach ($languages as $l)
				{
					if ($l['active'])
						echo '<li>';
					if (!$l['active'])
						echo '<li><a href="' . $l['url'] . '">';
					echo '<img src="' . $l['country_flag_url'] . '"  alt="' . $l['language_code'] . '"  title="' . $l['native_name'] . '" />';
					if (!$l['active'])
						echo '</a></li>';
					if ($l['active'])
						echo '</li>';
				}
				?> </ul> <?php
		}
	}
}

/**
 *
 * @param type $id
 * @return type
 */
function wpml_page_id($id)
{
	if (function_exists('icl_object_id'))
	{
		return icl_object_id($id, 'page', true);
	}
	else
	{
		return $id;
	}
}

/**
 *
 * @param type $id
 * @return type
 */
function wpml_post_id($id)
{
	if (function_exists('icl_object_id'))
	{
		return icl_object_id($id, 'post', true);
	}
	else
	{
		return $id;
	}
}

function wpml_cat_id($id)
{
	if (function_exists('icl_object_id'))
	{
		return icl_object_id($id, 'category', true);
	}
	else
	{
		return $id;
	}
}

/**
 * Class autoloader function
 * @param string $class Class name to load
 * @return boolean
 */
function wp_auto_loader($class)
{

	$theme_class_path = CLASS_DIR_PATH . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
	if (!class_exists($class))
	{
		if (file_exists($theme_class_path) && is_readable($theme_class_path))
		{
			include_once($theme_class_path);
			return true;
		}
//		elseif(file_exists($wp_class_name) && is_readable($wp_class_name))
//		{
//			include_once($wp_class_name);
//			return true;
//
//		}
	}
	return false;
}

/*
 * meta functions for easy access:
 */

//get term meta field
if (!function_exists('get_tax_meta'))
{

	function get_tax_meta($term_id, $key, $multi = false)
	{
		$t_id = (is_object($term_id)) ? $term_id->term_id : $term_id;
		$m = get_option('tax_meta_' . $t_id);
		if (isset($m[$key]))
		{
			return $m[$key];
		}
		else
		{
			return '';
		}
	}

}

//delete meta
if (!function_exists('delete_tax_meta'))
{

	function delete_tax_meta($term_id, $key)
	{
		$m = get_option('tax_meta_' . $term_id);
		if (isset($m[$key]))
		{
			unset($m[$key]);
		}
		update_option('tax_meta_' . $term_id, $m);
	}

}

//update meta
if (!function_exists('update_tax_meta'))
{

	function update_tax_meta($term_id, $key, $value)
	{
		$m = get_option('tax_meta_' . $term_id);
		$m[$key] = $value;
		update_option('tax_meta_' . $term_id, $m);
	}

}

/**
 * Get two thumbnailds(color & black & white)<br/>
 * by PAGE size and post multiplicity
 *
 * @param int $post_id gallery POST id
 * @param int $page_w page thumbnail width
 * @param int $page_h PAGE thumbnail height
 */
function get_gallery_thumbnail($post_id, $page_w, $page_h, $gallery_page_id)
{
	Custom_Thumbnail_Gallery::getInstance()->getThumbnail($post_id, $page_w, $page_h, $gallery_page_id);
}

function get_custom_post_thumbnail($post_id=null)
{
	Custom_Thumbnail_Post::getInstance()->getThumbnail($post_id);
}

function get_theme_post_thumbnail($id, $size = 'thumbnail')
{
	global $theme_images_size;
	if ($theme_images_size instanceof Custom_Thumbnail)
	{
		$theme_images_size->getThumbnail($id, $size);
	}
	else
	{
		the_post_thumbnail($size);
	}
}

function theme_post_thumbnail($size = 'thumbnail')
{
	global $theme_images_size;
	if ($theme_images_size instanceof Custom_Thumbnail)
	{
		$theme_images_size->getThumbnail(null, $size);
	}
	else
	{
		the_post_thumbnail($size);
	}
}

/**
 * get thumbnail croped only for width
 * @global Custom_Thumbnail $theme_images_size
 * @param int $id post id
 * @param string $size thumbnail size name
 */
function get_theme_blog_thumbnail($id, $size = 'thumbnail')
{
	global $theme_images_size;
	Custom_Thumbnail_Blog::getInstance($theme_images_size)->getThumbnail($id, $size);
}


//
if( !is_admin() ){
add_action( 'pre_get_posts',  'set_per_page'  );
}
function set_per_page( $query ) {
	if (is_category() || is_tag() || is_tax()){
		global $wp_query;
		$term = $wp_query->get_queried_object();
		if ($term){
			if( get_tax_meta($term->term_id,  SHORTNAME . '_post_listing_number', true)){
			$post_count  = get_tax_meta($term->term_id,  SHORTNAME . '_post_listing_number', true);
			$query->set( 'posts_per_page', $post_count);
			}
		}
	}

  return $query;
}


// Sidebars
register_sidebar(array(
	'id' => 'default-sidebar',
	'description' => __('The default sidebar!', 'liquidfolio'),
	'name' => 'Default sidebar',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));



// Page paginations
add_filter('wp_link_pages_args','add_next_and_number');
function add_next_and_number($args){
    if($args['next_or_number'] == 'next_and_number'){
        global $page, $numpages, $multipage, $more, $pagenow;
        $args['next_or_number'] = 'number';
        $prev = '';
        $next = '';
        if ( $multipage ) {
            if ( $more ) {
                $i = $page - 1;
                if ( $i && $more ) {
                    $prev .= _wp_link_page($i);
                    $prev .= $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>';
                }
                $i = $page + 1;
                if ( $i <= $numpages && $more ) {
                    $next .= _wp_link_page($i);
                    $next .= $args['link_before']. $args['nextpagelink'] . $args['link_after'] . '</a>';
                }
            }
        }
        $args['before'] = $args['before'].$prev;
        $args['after'] = $next.$args['after'];
    }
    return $args;
}


//Responsive twitter
	function twitter_oembed_hotfix( $html, $data, $url ) {
		// remove the blockquote width attribute and value from the twitter oembed html response and return the filtered version
		$html = str_ireplace( '<blockquote class="twitter-tweet" width="550">', '<blockquote class="twitter-tweet">', $html );
		return $html;
	}
	//add_filter( 'embed_oembed_html', 'twitter_oembed_hotfix', 10, 3 );

	function list_comments($comment, $args, $depth)
	{

	$GLOBALS['comment'] = $comment;
		?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

		<div id="comment-<?php comment_ID(); ?>" class="comment-body">

			<div class="clearfix">
				<div class="avatars alignleft">
					<?php echo get_avatar($comment, $size = '32', '',get_comment_author()); ?>
				</div>

				<div class="extra_wrap comment-text">
					<div class="comment-meta">
						<?php printf('<cite class="fn">%s</cite>', get_comment_author_link()) ?>
						<span><?php echo human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ago <sup>.</sup>';?></span><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					</div>
					<div class="comment-entry" >
						<?php comment_text() ?>
					</div>
					<?php if ($comment->comment_approved == '0') : ?>
						<em><?php _e('Your comment is awaiting moderation.', 'liquidfolio') ?></em>
					<?php endif; ?>
				</div>
			</div>

		</div>
	<?php } ?>