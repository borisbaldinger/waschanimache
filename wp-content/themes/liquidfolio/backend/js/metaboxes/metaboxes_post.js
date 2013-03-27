jQuery(document).ready(function($) {
	//Hide all custom
	$('#post-video, #post-audio, #gallery-slider, #post-link, #post-quote, #post-tweet, #hide-descriptions-and-title').hide();
	
	//Show only for selected template
	if ($('#post-format-gallery').is(":checked")) {
					$("#gallery-slider, #hide-descriptions-and-title").show();
					$("#post-video, #post-audio, #post-link, #post-quote, #post-tweet").hide();
	} 
	else if($('#post-format-link').is(":checked")){
					$("#post-link").show();
					$("#post-video, #post-audio, #gallery-slider,  #post-quote, #post-tweet").hide();
	} 
	else if($('#post-format-quote').is(":checked")){
					$("#post-quote").show();
					$("#post-video, #post-audio, #gallery-slider, #post-link, #post-tweet").hide();
	} 
	else if($('#post-format-video').is(":checked")){
					$("#post-video, #hide-descriptions-and-title").show();
					$("#post-audio, #gallery-slider, #post-link, #post-quote, #post-tweet").hide();
	} 
	else if($('#post-format-audio').is(":checked")){
					$("#post-audio").show();
					$("#post-video, #gallery-slider, #post-link, #post-quote, #post-tweet").hide();
	} 
	else if($('#post-format-status').is(":checked")){
					$("#post-tweet").show();
					$("#post-video, #gallery-slider, #post-link, #post-quote, #post-audio").hide();
	} 
	else if($('#post-format-image').is(":checked")){
					$("#hide-descriptions-and-title").show();
	} 
	else {
					$('#post-video, #post-audio, #gallery-slider, #post-link, #post-quote, #post-tweet, #hide-descriptions-and-title').hide();
	}

	//Show/hide on template change
	$('#post-formats-select input').change(function() {
		if(jQuery(this).val() == 'gallery'){
			$("#gallery-slider, #hide-descriptions-and-title").show();
			$("#post-video, #post-audio, #post-link, #post-quote, #post-tweet").hide();
		} 
		else if(jQuery(this).val() == 'link'){
			$("#post-link").show();
			$("#post-video, #post-audio, #gallery-slider,  #post-quote, #post-tweet, #hide-descriptions-and-title").hide();
		} 
		else if(jQuery(this).val() == 'quote'){
			$("#post-quote").show();
			$("#post-video, #post-audio, #gallery-slider, #post-link, #post-tweet, #hide-descriptions-and-title").hide();
		} 
		else if(jQuery(this).val() == 'video'){
			$("#post-video, #hide-descriptions-and-title").show();
			$("#post-audio, #gallery-slider, #post-link, #post-quote, #post-tweet").hide();
		} 
		else if(jQuery(this).val() == 'audio'){
			$("#post-audio").show();
			$("#post-video, #gallery-slider, #post-link, #post-quote, #post-tweet, #hide-descriptions-and-title").hide();
		} 
		else if(jQuery(this).val() == 'status'){
			$("#post-tweet").show();
			$("#post-video, #gallery-slider, #post-link, #post-quote, #post-audio, #hide-descriptions-and-title").hide();
		} 
		else if(jQuery(this).val() == 'image'){
			$("#hide-descriptions-and-title").show();
		}
		else {
			$("#post-video, #post-audio, #gallery-slider, #post-link, #post-quote, #post-tweet, #hide-descriptions-and-title").hide();
		}

	});
});