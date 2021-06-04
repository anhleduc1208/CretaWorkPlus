<?php
/*
Title: Thông tin khách hàng từ KIOTViet
Post Type: cr_customer
*/
piklist('field', array(
    'type' => 'text',
    'field' => 'code',
    'label' => 'Mã',
    'description' => 'Mã khách hàng',
  ));
  
piklist('field', array(
    'type' => 'group',
    'field' => 'customerInfo', 
    'label' => 'Thông tin',
    'description' => 'Đây là thông tin được cập nhật từ kiot',
    'add_more' => true,
    'fields' => array(        
        array(
            'type' => 'text'
            ,'field' => 'name'
            ,'label' => 'Tên khách hàng'
            ,'columns' => 6
        ),
        array(
            'type' => 'text'
            ,'field' => 'contactNumber'
            ,'label' => 'Số điện thoại'
            ,'columns' => 4
        ),
        array(
            'type' => 'text'
            ,'field' => 'gender'
            ,'label' => 'Giới tính'
            ,'columns' => 2
        ),
        array(
            'type' => 'text'
            ,'field' => 'address'
            ,'label' => 'Địa chỉ'
            ,'columns' => 9
        ),
        array(
            'type' => 'text'
            ,'field' => 'locationName'
            ,'label' => 'Khu vực giao hàng'
            ,'columns' => 9
        ),
        array(
            'type' => 'text'
            ,'field' => 'wardName'
            ,'label' => 'Phường Xã'
            ,'columns' => 9
        ),
       
        array(
            'type' => 'textarea'
            ,'field' => 'comments'
            ,'label' => 'Lưu ý'
            ,'columns' => 12
        ),
        array(
            'type' => 'number'
            ,'field' => 'rewardPoint'
            ,'label' => 'Điểm thưởng còn lại'
            ,'columns' => 6
        ),
        array(
            'type' => 'number'
            ,'field' => 'totalPoint'
            ,'label' => 'Tổng điểm thưởng tích lũy'
            ,'columns' => 6
        ),
        array(
            'type' => 'number'
            ,'field' => 'debt'
            ,'label' => 'Nợ'
            ,'columns' => 4
        ),
        array(
            'type' => 'number'
            ,'field' => 'totalInvoiced'
            ,'label' => 'Total Invoiced'
            ,'columns' => 4
        ),
        array(
            'type' => 'number'
            ,'field' => 'totalRevenue'
            ,'label' => 'Total Revenue'
            ,'columns' => 4
        ),

    )
));