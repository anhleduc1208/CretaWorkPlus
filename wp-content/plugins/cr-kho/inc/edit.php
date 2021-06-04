<?
add_filter( 'manage_cr_account_posts_columns', 'set_custom_edit_book_columns' );
add_action( 'manage_cr_account_posts_custom_column' , 'custom_book_column', 10, 2 );
 
function set_custom_edit_book_columns($columns) {
    unset( $columns['title'] );
    // unset( $column['date']);
    unset( $columns['date']   );
    $columns['account_number'] = __( 'Mã số', 'your_text_domain' );
    $columns['account_name'] = __('Tên tài khoản', 'your_text_domain');
    return $columns;
}
 
function custom_book_column( $column, $post_id ) {
    switch ( $column ) {
        case 'account_number' :
            $terms = get_post_meta( $post_id , 'account_number');
            echo $terms[0];
            break;
        case 'account_name' :
            echo get_the_title( $post_id ); 
            break;
    }
}

add_filter( 'manage_cr_deal_posts_columns', 'set_column_deal' );
add_action( 'manage_cr_deal_posts_custom_column' , 'edit_column_deal', 10, 2 );
function set_column_deal($columns) {
    unset( $columns['title'] );
    unset( $columns['date']   );
    $columns['deal_name'] = __('Giao dịch', 'your_text_domain');
    $columns['deal_amount'] = __('Số tiền', 'your_text_domain');
    $columns['deal_date'] = __('Ngày giao dịch', 'your_text_domain');
    $columns['deal_staff'] = __( 'Nhân viên', 'your_text_domain' );
    return $columns;
}
 
function edit_column_deal( $column, $post_id ) {
    switch ( $column ) {
        case 'deal_name' :
            $terms = get_post_meta( $post_id , 'define_deal');
            $post = get_post($terms[0] + 0);
            echo $post->post_title;
            break;
        case 'deal_amount' :
            $terms = get_post_meta( $post_id , 'amount');
             // echo var_dump($terms[0]);
             echo number_format($terms[0] + 0);
            break;
        case 'deal_date':
            $terms = get_post_meta( $post_id , 'date_deal');
             // echo var_dump($terms[0]);
             echo $terms[0];
        break;
        case 'deal_staff':
            $terms = get_post_meta( $post_id , 'staff_deal');
            $user = get_user_by('id', $terms[0]);
             echo $user->display_name;
            
        break;
    }
}