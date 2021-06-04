<?php
    include_once 'dev1_DucAnh/Classes/class_creta.php'
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

                                $i_plan_crRealStart =  substr($i_plan_deTime,0,10)." ".$i_plan_crStart;
                                $i_plan_crRealName = substr($i_plan_crName,7);

                                $i_plan_deTime = str_replace('T',' ',$i_plan_deTime);

                    /*-----Tình trạng giao vận của đơn------*/
                        $invoice_log_history = $the_invoice['logHistory'];
                            $invoice_log_number = count($invoice_log_history);
                        
                    /*-----Danh sách sản phẩm của đơn------*/
                        //$invoice_obj = new Cr_Invoice();
                        $invoice_product_list = $invoice_obj->productList($invoice_code);
                            $product_count = count($invoice_product_list);
                /*--End-Lấy thông tin để hiển thị--*/    
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

            <!-- Hiển thị đơn -->        
        <div id="origin" class="w3-container" style="color:black">
            <h1 class="w3-center">Chi tiết đơn hàng <?php echo $invoice_code;?></h1>

            <a href="http://creta.work/invoice-view-all/"><button class="w3-button w3-right w3-<?=$color_status?> w3-round">Trang hóa đơn</button></a>

            <div id="delivery-status" class="w3-container w3-white">        
                <div  class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-<?=$color_status?>" style="border:8px solid" >
                    <div id="title" class="w3-panel">                
                        <h2 class="w3-center">Tình hình đơn hàng</h2>
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
                            <div class="w3-container">
                                    <table class="w3-table w3-bordered w3-card w3-striped">
                                        <thead>
                                            <tr>   
                                                <th colspan='2' class="w3-center w3-<?=$color_status?>">
                                                    <h5>Thông tin hóa đơn</h5>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tr>   
                                            <th>Mã hóa đơn</th>
                                            <td><?=$invoice_code;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Code hóa đơn gửi KH</th>
                                            <td><?=$invoice_hidden_code;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Giá trị đơn</th>
                                            <td><?=$invoice_total;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Thời điểm lên đơn</th>
                                            <td><?=$timestamp;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Nhân viên lên đơn</th>
                                            <td><?=$invoice_sale;?></td>
                                        </tr>
                                        <tr>   
                                            <th>Thời gian hàng đi khỏi CRETA thực tế</th>
                                            <td><a class="w3-green"><?=$invoice_delivery_real_time?></a></td>
                                        </tr>
                                        <tr>   
                                            <th>Ghi chú giao</th>
                                            <td><?=$invoice_customer_note;?></td>
                                        </tr>                                        
                                    </table>
                            </div>
                             
                        </div>
                    </div> 
                </div>       
            </div>

            <div id="product-list" class="w3-panel w3-white">        
                    <div  class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-<?=$color_status?>" style="border:6px solid" >
                        <div id="title" class="w3-panel">                
                            <h2 class="w3-center"><strong>Danh sách sản phẩm</strong></h2>
                        </div>

                        <div id="product-table">
                            <div>
                                <table class='w3-table-all w3-striped w3-card w3-border-all'>
                                    <thead>
                                        <tr class='w3-theme-l2'>
                                            <th>STT</th>
                                            <th>Mã</th>
                                            <th>Sản phẩm</th>
                                            <th>SL</th>
                                            <!-- <th>Đơn giá</th>
                                            <th>Thành tiền</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for ($i=0; $i<$product_count;$i++) {
                                                $stt = $i+1;
                                                echo '<tr>';
                                                echo '<td>'.$stt.'</td>';
                                                echo '<td>'.$invoice_product_list[$i]['code'].'</td>';
                                                echo '<td>'.$invoice_product_list[$i]['name'].'</td>';
                                                echo '<td>'.$invoice_product_list[$i]['quantity'].'</td>';
                                                //echo '<td>'.$invoice_product_list[$i]['price'].'</td>';
                                            // echo '<td>'.$invoice_product_list[$i]['subtotal'].'</td>';
                                                echo '</tr>';
                                            }
                                        ?>
                                    </tbody>        
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
                            <h2 class="w3-center">Thông tin giao vận</h2>
                            </div>
                            <div class="w3-panel">
                                <table class="w3-table w3-striped w3-hoverable w3-border w3-card">
                                    <tr>   
                                        <th>Chành xe</th>
                                        <td><?=$i_plan_crRealName;?></td>
                                    </tr>
                                    <tr>   
                                        <th>Mã Chành xe</th>
                                        <td><?=$i_plan_crCode;?></td>
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
                                        <th>Địa chỉ chành</th>
                                        <td><?=$i_plan_crAddress;?></td>
                                    </tr> 
                                    <tr>   
                                        <th>Địa chỉ đến của chành</th>
                                        <td><?=$i_plan_crArrive;?></td>
                                    </tr>
                                    <tr>   
                                        <th>Thời gian di chuyển dự kiến</th>
                                        <td><?=$i_plan_crPeriod;?></td>
                                    </tr>
                                    <tr>   
                                        <th>Thời gian xuất phát của nhân viên GV</th>
                                        <td><?=$i_plan_deTime;?></td>
                                    </tr>
                                    <tr>   
                                        <th>Kho lấy hàng</th>
                                        <td><?=$i_plan_deStorage;?></td>
                                    </tr>
                                    <tr>   
                                        <th>Ghi chú riêng</th>
                                        <td><?=$i_plan_crOwnNote;?></td>
                                    </tr>
                                    <tr>   
                                        <th>Ghi chú của nhà xe</th>
                                        <td><?=$i_plan_crNote;?></td>
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
                                            <th>Mã khách hàng</th>
                                            <td><?=$invoice_customer_code;?></td>
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
                        
                        <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:5px solid ">                
                            <div class="w3-panel">
                                <h2 class="w3-center">Lịch sử thay đổi đơn hàng</h2>
                            </div>
                            <div class="w3-panel">
                                <table class="w3-table w3-striped w3-hoverable w3-border w3-card">
                                    <thead>
                                    <tr>
                                        <th class="w3-center">Thời điểm</th>                                        
                                        <th class="w3-center">Chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        for ($cnt = 0; $cnt < $invoice_log_number; $cnt++){
                                            switch ($invoice_log_history[$cnt]['dangerousLevel']){
                                                case 'Normal':
                                                    $color_log = "green";
                                                    break;
                                                case 'Warning':
                                                    $color_log = "yellow";
                                                    break;
                                                case 'Error':
                                                    $color_log = "red";
                                                    break;
                                                default:                                                        
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$invoice_log_history[$cnt]['datetime']?></td>
                                            <td><a class="w3-<?=$color_log; ?>"><?=$invoice_log_history[$cnt]['description']?></a></td>                                 
                                        </tr>
                                        <?php
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>               
                    </div>
                </div>       
            </div>

            
        </div>

<?php?>



<!-- Trường hợp ko có code hoặc code sai -->
<?php } else {  ?>

            <!-- Hiển thị trang nhập code hóa đơn -->
        <div id="missing-code" class="w3-container" style="color:black">    
            <div id="title-2" class="w3-panel">
                
                <a href="http://creta.work/invoice-view-all/"><button class="w3-button left w3-green w3-round">Trang hóa đơn</button></a>
                </br>
                <h1 class="w3-center">Chi tiết hóa đơn</h1>
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