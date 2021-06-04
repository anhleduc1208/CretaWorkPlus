<!-- Lấy thông tin back end -->
<?php
    $check_code_wrong= false;
    if ($_GET['code']) {       
        $my_query_args = array(
            'post_type' => 'cr_invoice',
            'meta_query' => array(
                array(
                    'key' => 'code',
                    'value' => $_GET['code'],
                    'compare' => '='
                )
            )            
        );
        $invoice_query = new WP_Query($my_query_args);
        if ($invoice_query->have_posts()){
            $check_code_wrong = false;
            while ($invoice_query->have_posts()){
                $invoice_query->the_post();
                $invoice_id = get_the_ID();
                $invoice_title = get_the_title();
                /*--Start-Lấy thông tin để hiển thị--*/
                    /*-----Mã hóa đơn------*/
                        $invoice_code = get_post_meta($invoice_id,'code',true);                 
                    
                    /*-----Ngày lên đơn------*/
                        $invoice_purchase_date = get_post_meta($invoice_id,'purchaseDate',true);

                    /*-----Thời điểm hàng đi------*/
                        $invoice_delivery_real_time = get_post_meta($invoice_id,'deliveryRealTime',true);

                    /*-----Tình trạng giao vận của đơn------*/
                        $invoice_delivery_status = get_post_meta($invoice_id,'deliveryStatus',true);
                            $invoice_delivery_status_VN = "";
                            $color_status = "red";
                            $link_pic = "";
                            $css_url="";
                            switch ($invoice_delivery_status) {
                                case "CHO_LEN_KE_HOACH":
                                    $color_status = "red";
                                    $invoice_delivery_status_VN = "Chờ lên kế hoạch";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/plan.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-red.css">';
                                    break;
                                case "DANG_DONG_HANG":
                                    $color_status = "yellow";
                                    $invoice_delivery_status_VN = "Đang đóng hàng";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/wrap-package.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-yellow.css">';
                                    break;
                                case "CHO_GIAO_HANG":
                                    $color_status = "teal";
                                    $invoice_delivery_status_VN = "Chờ giao hàng";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/delivery.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-teal.css">';
                                    break;
                                case "DA_GIAO_VAN":
                                    $color_status = "purple";
                                    $invoice_delivery_status_VN = "Đã giao vận";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/confirm-1.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-purple.css">';
                                    break;
                                case "HOAN_THANH":
                                    $color_status = "green";
                                    $invoice_delivery_status_VN = "Hoàn thành";
                                    $link_pic = "http://creta.work/wp-content/uploads/2021/05/check.png";
                                    $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-green.css">';
                                    break;
                                default:
                            }       
                    
                
                    /*-----Nội dung của hóa đơn từ kiotviet------*/
                        $invoice_content_str = get_post_meta($invoice_id,'contentInvoice',true);    
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
                        $invoice_customer_code = get_post_meta($invoice_id,'customerCode',true);
                    /*-----Thông tin về khách hàng của đơn------*/
                        $invoice_customerInfo1 = get_post_meta($invoice_id,'customerInfo',true); 
                            $invoice_customerInfo =  $invoice_customerInfo1[0];
                                $i_cus_Name = $invoice_customerInfo['customerName'];   
                                $i_cus_Address = $invoice_customerInfo['customerAddress'];
                        
                    /*-----Thông tin về kế hoạch giao vận của đơn------*/
                        $invoice_planinfo1 = get_post_meta($invoice_id,'planInfo',true); 
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

                                $i_plan_crRealStart =  $i_plan_crStart." ngày ".substr($i_plan_deTime,0,10);
                                $i_plan_crRealName = substr($i_plan_crName,7);
                /*--End-Lấy thông tin để hiển thị--*/    
            }
        }   else {
            $check_code_wrong = true;
        }  
        wp_reset_postdata();   
    }
?>

<!-- Trường hợp đúng link và code đúng -->
<?php if (($_GET['code'])&&($check_code_wrong==false)) {
    echo  $css_url;
    ?>

            <!-- Hiển thị đơn -->
        
        <div id="origin" class="w3-container" style="color:black">
            <h1 class="w3-center">Kế hoạch giao vận đơn hàng <?php echo $invoice_code;?></h1>

            <a href="http://creta.work/invoice-view-all/"><button class="w3-button w3-right w3-<?=$color_status?> w3-round">Trang hóa đơn</button></a>

            <div id="delivery-status" class="w3-container w3-white">        
                <div  class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-<?=$color_status?>" style="border:8px solid" >
                    <div id="title" class="w3-panel">                
                        <h2 class="w3-center">Tình hình đơn hàng <?=$invoice_code;?></h2>
                    </div>

                    <div id="content" class="w3-row">
                        <div class="w3-third w3-container">
                            <div class="w3-panel w3-theme-l5 w3-border w3-hover-border-<?=$color_status?> w3-round-xlarge" >
                                
                                <div class="w3-panel w3-theme-l5 ">                                    
                                    <img src="<?=$link_pic?>">                                    
                                </div>
                                <div class="w3-panel">
                                    <h4 class="w3-center"><?= $invoice_delivery_status_VN;?></h4>
                                </div>
                            </div> 
                        </div>

                        <div class="w3-twothird w3-panel">
                         
                                    <table class="w3-table w3-bordered w3-card w3-striped">
                                        <thead>
                                            <tr>   
                                                <th colspan='2' class="w3-center w3-<?=$color_status?>">Thông tin giao vận</th>
                                            </tr>
                                        </thead>
                                        <tr>   
                                            <th>Khách hàng</th>
                                            <td><?=$invoice_customer_name;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Số điện thoại</th>
                                            <td><?=$invoice_customer_phone;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Chành xe</th>
                                            <td><?=$i_plan_crRealName;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Số điện thoại chành xe</th>
                                            <td><?=$i_plan_crPhone;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Giờ xe xuất phát</th>
                                            <td><?=$i_plan_crRealStart;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Thời điểm hàng rời khỏi kho CRETA</th>
                                            <td><a class="w3-green"><?=$invoice_delivery_real_time;?></a></td>
                                        </tr>
                                        <tr>   
                                            <th>Địa chỉ chành</th>
                                            <td><?=$i_plan_crAddress;?></td>
                                        </tr> 
                                        <tr>   
                                            <th>Lưu ý của khách với chành</th>
                                            <td><?=$i_plan_crNote;?></td>
                                        </tr>
                                       
                                    </table>
                             
                        </div>
                    </div> 
                </div>       
            </div>

            <div id="invoice-info" class="w3-container w3-white">
                <div class="w3-row">
                    <div class="w3-half w3-panel">
                        <div  class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:5px solid">
                            <div class="w3-panel">
                            <h2 class="w3-center">Thông tin hóa đơn</h2>
                            </div>
                            <div class="w3-panel">
                                <table class="w3-table w3-striped w3-hoverable w3-border w3-card">
                                        <tr>   
                                            <th>Mã hóa đơn</th>
                                            <td><?=$invoice_code;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Giá trị đơn</th>
                                            <td><?=$invoice_total;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Thời điểm lên đơn</th>
                                            <td ><?=$timestamp;?></td>
                                        </tr>
                                        
                                        <tr>   
                                            <th>Phương thức thanh toán</th>
                                            <td></td>
                                        </tr>
                                        <tr>   
                                            <th>Lưu ý cho hóa đơn</th>
                                            <td><?=$invoice_customer_note;?></td>
                                        </tr>
                                </table>
                            </div>
                        </div>                
                    </div>
                    <div class="w3-half w3-panel">
                        <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:5px solid ">                
                            <div class="w3-panel">
                                <h2 class="w3-center">Thông tin khách hàng</h2>
                            </div>
                            <div class="w3-panel">
                                <table class="w3-table w3-striped w3-hoverable w3-border w3-card">
                                        <tr>   
                                            <th>Tên khách hàng</th>
                                            <td><?=$i_cus_Name;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Địa chỉ khách hàng</th>
                                            <td><?=$i_cus_Address;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Số diện thoại</th>
                                            <td><?=$invoice_customer_phone;?></td>
                                        </tr>
                                        
                                </table>
                            </div>
                        </div>                
                    </div>
                </div>       
            </div>

            
        </div>

<!-- Trường hợp ko có code hoặc code sai -->
<?php } else {  ?>

            <!-- Hiển thị trang nhập code hóa đơn -->
        <div id="missing-code" class="w3-container" style="color:black">    
            <div id="title-2" class="w3-panel">
                
                <a href="http://creta.work/invoice-view-all/"><button class="w3-button left w3-green w3-round">Trang hóa đơn</button></a>
                </br>
                <h1 class="w3-center">Kế hoạch giao vận hóa đơn</h1>
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
                    <input type="submit" class="w3-button w3-teal" value="Enter"> 
                                        
                    </form>                  
                </div>
                <div class="w3-quarter">                    
                </div>
            </div>
        </div>

<?php }?>