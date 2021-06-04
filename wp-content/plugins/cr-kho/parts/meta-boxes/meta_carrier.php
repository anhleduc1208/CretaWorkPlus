<?php
/*
Title: Thông tin nhà xe
Post Type: cr_carrier
*/
piklist('field', array(
  'type' => 'text',
  'field' => 'code',
  'label' => 'Mã',
  'description' => 'Mã nhà giao vận',
));
piklist('field', array(
    'type' => 'group',
    'field' => 'address', 
    'description' => 'Thông tin nhà giao vận',
    'label' => 'Thông tin',
    // 'add_more' => true,
    'fields' => array(
        array(
            'type' => 'textarea',
            'field' => 'address',
            'label' => 'Địa chỉ trụ sở',
            'columns' => 12
        ),
        array(
            'type' => 'textarea',
            'field' => 'addressArrive',
            'label' => 'Khu vực đến',
            'columns' => 12
        ),
        array(
            'type' => 'text',
            'field' => 'phone',
            'label' => 'Số điện thoại',
            'columns' => 6
        ),
        array(
            'type' => 'text',
            'field' => 'time',
            'label' => 'Thời gian di chuyển dự kiến',
            'columns' => 6
        ),
        array(
            'type' => 'textarea',
            'field' => 'note',
            'label' => 'Ghi chú',
            'columns' => 12
        ),
        
        
        array(
            'type' => 'time',
            'field' => 'start',
            'add_more' => true,
            'label' => 'Giờ bắt đầu di chuyển trong ngày',
            'columns' => 12
        )
    )
));