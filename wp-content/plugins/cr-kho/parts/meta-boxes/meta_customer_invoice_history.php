<?php
/*
Title: Lịch sử mua hàng
Post Type: cr_customer
*/
piklist('field', array(
    'type' => 'group',
    'field' => 'recentInvoices',
    'label' => 'Lịch sử hóa đơn',
    'description' => 'Danh sách các đơn hàng gần đây',    
    'add_more' => true,
    'fields' => array(
        array(
            'type' => 'text'
            ,'field' => 'invCode'
            ,'label' => 'Mã hóa đơn'
            ,'columns' => 6
        ),
        array(
            'type' => 'datetime-local'
            ,'field' => 'purchaseDate'
            ,'label' => 'Ngày lên đơn'
            ,'columns' => 6
        )
    )
));

  