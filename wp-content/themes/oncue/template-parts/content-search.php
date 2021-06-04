<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package oncue
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header">
		<?php
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'oncue' ) );
		}
		
		?>
	</div><!-- .entry-header -->
	<div class="search entry-content m-0">
		<div class="search-thumb">
			<?php the_post_thumbnail('oncue-search-thumbnail'); ?>
		</div>
		<div class="search-content">
			<?php
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			echo oncue_get_excerpt(200);
			?>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->


