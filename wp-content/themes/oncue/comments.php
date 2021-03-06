<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package oncue
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

    <?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
    <h2 class="comments-title">
        <?php
			$oncue_comment_count = get_comments_number();
			if ( '1' === $oncue_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'oncue' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $oncue_comment_count, 'comments title', 'oncue' ) ),
					number_format_i18n( $oncue_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
    </h2><!-- .comments-title -->
    <hr>

    <?php the_comments_navigation(); ?>

    <ol class="comment-list">
        <?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'format'      => 'html5',
				'avatar_size' => 72,
				
			) );
			?>
    </ol><!-- .comment-list -->

    <?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'oncue' ); ?></p>
    <?php
		endif;
	endif; // Check for have_comments().
	$aria_req = ($req) ? " aria-required='true'" : '' ;
	$args = array(
    'fields' => apply_filters(
        'comment_form_default_fields', array(
            'author' =>'<div class="row">
	<div class="col-md-6">
	<input class="input__field" id="author" placeholder="'.esc_attr__('Name *','oncue').'" name="author" type="text" '. $aria_req .'>
	</div>'
                ,
     'email'  => '<div class="col-md-6">
	<input class="input__field" id="email" placeholder="'.esc_attr__('Email *','oncue').'" name="email" type="email" '. $aria_req .'>
	</div>',
    'url'    => '<div class="col-md-12">
	<input class="input__field " id="url" placeholder="'.esc_attr__('Website','oncue').'" name="url" type="url">
	</div>
	</div>'
        )),
    'comment_field' => '<div class="row">
		<div class="col-md-12">
				<textarea class="textarea__field" id="comment" rows="4" placeholder="'.esc_attr__('Comment *','oncue').'" name="comment" '. $aria_req .'></textarea>
		</div>
	</div>',
);
	comment_form($args);
	?>

</div><!-- #comments -->