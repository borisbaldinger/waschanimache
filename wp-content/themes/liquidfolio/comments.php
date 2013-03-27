<?php if (have_comments() && !post_password_required() && Custom_Posts_Type_Gallery::POST_TYPE) : ?>
<div class="comments clearfix">
		<h3 id="comments"><?php printf(_n('One Response to &quot;%2$s&quot;', '%1$s Responses to &quot;%2$s&quot;', get_comments_number(), 'liquidfolio'), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>
		<ol class="commentlist">
	<?php wp_list_comments('callback=list_comments'); ?>
			<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through?  ?>
			<div class="pagination clearfix">
				<?php
				paginate_comments_links(array(
					'type' => 'list'
				))
				?>
			</div>
		<?php endif; // check for comment navigation  ?>
</div>

<?php else : // this is displayed if there are no comments so far  ?>

		<?php if ('open' == $post->comment_status) : ?>
			<!-- If comments are open, but there are no comments. -->

		<?php else : // comments are closed ?>
			<!-- If comments are closed. -->

	<?php endif; ?>
<?php endif; ?>
			
			

<?php if (comments_open() && !post_password_required()) : ?>
	<?php
	global $aria_req;
	wp_enqueue_script('validate');
	$commenter = wp_get_current_commenter();
	$comment_args = array('fields' => apply_filters('comment_form_default_fields', array(
		'author' =>
		'<p class="comment-form-author clearfix">' . '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' class="required" placeholder="'.__('Name','liquidfolio').'">' . '</p>',
		
		'email' => '' .
		'<p class="comment-form-emale clearfix">' . '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' class="required" placeholder="'.__('E-mail','liquidfolio').'">' . '</p>')),
		
		'comment_field' => 
		'<p class="comment-form-comment">' .'<textarea id="comment" name="comment" cols="45" rows="16" aria-required="true" class="required" placeholder="'.__('Comment','liquidfolio').'"></textarea>' .'</p>',
		
		'comment_notes_before' => '',
		
		'label_submit' => __('Add comment','liquidfolio'),
		
		'comment_notes_after' => ''
	);
	comment_form($comment_args);
	?>
<?php endif; ?>


<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die(_e('Please do not load this page directly. Thanks!', 'liquidfolio'));


?>

<?php if (have_comments() && !post_password_required() && !Custom_Posts_Type_Gallery::POST_TYPE)  : ?>
<div class="comments clearfix">
		<h3 id="comments"><?php printf(_n('One Response to &quot;%2$s&quot;', '%1$s Responses to &quot;%2$s&quot;', get_comments_number(), 'liquidfolio'), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>
		<ol class="commentlist">
	<?php wp_list_comments('callback=list_comments'); ?>
			<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through?  ?>
			<div class="pagination clearfix">
				<?php
				paginate_comments_links(array(
					'type' => 'list'
				))
				?>
			</div>
		<?php endif; // check for comment navigation  ?>
</div>

<?php else : // this is displayed if there are no comments so far  ?>

		<?php if ('open' == $post->comment_status) : ?>
			<!-- If comments are open, but there are no comments. -->

		<?php else : // comments are closed ?>
			<!-- If comments are closed. -->

	<?php endif; ?>
<?php endif; ?>
