<?php 
//ACTIVATION
global $pagenow;
if (is_admin() && isset($_GET['activated'])  && $pagenow == "themes.php"){

	// redirect to theme options
	wp_redirect(admin_url("admin.php?page=".SHORTNAME."_dummy"));		
}
//CLEANUP

// remove WordPress version from RSS feed
function qd_no_generator() { return ''; }
add_filter('the_generator', 'qd_no_generator');

// cleanup wp_head
function qd_noindex() {
	if (get_option('blog_public') === '0') {
    echo '<meta name="robots" content="noindex,nofollow">', "\n";
  }
}	

add_filter( 'media_view_strings', 'qd_media_view_strings' );
/**
 * Removes the media 'From URL' string.
 *
 * @see wp-includes|media.php
 */
function qd_media_view_strings( $strings ) {
	global $admin_menu;
	if($admin_menu && $admin_menu->isEditThemeSubmenu())
	{
		unset( $strings['insertFromUrlTitle'] );
	}
    return $strings;
}


function qd_rel_canonical() {
	if (!is_singular()) {
		return;
  }

	global $wp_the_query;
	if (!$id = $wp_the_query->get_queried_object_id()) {
		return;
  }

	$link = get_permalink($id);
	echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

// remove CSS from recent comments widget
function qd_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}

// remove CSS from gallery
/*function qd_gallery_style($css) {
	return preg_replace("/<style type='text\/css'>(.*?)<\/style>/s", '', $css);
}*/

function qd_head_cleanup() {
	// http://wpengineer.com/1438/wordpress-header/
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'noindex', 1);	
	add_action('wp_head', 'qd_noindex');
	remove_action('wp_head', 'rel_canonical');	
	add_action('wp_head', 'qd_rel_canonical');
	add_action('wp_head', 'qd_remove_recent_comments_style', 1);	
	//add_filter('gallery_style', 'qd_gallery_style');
}

add_action('init', 'qd_head_cleanup');

////
//OTHER TWEAKS
////


// we don't need to self-close these tags in html5:
// <img>, <input>
function qd_remove_self_closing_tags($input) {
	return str_replace(' />', '>', $input);
}

add_filter('get_avatar', 'qd_remove_self_closing_tags');
add_filter('comment_id_fields', 'qd_remove_self_closing_tags');

// set the post revisions to 5 unless the constant
// was set in wp-config.php to avoid DB bloat
if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 5);

// allow more tags in TinyMCE including iframes
function qd_change_mce_options($options) {
	$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';	
	if (isset($initArray['extended_valid_elements'])) {
		$options['extended_valid_elements'] .= ',' . $ext;
	} else {
		$options['extended_valid_elements'] = $ext;
	}
	return $options;
}

add_filter('tiny_mce_before_init', 'qd_change_mce_options');

//clean up the default WordPress style tags
add_filter('style_loader_tag', 'qd_clean_style_tag');

function qd_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  //only display media if it's print
  $media = $matches[3][0] === 'print' ? ' media="print"' : '';                                                                             
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

//lightbox replace

add_filter('the_content', 'addlightboxrel_replace', 12);

add_filter('get_comment_text', 'addlightboxrel_replace');

function addlightboxrel_replace ($content)
{   global $post;
	if($post)
	{
		$color = get_post_meta($post->ID, SHORTNAME . '_post_color', true);
		if ( get_post_format($post->ID) ) {
			$post_format = get_post_format($post->ID);
		} else {
			$post_format = 'standart';
		}
		if(!($color && $color !='#'))
		{
			if (is_page()){
				$color = get_option(SHORTNAME.'_page_color');
			} else {
				$color = get_option(SHORTNAME.'_pf_'.$post_format);
			}
		}
		
		$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 data-pp="lightbox" data-fancybox-color="'.$color.'" rel="'.$post->ID.'" class="lightbox autolink"$6 data-script="fancybox">$7</a>';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}
	return $content;
}

function qd_the_content($content)
{
	/**
	* @see http://wordpress.stackexchange.com/questions/9667/get-wordpress-post-content-by-post-id
	*/
	
	$content = wpautop($content);
	$content = do_shortcode($content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}


//SEO meta

function add_theme_favicon() {
	if( get_option(SHORTNAME."_favicon")) { 
	 ?>
	<link rel="shortcut icon" href="<?php echo get_option(SHORTNAME."_favicon"); ?>" />
<?php } }
add_action('wp_head', 'add_theme_favicon');

function default_comments_off( $data ) {
	// each custom post type has default_comments_off method to.
    if($data['post_type'] == 'page' && $data['post_status'] == 'auto-draft')
	{
        $data['comment_status'] = 0;
		$data['ping_status'] = 0;
    }
	
    return $data;
}
add_filter( 'wp_insert_post_data', 'default_comments_off' );


function imgborder_from_editor($class){
$class=$class.' imgborder';
return $class;
}
add_filter('get_image_tag_class','imgborder_from_editor');

function qd_restore_image_title( $html, $id ) {

    /* retrieve the post object */
    $attachment = get_post( $id );

    /* if the title attribute is already present, bail early */
    if ( strpos( $html, 'title=' ) )
        return $html;

    /* retrieve the attached image attrbute */
    $image_title = esc_attr( $attachment->post_title );

    /* apply the title attribute to the image tag */
    $html = str_replace( '<img', '<img title="' . $image_title . '" ', $html );
	return  str_replace( '<a', '<a title="' . $image_title . '" ', $html );
}
add_filter( 'media_send_to_editor', 'qd_restore_image_title', 15, 2 );

function default_widgets_init() {	

  if ( isset( $_GET['activated'] ) ) {
  
  		update_option( 'sidebars_widgets', array (
							 'default-sidebar' => array('search')
							 ));
  }
}
add_action('widgets_init', 'default_widgets_init');

// CUSTOMIZE ADMIN MENU ORDER
function custom_menu_order($menu_ord)
{
	if (!$menu_ord)
	{
		return true;
	}
	return array(
		'index.php',
		'separator1',
		'edit.php',
		'edit.php?post_type=page',
		
		'edit.php?post_type=' . Custom_Posts_Type_Gallery::POST_TYPE,
		
		'separator2',
		SHORTNAME . '_general',
		'separator-last'
	);
}

add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');

// CUSTOM USER PROFILE FIELDS
function my_custom_userfields($contactmethods)
{
	// ADD CONTACT CUSTOM FIELDS
	$contactmethods['conatct_twitter'] = 'Twitter';
	$contactmethods['conatct_facebook'] = 'Facebook';
	$contactmethods['conatct_gplus'] = 'Gplus';
	$contactmethods['contact_phone_office'] = 'Office Phone';
	$contactmethods['contact_phone_mobile'] = 'Mobile Phone';
	$contactmethods['contact_office_fax'] = 'Office Fax';

	// ADD ADDRESS CUSTOM FIELDS
	$contactmethods['address_line_1'] = 'Address Line 1';
	$contactmethods['address_line_2'] = 'Address Line 2 (optional)';
	$contactmethods['address_city'] = 'City';
	$contactmethods['address_state'] = 'State';
	$contactmethods['address_zipcode'] = 'Zipcode';
	return $contactmethods;
}

add_filter('user_contactmethods', 'my_custom_userfields', 10, 1);
   
   
//Remove read more page jump
function remove_more_jump_link($link)
{
	$offset = strpos($link, '#more-');
	if ($offset)
	{
		$end = strpos($link, '"', $offset);
	}
	if ($end)
	{
		$link = substr_replace($link, '', $offset, $end - $offset);
	}
	 $link = str_replace(
         'more-link'
        ,'more-link qd_button_small'
        ,$link
    );
	return '<div  class="aligncenter">'.$link.'</div>';
}

add_filter('the_content_more_link', 'remove_more_jump_link');

//remove pings to self
function no_self_ping(&$links)
{
	$home = home_url();
	foreach ($links as $l => $link)
	{
		if (0 === strpos($link, $home))
			unset($links[$l]);
	}
}

add_action('pre_ping', 'no_self_ping');

// customize admin footer text
function custom_admin_footer() {
        echo 'Copyrighted by '.get_option('blogname').'. | Developed by <a href="http://queldorei.com" title="WordPress Premium Themes" >Queldorei</a>.';
} 
add_filter('admin_footer_text', 'custom_admin_footer');

//
function new_excerpt_more($more) {
	return '...';
}

add_filter('excerpt_more', 'new_excerpt_more');

//excerpt length
function excerpt($num) {
    $limit = $num+1;
	$cleaned = $text = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', get_the_excerpt());
    $excerpt = substr($cleaned,0, $limit);
    
    $excerpt .= "...";
    echo $excerpt;
}

// Theme default avatar
//add_filter( 'avatar_defaults', 'newgravatar' );
// 
//function newgravatar ($avatar_defaults) {
//    $myavatar = get_template_directory_uri() . '/images/noava.png';
//    $avatar_defaults[$myavatar] = THEMENAME;
//    return $avatar_defaults;
//}

//Password protected form
add_filter( 'the_password_form', 'qd_password_form' );

function qd_ajax_calendar_walker()
{
	require_once get_template_directory() . '/lib/shortcode/eventsCalendar.php';
	die();
}
add_action('wp_ajax_calendar_walker', 'qd_ajax_calendar_walker');
add_action('wp_ajax_nopriv_calendar_walker', 'qd_ajax_calendar_walker');

function qd_ajax_send_contact_form()
{
	require_once get_template_directory() . '/lib/shortcode/contactForm/contactsend.php';
	die();
}
add_action('wp_ajax_send_contact_form', 'qd_ajax_send_contact_form');
add_action('wp_ajax_nopriv_send_contact_form', 'qd_ajax_send_contact_form');


function qd_password_form() {
	global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form class="protected-post-form" action="' . get_option( 'siteurl' ) . '/wp-login.php?action=postpass" method="post">   
    <label for="' . $label . '">' . __( "To view this protected post, enter the password below:",'liquidfolio' ) . ' </label><input class="password_input" name="post_password" id="' . $label . '" type="password" size="20"  placeholder="'.__('Enter password','liquidfolio').'" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" class="password_submit" />
    </form>
    ';
    return $o;
}

/**
 * Determine if data was sent to a specific page using an xmlhttprequest.
 * @return boolran true if AJAX
 */
function isAjaxCall() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function qd_the_title_trim($title) {
$title = esc_attr($title);
$findthese = array(
    '#Protected:#',
    '#Private:#'
);
$replacewith = array(
    '', // What to replace "Protected:" with
    '' // What to replace "Private:" with
);
$title = preg_replace($findthese, $replacewith, $title);
return $title;
}
add_filter('the_title', 'qd_the_title_trim');

//Searchbox placeholder
function lf_search_form( $form ){
	 return '<form role="search" method="get" id="searchform" action="' . esc_url( home_url() ) . '">
	 <div><label class="screen-reader-text" for="s">'.__('Search for:','liquidfolio').'</label>
	 <input type="text" value="' . ( is_search() ? get_search_query() : '' ) . '" name="s" id="s" placeholder="'.__('To search type and hit enter','liquidfolio').'">
	 <input type="submit" id="searchsubmit" value="'.__('Search','liquidfolio').'">
	 </div>
	 </form>';
}
add_filter( 'get_search_form', 'lf_search_form', 99999 );

function qd_dropdown_categories( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'show_option_none' => '',
		'orderby' => 'id', 'order' => 'ASC',
		'show_count' => 0,
		'hide_empty' => 1, 'child_of' => 0,
		'exclude' => '', 'echo' => 1,
		'selected' => array(0), 'hierarchical' => 0,
		'name' => 'cat', 'id' => '',
		'class' => 'taxonomy_multiselect', 'depth' => 0,
		'tab_index' => 0, 'taxonomy' => 'category',
		'hide_if_empty' => false,
		'is_multiple' => false,
		'multiple_size' =>6
		
	);
	
	if(isset($args['name']) && $args['name'])
	{
		$args['name'] = $args['name']. '[]';
	}
//	$defaults['selected'] = ( is_category() ) ? get_query_var( 'cat' ) : 0;
	if(isset($args['selected']))
	{
		if(is_array($args['selected']))
		{
			$defaults['selected'] = $args['selected'];
		}
		elseif(is_string($args['selected']))
		{
			$defaults['selected'] = explode(',', $args['selected']);
		}
		elseif (is_integer($args['selected']))
		{
			$defaults['selected'] = array($args['selected']);
		}
		else
		{
			$defaults['selected'] = array();
		}
	}
	
	if(isset($args['is_multiple']) && $args['is_multiple'])
	{
		$multiple = 'multiple="multiple"';
		if(isset($args['multiple_size']))
		{
			$multiple .= ' size="'.$args['multiple_size'].'"';
		}
		else
		{
			$multiple .= ' size="'.$defaults['multiple_size'].'" ';
		}
	}
	else
	{
		$multiple = '';
	}

	// Back compat.
	if ( isset( $args['type'] ) && 'link' == $args['type'] ) {
		_deprecated_argument( __FUNCTION__, '3.0', '' );
		$args['taxonomy'] = 'link_category';
	}

	$r = wp_parse_args( $args, $defaults );
	if($r['selected'] === '')
	{
		$r['selected'] = array();
	}
	
	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
		$r['pad_counts'] = true;
	}

	extract( $r );

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 )
		$tab_index_attribute = " tabindex=\"$tab_index\"";

	$categories = get_terms( $taxonomy, $r );
	$name = esc_attr( $name );
	$class = esc_attr( $class );
	$id = $id ? esc_attr( $id ) : $name;

	if ( ! $r['hide_if_empty'] || ! empty($categories) )
		$output = "<select name='$name' id='$id' class='$class' $tab_index_attribute $multiple>\n";
	else
		$output = '';

	if ( empty($categories) && ! $r['hide_if_empty'] && !empty($show_option_none) ) {
		$show_option_none = apply_filters( 'list_cats', $show_option_none );
		$output .= "\t<option value='-1' selected='selected'>$show_option_none</option>\n";
	}

	if ( ! empty( $categories ) ) {

		if ( $show_option_all ) {
			$show_option_all = apply_filters( 'list_cats', $show_option_all );
			$selected = ( in_array( 0, $r['selected'] ) /*'0' === strval($r['selected'])*/ ) ? " selected='selected'" : '';
			$output .= "\t<option value='0'$selected>$show_option_all</option>\n";
		}

		if ( $show_option_none ) {
			$show_option_none = apply_filters( 'list_cats', $show_option_none );
			$selected = ( in_array( -1, $r['selected'] ) /*'-1' === strval($r['selected']) */) ? " selected='selected'" : '';
			$output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
		}

		if ( $hierarchical )
			$depth = $r['depth'];  // Walk the full depth.
		else
			$depth = -1; // Flat.
		
		$r['walker'] = new Walker_Category_Multiselect();
		$output .= walk_category_dropdown_tree( $categories, $depth, $r );
	}

	if ( ! $r['hide_if_empty'] || ! empty($categories) )
		$output .= "</select>\n";

	$output = apply_filters( 'wp_dropdown_cats', $output );

	if ( $echo )
		echo $output;

	return $output;
}
function print_filters_for( $hook = '' ) {
    global $wp_filter;
    if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
        return;

    print '<pre>';
    print_r( $wp_filter[$hook] );
    print '</pre>';
}

function by_post_author() {
	if (get_option(SHORTNAME . "_showauthor")){ 
		echo_author_info();
	}
}

function by_gallery_author() {
	if (get_option(SHORTNAME . "_show_gallery_author")){ 
		echo_author_info();
	}
}

function post_navigation()
{
	if (get_option(SHORTNAME . "_shownavi"))
	{
		echo_post_navigation( true );
	}
}

function gallery_navigation()
{
	if (get_option(SHORTNAME . "_show_gallery_navi"))
	{
		echo_post_navigation( get_option(SHORTNAME . "_show_gallery_blog_link") );
	}
}

function echo_author_info() {
	?>
	<div class="authormeta" >
		<div class="authorimage"><?php echo get_avatar(get_the_author_meta('email'), '100'); ?></div>
		<div class="authorblock">
			<span class="authorname">Author: <strong><?php the_author_meta('display_name'); ?></strong></span>
			<span class="authorinfo"><?php the_author_meta('description'); ?></span>
		</div>
	</div>
	<?php
}

function echo_post_navigation($showBlogLink) {
	?>
	<div class="postnav">
		<span class="prev_post_link"><?php previous_post_link('%link', 'Prev'); ?></span>
		<?php if($showBlogLink){
			$blog_url = (get_option('show_on_front') == 'page') ? get_permalink(get_option('page_for_posts')) : get_bloginfo( 'url', 'display' )
		?>
			<span class="blog_link"><a href="<?php echo $blog_url; ?>" title="<?php _e('Blog', 'liquidfolio')?>"><?php _e('Blog', 'liquidfolio')?></a></span>
		<?php } ?>
		<span class="next_post_link"><?php next_post_link('%link', 'Next'); ?></span>
	</div>
	<?php
}
?>