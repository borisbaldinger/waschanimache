jQuery(document).ready(function($) {
	//Hide all custom
	$('#post-video, #post-audio, #gallery-slider, #gallery_audio_background').hide();
	
	//Show only for selected template
	if ($('#post-format-gallery').is(":checked")) {
					$("#gallery-slider").show();
					$("#post-video, #post-audio, #gallery_audio_background").hide();
	} 	
	else if($('#post-format-video').is(":checked")){
					$("#post-video").show();
					$("#post-audio, #gallery-slider, #gallery_audio_background").hide();
	} 
	else if($('#post-format-audio').is(":checked")){
					$("#post-audio, #gallery_audio_background").show();
					$("#post-video, #gallery-slider").hide();
	} 
	else {
					$('#post-video, #post-audio, #gallery-slider, #gallery_audio_background').hide();
	}

	//Show/hide on template change
	$('#post-formats-select input').change(function() {
		if(jQuery(this).val() == 'gallery'){
			$("#gallery-slider").show();
			$("#post-video, #post-audio, #gallery_audio_background").hide();
		} 		
		else if(jQuery(this).val() == 'video'){
			$("#post-video").show();
			$("#post-audio, #gallery-slider, #gallery_audio_background").hide();
		} 
		else if(jQuery(this).val() == 'audio'){
			$("#post-audio, #gallery_audio_background").show();
			$("#post-video, #gallery-slider").hide();
		} 
		else {
			$("#post-video, #post-audio, #gallery-slider, #gallery_audio_background").hide();
		}

	});
});