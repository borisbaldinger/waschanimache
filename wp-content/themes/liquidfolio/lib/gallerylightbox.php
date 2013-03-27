<?php
	add_action('wp_ajax_show_gallery_fullscreen_lightbox', 'show_gallery_fullscreeen_lightbox');
	add_action('wp_ajax_nopriv_show_gallery_fullscreen_lightbox', 'show_gallery_fullscreeen_lightbox');



	function show_gallery_fullscreeen_lightbox()
	{
		if(isset($_POST['nonce']))
		{
			if(wp_verify_nonce($_POST['nonce'], 'liquid-folio-nonce'))
			{
				$gallery_id = isset($_POST['current'])?$_POST['current']:'';
				$gallery_page_id = isset($_POST['gallery_page_id'])?$_POST['gallery_page_id']:'';

				header('Content-Type: text/html');
				die(json_encode(getGalleryLightboxHtml($gallery_id, $gallery_page_id)));
			}
		}
	}

	function getGalleryLightboxHtml($gallery_id, $gallery_page_id)
	{
		$gallery = new Gallery($gallery_id, $gallery_page_id);
		/*
			Fullscreen scale	=> ''
			Scale by one side	=> scaleByOneSide
			Original Size'		=> originalSize
		 */
		$lightboxType = $gallery->getGalleryFullscreenOptionName();

		wp_enqueue_script('jquery-effects-core');

		if($lightboxType == 'scaleByOneSide')
		{
			$cssBackgroundSize	= true;
			$cssTransitions		= true;
			$verticalCenter		= true;
			$horizontalCenter	= true;
			$backgroundSize		= "'contain'";
		}
		elseif($lightboxType == 'originalSize')
		{
			$cssBackgroundSize	= false;
			$cssTransitions		= false;
			$verticalCenter		= false;
			$horizontalCenter	= false;
			$backgroundSize		= 'function($img){	if($img.hasClass("active-slide")) { rebindMouseMove($img.parent()); } }';
		}
		else  // fullscreen
		{
			$cssBackgroundSize	= true;
			$cssTransitions		= true;
			$verticalCenter		= true;
			$horizontalCenter	= true;
			$backgroundSize		= "'cover'"; //contain,cover
		}
		ob_start();
?>
			<script>
				var isOriginalLightBox = <?php echo  ($lightboxType=='originalSize')?'true':'false'; ?>

				function rebindMouseMove(el) {
					if(isOriginalLightBox)
					{
						var $img = jQuery('img', el);
						if($img && $img.length) 
						{
							var $cont = $img.closest('.gallerylightbox.mc-cycle');
							
							$cont.unbind('mousemove');
							
							var cont_width		= $cont.width(),
								cont_height		= $cont.height(),
								img_width		= $img.prop('naturalWidth'),
								img_height		= $img.prop('naturalHeight');

							$img.css({
									'top'		: ($img.prop('naturalHeight') - $cont.height()) / 2 * -1,
									'left'		: ($img.prop('naturalWidth') - $cont.width()) / 2 * -1,
									'margin'	: 0
								});
								
							if (img_height > cont_height || img_width > cont_width ) {
								var offsetT		= $cont.offset().top,
									offsetL		= $cont.offset().left,
									dy			= img_height - cont_height,
									dx			= img_width - cont_width,
									img_left	= $img.position().left,
									img_top		= $img.position().top;

								$cont.mousemove(function(e) {
									
									img_left	= (dx > 0) ? (((e.pageX - offsetL)/ cont_width) * dx * -1) : img_left;
									img_top		= (dy > 0) ? (((e.pageY - offsetT)/ cont_height) * dy * -1) : img_top;

									$img.css({
										'left'	: img_left,
										'top'	: img_top
									});
								});
							}
						}
					}
				}

				function setImagesOriginalSize($container) {
					
					if(isOriginalLightBox){
							jQuery('img', $container).each(function(){
								var $this = jQuery(this);

								$this.css({
									'height'	: $this.prop('naturalHeight'),
									'width'		: $this.prop('naturalWidth'),
									'position'	: 'relative',
									'max-width'	: 'none',
									'top'		: ($this.prop('naturalHeight') - $container.height()) / 2 * -1,
									'left'		: ($this.prop('naturalWidth') - $container.width()) / 2 * -1,
									'margin'	: 0
								});
							});
					}
				}
				
				function resizeGalleryVideo($item)
				{
					$item.css({
						'height' : $item.closest('.gallery_slider').height(),
						'width' : $item.closest('.gallery_slider').width()
					});
				}

				function showLightBoxImages(){
					if(typeof jQuery.maximage == 'undefined')
					{
						themeScripts.load('cycleall');
						themeScripts.load('maximage');
//						initFancybox();
					}

					jQuery('.gallerylightbox').maximage({
						cycleOptions: {
							fx: 		'fade',
							speed: 		1000, // Has to match the speed for CSS transitions in jQuery.maximage.css (lines 30 - 33)
							timeout: 	0,
							prev: 		'.prev',
							next: 		'.next',
							pause: 		1,

							before: function(last,current){
								if(!jQuery.browser.msie){
									// Start HTML5 video when you arrive
									if(jQuery(current).find('video').length > 0) jQuery(current).find('video')[0].play();
								}
							},
							after: function(currSlideElement, nextSlideElement, options, forwardFlag){
								
								
								jQuery('img', currSlideElement).removeClass('active-slide');
								jQuery('img', nextSlideElement).addClass('active-slide');
								
								rebindMouseMove(nextSlideElement);
								if(!jQuery.browser.msie){
									// Pauses HTML5 video when you leave it
									if(jQuery(currSlideElement).find('video').length > 0) jQuery(currSlideElement).find('video')[0].pause();
								}
							}
						},
						onFirstImageLoaded: function(){
					
							if(jQuery('.gallerylightbox.mc-cycle img').length == 1)
							{
								
								var cont = jQuery('.mc-image-n0');
								jQuery('img', cont).addClass('active-slide');
								setImagesOriginalSize(cont);
								rebindMouseMove(cont);
							}
							
							jQuery('#cycle-loader').hide();
							jQuery('.gallerylightbox').fadeIn('fast');
						},
						onImagesLoaded: setImagesOriginalSize,
						fillElement: '.gallery_slider',
						cssBackgroundSize: 	<?php echo ($cssBackgroundSize)?'true':'false';	?>,
						cssTransitions: 	<?php echo $cssTransitions?'true':'false';		?>,
						verticalCenter: 	<?php echo $verticalCenter?'true':'false';		?>,
						horizontalCenter: 	<?php echo $horizontalCenter?'true':'false';	?>,
						backgroundSize: 	<?php echo $backgroundSize;		?>

					});

					// Helper function to Fill and Center the HTML5 Video
					jQuery('.gallery_slider video,.gallery_slider object,.gallery_slider iframe').maximage('maxcover', {backgroundSize: resizeGalleryVideo, verticalCenter:false, horizontalCenter:false, fillElement: '.gallery_slider'});


					// To show it is dynamic html text
					jQuery('.in-slide-content').delay(1200).fadeIn();

					// Add marker for list
					jQuery('ul.qd_list li').prepend('<span class="mark" />');


					if (jQuery('.gallery_button').length) {
						jQuery('.gallery_button').hover(
							function(){
								jQuery(this).find('.bgColor').stop().css({width: jQuery(this).outerWidth()-50}).animate({ width: jQuery(this).outerWidth(), opacity: 1}, 200);
							},
							function () {
								jQuery(this).find('.bgColor').stop().animate({ width: 0, opacity: 0}, 200);
							}
						);
					};

					jQuery('.gallery_single .social_links').wrapInner('<span />');
					jQuery('.gallery_single .social_links span').css('opacity', 0);

					jQuery('.gallery_single .social_links').on(
					{
						mouseenter: function()
						{
							jQuery(this).find('span').stop().fadeTo(100, 1);
						},
						mouseleave: function()
						{
							jQuery(this).find('span').stop().fadeTo(600, 0);
						}
					});

							//custom color inside post
							jQuery('.gallery_width').each(function(){
								if (jQuery(this).data('color')){
									var color = jQuery(this).data('color');
									jQuery(this).find('.entry-content a:not(".ui-tabs-anchor"), .comment-entry a').css({'color':color});
									jQuery(this).find('.entry-content a:not(".ui-tabs-anchor"), .comment-entry a').on({
										mouseenter:function(){
											jQuery(this).css({'color':''});
										},
										mouseleave:function(){
											jQuery(this).css({'color':color});
										}
									});

									jQuery(this).find('.qd_list li a').on({
										mouseenter:function(){
											jQuery(this).css({'color':color});
										},
										mouseleave:function(){
											jQuery(this).css({'color':color});
										}
									});

									jQuery(this).find('.zoom, .t_ico').css({'background-color':color});
									jQuery(this).find('li').on({
										mouseenter:function(){
											jQuery(this).find('.mark').css({'background-color':color});
										},
										mouseleave:function(){
											jQuery(this).find('.mark').css({'background-color':''});
										}
									});
									jQuery(this).find('.jp-play, .qd_contact-submit .liquidfolio_button, #commentform #submit').on({
										mouseenter:function(){
											jQuery(this).css({'background-color':color});
										},
										mouseleave:function(){
											jQuery(this).css({'background-color':''});
										}
									});
									jQuery(this).find('.jp-pause').css({'background-color':color});
								}
							});


							//custom color inside post
							jQuery('.gallery_slider').each(function(){
								if (jQuery(this).data('color')){
									var color = jQuery(this).data('color');
									jQuery(this).find('.jp-play, .jp-pause, .jp-stop, .jp-video-play-icon').on({
										mouseenter:function(){
											jQuery(this).css({'background-color':color});
										},
										mouseleave:function(){
											jQuery(this).css({'background-color':''});
										}
									});
									jQuery(this).find('.jp-pause').css({'background-color':color});
								}
							});

				}
				//  Gallery single - add indent in right when scroll
					jQuery(window).resize(function() {
						if ( jQuery('.gallery_width').height() > jQuery(window).height() ) {
							jQuery('.gallery_slider').css({"right": "16px"});
						} else {
							jQuery('.gallery_slider').css({"right": "0"});
						}
					});
					jQuery(window).resize();
			</script>
			<style>
				body { overflow:hidden; }
				div.mc-image {	-webkit-background-size: <?php echo str_replace("'", "", $backgroundSize);?>; -moz-background-size: <?php echo str_replace("'", "", $backgroundSize);?>; -o-background-size: <?php echo str_replace("'", "", $backgroundSize);?>; background-size: <?php echo str_replace("'", "", $backgroundSize);?>;
					}
			</style>




			<div class="gallery_left" data-gallery_page_id ="<?php echo $gallery_page_id; ?>">
				<div class="gallery_width" style="border-color: <?php echo $gallery->getColor()?>; position:relative;" data-color="<?php echo $gallery->getColor()?>">
					<div class="indent">
						<div class="indent_content">
							<h1 class="gallery-title"><?php echo strtoupper($gallery->getTitle());?></h1>
							<div class="postcategories">
								<?php echo $gallery->getGalleryCategories(); ?><br><span><?php echo $gallery->getDate(); ?></span>
								<div class="postcontent-line"></div>
								</div>
							<div class="entry-content"><!--gallery_entry-->
								<?php echo $gallery->getContent(); ?>
							</div>
							<?php if($gallery->displayPageLink()):?>
								<div class="gallery_button">
									<div class="bgColor"></div>
									<a href="<?php echo $gallery->getLinkURL(); ?>" <?php echo $gallery->getLinkTarget(); ?>><span style="background-color:<?php echo $gallery->getColor()?>;"></span><?php echo $gallery->getLinkText();  ?></a>
								</div>
							<?php endif;?>
						</div>
						<div class="indent_buttom clearfix">
							<?php if($gallery->displayTwitter()):?>
								<div class="shara_opt">
									<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
									<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}else{twttr.widgets.load();}}(document,"script","twitter-wjs");</script>
								</div>
							<?php endif;?>
							<?php if($gallery->displayGoogle()):?>
								<div class="shara_opt shara_gp">
									<g:plusone></g:plusone>
									<script type="text/javascript">
										window.___gcfg = {
											lang: 'en-US'
										};
										(function() {
											var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
											po.src = 'https://apis.google.com/js/plusone.js';
											var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
										})();
									</script>
								</div>
							<?php endif;?>
							<?php if($gallery->displayPinterest()):?>
								<div class="shara_opt shara_pt">
									<a href="http://pinterest.com/pin/create/button/?url=<?php echo in_the_loop()?get_permalink():''; ?>media=<?php echo urlencode($gallery->getThumbnail()); ?>" class="pin-it-button" count-layout="horizontal" target="_blank"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
									<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
								</div>
							<?php endif;?>
								<?php if($gallery->displayFacebook()):?>
								<div class="shara_opt shara_fb">
									<div id="fb-root"></div>
									<script>
										(function(d, s, id) {
										  var js, fjs = d.getElementsByTagName(s)[0];
										  if (d.getElementById(id)) {
											  if(typeof FB !='undefined')
												{
													FB.XFBML.parse(document.getElementById('gallery_single_content'));
												}
											  return;
										  }
										  js = d.createElement(s); js.id = id;
										  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
										  fjs.parentNode.insertBefore(js, fjs);
										}(document, 'script', 'facebook-jssdk'));
									</script>
									<div class="fb-like" data-send="false" data-width="80" data-layout="button_count"  data-show-faces="false"></div>
								</div>
							<?php endif;?>
							<!--Social Links -->
						</div>

					</div>
				</div>
			</div>
			<?php
			if (has_post_format('audio', $gallery_id)) {

			if(get_post_meta($gallery_id, SHORTNAME . '_post_audio_background_settings', true) == "custom") {

				echo "<style>.gallery_slider {background: url('".get_post_meta($gallery_id, SHORTNAME . '_post_audio_background_custom', true)."' ) ".get_post_meta($gallery_id, SHORTNAME . '_post_audio_background_repeat', true)." ".get_post_meta($gallery_id, SHORTNAME . '_post_audio_background_attachment', true)." ".get_post_meta($gallery_id, SHORTNAME . '_post_audio_background_x', true)." ".get_post_meta($gallery_id,  SHORTNAME . '_post_audio_background_y', true)."}";

				if(get_post_meta($gallery_id, SHORTNAME . '_post_audio_background_color', true) && get_post_meta($gallery_id,  SHORTNAME . '_post_audio_background_color', true) !='#')
				{
					echo ".gallery_slider {background-color:".get_post_meta($gallery_id, SHORTNAME . '_post_audio_background_color', true)."}";
				}
				 echo "</style>";
			}
		}
			?>
			<div class="gallery_slider" data-color="<?php echo $gallery->getColor()?>">
				<?php
					$gallery_img = $gallery->getGalleryImages();
				?>
				<ul class="flex-post-nav">
					<li><a class="flex-prev" href="#"><?php _e('Previous', 'liquidfolio')?></a></li>
					<li><a class="flex-next" href="#"><?php _e('Next', 'liquidfolio')?></a></li>
				</ul>
				<?php
						if (has_post_format('gallery', $gallery_id)) {?>
							<?php if($gallery_img && is_array($gallery_img) && count($gallery_img)>1):?>
								<a class="prev load-item"></a>
								<a class="next load-item"></a>
							<?php endif;?>
							<div class="gallerylightbox mc-cycle">
								<?php echo implode(' ', $gallery_img); ?>
							</div>
						<?php
						}
						elseif (has_post_format('video', $gallery_id))
						{
							if ($video_html = Theme::get_post_video($gallery_id)) {

								?>
									<?php echo $video_html;	?>
							 <?php
							}
						}
						elseif (has_post_format('audio', $gallery_id))
						{
							echo Theme::getPostAudio($gallery_id);
						}
						else
						{?>
							<div class="gallerylightbox mc-cycle">
								<?php echo get_the_post_thumbnail($gallery_id, 'full') //echo implode(' ', $gallery_img); ?>
							</div>
						<?php

						}
					?>
				<a class="gallery_close" href="#"><?php _e('Close', 'liquidfolio')?><span></span></a>
			</div>

<?php
		$html = ob_get_clean();
		return $html;
	}
?>