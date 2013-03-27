<?php	
require_once('../../../../../../wp-load.php');
if( get_option(SHORTNAME."_linkscolor")) { $customcolor = get_option(SHORTNAME."_linkscolor"); } else {$customcolor = "#c62b02"; }
?>
<!doctype html>
<html lang="en">
	<head>
	<title><?php _e('Insert Button','liquidfolio'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">if(typeof  THEME_URI == 'undefined'){var THEME_URI = '<?php echo get_template_directory_uri(); ?>';}</script>
	<script language="javascript" type="text/javascript" src="<?php echo  get_template_directory_uri() . '/backend/js/mColorPicker/javascripts/mColorPicker.js'?>"></script>
	<script language="javascript" type="text/javascript">
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}
	function submitData() {				
		var shortcode;
		var selectedContent = tinyMCE.activeEditor.selection.getContent();				
		var button_type = jQuery('#button_type').val();		
		var button_url = jQuery('#button_url').val();	
		
		// my adds		
		var button_color = jQuery('#button_color').val();
		
		if (jQuery('#button_target').is(':checked')) {
		var button_target = jQuery('#button_target:checked').val();} else {var button_target = '';}			
		shortcode = ' [button type="'+button_type+'" url="'+button_url+'" target="'+button_target+'" button_color_fon="'+button_color+'" ]'+selectedContent+'[/button] ';			
			
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
//		jQuery("#button_type").change(function() {
//				var type = jQuery(this).val();
//				var button_color = jQuery('#button_color').val();
//				jQuery("#preview").html(type ? "<a class='"+type+"' style='cursor:pointer;background-color:"+button_color+"'><span>Test button</span></a>"  : "");
//		});
//		jQuery('#button_color').change(function()
//		{
//				jQuery('#preview a').css('background-color', jQuery(this).val());
//		})



		jQuery('#button_color, #button_type').change(function()
		{
			var type = jQuery("#button_type").val();
			
			var color = jQuery('#button_color').val();
			
			var preview = jQuery('#preview');
			
			preview.html('');
			
			if(type == 'qd_button btn_xlarge')
			{
				preview.append("<a class='"+type+"' style='cursor:pointer;'>"
								+"<b style='background-color: "+color+";'></b>"
								+"<span>Test button</span></a>");
			}
			else
			{
				preview.append("<a class='"+type+"' style='cursor:pointer;background-color:"+color+"'><span>Test button</span></a>");
			}

		});

	});
	
	</script>

	<style type="text/css">
		/*	Button indent styles: */
		.qd_button {
			vertical-align: middle;
			display:inline-block; margin-bottom:4px;
		}
		.btn_small {
			padding: 0 10px; height: 23px;
			text-transform: lowercase;
			border-radius: 2px;
		}
		.qd_button_small {
			vertical-align: middle;
			display:inline-block;
			border-radius: 2px;
			padding: 0 10px; height: 23px;
			text-transform: lowercase;
		}
		
		.btn_middle {
			padding: 0 14px; height: 34px;
			border-radius: 3px;
			text-transform: uppercase;
		}
		.btn_large  {
			padding: 0 28px; height: 40px;
			border-radius: 4px;
			text-transform: uppercase;
		}
		.btn_xlarge  {
			position: relative;
			display: inline-block; overflow: hidden;
			height: 33px; border: 1px solid;
			border-radius: 3px;
			text-transform: uppercase;
			-moz-transition: all 0.8s ease-in-out; -webkit-transition: all 0.8s ease-in-out; -o-transition: all 0.8s ease-in-out;
		}
		.btn_xlarge:hover  {	
			-moz-transition: all 0.1s ease-in-out; -webkit-transition: all 0.1s ease-in-out; -o-transition: all 0.1s ease-in-out;
		}
			
			.btn_xlarge span {
				position: relative;	display: block;	padding: 0 15px;
				height: 35px; line-height: 33px; z-index: 2;
			}
			.btn_xlarge b {
				position: absolute; left: 0; top: 0;
				border-radius: 1px 0 0 1px;
				width: 7px; height: 33px;
				z-index: 1;
				-moz-transition: all 0.8s ease; -webkit-transition: all 0.8s ease; -o-transition: all 0.8s ease;
			}
			.btn_xlarge:hover b {
				width:100%;
				-moz-transition: all 0.1s; -webkit-transition: all 0.1s; -o-transition: all 0.1s;
			}
			
			
			
			
		
		/* Button color styles: */
			.qd_button { color: #ededed; background-color: #363636;}
			.column-main .qd_button { background-color: #1e1e1e;}
			
			.qd_button:hover {  color: #ededed; background-color: #545454!important;}
	
			.btn_small {
				font-size: 11px;
				line-height: 23px;
			}
	
			.qd_button_small {
				color: #ededed!important; background-color: #363636;
				font-size: 11px;
				line-height: 23px;
			}
			.qd_button_small:hover { background-color: #A05FEF;}
			
			.btn_middle {
				font-weight: 500;
				font-size: 14px;
				font-family: 'Open Sans', Arial, serif;
				line-height:34px;
			}
			.btn_large  {
				font-size: 16px;
				font-family: 'Open Sans', Arial, serif;
				line-height: 40px;
			}
			.btn_xlarge {
				border-color: #f6f6f6;
				box-shadow: 1px 2px 3px 0px rgba(102,102,102, 0.10);
				background: none;
				color: #404040;
				font-weight: 500;
				font-size: 14px;
				font-family: 'Open Sans', Arial, serif;
				line-height: 33px;
			}
			.btn_xlarge:hover { color:#fff; background: none!important;}
			.btn_xlarge b { background:#A05FEF;}
		
		
		
		
		/*.qd_button { color: #ededed; background-color: #363636;}
		.qd_button:hover {  color: #ededed; background-color: #A05FEF!important;}

		.btn_small {
			font-size: 11px;
			line-height: 23px;
		}
		.btn_middle {
			font-weight: 500;
			font-size: 14px;
			font-family: 'Open Sans', Arial, Helvetica, sans-serif;
			line-height:34px;
		}
		.btn_large  {
			font-size: 16px;
			font-family: 'Open Sans', Arial, Helvetica, sans-serif;
			line-height: 40px;
		}
		.btn_xlarge {
			border-color: #f6f6f6;
			-moz-box-shadow: 1px 2px 3px 0px rgba(#A05FEF, 0.10); -webkit-box-shadow: 1px 2px 3px 0px rgba(#A05FEF, 0.10); box-shadow: 1px 2px 3px 0px rgba(#A05FEF, 0.10);
			background: none;
			color: #404040;
			font-weight: 500;
			font-size: 14px;
			font-family: 'Open Sans', Arial, Helvetica, sans-serif;
			line-height: 33px;
		}*/
		
		
		
		
		
		
		
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
						<option value="qd_button btn_small"><?php _e('small button','liquidfolio'); ?></option>
						<option value="qd_button btn_middle"><?php _e('middle button black','liquidfolio'); ?></option>
						<option value="qd_button btn_large"><?php _e('large color button','liquidfolio'); ?></option>
						<option value="qd_button btn_xlarge"><?php _e('xlarge color button','liquidfolio'); ?></option>            
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
					<legend>Change Color:</legend>
						<label for="button_color">button background colors:</label><br><br>
						<input name="button_color" type="color"  data-hex="true" id="button_color" style="width:230px" value="#363636">
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