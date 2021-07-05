<?php
/*
Title: Thông tin hoá đơn
Post Type: cr_invoice
*/
piklist('field', array(
  'type' => 'text',
  'field' => 'code',
  'label' => 'Mã',
  'description' => 'Mã hoá đơn',
));
piklist('field', array(
    'type' => 'text',
    'field' => 'statusInv',
    'label' => 'Tình trạng',
    'description' => 'Miêu tả đơn đã hủy hay là đơn chính thức',
  ));
piklist('field', array(
    'type' => 'datetime-local',
    'field' => 'purchaseDate',
    'label' => 'Ngày lên đơn',
    'description' => 'Ngày lên đơn',     
));
piklist('field', array(
    'type' => 'text',
    'field' => 'deliveryStatus',
    'label' => 'Tình trạng giao vận',
    'description' => 'Tình trạng giao vận',     
));
piklist('field', array(
    'type' => 'text',
    'field' => 'deliveryRealTime',
    'label' => 'Thời điểm đơn đi',
    'description' => 'Thời điểm đơn hàng rời khỏi CRETA thực tế',     
));
piklist('field', array(
  'type' => 'textarea',
  'field' => 'contentInvoice',
  'label' => 'Nội dung',
  'description' => 'Nội dung hoá đơn',
  'columns' => 12,  
));
piklist('field', array(
    'type' => 'text',
    'field' => 'customerCode',
    'label' => 'Mã Khách Hàng',
    'description' => 'Mã Khách Hàng',     
));

piklist('field', array(
    'type' => 'group',
    'field' => 'customerInfo',
    'label' => 'Thông tin khách hàng',
    'description' => 'Thông tin của khách hàng',
    'add_more' => true,
    'fields' => array(
        array(
            'type' => 'text',
            'field' => 'customerName',
            'label' => 'Tên khách hàng',
            'columns' => 5
        ),
        array(
            'type' => 'text',
            'field' => 'customerAddress',
            'label' => 'Địa chỉ khách hàng',
            'columns' => 7
        ),
    )     
));

piklist('field', array(
    'type' => 'group',
    'field' => 'planInfo', 
    'label' => 'Lập plan',
    'description' => 'Lên kế hoạch giao vận',
    'add_more' => true,
    'fields' => array(
        array(
            'type' => 'text'
            ,'field' => 'carrierCode'
            ,'label' => 'Mã chành xe chọn'
            ,'columns' => 5
        ),
        array(
            'type' => 'text'
            ,'field' => 'carrierName'
            ,'label' => 'Tên chành xe chọn'
            ,'columns' => 7
        ),
        array(
            'type' => 'textarea'
            ,'field' => 'carrierAddress'
            ,'label' => 'Địa chỉ chành xe chọn'
            ,'columns' => 12
        ),
        array(
            'type' => 'textarea'
            ,'field' => 'carrierArrive'
            ,'label' => 'Địa chỉ đến chành xe chọn'
            ,'columns' => 12
        ),
        array(
            'type' => 'text'
            ,'field' => 'carrierPhone'
            ,'label' => 'Số điện thoại chành xe chọn'
            ,'columns' => 5
        ),
        array(
            'type' => 'text'
            ,'field' => 'carrierPeriod'
            ,'label' => 'Thời gian di chuyển dự kiến'
            ,'columns' => 7
        ),
        array(
            'type' => 'textarea'
            ,'field' => 'carrierOwnNote'
            ,'label' => 'Lưu ý chung đối với chành xe'
            ,'columns' => 12
        ),
        array(
            'type' => 'textarea'
            ,'field' => 'carrierNote'
            ,'label' => 'Lưu ý riêng của khách đối với chành xe'
            ,'columns' => 12
        ),
        array(
            'type' => 'time'
            ,'field' => 'carrierStart'
            ,'label' => 'Khung thời gian xe chạy được chọn cho đơn này'
            ,'columns' => 5
        ),
        array(
            'type' => 'text'
            ,'field' => 'deliveryStorage'
            ,'label' => 'Địa chỉ kho lấy hàng đem đi giao'
            ,'columns' => 7
        ),
        array(
            'type' => 'datetime-local'
            ,'field' => 'deliveryTime'
            ,'label' => 'Thời gian CRETA bắt đầu giao hàng'
            ,'columns' => 5
        ),
        
    )
));

piklist('field', array(
    'type' => 'text',
    'field' => 'hiddenCode',
    'label' => 'Mã Hóa Đơn ẩn',
    'description' => 'Mã Hóa đơn dành cho khách hàng',     
));

piklist('field', array(
    'type' => 'group',
    'field' => 'logHistory',
    'label' => 'Lịch sử log đơn hàng',
    'description' => 'Chi tiết về các thông tin đơn hàng bị thay đổi',
    'add_more' => true,
    'fields' => array(
        array(
            'type' => 'text',
            'field' => 'datetime',
            'label' => 'Thời gian',
            'columns' => 3
        ),
       
        array(
            'type' => 'textarea',
            'field' => 'description',
            'label' => 'Chi tiết log',
            'columns' => 7
        ),
        array(
            'type' => 'text',
            'field' => 'dangerousLevel',
            'label' => 'Mức độ',
            'columns' => 2
        ),
    )     
));

piklist('field', array(
    'type' => 'group',
    'field' => 'smsHistory',
    'label' => 'Lịch sử tin nhắn đơn hàng',
    'description' => 'Chi tiết về các thông tin đơn hàng bị thay đổi',
    'add_more' => true,
    'fields' => array(
        array(
            'type' => 'text',
            'field' => 'datetime',
            'label' => 'Thời gian',
            'columns' => 3
        ),
        array(
            'type' => 'text',
            'field' => 'phone',
            'label' => 'Số điện thoại',
            'columns' => 3
        ),
        array(
            'type' => 'textarea',
            'field' => 'content',
            'label' => 'Nội dung',
            'columns' => 6
        ),
      
    )     
));