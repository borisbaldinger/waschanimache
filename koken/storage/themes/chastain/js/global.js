$(function() {
	$(window).on('resize',resizeView);
	function resizeView() {
		$('#container').css({
			top: ( $('header').css('position') === 'fixed' ) ? $('header').height() : '0'
		});
	}
	resizeView();
});