		</div>
		<!-- Footer area -->
		<footer>
			
			<div class="sidebar" id="main_sidebar" data-walign="<?php echo get_option(SHORTNAME . "_walign");?>">			
				<?php 
				if (is_singular()) {
					$post_sidebar = (get_post_meta(get_the_ID(), SHORTNAME . '_page_sidebar', true)) ? get_post_meta(get_the_ID(), SHORTNAME . '_page_sidebar', true) :'default-sidebar' ;
				
					generated_dynamic_sidebar_lf($post_sidebar);
				}
				elseif (is_archive()){					
					global $wp_query;
					$term = $wp_query->get_queried_object();				
					if($term){
						$post_sidebar = (get_tax_meta($term->term_id, SHORTNAME . '_post_listing_sidebar', true)) ? get_tax_meta($term->term_id, SHORTNAME . '_post_listing_sidebar', true) : 'default-sidebar';
						generated_dynamic_sidebar_lf($post_sidebar);
					}
				}
				else {
					dynamic_sidebar("default-sidebar");
				}
				
				?>
			</div>
		<div id="copyright">
			<p><?php echo wpml_t('liquidfolio', 'copyright', stripslashes(get_option(SHORTNAME . "_copyright"))); ?></p>
		</div>
		</footer>
	</div>	
	<div class="gallery_single clearfix" id="gallery_single_content"></div>
	<div class="gallery_small_lightbox clearfix" id="gallery_small_lightbox"></div>
	<?php echo stripslashes(get_option(SHORTNAME . "_GA")); ?>
	<?php wp_footer(); ?>
</body></html>