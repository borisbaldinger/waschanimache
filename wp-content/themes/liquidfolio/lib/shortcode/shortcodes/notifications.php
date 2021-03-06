<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
require_once('../../../../../../wp-load.php');
?>
<!doctype html>
<html lang="en">
	<head>
	<title><?php _e('Insert Notification','liquidfolio'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
	}
	function submitData() {				
		var shortcode;
		var selectedContent = tinyMCE.activeEditor.selection.getContent();				
		var notification_type = jQuery('#notification_type').val();		
		shortcode = ' [notification type="'+notification_type+'"]'+selectedContent+'[/notification] ';			
			
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
    jQuery("#notification_type").change(function() {
        var type = jQuery(this).val();
        jQuery("#preview").html(type ? "<div class='qd_notification "+type+"' >Test block</div>"  : "");
    });	
	});
	
	</script>
	<style type="text/css">
		.qd_notification { 
			padding: 31px 25px 31px 73px;
			background-repeat: no-repeat; background-position: 23px 29px; background-color: #f3f3f3;
			font-size: 16px;
		}
		.notification_mark 		{ background-image: url(../../../images/i_successful.png);}
		.notification_error 	{ background-image: url(../../../images/i_errorn.png);}
		.notification_warning 	{ background-image: url(../../../images/i_warning.png);}
		.notification_info 		{ background-image: url(../../../images/i_info.png);}
	</style>
	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="notifications" action="#" >
		<div class="tabs">
			<ul>
				<li id="notifications_tab" class="current"><span><a href="javascript:mcTabs.displayTab('notifications_tab','notifications_panel');" onMouseDown="return false;"><?php _e('Notification','liquidfolio'); ?></a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper">
			
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Type of notification:','liquidfolio'); ?></legend>
					<label for="notification_type"><?php _e('Choose a type:','liquidfolio'); ?></label><br><br>
					<select name="notification_type" id="notification_type"  style="width:250px">
						<option value="" disabled selected><?php _e('Select type','liquidfolio'); ?></option>
						<option value="notification_mark"><?php _e('Successful','liquidfolio'); ?></option>
						<option value="notification_error"><?php _e('Error','liquidfolio'); ?></option>
						<option value="notification_warning"><?php _e('Warning','liquidfolio'); ?></option>
						<option value="notification_info"><?php _e('Info','liquidfolio'); ?></option>
					</select>					
				</fieldset>
			
				<fieldset style="margin-bottom:10px;padding:10px;">
					<legend><?php _e('Preview:','liquidfolio'); ?></legend>
					<div id="preview" style="min-height:95px"></div>
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