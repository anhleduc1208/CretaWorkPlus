<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package oncue
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('thumbnail'); ?>>
    <div class="caption">
        <header class="entry-header">
            <?php
			the_title( '<h1 class="entry-title mb-2"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			?>
            <div class="blog_post_meta mb-3">
                <?php
				oncue_posted_on();
				oncue_posted_by(); 
				oncue_get_category();
				?>
            </div>
            <?php 
				if ( 'post' === get_post_type() ) :
				oncue_post_thumbnail(); 
				endif; 
			?>

        </header><!-- .entry-header -->
        <div class="entry-content mb-5">
        <?php
		echo oncue_get_excerpt(200);
		?>
        </div><!-- .entry-content -->
    </div>
</div>