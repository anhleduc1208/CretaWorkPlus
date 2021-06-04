<?/**
 * Tạo custom post type
 * https://piklist.com/learn/doc/piklist_post_types/
 */
function creta_register_account( $post_types ) {
    // Tạo post type tên 'cr_invoice'
    $post_types['cr_invoice'] = array(
        'labels' => array(
            'name' => 'Hoá đơn',
            'singular_name' => 'Hoá đơn',
            'add_new' => 'Thêm hoá đơn',
            'add_new_item' => 'Thêm hoá đơn mới',
            'all_items' => 'Tất cả hoá đơn',
            'edit_item' => 'Sửa hoá đơn',
            'featured_image' => 'Ảnh đại diện hoá đơn',
            'filter_item_list' => 'Lọc danh sách hoá đơn',
            'item_list' => 'Danh sách hoá đơn',
            'set_featured_image' => 'Thiết lập ảnh đại diện'
        ),
        'menu_icon' => 'dashicons-clipboard',
        'title' => 'Nhập tên hoá đơn',
        'public' => true,
        'supports' => array('title', 'thumbnail', 'comment'),
         //'supports' => array('title', 'thumbnail', 'comment', 'custom-fields'),
        'rewrite' => array('slug' => 'cr_invoice'),
        'hide_meta_box' => array('author'),
        'has_archive' => true,
        'show_in_rest' => true,
        'rest_base' => 'invoices',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
         'register_post_meta' => true
        
    );
    return $post_types;
}

function creta_register_deal( $post_types ) {
 
    // Tạo post type tên 'cr_customer'
    $post_types['cr_customer'] = array(
        'labels' => array(
            'name' => 'Khách hàng',
            'singular_name' => 'Khách hàng',
            'add_new' => 'Thêm khách hàng',
            'add_new_item' => 'Thêm khách hàng mới',
            'all_items' => 'Tất cả khách hàng',
            'edit_item' => 'Sửa khách hàng',
            'featured_image' => 'Ảnh đại diện khách hàng',
            'filter_item_list' => 'Lọc danh sách khách hàng',
            'item_list' => 'Danh sách khách hàng',
            'set_featured_image' => 'Thiết lập ảnh đại diện'
        ),
        'menu_icon' => 'dashicons-buddicons-buddypress-logo',
        'title' => 'Nhập tên khách hàng',
        'public' => true,
        'supports' => array('title', 'thumbnail', 'comment'),
        // 'rewrite' => array('slug' => 'sanpham'),
        'hide_meta_box' => array('author'),
        'has_archive' => true,
        'show_in_rest' => true,
        'rest_base' => 'customers',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );
 
    return $post_types;
}
function creta_register_log( $post_types ) {
    // Tạo post type tên 'cr_carrier'
    $post_types['cr_carrier'] = array(
        'labels' => array(
            'name' => 'Vận chuyển',
            'singular_name' => 'Vận chuyển',
            'add_new' => 'Thêm vận chuyển',
            'add_new_item' => 'Thêm vận chuyển mới',
            'all_items' => 'Tất cả vận chuyển',
            'edit_item' => 'Sửa vận chuyển',
            'featured_image' => 'Ảnh đại diện vận chuyển',
            'filter_item_list' => 'Lọc danh sách vận chuyển',
            'item_list' => 'Danh sách vận chuyển',
            'set_featured_image' => 'Thiết lập ảnh đại diện'
        ),
        'menu_icon' => 'dashicons-car',
        'title' => 'Nhập tên vận chuyển',
        'public' => true,
        'supports' => array('thumbnail', 'comment', 'title'),
        // 'rewrite' => array('slug' => 'sanpham'),
        'hide_meta_box' => array('author'),
        'has_archive' => true,
        'show_in_rest' => true,
        'rest_base' => 'carriers',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );
 
    return $post_types;
}

function creta_register_logger( $post_types ) {
    // Tạo post type tên 'cr_carrier'
    $post_types['cr_log'] = array(
        'labels' => array(
            'name' => 'Log',
            'singular_name' => 'Log',
            'add_new' => 'Thêm log',
            'add_new_item' => 'Thêm log mới',
            'all_items' => 'Tất cả log',
            'edit_item' => 'Sửa log',
            'featured_image' => 'Ảnh đại diện log',
            'filter_item_list' => 'Lọc danh sách log',
            'item_list' => 'Danh sách log',
            'set_featured_image' => 'Thiết lập ảnh đại diện'
        ),
        'menu_icon' => 'dashicons-visibility',
        'title' => 'Nhập tên log',
        'public' => true,
        'supports' => array('thumbnail', 'comment', 'title'),
        // 'rewrite' => array('slug' => 'sanpham'),
        'hide_meta_box' => array('author'),
        'has_archive' => true,
        'show_in_rest' => true,
        'rest_base' => 'logs',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );
 
    return $post_types;
}
add_filter('piklist_post_types', 'creta_register_account');
add_filter('piklist_post_types', 'creta_register_deal');
add_filter('piklist_post_types', 'creta_register_log');
add_filter('piklist_post_types', 'creta_register_logger');
?>