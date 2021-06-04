<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package oncue
 */

get_header();
?>
<main id="site-content" class="site-main container mt-6">
    <div id="primary" class="content-area">
        <div class="row">
            <div class="col-md-8">
                <?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() );

				if ( is_singular( 'post' ) ) {
					// Previous/next post navigation.
					the_post_navigation(
						array(
							'next_text' => '<span class="next-post">' . __( 'Next post:', 'oncue' ) . '</span> ' .
								'<span class="post-title">%title</span>',
							'prev_text' => '<span class="previous-post">' . __( 'Previous post:', 'oncue' ) . '</span> ' .
								'<span class="post-title">%title</span>',
						)
					);
				}

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
            </div>
            <!--/col-md-8-->
            <?php get_sidebar();?>
        </div>
        <!--/Row-->
    </div><!-- #primary -->
</main><!-- #main -->

<?php
get_footer();