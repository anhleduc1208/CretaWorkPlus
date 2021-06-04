<?php
/*
Title: Thông tin log
Post Type: cr_log
*/
piklist('field', array(
  'type' => 'text',
  'field' => 'code',
  'label' => 'Mã',
  'description' => 'Mã ',
));
piklist('field', array(
    'type' => 'text',
    'field' => 'datetime',
    'label' => 'Thời điểm log',
    'description' => 'Thời điểm log',     
));
piklist('field', array(
    'type' => 'textarea',
    'field' => 'description',
    'label' => 'Chi tiết log',
    'description' => 'Chi tiết log', 
    'columns' => 12    
));
piklist('field', array(
    'type' => 'text',
    'field' => 'type',
    'label' => 'Loại post type',
    'description' => 'Loại custom post type',     
));

piklist('field', array(
    'type' => 'text',
    'field' => 'dangerousLevel',
    'label' => 'Mức độ cảnh báo log',
    'description' => 'Mức độ cảnh báo log',     
));




