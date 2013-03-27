<?php
/**
 *  Contact form widget
 */
class Widget_ContactForm extends Widget_Default {

	function __construct()
	{
		$this->setClassName('widget_contactform');
		$this->setName(__('Contact form','liquidfolio'));
		$this->setDescription(__('Contact form widget','liquidfolio'));
		$this->setIdSuffix('contactform');
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		$to = (isset($instance['recipient'])
						&& !empty($instance['recipient'])
						&& filter_var($instance['recipient'], FILTER_VALIDATE_EMAIL))
					? $instance['recipient']
					: get_bloginfo('admin_email');
		$wdescription = $instance['wdescription'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;
		
		if ($wdescription)
			echo '<div>'.qd_the_content($wdescription).'</div>';

		global $wid;
		$wid = $args['widget_id'];
		global $am_validate; $am_validate = true;

		?>


					<form class="contactformWidget" method="post" action="#contactformWidget">


							<div>

								<input name="name" class="name" type="text" placeholder="<?php _e('Name','liquidfolio'); ?>" />
							</div>
							<div>
								<input  name="email" class="email" type="text"  id="email_from" placeholder="<?php _e('E-Mail','liquidfolio'); ?>" />
							</div>
							<div>
								<textarea  name="comments"  rows="5" cols="20" placeholder="<?php _e('Type your message here','liquidfolio'); ?>"></textarea>
							</div>
							<div>
                            	<button type="submit"><?php _e('Send message','liquidfolio'); ?></button>
                            </div>
							<input type="hidden" name="to" value="<?php echo $to;?>">
							<input type='hidden' class = 'th-email-from' name = 'qd-email-from' value='email_from'>
					</form>
                    <script type="text/javascript">
					jQuery(document).ready(function() {
                    jQuery("#<?php global $wid; echo $wid; ?> .contactformWidget").validate({
						submitHandler: function(form) {
							jQuery("#<?php global $wid; echo $wid; ?> .contactformWidget button").attr('disabled', 'disabled');
							ajaxContact(form);
							return false;
						},
						 rules: {
								comments: "required",
								email: "required email",
								name: "required"
						},
						 messages: {
							name: "<?php _e('Please specify your name.','liquidfolio'); ?>",
							comments: "<?php _e('Please enter your message.','liquidfolio'); ?>",
							email: {
								required: "<?php _e('We need your email address to contact you.','liquidfolio'); ?>",
								email: "<?php _e('Your email address must be in the format of name@domain.com','liquidfolio'); ?>"
							}
					 }
					});
					});
                    </script>


                    <?php
		echo $after_widget;

		wp_enqueue_script('validate');
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['recipient'] = strip_tags( $new_instance['recipient'] );
		$instance['wdescription'] =  $new_instance['wdescription'] ;
		return $instance;
	}


	function form( $instance ) {

		// Defaults
		$defaults = array( 'title' => __( 'Contact us', 'liquidfolio' ),
						   'recipient' => get_bloginfo('admin_email'),'wdescription'=>'');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'liquidfolio' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'wdescription' ); ?>"><?php _e( 'Description:', 'liquidfolio' ); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'wdescription' ); ?>" name="<?php echo $this->get_field_name( 'wdescription' ); ?>"   style="width:100%;min-height:120px"><?php echo $instance['wdescription']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'recipient' ); ?>"><?php _e( 'Recipient email:', 'liquidfolio' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'recipient' ); ?>" name="<?php echo $this->get_field_name( 'recipient' ); ?>" type="text" value="<?php echo $instance['recipient']; ?>" style="width:100%;" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}