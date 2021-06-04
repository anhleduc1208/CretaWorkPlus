<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package oncue
 */

get_header();
?>
<main id="site-content" class="site-main container mt-5">
    <div id="primary" class="content-area">
        <section class="error-404 not-found">
            <header class="page-header mt-6">
                <h1><?php esc_html_e( 'Trang không tìm thấy', 'oncue' ); ?></h1>
                <h3 class="page-title mt-3"><?php esc_html_e( 'Hãy đăng nhập lại biết đâu lại được đấy !!!', 'oncue' ); ?>
                </h3>
            </header><!-- .page-header -->

            <div class="page-content row">
                <div class="col-md-6 offset-3">
                    <p><?php esc_html_e( 'Có thể đường dẫn không hợp lệ hoặc trang này cần quyền truy cập cao hơn để có thể xem được', 'oncue' ); ?>
                    </p>
                    <?php
						get_search_form();
						?>
                    <a class="btn btn-default button-primary"
                        href="<?php echo esc_url( home_url( '/wp-admin' ) ); ?>"><?php esc_html_e( 'Đăng nhập', 'oncue' ); ?></a>
                </div>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
    </div><!-- #primary -->
</main><!-- #main -->