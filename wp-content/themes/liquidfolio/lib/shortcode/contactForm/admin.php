<?php
function qd_contactform_esc_attr( $attr ) {
	$out = esc_attr( $attr );
	// we also have to entity-encode square brackets so they don't interfere with the shortcode parser
	// FIXME: do this better - just stripping out square brackets for now since they mysteriously keep reappearing
	$out = str_replace( '[', '', $out );
	$out = str_replace( ']', '', $out );
	return $out;
}

function qd_contactform_sort_objects( $a, $b ) {
	if ( isset($a['order']) && isset($b['order']) )
		return $a['order'] - $b['order'];
	return 0;
}

// take an array of field types from the form builder, and construct a shortcode form
// returns both the shortcode form, and HTML markup representing a preview of the form
function qd_contactform_ajax_shortcode() {
	check_ajax_referer( 'qd_contactform_shortcode' );
	
	$atts = '';
	if ( trim( $_POST['subject'] ) )
		$atts .= ' subject="'.qd_contactform_esc_attr($_POST['subject']).'"';
	
	if ( trim( $_POST['to'] ) )
		$atts .= ' to="'.qd_contactform_esc_attr($_POST['to']).'"';
	
	if ( trim( $_POST['button_text'] ) &&  $_POST['button_text'] != "Send")
		$atts .= ' button_text="'.qd_contactform_esc_attr($_POST['button_text']).'"';
	
	$shortcode = '[qd-contact-form'.$atts.']';
	$shortcode .= "\n";
	if ( is_array( $_POST['fields'] ) ) {
		usort( $_POST['fields'], 'qd_contactform_sort_objects' );
		foreach ( $_POST['fields'] as $field ) {
			$req = $opts = $reply = '';
			if ( $field['required'] == 'true' )
				$req = ' required="true"';
			if ( isset($field['reply']) && $field['reply'] == 'true' )
				$reply = ' reply="true"';
			if ( isset( $field['options'] ) && $field['options'] ) {
				$opts = ' options="';
				foreach ( $field['options'] as $option ) {
					$option = wp_kses( $option, array() );
					$option = qd_contactform_esc_attr( $option );

					# we need to be very specific about how we
					# encode these values
					$option = str_replace( ',', '&#x002c;', $option );
					$option = str_replace( '"', '&#x0022;', $option );
					$option = str_replace( "'", '&#x0027;', $option );
					$option = str_replace( '&', '&#x0026;', $option );

					$opts .= $option . ',';
				}
				$opts = rtrim( $opts, ',' ) . '"';
			}

			$field['label'] = wp_kses( $field['label'], array() );
			$field['label'] = str_replace( '"', '&#x0022;', $field['label'] );

			$shortcode .= '[qd-contact-field label="'. $field['label'] .'" type="'.qd_contactform_esc_attr($field['type']).'"' . $req . $opts . $reply .' /]'."\n";
		}
	}
	$shortcode .= '[/qd-contact-form]';
	
	die( "\n$shortcode\n" );
}

add_action( 'wp_ajax_qd_contactform_shortcode', 'qd_contactform_ajax_shortcode' );
?>