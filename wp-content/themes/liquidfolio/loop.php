<?php
$i = 0;
//wp_enqueue_script('fitvids');
//wp_enqueue_script('swfobject');
//wp_enqueue_script('jplayer');
//wp_enqueue_script('qd_frogoloop');
//wp_enqueue_script('maximage');
//wp_enqueue_script('validate');
//wp_enqueue_script('bgposition');

/* Start the Loop  */
if (have_posts()) :
	$infinite = null;
	if (get_option(SHORTNAME . "_infinite"))
	{
		global $wp_query;

		wp_enqueue_script('infinite');
		wp_localize_script('infinite', 'scrollData', array(
			'found_posts' => $wp_query->found_posts,
		));
		$infinite = 'infinite';
	}
	$postmetashow = !get_option(SHORTNAME . "_postmetashow");
	
	echo "<div class='post_wrap " . $infinite . "'>";

	while (have_posts()) : the_post();

		$post_size = (get_post_meta(get_the_ID(), SHORTNAME . '_post_size', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_post_size', true) : null;
		$post_color = (get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true) : null;
		$post_thumb = ($post_size) ? 'blog_small':'blog_double';

		$hide_post_title = get_option(SHORTNAME . "_hideposttitle") ? "display:none;" : '';
		$hide_post_desc = get_option(SHORTNAME . "_hidepostdesc") ? "display:none;" : '';
		if(get_post_meta(get_the_ID(), SHORTNAME . '_display_post_details_in_blog', true) == 'custom'){
			$hide_post_title = get_post_meta(get_the_ID(), SHORTNAME . '_hide_post_title', true) ? "display:none;" : '';
			$hide_post_desc = get_post_meta(get_the_ID(), SHORTNAME . '_hide_post_desc', true) ? "display:none;" : '';
		}
		
		/* Default page */
		if (is_page()) :			
			?>
			<div class="post_single <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
				<div class="post_inner">
					<article id="page-<?php the_ID(); ?>" <?php post_class('post'); ?> <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
						<h1 class="page-title"><?php the_title(); ?></a></h1>
						<div class="entry-content clearfix">
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
				<article <?php post_class('post_reply post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_inner">
						<?php comments_template('', true); ?>
					</div>
				</article>
			<?php } ?>
			
			
			<?php			
			/* Attachment */
				elseif (is_attachment() ) :
			?>
				<div class="post_single <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
					<div <?php if (comments_open()) : echo 'class="post_inner"'; endif;?> >
						<article <?php post_class('clearfix post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>						
							
							<div class="post_format">
								<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></span>
							</div>
							<div class="post_area_title">
								<h1 class="entry-title"><?php the_title(); ?></a></h1>
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
							</div>
							<div class="entry-content">
								<?php the_content(); ?>								
							</div>
							<?php
							by_post_author();
							post_navigation();
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
			/* Single post gallery */
				elseif (is_single() && has_post_format('gallery') ) :
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
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
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
							by_post_author();
							post_navigation();
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
				/* Single post video */
				elseif (is_single()  && has_post_format( 'video')) :
			?>
				<div class="post_single video_post <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
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
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
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
							by_post_author();
							post_navigation();
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
				/* Single post link */
				elseif (is_single()  && has_post_format( 'link')) :
			?>
				<div class="post_single <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
					<div <?php if (comments_open()) : echo 'class="post_inner"'; endif;?> >
						<article <?php post_class('clearfix  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
							<?php if (has_post_thumbnail()){?><figure class="post_img"><?php get_theme_blog_thumbnail(get_the_ID(), 'single'); ?></figure><?php } ?>
								<div class="post_format"><a href="<?php echo (get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true)) ?  get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true): get_permalink(); ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title">
						<h1 class="entry-title"><a href="<?php echo (get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true)) ?  get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true): get_permalink(); ?>" rel="bookmark" ><?php the_title(); ?></a></h1>							
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
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
							by_post_author();
							post_navigation();
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
				/* Single post aside */
				elseif (is_single()  && has_post_format( 'aside')) :
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
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
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
							by_post_author();
							post_navigation();
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
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
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
							by_post_author();
							post_navigation();
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
				/* Single post quote */
				elseif (is_single()  && has_post_format( 'quote')) :
			?>
				<div class="post_single <?php if (!comments_open()) { ?>comments_close<?php }else{ ?>comments_open<?php } ?>">
					<div <?php if (comments_open()) : echo 'class="post_inner"'; endif;?> >
						<article <?php post_class('clearfix  post') ?>  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
							<div class="post_format">
								<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></span>
							</div>
<!--							<div class="post_area_title">
								<h1 class="entry-title"><?php the_title(); ?></a></h1>
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
							</div>-->
							<div class="entry-content">	
								<?php 
						if (get_post_meta(get_the_ID(), SHORTNAME . '_post_quote', true)) { 
							
							echo  qd_the_content("<blockquote>&quot; ".get_post_meta(get_the_ID(), SHORTNAME . '_post_quote', true)." &quot;<cite>".get_post_meta(get_the_ID(), SHORTNAME . '_post_quote_author', true)."</cite></blockquote>");
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
							by_post_author();
							post_navigation();
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
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
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
							by_post_author();
							post_navigation();
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
								<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?><br><?php if (get_the_tags()) { the_tags(); } ?></div>
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
							by_post_author();
							post_navigation();
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

			
<!-----------------------------------------

	POST FORMAT

------------------------------------------>		
			
			<?php 
			// Post format image start
				elseif ( has_post_format( 'image' )):				
			?>
				<article <?php post_class('posts_listing  post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), $post_thumb); ?></a></figure><?php } ?>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title" style="<?php echo $hide_post_title;?>">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content" style="<?php echo $hide_post_desc;?>">
						<?php if (get_option(SHORTNAME . "_excerpt")) { the_content(__('Read more','liquidfolio')); } else { the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					<?php }?>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif; ?>
				</article>
			<?php // end
			
			// Post format gallery start
				elseif ( has_post_format( 'gallery' )):
				wp_enqueue_script('maximage');
			?>
				<article <?php post_class('posts_listing  post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php 
						$portfolio_slides = get_post_meta(get_the_ID(), SHORTNAME . '_project_slider');
						if($portfolio_slides && isset($portfolio_slides[0][0]['slide-img-src']) && $portfolio_slides[0][0]['slide-img-src'] != ''):?>
						<div class="postformat_gallery"  data-script="cycleall,maximage">
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
					<?php elseif (has_post_thumbnail()):?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_post_thumbnail(get_the_ID(), 'large'); ?></a></figure><?php endif;?>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title" style="<?php echo $hide_post_title;?>">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					
					<div class="entry-content" style="<?php echo $hide_post_desc;?>">
						<?php if (get_option(SHORTNAME . "_excerpt")) { the_content(__('Read more','liquidfolio')); } else { the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					<?php }?>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif; ?>
				</article>
			<?php // end
			
			
			// Post format video start
				elseif ( has_post_format( 'video' )):				
			?>
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if($video_html =  Theme::get_post_video( get_the_ID())){
						wp_enqueue_script('fitvids');
						?>
						<div class="video_frame"  data-script="fitvids">
					<?php echo $video_html; ?>
						</div>
					<?php }?>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title" style="<?php echo $hide_post_title;?>">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content" style="<?php echo $hide_post_desc;?>">
						<?php if (get_option(SHORTNAME . "_excerpt")) { the_content(__('Read more','liquidfolio')); } else { the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					<?php }?>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif; ?>
				</article>
			<?php // end
			
			
			// Post format link start
				elseif ( has_post_format( 'link' )):				
			?>
				<article <?php post_class('posts_listing  post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), $post_thumb); ?></a></figure><?php } ?>
					<div class="post_format"><a href="<?php echo (get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true)) ?  get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true): get_permalink(); ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title">
						<h2 class="entry-title"><a href="<?php echo (get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true)) ?  get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true): get_permalink(); ?>" rel="bookmark" ><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content">
						<?php if (get_option(SHORTNAME . "_excerpt")) { the_content(__('Read more','liquidfolio')); } else { the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					<?php }?>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif; ?>
				</article>
			<?php // end
			
			// Post format aside start
				elseif ( has_post_format( 'aside' )):				
			?>
				<article <?php post_class('posts_listing  post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), $post_thumb); ?></a></figure><?php } ?>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content">
						<?php if (get_option(SHORTNAME . "_excerpt")) { the_content(__('Read more','liquidfolio')); } else { the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					<?php }?>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif; ?>
				</article>
			<?php // end
			
			
			// Post format quote start
				elseif ( has_post_format( 'quote' )):				
			?>
				<article <?php post_class('posts_listing   post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="entry-content">
						<?php 
						if (get_post_meta(get_the_ID(), SHORTNAME . '_post_quote', true)) { 
							
							echo  qd_the_content("<blockquote>&quot; ".get_post_meta(get_the_ID(), SHORTNAME . '_post_quote', true)." &quot;<cite>".get_post_meta(get_the_ID(), SHORTNAME . '_post_quote_author', true)."</cite></blockquote>");
						}
						?>						
					</div><div class="clear"></div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif; ?>
				</article>
			<?php // end
			
			
			// Post format audio start
				elseif ( has_post_format( 'audio' )):				
			?>
				<article <?php post_class('posts_listing  post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), $post_thumb); ?></a></figure><?php } ?>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content">
						<?php 
						if (get_post_meta(get_the_ID(), SHORTNAME . '_post_audio_url', true)) { 
								echo Theme::getPostAudio(get_the_ID());
						}
						?>	
						<?php if (get_option(SHORTNAME . "_excerpt")) { the_content(__('Read more','liquidfolio')); } else { the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					<?php }?>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif; ?>
				</article>
			<?php // end
			
			
			// Post format status start
				elseif ( has_post_format( 'status' )):					
			?>
				<article <?php post_class('posts_listing  post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_format">
						<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>>&nbsp;</span>
					</div>
					<div class="entry-content">
						<?php 
						if (get_post_meta(get_the_ID(), SHORTNAME . '_post_tweet', true)) {
						global $wp_embed; echo  $wp_embed->autoembed(get_post_meta(get_the_ID(), SHORTNAME . '_post_tweet', true));
						}
						?>
						<?php if (get_option(SHORTNAME . "_excerpt")) { the_content(__('Read more','liquidfolio')); } else { the_excerpt(); }?>
					</div><div class="clear"></div>
				</article>
			<?php // end
			
			
			/* Blog posts */
				else :
			?>
			<article <?php post_class('posts_listing  post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
				<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), $post_thumb); ?></a></figure><?php } ?>
				<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
				<div class="post_area_title">
					<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
				</div>
				<div class="entry-content">
					<?php if (get_option(SHORTNAME . "_excerpt")) { the_content(__('Read more','liquidfolio')); } else { the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					<?php }?>
				</div>
				<?php if ($postmetashow): ?>
					<div class="postmeta">
						<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
						<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
						<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
						<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
					</div>
				<?php endif; ?>
			</article>
		<?php endif; ?>
	<?php endwhile; ?>
</div>
	<?php
	
	
	
	// get total number of pages
	global $wp_query;
	$total = $wp_query->max_num_pages;
// only bother with the rest if we have more than 1 page!
	if ($total > 1)
	{
	//Load more button
		?>
		<div class="pagination clearfix <?php echo (get_option(SHORTNAME . "_infinite")) ? 'paginationhide' : ''; ?>">
			<div class='pagination_line'></div>
			<?php
			if (get_option(SHORTNAME . "_infinite"))
				{
					echo "<a href='#' id='load' class='load_more'><span></span>Load more</a>";


				}
			
			// get the current page
			if (get_query_var('paged'))
			{
				$current_page = get_query_var('paged');
			}
			else if (get_query_var('page'))
			{
				$current_page = get_query_var('page');
			}
			else
			{
				$current_page = 1;
			}
			// structure of вЂњformatвЂќ depends on whether weвЂ™re using pretty permalinks
			$permalink_structure = get_option('permalink_structure');
			if (empty($permalink_structure))
			{
				if (is_front_page())
				{
					$format = '?paged=%#%';
				}
				else
				{
					$format = '&paged=%#%';
				}
			}
			else
			{
				$format = 'page/%#%/';
			}



			echo paginate_links(array(
				'base' => get_pagenum_link(1) . '%_%',
				'format' => $format,
				'current' => $current_page,
				'total' => $total,
				'mid_size' => 10,
				'type' => 'list'
			));
			?>
		</div>
	<?php }
	?>
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
