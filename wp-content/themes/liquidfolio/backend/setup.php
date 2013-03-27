<?php
/**
 * Add admin context menu items
 * 
 * @global string $themename Theme name
 * @global string $adminmenuname Admin theme name
 */
function lf_add_menu()
{
	global $admin_menu;
	echo $admin_menu->run();
}
add_action('admin_menu', 'lf_add_menu'); 

/**
 * Adding JS includes
 * @param type $hook 
 */
function lf_admin_enqueue_scripts($hook) {
	global $admin_menu;
	
	if ( ($hook == 'post.php') 
		|| ($hook == 'post-new.php') 
		|| $admin_menu->isEditThemeSubmenu())
	{
		$admin_menu->getJSIncludes();
	}
}
add_action('admin_enqueue_scripts', 'lf_admin_enqueue_scripts');

 
function gd_admin_notice(){
	if(!(extension_loaded('gd') && function_exists('gd_info')))
	{
		echo '<div class="updated">
		   <p>To theme fully work requires installation of GD library.</p>
		</div>';
	}
}
add_action('admin_notices', 'gd_admin_notice');
/**
 * Add to admin 
 */
function lf_add_theme_uri()
{
	?>
	<script language="javascript" type="text/javascript">
		if(typeof  THEME_URI == 'undefined')
		{
			var THEME_URI = '<?php echo get_template_directory_uri(); ?>';
		}
	</script>
	<?php
}
add_action('admin_enqueue_scripts', 'lf_add_theme_uri', 1);

/**
 * Print JS Code
 * @global object $admin_menu
 * @param string $hook 
 */
function lf_admin_print_scripts($hook) {
	global $admin_menu;
	
	if ( ($hook == 'post.php') 
		|| ($hook == 'post-new.php')
		||  $admin_menu->isEditThemeSubmenu())
	{
		echo $admin_menu->getJSCode();
		$admin_menu->printAdminScript();
	}
}
add_action('admin_head', 'lf_admin_print_scripts'); 
  
 /**
  * Enqueue CSS for admin part
  */
 function lf_admin_enqueue_styles() {
	 global $admin_menu;
	 if($admin_menu->isEditThemeSubmenu())
	 {
		 $admin_menu->getCSS();
	 }
}
add_action('admin_init', 'lf_admin_enqueue_styles');

/**
 * Removing file using Ajax
 * @global object $admin_menu 
 */
function ajax_file_rm() {	
	global $admin_menu;
	
	$admin_menu->removeFile();
}
add_action('wp_ajax_file_rm', 'ajax_file_rm');

function ajax_file_up()
{
	global $admin_menu;
	
	$admin_menu->addFile();
}
add_action('wp_ajax_file_up', 'ajax_file_up');

/**
 * Deleting sidebar using ajax
 * @global object $admin_menu
 * @global object $wpdb 
 * 
 */
function ajax_sidebar_rm()
{	
	global $admin_menu, $wpdb;

	$admin_menu->removeSidebar($wpdb);
}
add_action('wp_ajax_sidebar_rm', 'ajax_sidebar_rm');

/**
 * ??
 */
function ajax_install_dummy()
{	
	//include("dummy/lf_import.php");
	//installDummy();
	$importer = new Import_Dummy();
	$importer->run();
	
}
add_action('wp_ajax_install_dummy', 'ajax_install_dummy');

//function wordpress_odin_importer_init() {
//	load_plugin_textdomain( 'wordpress-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
//
//	/**
//	 * WordPress Importer object for registering the import callback
//	 * @global WP_Import $wp_import
//	 */
//	$GLOBALS['wp_import'] = new Import_Importer();
//	register_importer( 'wordpress', 'WordPress', __('Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.', 'wordpress-importer'), array( $GLOBALS['wp_import'], 'dispatch' ) );
//}
//add_action( 'admin_init', 'wordpress_odin_importer_init' );

/**
 * Add menu items to top admin bar.
 * 
 * @global object $wp_admin_bar WP_Admin_Bar
 * @global object $admin_menu Admin_Theme_Menu
 */
function lf_admin_bar_render() {
	global $wp_admin_bar, $admin_menu;
	$admin_menu->setAdminBar($wp_admin_bar);
}
add_action('wp_before_admin_bar_render', 'lf_admin_bar_render');

function lf_media_send_to_editor($html, $attachment_id, $attachment)
{
	$post =& get_post($attachment_id);
	if ( in_array($post->post_mime_type, get_allowed_mime_types()) // is supported by WP
		&& in_array($post->post_mime_type, array('audio/mpeg', 'audio/mp4', 'audio/ogg', 'audio/webm', 'audio/wav')))
	{
		return "[thaudio href='".esc_url($attachment['url'])."']{$attachment['post_title']}[/thaudio]";
	}
	return $html;
}

add_filter('media_send_to_editor', 'lf_media_send_to_editor', 10, 3);

add_action('admin_head', 'wpml_lang_init');

function wpml_lang_init()
{
	if(defined('ICL_LANGUAGE_CODE'))
	{?>
		<script>
			var qd_wpml_lang = '?lang=<?php echo ICL_LANGUAGE_CODE?>';
		</script>
	<?php
	}
	else
	{?>
		<script>
			var qd_wpml_lang = '';
		</script>
	<?php
	}
}

add_action( 'admin_enqueue_scripts', 'lf_enqueue_scripts' ,10,1);

function lf_enqueue_scripts($hook){

    $screen = get_current_screen();
    
    if ( ('post.php' == $hook || 'post-new.php' == $hook) && 'qd_galleries' == $screen->post_type ){
        wp_enqueue_script('metaboxes_gallery');
    }
	
	if ( ('post.php' == $hook || 'post-new.php' == $hook) && 'post' == $screen->post_type ){
        wp_enqueue_script('metaboxes_post');
    }
	
	if ( ('post.php' == $hook || 'post-new.php' == $hook) && 'page' == $screen->post_type ){
        wp_enqueue_script('metaboxes_page');
    }
}
?>