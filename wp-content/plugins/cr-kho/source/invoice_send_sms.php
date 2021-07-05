<?php
    include_once 'dev1_DucAnh/Classes/class_creta.php';
    include_once 'dev1_DucAnh/Function/short_link.php';
    include_once 'SMS/src/Playsms/Webservices.php';
    include_once 'SMS/My-Code/SendSms.php';
?>
<style>
    <?php include 'css_tracking_delivery/sendSMS_style.css';?>
</style>

<!-- Xử lý gửi msg khi có post data -->
<?php
    if ($_POST['raw_phone']) {
        
        // print_r($_POST);
        // echo '</br>';
        $code = $_GET['code'];
        $sent_phone = $_POST['raw_phone'];
        $sent_link = $_POST['raw_link'];
        $sent_head = $_POST['raw_head'];
        $sent_main = $_POST['raw_main'];
        $sent_foot = $_POST['raw_foot'];

        $short_link = general_short_link($sent_link);
        $sent_main .= $short_link;
        echo $short_link;
        echo '</br>';
        $phone = $sent_phone;
        $msg = $sent_head. "\n" . $sent_main . "\n" . $sent_foot;
        $msg2 = $sent_head. "</br>" . $sent_main . "</br>" . $sent_foot;
        // echo 'sendsms';
        // echo '</br>';
        sendSMS($phone,$msg);
        // echo '</br>';
        // echo 'endSendSMS';
        $inv_obj = new Cr_Invoice();
        $updated_sms = $inv_obj->addSMSHistory($code,$phone,$msg2);
        // print_r($updated_sms);
        echo 'Gui tin nhan thanh cong';
        echo '</br>';
    }
?>

<!-- Lấy thông tin back end -->
<?php
    $check_code_wrong= false;
    if ($_GET['code']) {    
        $get_code = $_GET['code'];   
        //$count = strlen($get_code);
        
        $invoice_obj = new Cr_Invoice();     
      
        $the_invoice = $invoice_obj->getDataByCode($get_code);
       
        
            if ($the_invoice) {                                
                $invoice_id =  $the_invoice['id'];
                $invoice_title =  $the_invoice['title'];
                /*--Start-Lấy thông tin để hiển thị--*/
                    /*-----Mã hóa đơn------*/
                        $invoice_code =   $the_invoice['code']; 
                        
                    /*-----Code hóa đơn cho KH------*/
                        $invoice_hidden_code =   $the_invoice['hiddenCode']; 
                    
                    /*-----Ngày lên đơn------*/
                        $invoice_purchase_date =   $the_invoice['purchaseDate'];

                    /*-----Thời điểm hàng đi------*/
                        $invoice_delivery_real_time = $the_invoice['deliveryRealTime'];

                    /*-----Tình trạng giao vận của đơn------*/
                        $invoice_delivery_status =  $the_invoice['deliveryStatus'];
                            $invoice_delivery_status_VN = "";
                            $color_status = "red";
                            $link_pic="";
                            $css_url="";
                            $code_status = 0;
                            switch ($invoice_delivery_status) {
                                case "CHO_LEN_KE_HOACH":
                                    $color_status = "red";
                                    $code_status = 0;
                                    $invoice_delivery_status_VN = "Chờ kho xác nhận";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/plan.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-red.css">';
                                    break;
                                case "DANG_DONG_HANG":
                                    $color_status = "yellow";
                                    $code_status = 1;
                                    $invoice_delivery_status_VN = "Đang đóng hàng";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/wrap-package.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-yellow.css">';
                                    break;
                                case "CHO_GIAO_HANG":
                                    $color_status = "teal";
                                    $code_status = 2;
                                    $invoice_delivery_status_VN = "Chờ giao hàng";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/delivery.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-teal.css">';
                                    break;
                                case "DA_GIAO_VAN":
                                    $color_status = "purple";
                                    $code_status = 3;
                                    $invoice_delivery_status_VN = "Đã giao ra nhà xe";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/confirm-1.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-purple.css">';
                                    break;
                                case "HOAN_THANH":
                                    $color_status = "green";
                                    $code_status = 4;
                                    $invoice_delivery_status_VN = "Hoàn thành";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/check.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-green.css">';
                                    break;
                                default:
                            }       
                    
                
                    /*-----Nội dung của hóa đơn từ kiotviet------*/
                        $invoice_content_str = $the_invoice['contentInvoice'];    
                            $invoice_content_obj = json_decode($invoice_content_str,true);   
                                $invoice_customer_name = $invoice_content_obj['customerName'];            
                                $invoice_customer_note = $invoice_content_obj['description'];
                                $invoice_customer_phone = $invoice_content_obj['invoiceDelivery']['contactNumber'];
                                $invoice_customer_time_created = $invoice_content_obj['createdDate'];
                                    $timestamp = date("d/m/Y H:i A",strtotime($invoice_customer_time_created));
                                $invoice_customer_address = $invoice_content_obj['invoiceDelivery']['address'];
                                $invoice_sale = $invoice_content_obj['soldByName'];
                                $invoice_total = $invoice_content_obj['total'];
                        
                    /*-----Mã khách hàng của đơn------*/
                        $invoice_customer_code = $the_invoice['customerCode'];
                    /*-----Thông tin về khách hàng của đơn------*/
                        $invoice_customerInfo1 = $the_invoice['customerInfo']; 
                            $invoice_customerInfo =  $invoice_customerInfo1[0];
                                $i_cus_Name = $invoice_customerInfo['customerName'];   
                                $i_cus_Address = $invoice_customerInfo['customerAddress'];
                        
                    /*-----Thông tin về kế hoạch giao vận của đơn------*/
                        $invoice_planinfo1 = $the_invoice['planInfo']; 
                            $invoice_planinfo =  $invoice_planinfo1[0];
                                $i_plan_crCode = $invoice_planinfo['carrierCode']; 
                                $i_plan_crName = $invoice_planinfo['carrierName'];   
                                $i_plan_crAddress = $invoice_planinfo['carrierAddress'];
                                $i_plan_crArrive = $invoice_planinfo['carrierArrive'];
                                $i_plan_crPhone = $invoice_planinfo['carrierPhone'];
                                $i_plan_crPeriod = $invoice_planinfo['carrierPeriod'];
                                $i_plan_crOwnNote = $invoice_planinfo['carrierOwnNote'];
                                $i_plan_crNote = $invoice_planinfo['carrierNote'];
                                $i_plan_crStart = $invoice_planinfo['carrierStart'];
                                $i_plan_deStorage = $invoice_planinfo['deliveryStorage'];
                                $i_plan_deTime = $invoice_planinfo['deliveryTime'];

                                $i_plan_crRealStart = $i_plan_crStart." ngay ".substr($i_plan_deTime,8,2). "-" .substr($i_plan_deTime,5,2);
                                $i_plan_crRealName = substr($i_plan_crName,7);

                                $i_plan_deTime = str_replace('T',' ',$i_plan_deTime);

                    /*-----Tình trạng giao vận của đơn------*/
                        $invoice_log_history = $the_invoice['logHistory'];
                            $invoice_log_number = count($invoice_log_history);
                        
                    /*-----Danh sách sản phẩm của đơn------*/
                        //$invoice_obj = new Cr_Invoice();
                        $invoice_product_list = $invoice_obj->productList($invoice_code);
                            $product_count = count($invoice_product_list);

                    /*-----Lịch sử gửi tin nhắn của đơn------*/
                        $invoice_sms_history = $the_invoice['smsHistory'];
                            $invoice_sms_count = count($invoice_sms_history);



                /*--End-Lấy thông tin để hiển thị--*/   
                if ($_POST['raw_phone']) {
                    $raw_code = $invoice_code;
                    $raw_name = $invoice_customer_name;
                    $raw_phone = $_POST['raw_phone'];
                    $raw_link = $_POST['raw_link'];
                    $raw_head = $_POST['raw_head'];
                    $raw_main = $_POST['raw_main'];
                    $raw_foot = $_POST['raw_foot'];
                }   else {
                    $raw_code = $invoice_code;
                    $raw_name = $invoice_customer_name;
                    $raw_phone = $invoice_customer_phone;
                    $raw_link = "http://creta.work/thong-tin-don-hang/?code=".$invoice_hidden_code;
                    $raw_head = "Don hang ".$invoice_code." dang dong goi tai CRETA. Du kien xuat kho: ".$i_plan_crRealStart.".";
                    $raw_main = "Theo doi lich trinh don hang tai: ";
                    $raw_foot = "Cam on anh da mua hang tai Creta.";
                }
                
            //}
            }   else {
                $check_code_wrong = true;
            }  
        //wp_reset_postdata();   
    }
?>


<!-- Trường hợp đúng link và code đúng -->
<?php if (($_GET['code'])&&($check_code_wrong==false)) {
    echo  $css_url;
    ?>
    
            <!-- Hiển thị -->      
    <link rel="stylesheet" href="sendSMS_style.css" type="text/css"> 
    <a href="http://creta.work/invoice-view-all/"><button class="w3-button w3-right w3-teal w3-round">Trang hóa đơn</button></a>

    <div id="old_sms" class="w3-panel">
        <div id="title">
            <h4 class="w3-center">Tin nhắn đã gửi của <?=$invoice_code?></h4>
        </div>
        <div id="table" class="w3-container"></div>
        <table class="w3-table-all w3-bordered w3-container w3-strip">
            <thead>
                <tr class="w3-teal">
                    <th>Thời gian</th>
                    <th>Số điện thoại</th>
                    <th>Nội dung</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    for ($b = 0 ; $b < $invoice_sms_count; $b++){
                        $time = $invoice_sms_history[$b]['datetime'];
                        $phone = $invoice_sms_history[$b]['phone'];
                        $content = $invoice_sms_history[$b]['content'];
                ?>
                    <tr>
                        <td><?=$time?></td>
                        <td><?=$phone?></td>
                        <td><?=$content?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

    <form method="POST" id="my_form" >
        <button type="submit" disabled style="display: none" aria-hidden="true"></button>
        <div class="my-row" >
            <div class="my-half">
                <div id="form">
                    <h3>Xác nhận thông tin gửi tin</h3>
                    <div class="form-content">
                        <div class="row-data">
                            <div class="row-key">
                                <p>Hóa đơn</p>
                            </div>
                            <div class="row-value">
                                <p id="raw_code"><?=$raw_code?></p>
                            </div>
                        </div>

                        <div class="row-data">
                            <div class="row-key">
                                <p>Tên</p>
                            </div>
                            <div class="row-value">
                                <p id="raw_name"><?=$raw_name?></p>
                            </div>
                        </div>

                        <div class="row-data">
                            <div class="row-key">Link giao vận</div>
                            <div class="row-value">
                                <p><a href="<?=$raw_link?>"><?=$raw_link?></a></p>
                                <input id="raw_link" type="hidden" name="raw_link" value="<?=$raw_link?>">
                            </div>
                        </div>

                        <div class="row-data">
                            <div class="row-key">Số điện thoại</div>
                            <div class="row-value">
                                <input id="raw_phone" type="text" name="raw_phone" value="<?=$raw_phone?>">
                            </div>
                        </div>

                        

                        <div class="row-data">
                            <div class="row-key">
                                    <p>Câu chào</p>
                            </div>
                            <div class="row-value">
                                    <!-- <input id="raw_head" type="text" name="raw_head" value="<?=$raw_head?>"> -->
                                    <textarea id="raw_head" name="raw_head"><?=$raw_head?></textarea>
                            </div>
                        </div>  

                        <div class="row-data">
                            <div class="row-key">
                                <p>Nội dung</p>
                                <p>(*Hệ thống tự điền link sau)</p>
                            </div>
                            <div class="row-value">
                                <textarea id="raw_main" name="raw_main"><?=$raw_main?></textarea>
                            </div>
                        </div> 

                        <div class="row-data">
                            <div class="row-key">
                                <p>Lời chúc</p>
                            </div>
                            <div class="row-value">
                                <input id="raw_foot" type="text" name="raw_foot" value="<?=$raw_foot?>">
                            </div>
                        </div>              
                    </div>
                </div>
            </div>
            <div class="my-half">
                <div id="preview">
                    <h3>Preview tin nhắn sẽ gửi</h3>
                    <div class="preview-content">
                        <div class="row-data">
                            <div class="row-key">
                                <p>Đến:</p>
                            </div>
                            <div class="row-value">
                                <div id="send_phone" >
                                    <p><?=$invoice_customer_phone?></p>
                                </div>
                                
                            </div>
                        </div>

                        <div class="row-data">
                            <div class="row-key">
                                <p>Nội dung:</p>
                            </div>
                            <div class="row-value">
                                <div id="send_content">
                                    <p><?=$i_cus_Name?></p>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore, provident magni natus totam consectetur autem consequuntur porro non nam quasi necessitatibus consequatur rerum odit ipsam quibusdam labore maiores libero excepturi error tenetur saepe dignissimos nesciunt? Fugit deserunt provident delectus. Dolor eaque voluptatibus repudiandae alias eius, quasi vitae iusto deserunt voluptatem!</p>    
                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, magni.</p>
                                </div>                        
                            </div>
                        </div>
                    </div>
                    <div class="">
                        
                        <button class="btn-submit" id="my_btn">Gửi SMS</button>

                        <button class="btn-confirm" id="my_btn_confirm" onclick="confirm()">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>   
    </form> 

<?php?>



<!-- Trường hợp ko có code hoặc code sai -->
<?php } else {  ?>

            <!-- Hiển thị trang nhập code hóa đơn -->
        <div id="missing-code" class="w3-container" style="color:black">    
            <div id="title-2" class="w3-panel">
                
                <a href="http://creta.work/invoice-view-all/"><button class="w3-button left w3-green w3-round">Trang hóa đơn</button></a>
                </br>
                <h1 class="w3-center">Trang gửi sms giao vận</h1>
                </br>
                <h5><?php if($check_code_wrong==true) {echo "Hóa đơn k tồn tại, nhập lại nhé:";}?></h5>  
           
            </div>

            <div class="w3-row">
                <div class="w3-quarter w3-panel">
                    <h2>Nhập code hóa đơn: </h2>       
                </div>
                <div id="form-code" class="w3-panel w3-quarter ">
                    <form method="get">
                        <input type="text" name="code" value="<?php if ($_GET['code']) {echo $_GET['code'];} else {echo "HD";}?>"> 
                </div>
                <div class="w3-quarter w3-panel">  
                    <input type="submit" class="w3-button w3-gray" value="Enter"> 
                                        
                    </form>                  
                </div>
                <div class="w3-quarter">                    
                </div>
            </div>
        </div>

<?php }?>

<script>
    var raw_code = document.getElementById("raw_code");
    var raw_name = document.getElementById("raw_name");
    var raw_phone = document.getElementById("raw_phone");
    var raw_link = document.getElementById("raw_link");
    var raw_head = document.getElementById("raw_head");
    var raw_main = document.getElementById("raw_main");
    var raw_foot = document.getElementById("raw_foot");
    var send_phone = document.getElementById("send_phone");
    var send_content = document.getElementById("send_content");
    var my_form = document.getElementById("my_form");
    var my_btn_confirm = document.getElementById("my_btn_confirm");
    var my_btn = document.getElementById("my_btn");

    
    function updateSend() {
        // my_btn_confirm.style.visibility = "visible";
        // my_btn.style.visibility = "hidden"; 
        my_btn_confirm.style.display = "block";
        my_btn.style.display = "none"; 
        let code = raw_code.value;
        let name = raw_name.value;
        let phone =raw_phone.value;
        let link = raw_link.value;
        let head = raw_head.value;
        let main = raw_main.value;
        let foot = raw_foot.value;

        let se_phone = phone;
        let se_content = '';

        se_content = '<p>';
        se_content += head ;
        se_content += '</p>';
        se_content += '<p>';
        se_content += main + ' *link*' ;
        se_content += '</p>';
        se_content += '<p>';
        se_content += foot ;
        se_content += '</p>';
        send_phone.innerHTML = se_phone;
        send_content.innerHTML = se_content;
    }
    updateSend();
    //setInterval(updateSend,1000);

    raw_phone.addEventListener("input", updateSend);
    raw_link.addEventListener("input", updateSend);
    raw_head.addEventListener("input", updateSend);
    raw_main.addEventListener("input", updateSend);
    raw_foot.addEventListener("input", updateSend);



    function confirm() {
        event.preventDefault();
        // my_btn_confirm.style.visibility = "hidden";
        // my_btn.style.visibility = "visible"; 
        my_btn_confirm.style.display = "none";
        my_btn.style.display = "block"; 
    };

    document.getElementById("my_btn").addEventListener("click", function () {
        my_form.submit();
    });

</script>