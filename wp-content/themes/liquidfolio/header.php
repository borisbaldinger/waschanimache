<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<?php
		if (!get_option(SHORTNAME . "_gfontdisable"))
		{
			?>
			<link href='//fonts.googleapis.com/css?family=<?php
			$gfont = array();
			if (get_option(SHORTNAME . "_preview") != "")
			{


				if (isset($_SESSION['lf_gfont']))
				{
					$gfont[] = $_SESSION['lf_gfont'];
				}
				
			}
			else
			{

				
				$gfont[] = get_option(SHORTNAME . '_gfont').':'.Admin_Theme_Element_Select_Gfont::DEFAULT_STYLE;
				$gfont[] = get_option(SHORTNAME . '_logo_gfont').':'.Admin_Theme_Element_Select_Gfont::DEFAULT_STYLE;
				
			}
			
			if(!count($gfont))
			{
				//default style
				$gfont[] = "Open Sans:".Admin_Theme_Element_Select_Gfont::DEFAULT_STYLE;
			}
			
			echo str_replace(' ', '+', implode('|', array_unique($gfont)));
			?>' rel='stylesheet' type='text/css'>
	 <?php } ?>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="<?php echo home_url(); ?>">
		<title>
			<?php
			if (!defined('WPSEO_VERSION'))
	{
		// if there is no WordPress SEO plugin activated

		wp_title(' | ', true, 'right');
		bloginfo('name');
				?> | <?php
			bloginfo('description'); // or some WordPress default
		}
		else
		{
			wp_title();
		}
			?>	
		</title>
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php  bloginfo('rss2_url');  ?>">	
		
		<?php 
		if (is_singular() && get_option('thread_comments'))
		{
			wp_enqueue_script('comment-reply');
		}
		wp_head();
		?>
	</head>	
	<?php
		$body_styles = null;
		if (is_singular()) {
			if(get_post_meta(get_the_ID(), SHORTNAME . '_post_background_settings', true) == "custom") {
				$body_styles = "style='";
				if(get_post_meta(get_the_ID(), SHORTNAME . '_post_background_custom', true)) {
					$body_styles .=   "background: url(".get_post_meta(get_the_ID(), SHORTNAME . '_post_background_custom', true)." ) ".get_post_meta(get_the_ID(), SHORTNAME . '_post_background_repeat', true)." ".get_post_meta(get_the_ID(), SHORTNAME . '_post_background_attachment', true)." ".get_post_meta(get_the_ID(), SHORTNAME . '_post_background_x', true)." ".get_post_meta(get_the_ID(), SHORTNAME . '_post_background_y', true).";";
				} else {
					$body_styles .=   "background:none;";
				}
				
				if(get_post_meta(get_the_ID(), SHORTNAME . '_post_background_color', true) && get_post_meta(get_the_ID(), SHORTNAME . '_post_background_color', true) !='#')
				{
					$body_styles .=   "background-color:".get_post_meta(get_the_ID(), SHORTNAME . '_post_background_color', true).";";
				}
				 $body_styles .=  "'";
			}
		}
		?>	
	<body <?php body_class(); ?> <?php echo $body_styles ?>>
	<!--[if lt IE 8]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<!-- Header area -->
	<div class="content_bg">	
		<div class="header_bar">
			<div class="header_indent clearfix">
				
				<div class="column-left">
					<?php get_search_form() ?>
				</div>
				<div class="column-main">
					
					<?php if (is_page() && get_post_meta(get_the_ID(),'_wp_page_template',true) == 'template-galleries.php' && !get_post_meta(get_the_ID(),SHORTNAME . '_gallery_filters',true)) { ?>
						<div class="clearfix filters">
							<?php 
							$post_color = (get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true) : null;

							$all_categories_ids  = get_terms(Custom_Posts_Type_Gallery::TAXONOMY, array('fields'=>'ids'));
							$gallery_cat = get_post_meta(get_the_ID(), SHORTNAME . '_gallery_cat', true);
							
							if($gallery_cat && is_array($gallery_cat))
							{
								$exclude = array_diff($all_categories_ids, $gallery_cat);
							}
							else
							{
								$exclude = $all_categories_ids;
							}
							
							

							$args = array(
								'taxonomy'			=> Custom_Posts_Type_Gallery::TAXONOMY,
//								'child_of'			=> $parent,
								'exclude'			=> $exclude,
								'title_li'			=> '',
								'show_option_none'	=> '',
								'hierarchical'		=> false,
								'hide_empty'		=> 1,
								'walker'			=> new Walker_Category_Color()
							);
							?>
							<ul>	  
								
								<li><?php _e('VIEW:', 'liquidfolio') ?></li>
								<li class="*"><a href="#" class="selected" data-color="<?php echo $post_color;?>"><?php _e('All', 'liquidfolio') ?></a></li>
								<?php echo wp_list_categories( $args ); ?>
							</ul>
						  </div>
					<?php } ?>
					
					<div class="social_links_area">
						<?php if($header_tinymce_content = get_option(SHORTNAME . '_header_tinymce')) {
							echo qd_the_content($header_tinymce_content);
						}
						?>
					</div>
				</div>
			</div>
		</div>
		
		<header>
			<div class="logo">
				<?php
						if (is_front_page())
						{
							?><h1><?php } ?>
						<?php
						if (get_option(SHORTNAME . "_logo_txt"))
						{
							if (get_bloginfo('name'))
							{
								?><a href="<?php echo (get_option(SHORTNAME."_preview"))? '/' : wpml_get_home_url(); ?>"><span><?php bloginfo('name'); ?></span></a><?php
							}
						}
						elseif (get_option(SHORTNAME . "_logo_custom"))
						{
							$data_retina = '';
							$retina = get_option(SHORTNAME . "_logo_retina_custom");
							if($retina)
							{
								$data_retina = ' data-retina="'.$retina.'" ';
							}									
							?>
								<a href="<?php echo (get_option(SHORTNAME."_preview"))? '/' : wpml_get_home_url(); ?>"><img src="<?php echo get_option(SHORTNAME . "_logo_custom"); ?>" alt="<?php bloginfo('name'); ?>"<?php echo $data_retina; ?>><span class="hidden"><?php bloginfo('name'); ?></span></a>
					<?php } 
						if (is_front_page())
						{
						?></h1><?php } ?>
			</div>
			<div class="description"><?php bloginfo('description'); ?></div>
			<div class="mainmenu <?php echo (get_option(SHORTNAME . "_menu_left")) ? 'menu_left' : ''; ?>">			
				<?php
				wp_nav_menu(array('theme_location' => 'main-menu', 'container_class' => 'main_menu', 'menu_class' => 'sf-menu', 'fallback_cb' => '', 'container' => 'nav', 'link_before' => '', 'link_after' => '', 'walker' => new Walker_Nav_Menu_Sub()));
				wp_nav_menu(array('theme_location' => 'main-menu', 'container_class' => 'main_menu_select', 'menu_class' => '', 'fallback_cb' => '', 'container' => 'nav', 'items_wrap' => '<select>%3$s</select>', 'walker' => new Walker_Nav_Menu_Dropdown()));
				?>
			</div>		
			
			<div class="clear"></div>
			
			<div class="sidebar_bg"></div>
			
		</header>
		
		
		
		<!-- Content area -->
		<div role="main" id="main">