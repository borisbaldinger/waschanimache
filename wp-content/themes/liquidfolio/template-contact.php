<?php

$location_img =  get_option(SHORTNAME . '_map_location');
if(isset($post) && isset($post->ID))
{
	if(get_post_meta($post->ID, SHORTNAME . '_map_location_settings', true) == 'custom')
	{
		if($custom_img = get_post_meta($post->ID, SHORTNAME . '_map_location_custom', true))
		{
			$location_img = $custom_img;
		}
	}
}

wp_localize_script( 'jquery', 'contact', array(
						'location_img'	=> $location_img,
					));
/*
  Template Name: Contact
 */
?>
<?php get_header(); ?>
<div class="content_area tpl_contact clearfix">	
	<div class="txt-a-r"><?php
	if ( have_posts()) : while (have_posts()) : the_post();
		
		$post_color = (get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true) : null;
		$post_color2 = (get_post_meta(get_the_ID(), SHORTNAME . '_post_color2', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_post_color2', true) : null;
	?>
		<div class="contact_adress">
			<a class="gallery_close close1 close_map_boxes" href="#"><span></span></a>
			<article id="page-<?php the_ID(); ?>" class="page small_post_size" <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
				<div class="post_format"><span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'" data-color="'.$post_color.'"';}?>></span></div>
				<h1 class="contact-title"><?php the_title(); ?></a></h1>
				<div class="entry-content clearfix">
					<?php the_content(); ?>
				</div>
			</article>
		</div>
	<?php  if(get_post_meta(get_the_ID(), SHORTNAME . '_contact_second_show', true)) { ?>
		<div class="contact_form">
			<a class="gallery_close close2 close_map_boxes" href="#"><span></span></a>
			<article class="page small_post_size" <?php if ($post_color2){ echo 'style="border-color:'.$post_color2.'" data-color="'.$post_color2.'"';}?>>
				<div class="post_format"><span <?php if ($post_color2){ echo 'style="background-color:'.$post_color2.'" data-color="'.$post_color2.'"';}?>></span></div>
				<h1 class="contact-title">
					<?php if(get_post_meta(get_the_ID(), SHORTNAME . '_contact_second_title', true) && get_post_meta(get_the_ID(), SHORTNAME . '_contact_second_show', true)) {
							echo get_post_meta(get_the_ID(), SHORTNAME . '_contact_second_title', true);
						}
						?></h1>
				<div class="entry-content">
					<?php if(get_post_meta(get_the_ID(), SHORTNAME . '_contact_second_cont', true) && get_post_meta(get_the_ID(), SHORTNAME . '_contact_second_show', true)) {
							echo qd_the_content(get_post_meta(get_the_ID(), SHORTNAME . '_contact_second_cont', true));
						}
						?>
				</div>
			</article>
		</div>
		<?php } ?>
	<?php endwhile; endif; ?></div>
	<div class="content_map">
		<?php
			if (get_the_ID() && get_post_meta(get_the_ID(), Locate_Api_Map::getMetaKey(), true))
			{
				$map = apply_filters('the_event_map', null);
				echo do_shortcode($map);
			}
		?>
	</div>
</div>
<?php get_footer(); ?>