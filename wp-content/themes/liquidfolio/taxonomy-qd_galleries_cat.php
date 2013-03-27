<?php get_header(); ?>
<div class="content_area gallery_template">

<?php

	$term = $wp_query->get_queried_object();
	

	$gallery_cat = $term->term_id;
	/**
	 * get page size for gallery thumbnails
	 */

	if(get_tax_meta($gallery_cat, SHORTNAME . '_post_listing_thumb', true) == 'custom')
	{
		$page_width = get_tax_meta($gallery_cat, SHORTNAME . '_post_listing_thumb_x', true);
		$page_height = get_tax_meta($gallery_cat, SHORTNAME . '_post_listing_thumb_y', true);
	}
	else
	{
		$page_width = get_option( SHORTNAME . Custom_Thumbnail_Gallery::GLOBAL_PAGE_WIDTH);
		$page_height = get_option( SHORTNAME . Custom_Thumbnail_Gallery::GLOBAL_PAGE_HEIGHT);
	}


	if(!$page_height && !$page_width)
	{
		$page_height = Custom_Thumbnail_Gallery::DEFAULT_HEIGHT;
		$page_width = Custom_Thumbnail_Gallery::DEFAULT_WIDTH;
	}
	?>
	<script>
			var col_width = <?php echo (int)($page_width-20) ?>;
	</script>







<?php




$args = array('posts_per_page'	=> '-1',
				'post_status'		=> 'publish',
				'post_type'			=> Custom_Posts_Type_Gallery::POST_TYPE,
				'paged'				=> '1',
				'ignore_sticky_posts' => true,
				'order'				=> 'DESC',
				'tax_query' => array(
						array(
							'taxonomy'			=> Custom_Posts_Type_Gallery::TAXONOMY,
							'field'				=> 'id',
							'terms'				=> $gallery_cat,
							'include_children'	=> true,
						)
	)
		);

	$gallery_list = new WP_Query($args);


/* Start the Loop  */
if ($gallery_list && $gallery_list->have_posts()) :?>

<div class="row gallery_wrap">
<?php wp_enqueue_script('jquery-effects-core'); ?>
<?php wp_enqueue_script('swfobject');?>
<?php wp_enqueue_script('jplayer');?>
<?php	while ($gallery_list->have_posts()) : $gallery_list->the_post();
//---------------------------------------------

		//MULTIPLICITY CALCULATION
		$article_style	= '';
		$multi_width	= 1;
		$multi_height	= 1;

		if($multiplicity = get_post_meta(get_the_ID(), SHORTNAME . Custom_Thumbnail_Gallery::MULTIPLICITY, true))
		{
			list($multi_width, $multi_height) = explode('|', $multiplicity);
		}

		$style_width = $page_width * $multi_width - 20*$multi_width;
		$style_height = $page_height * $multi_height - 20*$multi_height;
		$color = get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true);
		if ( get_post_format() ) {
			$post_format = get_post_format();
		} else {
			$post_format = '';
		}
		if(!($color && $color !='#'))
		{
			$color = get_option(SHORTNAME.'_gallery_'.$post_format.'_color');
		}


		$article_style = ' style="width:'.$style_width.'px; height:'.$style_height.'px" ';
		// end multiplicity calculation

//---------------------------------------------

		// COLOR SETTINGS
		$term_id = NULL;
		$terms = wp_get_post_terms(get_the_ID(), Custom_Posts_Type_Gallery::TAXONOMY);
		foreach ($terms as $termid) {
			$term_id =  $term_id.' cat-item-'.$termid->term_id;
		}

		$post_color = (get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true) : null;
		// end color settings

//---------------------------------------------

		//SHOWING TITLE SETTINGS
		if(get_post_meta(get_the_ID(), SHORTNAME . '_post_listing_title', true) == 'custom')
		{
			$isShowingTitle = (bool) get_post_meta(get_the_ID(), SHORTNAME . '_show_gallery_title', true);
		}
		else
		{
			$isShowingTitle = (bool) get_tax_meta($gallery_cat, SHORTNAME . '_post_listing_title', true);
		}

		$showTitle = '';
		if($isShowingTitle)
		{
			$showTitle = ' data-show_title="yes"';
		}
		// End Showing title

//---------------------------------------------

		// LIGHTBOX TYPE SETTINGS
		if(get_post_meta(get_the_ID(), SHORTNAME . '_gallery_lightbox_setting', true) == 'custom')
		{
			// Gallery value
			$lightBoxType = get_post_meta(get_the_ID(), SHORTNAME . '_gallery_lightbox_type', true);
		}
		else
		{
			// Page value
			$lightBoxType = get_tax_meta($gallery_cat, SHORTNAME . '_post_listing_lightbox', true);
		}

		if(!$lightBoxType)
		{
			$lightBoxType = 'fullscreen';
		}
		$lightboxData = ' data-lightbox="'.$lightBoxType.'"';
		// end Lightbox type

//---------------------------------------------
?>
	<article <?php post_class($term_id.' gallery_listing') ?> id="post-<?php the_ID(); ?>" <?php echo $article_style;?> data-wm="<?php echo $multi_width?>" data-hm="<?php echo $multi_height?>" data-show_title="<?php echo $showTitle; ?>" <?php echo ($lightBoxType !== 'permalink')?$lightboxData: '';?>>
		<?php if (has_post_thumbnail())	{ ?>
		<a href="<?php the_permalink(); ?>"    style="background:transparent"  class="double_thumb loading" data-pagew ="<?php echo $page_width;?>" data-pageh="<?php echo $page_height; ?>" data-galleryid="<?php echo get_the_ID(); ?>" data-gallery_page_id="<?php echo $current_page_ID;?>"><ul>
			<?php 
				for ($i=0;$i<9;$i++){
				echo	'<li style="background-color:'.$color.';"></li>';		      
				}
			?>
		</ul></a>	
				<?php } ?>		   
					<div class="postcontent" <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
						
						<div class="postcontent-bg" >
							<div class="post_format"><a href="<?php the_permalink() ?>"   <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
						</div>
						
						<div class="postcontent-indent">
							
							<h2 class="postcontent-title"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h2>	
							<div class="postcategories"><?php echo get_the_term_list(get_the_ID(), Custom_Posts_Type_Gallery::TAXONOMY,'',' / ',''); ?></div>
						</div>
					</div>
				</article>				
			

			
	<?php endwhile; ?>

</div>

<?php else : ?>
	<article class="hentry">
		<h1>
	<?php _e('Not Found', 'liquidfolio'); ?>
		</h1>
		<p class="center">
	<?php _e('Sorry, but you are looking for something that isn\'t here.', 'liquidfolio'); ?>
		</p>
	</article>
<?php endif; ?>
<?php wp_reset_query(); ?>

</div>
<?php get_footer(); ?>