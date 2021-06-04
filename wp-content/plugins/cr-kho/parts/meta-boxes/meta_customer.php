<?php
/*
Title: Thông tin hóa đơn
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
    'field' => 'c_codes',
    'label' => 'Mã nhà xe',
    'description' => 'Mã nhà xe',
    'add_more' => true,
    'fields' => array(
        array(
            'type' => 'text'
            ,'field' => 'code'
            ,'label' => 'Mã nhà xe'
            ,'columns' => 5
        ),
        array(
            'type' => 'textarea'
            ,'field' => 'note'
            ,'label' => 'Ghi chú nhà xe'
            ,'columns' => 7
        )
    )
));

piklist('field', array(
    'type' => 'group',
    'field' => 'carrierInfo', 
    'label' => 'Thông tin nhà xe giao vận',
    'description' => 'Chọn nhà xe',
    'add_more' => true,
    'fields' => array(
        array(
            'type' => 'text'
            ,'field' => 'code'
            ,'label' => 'Mã nhà xe'
            ,'columns' => 5
        ),
        array(
            'type' => 'text'
            ,'field' => 'name'
            ,'label' => 'Tên tên nhà xe'
            ,'columns' => 7
        ),
        array(
            'type' => 'textarea'
            ,'field' => 'note'
            ,'label' => 'Lưu ý nhà xe'
            ,'columns' => 12
        )
    )
));