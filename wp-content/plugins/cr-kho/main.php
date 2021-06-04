<?php
/**
 * Plugin Name: VẬN HÀNH KHO
 * Plugin URI: http://creta.vn
 * Description: Chương trình nâng cấp hệ thống kho ở CRETA
 * Version: 0.1 - demo
 * Author: Kỹ thuật TEAM
 * Author URI: 
 * License: GPLv2
 * Plugin Type: Piklist
 */
?>
<? 
if(!class_exists('Creta_Storage')) {
    class Creta_Storage {
            function __construct() {
                    if(!function_exists('add_shortcode')) {
                            return;
                    }
                    add_shortcode( 'cr_plus' , array(&$this, 'main_function') );
                    add_shortcode( 'cr_plus_api' , array(&$this, 'api_function') );
            }

            function main_function($atts = array(), $content = null) {
                    extract(shortcode_atts(array('page' => 'none'), $atts));
                    ob_start();
                    include "source/".$page.'.php';
                    $output = ob_get_clean();
                    return $output;
            }

            function api_function($atts = array(), $content = null) {
                extract(shortcode_atts(array('page' => 'none'), $atts));
                ob_start();
                include "source/api/".$page.'.php';
                $output = ob_get_clean();
                return $output;
                }
    }
}
function cr_kho() {
    global $cr_kho;
    $cr_kho = new Creta_Storage();
}


if( ! function_exists( 'post_meta_request_params' ) ) :
	function post_meta_request_params( $args, $request )
	{
		$args += array(
			'meta_key'   => $request['meta_key'],
			'meta_value' => $request['meta_value'],
			'meta_query' => $request['meta_query'],
		);

	    return $args;
	}
	//add_filter( 'rest_post_query', 'post_meta_request_params', 99, 2 );
	// add_filter( 'rest_page_query', 'post_meta_request_params', 99, 2 ); // Add support for `page`
	add_filter( 'rest_cr_customer_query', 'post_meta_request_params', 99, 2 ); // Add support for `my-custom-post`
        add_filter( 'rest_cr_invoice_query', 'post_meta_request_params', 99, 2 ); // Add support for `my-custom-post`
        add_filter( 'rest_cr_carrier_query', 'post_meta_request_params', 99, 2 ); // Add support for `my-custom-post`
        add_filter( 'rest_cr_log_query', 'post_meta_request_params', 99, 2 ); // Add support for `my-custom-post`

endif;

add_action( 'plugins_loaded', 'cr_kho' );
require dirname( __FILE__ ) . '/inc/init.php';
// require dirname( __FILE__ ) . '/inc/edit.php';
require dirname( __FILE__ ) . '/inc/reg.php';