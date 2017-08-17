<?php
/**
 * @package Trego
 * @since Trego 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				echo __('Comments', 'trego') . " (" . get_comments_number() . ")";
			?>
		</h2>

		<ul class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'trego_comment' ) ); ?>
		</ul><!-- .comment-list -->

		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'trego' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&laquo; Older Comments', 'trego' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &raquo;', 'trego' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'trego' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
	<?php
		$req = get_option( 'require_name_email' );
		$fields =  array(
			'author' => '<p class="comment-form-author"><label for="author">' . __( 'Name:', 'trego' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="author" type="text" aria-required="true" size="30" value="' . esc_attr( $commenter['comment_author'] ) . '" name="author" placeholder="' . __( 'Enter Your Name *', 'trego' ) . '"></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email Address:', 'trego' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="email" type="email" aria-required="true" size="30" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" name="email" placeholder="' . __( 'Enter Your Email *', 'trego' ) . '"></p>',
		);
		$comments_args = array(
			'fields' => $fields,
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment:', 'trego' ) . '</label><textarea id="comment" aria-required="true" rows="8" cols="45" name="comment" placeholder="' . __( 'Your Comment', 'trego' ) . '"></textarea></p>'
		);
	?>
	<?php comment_form($comments_args); ?>

</div><!-- #comments -->