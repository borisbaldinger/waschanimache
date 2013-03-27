<?php
$i = 0;
//wp_enqueue_script('fitvids');
//wp_enqueue_script('swfobject');
//wp_enqueue_script('jplayer');
//wp_enqueue_script('qd_frogoloop');
//wp_enqueue_script('maximage');
//wp_enqueue_script('validate');

/* Start the Loop  */
if (have_posts()) :
	
	$postmetashow = !get_option(SHORTNAME . "_postmetashow");
	
	echo "<div class='post_wrap'>";

	while (have_posts()) : the_post();

		$post_color = (get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true) : null;
	
			/* Single post gallery */
				if (is_single() && has_post_format('gallery') ) :
//					wp_enqueue_script('cycleall');
					wp_enqueue_script('maximage');
			?>
				<div class="post_single <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
					<div <?php if (comments_open()) : echo 'class="post_inner"'; endif;?> >
						<article <?php post_class('clearfix post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
							
							<?php 
							$portfolio_slides = get_post_meta(get_the_ID(), SHORTNAME . '_project_slider');
						if($portfolio_slides && isset($portfolio_slides[0][0]['slide-img-src']) && $portfolio_slides[0][0]['slide-img-src'] != ''):?>
								<div class="postformat_gallery">
									<?php if($portfolio_slides && is_array($portfolio_slides)):?>
									<a class="prev load-item" id="prev_<?php echo get_the_ID();?>">PREV</a>
										<a class="next load-item" id="next_<?php echo get_the_ID();?>">NEXT</a>
									<?php endif;?>
								<div class="postformat_maximage maximage" data-id="<?php echo get_the_ID();?>">
								<?php foreach(array_shift($portfolio_slides) as $slides):?>
									<img src="<?php echo  $slides['slide-img-src']?>" alt="<?php the_title_attribute(); ?>">
								<?php endforeach;?>
							</div>
						</div>
							<?php elseif (has_post_thumbnail()):?><figure class="post_img"><?php get_theme_post_thumbnail(get_the_ID(), 'large'); ?></figure><?php endif;?>
							<div class="post_format">
								<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></span>
							</div>
							<div class="post_area_title">
								<h1 class="entry-title"><?php the_title(); ?></a></h1>
								<div class="postcategories"><?php echo get_the_term_list( get_the_ID(), Custom_Posts_Type_Gallery::TAXONOMY, '', ', ', '' ); ?></div>
							</div>
							<div class="entry-content">
								<?php the_content(); ?>
								<?php wp_link_pages(array(
								'before' => '<div class="page-pagination">',
								'after' => '</div>',
								'next_or_number' => 'next_and_number',
								'nextpagelink' => __('next page', 'liquidfolio'),
								'previouspagelink' => __('previous page', 'liquidfolio'),
								'pagelink' => '<span>%</span>',
								'echo' => 1 )
							);?>
							</div>
							<?php
							by_gallery_author();
							gallery_navigation();
							?>
							<?php if ($postmetashow): ?>
								<div class="postmeta" >
									<span class="postdata"><?php echo get_the_date( ) ?></span>
									<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
									<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
									<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
								</div>
							<?php endif ?>
						</article>
					</div>
				</div>
				<?php if (comments_open() && !post_password_required()) { ?> 
				<article <?php post_class('post_reply  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_inner">
						<?php comments_template('', true); ?>
					</div>
				</article>
				<?php } ?>
				

			<?php
				/* Single post video */
				elseif (is_single()  && has_post_format( 'video')) :
			?>
				<div class="post_single <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
					<div <?php if (comments_open()) : echo 'class="post_inner"'; endif;?> >
						<article <?php post_class('clearfix  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
							<?php if($video_html =  Theme::get_post_video( get_the_ID())){
								wp_enqueue_script('fitvids');
								?>
								<div class="video_frame" data-script="fitvids">
							<?php echo $video_html; ?>
								</div>
							<?php }?>
							<div class="post_format">
								<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></span>
							</div>
							<div class="post_area_title">
								<h1 class="entry-title"><?php the_title(); ?></a></h1>
								<div class="postcategories"><?php echo get_the_term_list( get_the_ID(), Custom_Posts_Type_Gallery::TAXONOMY, '', ', ', '' ); ?></div>
							</div>
							<div class="entry-content">								
								<?php the_content(); ?>
								<?php wp_link_pages(array(
								'before' => '<div class="page-pagination">',
								'after' => '</div>',
								'next_or_number' => 'next_and_number',
								'nextpagelink' => __('next page', 'liquidfolio'),
								'previouspagelink' => __('previous page', 'liquidfolio'),
								'pagelink' => '<span>%</span>',
								'echo' => 1 )
							);?>
							</div>
							<?php
							by_gallery_author();
							gallery_navigation();
							?>
							<?php if ($postmetashow): ?>							
								<div class="postmeta" >
									<span class="postdata"><?php echo get_the_date( ) ?></span>
									<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
									<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
									<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
								</div>
							<?php endif; ?>
						</article>
					</div>
				</div>
				<?php if (comments_open() && !post_password_required()) { ?> 
				<article <?php post_class('post_reply  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_inner">
						<?php comments_template('', true); ?>
					</div>
				</article>
				<?php } ?>

			
				
			<?php
				/* Single post image */
				elseif (is_single()  && has_post_format( 'image')) :
			?>
				<div class="post_single <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
					<div <?php if (comments_open()) : echo 'class="post_inner"'; endif;?> >
						<article <?php post_class('clearfix  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
							<?php if (has_post_thumbnail()){?><figure class="post_img"><?php get_theme_blog_thumbnail(get_the_ID(), 'single'); ?></figure><?php } ?>
							<div class="post_format">
								<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></span>
							</div>
							<div class="post_area_title">
								<h1 class="entry-title"><?php the_title(); ?></a></h1>
								<div class="postcategories"><?php echo get_the_term_list( get_the_ID(), Custom_Posts_Type_Gallery::TAXONOMY, '', ', ', '' ); ?></div>
							</div>
							<div class="entry-content">								
								<?php the_content(); ?>
								<?php wp_link_pages(array(
									'before' => '<div class="page-pagination">',
									'after' => '</div>',
									'next_or_number' => 'next_and_number',
									'nextpagelink' => __('next page', 'liquidfolio'),
									'previouspagelink' => __('previous page', 'liquidfolio'),
									'pagelink' => '<span>%</span>',
									'echo' => 1 )
								);?>
							</div>
							<?php
							by_gallery_author();
							gallery_navigation();
							?>
							<?php if ($postmetashow): ?>
								<div class="postmeta" >
									<span class="postdata"><?php echo get_the_date( ) ?></span>
									<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
									<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
									<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
								</div>
							<?php endif; ?>
						</article>
					</div>
				</div>
				<?php if (comments_open() && !post_password_required()) { ?> 
				<article <?php post_class('post_reply  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_inner">
						<?php comments_template('', true); ?>						
					</div>
				</article>
				<?php } ?>	
			
			
			<?php
				/* Single post audio */
				elseif (is_single()  && has_post_format( 'audio')) :
			?>
				<div class="post_single <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
					<div <?php if (comments_open()) : echo 'class="post_inner"'; endif;?> >
						<article <?php post_class('clearfix  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
							<?php if (has_post_thumbnail()){?><figure class="post_img"><?php get_theme_blog_thumbnail(get_the_ID(), 'single'); ?></figure><?php } ?>
							<div class="post_format">
								<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></span>
							</div>
							<div class="post_area_title">
								<h1 class="entry-title"><?php the_title(); ?></a></h1>
								<div class="postcategories"><?php echo get_the_term_list( get_the_ID(), Custom_Posts_Type_Gallery::TAXONOMY, '', ', ', '' ); ?></div>
							</div>
							<div class="entry-content">	
								<?php 
						if (get_post_meta(get_the_ID(), SHORTNAME . '_post_audio_url', true)) { 
							
						echo	do_shortcode("[thaudio href='".get_post_meta(get_the_ID(), SHORTNAME . '_post_audio_url', true)."'][/thaudio]");
						}
						?>	
								<?php the_content(); ?>
								<?php wp_link_pages(array(
								'before' => '<div class="page-pagination">',
								'after' => '</div>',
								'next_or_number' => 'next_and_number',
								'nextpagelink' => __('next page', 'liquidfolio'),
								'previouspagelink' => __('previous page', 'liquidfolio'),
								'pagelink' => '<span>%</span>',
								'echo' => 1 )
							);?>
								
							</div>
							<?php
							by_gallery_author();
							gallery_navigation();
							?>
							<?php if ($postmetashow): ?>
								<div class="postmeta" >
									<span class="postdata"><?php echo get_the_date( ) ?></span>
									<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
									<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
									<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
								</div>
							<?php endif; ?>
						</article>
					</div>
				</div>
				<?php if (comments_open() && !post_password_required()) { ?> 
				<article <?php post_class('post_reply  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_inner">
						<?php comments_template('', true); ?>
					</div>
				</article>
				<?php } ?>	
			
			<?php
				/* Single post */
				elseif (is_single()) :
			?>
				<div class="post_single <?php if (!comments_open() ||  post_password_required()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
					<div class="post_inner" >
						<article <?php post_class('clearfix  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
							<?php if (has_post_thumbnail()){?><figure class="post_img"><?php get_theme_blog_thumbnail(get_the_ID(), 'single'); ?></figure><?php } ?>
							<div class="post_format">
								<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></span>
							</div>
							<div class="post_area_title">
								<h1 class="entry-title"><?php the_title(); ?></a></h1>
								<div class="postcategories"><?php echo get_the_term_list( get_the_ID(), Custom_Posts_Type_Gallery::TAXONOMY, '', ', ', '' ); ?></div>
							</div>
							<div class="entry-content">							
								<?php the_content(); ?>	
								<?php wp_link_pages(array(
								'before' => '<div class="page-pagination">',
								'after' => '</div>',
								'next_or_number' => 'next_and_number',
								'nextpagelink' => __('next page', 'liquidfolio'),
								'previouspagelink' => __('previous page', 'liquidfolio'),
								'pagelink' => '<span>%</span>',
								'echo' => 1 )
							);?>
							</div>
							<?php
							by_gallery_author();
							gallery_navigation();
							?>
							<?php if ($postmetashow): ?>
								<div class="postmeta" >
									<span class="postdata"><?php echo get_the_date( ) ?></span>
									<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
									<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
									<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
								</div>
							<?php endif; ?>
						</article>
					</div>
				</div>
				<?php if (comments_open() && !post_password_required()) { ?> 
				<article <?php post_class('post_reply  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_inner">
						<?php comments_template('', true); ?>
					</div>
				</article>
				<?php } ?>

	
		<?php endif; ?>
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