<?php

add_action('wp_ajax_show_gallery_small_lightbox', 'show_gallery_small_lightbox');
add_action('wp_ajax_nopriv_show_gallery_small_lightbox', 'show_gallery_small_lightbox');


function show_gallery_small_lightbox()
{
	if(isset($_POST['nonce']))
	{
		if(wp_verify_nonce($_POST['nonce'], 'liquid-folio-nonce'))
		{
			$id = isset($_POST['current'])?$_POST['current']:'';
			header('Content-Type: text/html');
			die(json_encode(getGallerySmallLightboxHtml($id)));
		}
	}
}
	
function getGallerySmallLightboxHtml($id)
{
	$gallery = new Gallery($id);
	
	$images = $gallery->getFancyBoxImages();
	
	if($images && is_array($images) && count($images))
	{
		return implode(' ', $images);
	}
}
?>