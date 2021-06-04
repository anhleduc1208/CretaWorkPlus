<?php 
/**
 * Custom theme functions.
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Oncue
 */
if ( ! function_exists( 'oncue_header' ) ) :
	function oncue_header(){?>

<header class="nav-header">
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-theme">
        <div class="container">
            <div class="brand mr-auto">
                <?php oncue_site_logo(); ?>
                <?php oncue_site_description();?>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse"
                aria-controls="navbar-collapse" aria-expanded="false"
                aria-label="<?php esc_attr_e( 'Toggle navigation', 'oncue' ); ?>">
                <span class="toggle-menu fa fa-bars"></span>

            </button>
            <?php
				wp_nav_menu( array(
					'theme_location'    => 'primary',
					'depth'             => 3,
					'container'         => 'div',
					'container_class'   => 'collapse navbar-collapse justify-content-center',
					'container_id'      => 'navbar-collapse',
					'menu_class'        => 'nav navbar-nav',
					'items_wrap'		=> '<ul class="nav navbar-nav" data-function="navbar">%3$s</ul>',
				) );
			?>
        </div>
    </nav>
    <!--/navbar-->
</header>
<?php
	}
endif;
add_action('oncue_action_header','oncue_header', 10);

/**
Footer hook function
**/
if ( ! function_exists( 'oncue_footer' ) ) :
	function oncue_footer(){?>
<!--Footer-->
<footer class="footer sec-bg">
    <div class="container">
        <div class="row text-left mt-4 mb-4">
            <?php
				if (is_active_sidebar('footer_menu')) {
					dynamic_sidebar('footer_menu');
				}
				?>
        </div>
        <hr>
        <div class="row copyright_info">
            <div class="col-md-12">
                <div class="mt-2">
                    <?php
					if (!is_active_sidebar('copyright')) {
					?>
                    <div class="footer-credits">
                        <p class="footer-copyright powered-by-wordpress">
                            &copy;
                            <?php
							echo date_i18n(
								/* translators: Copyright date format, see https://secure.php.net/date */
								_x( 'Y', 'copyright date format', 'oncue' )
							);
							?>
									
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?>.</a>
							<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'oncue' ) ); ?>">
							<?php _e( 'Powered by WordPress', 'oncue' ); ?>
							</a>
                        </p><!-- .powered-by-wordpress -->
                    </div><!-- .footer-credits -->
                    <?php } else{?>
                    <small><?php dynamic_sidebar('copyright');?> </small>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php
	}
endif;
add_action('oncue_action_footer','oncue_footer', 10);
?>