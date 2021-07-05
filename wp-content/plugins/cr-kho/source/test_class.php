<?php
    include_once 'dev1_DucAnh/Classes/class_creta.php';
    include_once 'SMS/src/Playsms/Webservices.php';
    include_once 'SMS/My-Code/SendSms.php';
?>
<h2>Test class</h2>

<?php

    // $invoice_obj = new Cr_Invoice();      
    // $args = array(
    //     'posts_per_page' => '-1'
    // );
    // $my_invs = $invoice_obj->findIdsByArgs($args);   
    // $cnt = $my_invs['count'];
    // $customer_obj = new Cr_Customer();
    // for ($x = 0; $x <br $cnt; $x++) {
    //     $id = $my_invs['id'][$x];
    //     // $cus_code = get_post_meta($id,'customerCode',true);
    //     // $inv_code = get_post_meta($id,'code',true);
    //     // $purchaseDate = get_post_meta($id,'purchaseDate',true);
    //     //update_post_meta($id,'statusInv','official');
    // }
    // echo 'start';
    // $invoice_obj = new Cr_Invoice();
    // $data = $invoice_obj->findRecentInvoices("HD004780",5);
    //     print_r($data);
    // echo 'end';

    $phone= '0919986654';    
    $msg = "Mến chào anh A\n";
    $msg .= "Cảm ơn anh đã tin tưởng Creta\n";
    $msg .= "Mời anh theo dõi thông tin giao vận đơn hàng ở link này nhé: http://creta.work \n";
    $msg .= "Trân trọng!!";
    echo 'sendsms';
    echo '</br>';
    // sendSMS($phone,$msg);
    echo '</br>';
    echo 'endSMS';

    // echo '</br>';
    // echo 'get credit';
    // $credit = getCredit();
    // echo '</br>';
    // echo 'end get credit';
    


    // $my_product_list = $invoice_obj->productList("HD004720");   
    // print_r($my_product_list);
    // echo "</br>";

    // $carrier_obj = new Cr_Carrier();
    // $my_car3 = $carrier_obj->getDataByCode("GV0002");
    // print_r($my_car3['address']);
    // echo "</br>";
    // $my_car2 = $carrier_obj->getDataByCode("GV0001");
    // print_r($my_car2['address']);
    // echo "</br>";

        // $new_address = array(
        //     '0' => array(
        //         'address' => "hehe",
        //         'addressArrive' => "hehe",
        //         'phone' => "hehe",
        //         'time' => "hehe",
        //         'note' => "hehe1", 
        //         'start' => array (
        //             '0' => ""
        //         )                  

        //     )
        // );
        // $new_carrier_obj = array(
        //     'code' => 'GV0000test1',
        //     'title' => 'GV0000test1: test',
        //     'address' => $new_address
        // );
        // $carrier_obj->createData($new_carrier_obj,false);

        

        // $update_address = array(
        //     '0' => array(
        //         'address' => "hehe",
        //         'addressArrive' => "hehe",
        //         'phone' => "hehe",
        //         'time' => "hehe",
        //         'note' => "hehe1", 
        //         'start' => array (
        //             '0' => ""
        //         )                  

        //     )
        // );
        // $update_carrier_obj = array(
        //     'address' => $update_address
        // );
        // $carrier_obj->updateDataByCode("GVtest01",$update_carrier_obj);

        //$carrier_obj->deleteByCode("GVtest01");

    
    //$customer_obj = new Cr_Customer();    
    //$my_cus2 = $customer_obj->getDataByCode("KH000370");
    //print_r($my_cus2);

    //echo "</br>";
    //$customer_obj->addInvoice('KH000370','HD004773','2021-05-27T13:57');
    //$customer_obj->addInvoice('KH000370','HD004772','2021-05-27T13:57');
    //$customer_obj->addInvoice('KH000370','HD004774','2021-05-27T13:57');

   // echo 'success';
    //$customer_obj->delInvoice('KH000370','HD004774');
    //update_post_meta(2864,'logHistory',array());
     //$invoice_obj->logNormal('HD004741','log 1');
     //$invoice_obj->logWarning('HD004738','log 2');
    // $invoice_obj->logError('HD004653','log 3');

    //$log_obj = new Cr_Logger();
    //$log_obj-> createLog('HD004739','cr_invoice','Vua duoc log hehe','normal');
    //$logHistory = get_post_meta(2864,'logHistory',true);
    //print_r($logHistory);

    
?>

