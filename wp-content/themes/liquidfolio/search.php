<?php get_header(); ?>
<div class="content_area">
	<div class="row">
		<h1 class="content-area-title"><?php _e('Search results for: ', 'liquidfolio'); the_search_query(); ?></h1>
		<?php 
		
		wp_enqueue_script('fitvids');
		wp_enqueue_script('sharrre');
		wp_enqueue_script('isotope');
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
	echo "<div class='post_wrap ".$infinite."'>";
	
	
	while (have_posts()) : the_post();

$post_size = 'small_post_size';
$post_color = (get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_post_color', true) : null;	
			
					
		
			// Post format image start
			if ( has_post_format( 'image' )):				
			?>
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), 'blog_small'); ?></a></figure><?php } ?>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif ?>
				</article>
			<?php // end
			
			// Post format gallery start
				elseif ( has_post_format( 'gallery' )):							
			?>
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
				<?php
						wp_enqueue_script('maximage');
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
					<div class="post_area_title">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					
					<div class="entry-content">
						<?php the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif ?>
				</article>
			<?php // end
			
			
			// Post format video start
				elseif ( has_post_format( 'video' )):				
			?>
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if($video_html =  Theme::get_post_video( get_the_ID())){
						wp_enqueue_script('fitvids');
						?>
						<div class="video_frame">
					<?php echo $video_html; ?>
						</div>
					<?php }?>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					</div>
					<?php if ($postmetashow): ?>
						<div class="postmeta">
							<span class="postdata"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php echo get_the_date( ) ?></a></span>
							<?php if (comments_open() && !post_password_required()) : comments_popup_link(__('0', 'liquidfolio'), __('1', 'liquidfolio'), __('%', 'liquidfolio'), 'commentslink'); endif;?>
							<span class="share_box"  data-url="<?php the_permalink(); ?>" data-curl="<?php echo  get_template_directory_uri() .'/lib/sharrre.php'; ?>" data-title="<?php the_title(); ?>"></span>
							<?php edit_post_link( __( 'Edit', 'liquidfolio' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					<?php endif ?>
				</article>
			<?php // end
			
			
			// Post format link start
				elseif ( has_post_format( 'link' )):				
			?>
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), 'blog_small'); ?></a></figure><?php } ?>
					<div class="post_format"><a href="<?php echo (get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true)) ?  get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true): get_permalink(); ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title">
						<h2 class="entry-title"><a href="<?php echo (get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true)) ?  get_post_meta(get_the_ID(), SHORTNAME . '_post_link_url', true): get_permalink(); ?>" rel="bookmark" ><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
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
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), 'blog_small'); ?></a></figure><?php } ?>
					<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
					<div class="post_area_title">
						<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
					</div>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
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
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
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
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), 'blog_small'); ?></a></figure><?php } ?>
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
						<?php the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
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
				<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
					<div class="post_format">
						<span <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>>&nbsp;</span>
					</div>
					<div class="entry-content">
						<?php 
						if (get_post_meta(get_the_ID(), SHORTNAME . '_post_tweet', true)) {
						global $wp_embed; echo  $wp_embed->autoembed(get_post_meta(get_the_ID(), SHORTNAME . '_post_tweet', true));
						}
						?>
						<?php the_excerpt(); ?>
					</div><div class="clear"></div>
				</article>
			<?php // end
			
			
			/* Blog posts */
				else :
			?>
			<article <?php post_class('posts_listing post '.$post_size) ?> id="post-<?php the_ID(); ?>"  <?php if ($post_color){ echo 'style="border-color:'.$post_color.'" data-color="'.$post_color.'"';}?>>
				<?php if (has_post_thumbnail()){?><figure class="post_img"><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>" class="imgborder clearfix thumb listing"><?php get_theme_blog_thumbnail(get_the_ID(), 'blog_small'); ?></a></figure><?php } ?>
				<div class="post_format"><a href="<?php the_permalink() ?>" <?php if ($post_color){ echo 'style="background-color:'.$post_color.'"';}?>></a></div>
				<div class="post_area_title">
					<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<div class="postcategories"><?php //_e('Categories:', 'liquidfolio'); ?><?php the_category(' / '); ?></div>
				</div>
				<div class="entry-content">
					<?php the_excerpt(); ?>
					<div class="aligncenter"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'liquidfolio'); ?> <?php the_title_attribute(); ?>"  class="qd_button_small"><?php _e('Read more', 'liquidfolio'); ?></a></div>
					
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
			
			$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

					$pagination = array(
						'base' => @add_query_arg('paged', '%#%'),
						'format' => '',
						'total' => $wp_query->max_num_pages,
						'current' => $current,
						'show_all' => true,
						'type' => 'list'
					);

					if ($wp_rewrite->using_permalinks())
						$pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');

					if (!empty($wp_query->query_vars['s']))
						$pagination['add_args'] = array('s' => urlencode(get_query_var('s')));

					echo paginate_links($pagination);
			?>
		</div>
	<?php } ?>
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
		
	</div>
</div>
<?php get_footer(); ?>