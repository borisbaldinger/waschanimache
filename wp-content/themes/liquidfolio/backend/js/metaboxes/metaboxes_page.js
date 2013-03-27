jQuery(document).ready(function($) {
	//Hide all custom
	$('#gallery_template, #page_lightbox_title_option, #page_lightbox_type, #page_size_option, #eventmap, #contact_location_point, #contact_second').hide();
	
	//Show only for selected template
	if ($('#page_template').find(":selected").val() == 'template-galleries.php') {
					$("#gallery_template,  #page_lightbox_title_option, #page_lightbox_type, #page_size_option").show();
					$("#eventmap, #contact_location_point, #contact_second").hide();
	} 
	else if($('#page_template').find(":selected").val() == 'template-contact.php'){
					$("#eventmap, #contact_location_point, #contact_second").show();
					$("#gallery_template,  #page_lightbox_title_option, #page_lightbox_type, #page_size_option, #post_background").hide();
	} 
	else {
					$("#gallery_template,  #page_lightbox_title_option, #page_lightbox_type, #page_size_option, #eventmap, #contact_location_point, #contact_second").hide();
	}

	//Show/hide on template change
	$('#page_template').change(function() {
		if(jQuery(this).val() == 'template-galleries.php'){
			$("#gallery_template,  #page_lightbox_title_option, #page_lightbox_type, #page_size_option, #post_background").show();
			$("#eventmap, #contact_location_point, #contact_second").hide();
		} 
		else if(jQuery(this).val() == 'template-contact.php'){
			$("#eventmap, #contact_location_point, #contact_second").show();
			$("#gallery_template,  #page_lightbox_title_option, #page_lightbox_type, #page_size_option, #post_background").hide();
		} 
		else {
			$("#post_background").show();
			$("#gallery_template,  #page_lightbox_title_option, #page_lightbox_type, #page_size_option, #eventmap, #contact_location_point, #contact_second").hide();
		}

	});
});