jQuery(document).ready(function(){
	jQuery('.select_wide').parent().addClass('wide_wrap');
	
	var enablePrevnextEl = jQuery('#lf_show_gallery_navi'),
		enableGalleryBlogLinkEl = jQuery('#lf_show_gallery_blog_link').closest('li');
	
	if(!enablePrevnextEl.is(':checked')){
		enableGalleryBlogLinkEl.hide();
	}
	
	enablePrevnextEl.change(function(){
		if(jQuery(this).is(':checked')){
			enableGalleryBlogLinkEl.show()
		} else {
			enableGalleryBlogLinkEl.hide();
		}
	});
});