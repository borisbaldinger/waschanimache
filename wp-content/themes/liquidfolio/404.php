<?php get_header(); ?>
<div class="content_area">
	<div class="row">
		<div class="post_single comments_close">
				<div class="post_inner">
					<article class="page type-page status-publish hentry post" >
						<h1 class="page-title"><?php _e('404 - Oops!', 'liquidfolio'); ?></a></h1>
						<div class="entry-content">
							<h2 class="entry-title">
				<?php _e('The page you are trying to reach can&apos;t be found', 'liquidfolio'); ?>
			</h2>
			<p><?php _e('Try refining your search, or use the navigation above to locate the post.', 'liquidfolio'); ?></p>
			<p><a href="<?php echo get_home_url() ?>" class="qd_button btn_small"><?php _e('back to home', 'liquidfolio'); ?></a></p>
						
						</div>
					</article>
				</div>
			</div>
	</div>
</div>
<?php get_footer(); ?>