<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
require_once('../../../../../../wp-load.php');
if( get_option(SHORTNAME."_linkscolor")) { $customcolor = get_option(SHORTNAME."_linkscolor"); } else {$customcolor = "#c62b02"; }
?>
<!doctype html>
<html lang="en">
	<head>
	<title><?php _e('Insert Social Link','liquidfolio'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
	}
	function submitData() {				
		var shortcode;
		var selectedContent = tinyMCE.activeEditor.selection.getContent();				
		var button_type = jQuery('#button_type').val();		
		var button_url = jQuery('#button_url').val();	
		if (jQuery('#button_target').is(':checked')) {
		var button_target = jQuery('#button_target:checked').val();} else {var button_target = '';}			
		shortcode = ' [social_link type="'+button_type+'" url="'+button_url+'" target="'+button_target+'" ]';			
			
		if(window.tinyMCE) {
			var id;
			if(typeof tinyMCE.activeEditor.editorId != 'undefined')
			{
				id =  tinyMCE.activeEditor.editorId;
			}
			else
			{
				id = 'content';
			}
			window.tinyMCE.execInstanceCommand(id, 'mceInsertContent', false, shortcode)

			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
	
	jQuery(document).ready(function() {
		jQuery("#button_type").change(function() {
			var type = jQuery(this).val();
			jQuery("#preview").html(type ? "<a class='social_links "+type+"' style='cursor:pointer'><span> </span></a>"  : "");
		});
		
	});
	
	</script>
		<?php
		/**
		 * @todo add  correct classes
		 */
		?>
	<style type="text/css">
		a.social_links {
			display: inline-block;
			margin: 0 3px 7px 0;
			width: 39px; height: 39px;
			border-radius: 100%;
			background: url(<?php echo  get_template_directory_uri()?>/images/sprite_socialbuttons.png) no-repeat 0 0 #ebebeb; background-size: 78px 1170px;
			text-indent: -1000em; text-align:left; vertical-align:middle;
			-moz-transition: 	all .8s ease;
			-webkit-transition: all .8s ease;
			-o-transition: 		all .8s ease;
		}
		a.social_links:hover {
			-moz-transition: 	all .1s ease;
			-webkit-transition: all .1s ease;
			-o-transition: 		all .1s ease;
		}
		a.social_links span {
			display: block;
			width: 39px; height: 39px;
			border-radius: 50%;
			
		}
		a.social_links:hover span {
			background: url(<?php echo  get_template_directory_uri()?>/images/sprite_socialbuttons.png) no-repeat 0 0; background-size: 78px 1170px;
		}
		
			a.twitter_account { background-position: 0 -195px;}
			a.twitter_account:hover { background-color:#00c3f4;}
			a.twitter_account:hover span { background-position: right -195px; background-color: #00c3f4;}
			
			a.facebook_account { background-position: 0 -156px;}
			a.facebook_account:hover { background-color: #3b5998;}
			a.facebook_account:hover span { background-position: right -156px; background-color: #3b5998;}
			
			a.google_plus_account { background-position: 0 -273px;}
			a.google_plus_account:hover { background-color: #4b8df7;}
			a.google_plus_account:hover span { background-position: right -273px; background-color: #4b8df7;}
			
			a.rss_feed { background-position: 0 0;}
			a.rss_feed:hover { background-color: #ffb400;}
			a.rss_feed:hover span { background-position: right 0; background-color: #ffb400;}
			
			a.email_to { background-position: 0 -234px;}
			a.email_to:hover { background-color: #a8c000;}
			a.email_to:hover span { background-position: right -234px; background-color: #a8c000;}
			
			a.flicker_account { background-position: 0 -39px;}
			a.flicker_account:hover { background-color: #ff0084;}
			a.flicker_account:hover span { background-position: right -39px; background-color: #ff0084;}
			
			a.vimeo_account { background-position: 0 -78px;}
			a.vimeo_account:hover { background-color: #1ab7ea;}
			a.vimeo_account:hover span { background-position: right -78px; background-color: #1ab7ea;}
			
			a.dribble_account { background-position: 0 -117px;}
			a.dribble_account:hover { background-color: #f977a6;}
			a.dribble_account:hover span { background-position: right -117px; background-color: #f977a6;}
			
			a.youtube_account { background-position: 0 -312px;}
			a.youtube_account:hover { background-color: #b72d28;}
			a.youtube_account:hover span { background-position: right -312px; background-color: #b72d28;}
			
			a.linkedin_account { background-position: 0 -350px;}
			a.linkedin_account:hover { background-color: #4b8df7;}
			a.linkedin_account:hover span { background-position: right -350px; background-color: #4b8df7;}
			
			a.pinterest_account { background-position: 0 -390px;}
			a.pinterest_account:hover { background-color: #cb2027;}
			a.pinterest_account:hover span { background-position: right -390px; background-color: #cb2027;}
			
			a.picasa_account { background-position: 0 -975px;}
			a.picasa_account:hover { background-color: #4b8df8;}
			a.picasa_account:hover span { background-position: right -975px; background-color: #4b8df8;}
			
			a.digg_account { background-position: 0 -1014px;}
			a.digg_account:hover { background-color: #1b5891;}
			a.digg_account:hover span { background-position: right -1014px; background-color: #1b5891;}

			a.plurk_account { background-position: 0 -936px;}
			a.plurk_account:hover { background-color: #cf682f;}
			a.plurk_account:hover span { background-position: right -936px; background-color: #cf682f;}
			
			a.tripadvisor_account { background-position: 0 -897px;}
			a.tripadvisor_account:hover { background-color: #589642;}
			a.tripadvisor_account:hover span { background-position: right -897px; background-color: #589642;}

			a.yahoo_account { background-position: -1px -819px;}
			a.yahoo_account:hover { background-color: #ab64bc;}
			a.yahoo_account:hover span { background-position: -40px -819px; background-color: #ab64bc;}
			
			a.delicious_account { background-position: 0 -1092px;}
			a.delicious_account:hover { background-color: #004795;}
			a.delicious_account:hover span { background-position: right -1093px; background-color: #004795;}
			
			a.devianart_account { background-position: 0 -663px;}
			a.devianart_account:hover { background-color: #54675a;}
			a.devianart_account:hover span { background-position: right -663px; background-color: #54675a;}
			
			a.tumblr_account { background-position: 0 -702px;}
			a.tumblr_account:hover { background-color: #34526f;}
			a.tumblr_account:hover span { background-position: right -702px; background-color: #34526f;}
			
			a.skype_account { background-position: 0 -741px;}
			a.skype_account:hover { background-color: #33bff3;}
			a.skype_account:hover span { background-position: right -741px; background-color: #33bff3;}
			
			a.apple_account { background-position: 0 -780px;}
			a.apple_account:hover { background-color: #4c4c4c;}
			a.apple_account:hover span { background-position: right -780px; background-color: #4c4c4c;}
			
			a.aim_account { background-position: 0 -1053px;}
			a.aim_account:hover { background-color: #ffb400;}
			a.aim_account:hover span { background-position: right -1053px; background-color: #ffb400;}
			
			a.paypal_account { background-position: 0 -468px;}
			a.paypal_account:hover { background-color: #0079c1;}
			a.paypal_account:hover span { background-position: right -468px; background-color: #0079c1;}
			
			a.blogger_account { background-position: 0 -585px;}
			a.blogger_account:hover { background-color: #ff6403;}
			a.blogger_account:hover span { background-position: right -585px; background-color: #ff6403;}
			
			a.behance_account { background-position: 0 -624px;}
			a.behance_account:hover { background-color: #1769ff;}
			a.behance_account:hover span { background-position: right -624px; background-color: #1769ff;}
			
			a.myspace_account { background-position: 0 -859px;}
			a.myspace_account:hover { background-color: #003399;}
			a.myspace_account:hover span { background-position: right -859px; background-color: #003399;}
			
			a.stumble_account { background-position: 0 -430px;}
			a.stumble_account:hover { background-color: #cc492b;}
			a.stumble_account:hover span { background-position: right -430px; background-color: #cc492b;}
			
			a.forrst_account { background-position: 0 -506px;}
			a.forrst_account:hover { background-color: #176023;}
			a.forrst_account:hover span { background-position: right -506px; background-color: #176023;}
			
			a.imdb_account { background-position: 0 -547px;}
			a.imdb_account:hover { background-color: #f4c118;}
			a.imdb_account:hover span { background-position: right -547px; background-color: #f4c118;}

			a.instagram_account { background-position: 0 -1131px;}
			a.instagram_account:hover { background-color: #99654d;}
			a.instagram_account:hover span { background-position: right -1131px; background-color: #99654d;}

	</style>
	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="buttons" action="#" >
		<div class="tabs">
			<ul>
				<li id="buttons_tab" class="current"><span><a href="javascript:mcTabs.displayTab('buttons_tab','buttons_panel');" onMouseDown="return false;"><?php _e('Buttons','liquidfolio'); ?></a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper">
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Type of button:','liquidfolio'); ?></legend>
					<label for="button_type"><?php _e('Choose a type:','liquidfolio'); ?></label><br><br>
					<select name="button_type" id="button_type"  style="width:250px">
						<option value="" disabled selected><?php _e('Select type','liquidfolio'); ?></option>
						<option value="rss_feed">RSS</option>
						<option value="facebook_account">Facebook</option>
						<option value="twitter_account">Twitter</option>
                        <option value="dribble_account">Dribbble</option>
						<option value="email_to">Email to</option>
						<option value="google_plus_account">Google+</option>
                        <option value="flicker_account">Flickr</option>
                        <option value="vimeo_account">Vimeo</option>
						<option value="linkedin_account">LinkedIn</option>
						<option value="youtube_account">Youtube</option>
						<option value="pinterest_account">Pinterest</option>
						<option value="picasa_account">Picasa</option>
						<option value="digg_account">Digg</option>
						<option value="plurk_account">Plurk</option>
						<option value="tripadvisor_account">TripAdvisor</option>
						<option value="yahoo_account">Yahoo!</option>
						<option value="delicious_account">Delicious</option>
						<option value="devianart_account">deviantART</option>
						<option value="tumblr_account">Tumblr</option>
						<option value="skype_account">Skype</option>
						<option value="apple_account">Apple</option>
						<option value="aim_account">AIM</option>
						<option value="paypal_account">PayPal</option>
						<option value="blogger_account">Blogger</option>
						<option value="behance_account">Behance</option>
						<option value="myspace_account">Myspace</option>
						<option value="stumble_account">Stumble</option>
						<option value="forrst_account">Forrst</option>
						<option value="imdb_account">IMDb</option>
						<option value="instagram_account">Instagram</option>
					</select>					
				</fieldset>
			
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('URL for button:','liquidfolio'); ?></legend>
					<label for="button_url"><?php _e('Type your URL here:','liquidfolio'); ?></label><br><br>
					<input name="button_url" type="text" id="button_url" style="width:250px">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Link target:','liquidfolio'); ?></legend>
					<label for="button_target"><?php _e('Check if you want open in new window:','liquidfolio'); ?></label><br><br>
					<input name="button_target" type="checkbox" id="button_target">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Preview:','liquidfolio'); ?></legend>
					<div id="preview" style="height:70px"></div>
				</fieldset>
			
		</div>
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="<?php _e('Insert','liquidfolio'); ?>" onClick="submitData();" />
			</div>
		</div>
	</form>
</body>
</html>