<?php
    include_once 'dev1_DucAnh/Classes/class_creta.php';   
?>
<style>
    <?php include 'css_tracking_delivery/style.css';?>
</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href='https://use.fontawesome.com/releases/v5.7.2/css/all.css'>
<!-- Lấy thông tin back end -->
<?php
    $check_code_wrong= false;
    if ($_GET['code']) {    
        $get_code = $_GET['code'];   
        $count = strlen($get_code);
        
        $invoice_obj = new Cr_Invoice();
        
        if ($count == 8 || $count==11) {
            $the_invoice_raw = $invoice_obj->getDataByCode($get_code);
            $this_code_hidden = $the_invoice_raw['hiddenCode'];
            if ($this_code_hidden) {
                //do nothing
            } else {
                $the_invoice = $invoice_obj->getDataByCode($get_code);
            }
        } else  {
            $the_invoice = $invoice_obj->getDataByHiddenCode($get_code);
        }
        
            if ($the_invoice) {                                
                $invoice_id =  $the_invoice['id'];
                $invoice_title =  $the_invoice['title'];
                /*--Start-Lấy thông tin để hiển thị--*/
                    /*-----Mã hóa đơn------*/
                        $invoice_code =   $the_invoice['code']; 
                        
                    /*-----Mã hóa đơn------*/
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
                                    $real_name = '';
                                    $start = substr($i_cus_Name,0,3);
                                    if (($start=="anh") || ($start=="Anh")) {
                                        $real_name = substr($i_cus_Name,3);
                                    } else {
                                        $real_name = $i_cus_Name;
                                    }
                                    //echo $real_name;
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

                    /*-----Lịch sử mua hàng của khách hàng------*/
                        //$invoice_obj = new Cr_Invoice();
                        $invoice_recent_invs = $invoice_obj->findRecentInvoices($invoice_code,5);
                            $invs_count = count($invoice_recent_invs);


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
        <div class='w3-container w3-white w3-responsive'> 
            <!-- Màn hình bự -->
            <div id="origin" class="w3-panel w3-white  w3-hide-small w3-hide-medium" style="color:black">
                <div class='w3-container'>
                    <a class="w3-right"><p>Xin chào, anh <?=$real_name?>!!!</p></a>                
                </div>
                
                
                <div class='w3-row'>
                    <div class='w3-panel w3-quarter'>
                        <div class='w3-panel w3-center'>
                            <img src="http://creta.work/wp-content/uploads/2021/05/logowp.png">
                        </div>
                    </div>
                    <div class='w3-panel w3-threequarter'>
                        <h1 class="w3-center"><strong>Chi tiết đơn hàng <?php echo $invoice_code;?></strong></h1>
                        <br>
                        <h6 class="w3-center"><i>"CRETA biết anh/chị có nhiều sự lựa chọn</i></h6>
                        <h6 class="w3-center"><i>Xin cảm ơn vì đã chọn chúng tôi hôm nay"</i></h6>
                    </div>                
                        
                </div>
                        <a href="https://creta.vn/"><button class="w3-button w3-right w3-<?=$color_status?> w3-round">Creta.vn</button></a>

                <div id="delivery-status" class="w3-container w3-white">        
                    <div  class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-<?=$color_status?>" style="border:8px solid" >
                        <div id="title" class="w3-container">                
                            <h2 class="w3-center"><strong>Tình hình giao vận</strong></h2>
                            
                        </div>

                        <div id="tracking-bar">            
                            <div class="container">
                                <!-- <article class="card"> -->
                                    <!-- <header class="card-header"><strong><a> Theo dõi giao vận</a></strong> </header> -->
                                    <!-- <div class="card-body"> -->
                                        <!-- <h6>Mã hóa đơn: <?=$invoice_code?></h6> -->
                                        
                                        <div class="track">
                                            <div class="step <?php if ($code_status>=1) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-file-invoice"></i> </span> <span class="text">Kho đã xác nhận</span> </div>
                                            <div class="step <?php if ($code_status>=2) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text"> Đã đóng hàng</span> </div>
                                            <div class="step <?php if ($code_status>=3) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Hàng đã giao cho bên vận chuyển </span> </div>
                                            <div class="step <?php if ($code_status>=4) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Khách đã nhận hàng</span> </div>
                                        </div>
                                        </br>
                                        </br>

                                        <article class="card">
                                            <div class="card-body row">
                                                <div class="col"> <strong>Thời gian dự kiến nhà xe chạy:</strong> <br> <?=$i_plan_crRealStart ?> </div>
                                                <div class="col"> <strong>Thời gian dự kiến gửi hàng cho nhà xe:</strong> <br><?=$i_plan_deTime?> </div>
                                                <div class="col"> <strong>Nhà xe nhận:</strong> <br> <?=$i_plan_crRealName?> <br> <i class="fa fa-phone"></i> <?=$i_plan_crPhone?> </div>
                                                
                                            
                                                
                                            </div>
                                        </article>

                                        <!-- <hr>
                                        <ul class="row">
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/iDwDQ4o.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">Dell Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$950 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/tVBy5Q0.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">HP Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$850 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/Bd56jKH.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">ACER Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$650 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                        </ul>
                                        <hr> <a href="#" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a> -->
                                    
                                    <!-- </div> -->
                                <!-- </article> -->
                            
                            
                            </br>
                            </div>
                
                        </div> 
                    </div>       
                </div>


                

                <div id="log-and-product" class="w3-container w3-white">
                    <div class="w3-row">
                        <div class="w3-half w3-panel">

                            <div id="product-list" class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-<?=$color_status?>" style="border:6px solid" >
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

                        <div class="w3-half w3-panel">
                            <div id='log-history' class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:5px solid ">                
                                <div class="w3-panel">
                                    <h2 class="w3-center"><strong>Lịch sử thay đổi đơn hàng</strong></h2>
                                </div>
                                <div >
                                    <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                        <thead>
                                        <tr class='w3-theme-l2'>
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

                <div id="invoice-info" class="w3-container w3-white">
                    <div class="w3-row">
                        <div class="w3-half w3-panel">

                            <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:6px solid ">                
                                    <div class="w3-panel">
                                        <h2 class="w3-center"><strong>Thông tin khách hàng</strong></h2>
                                    </div>
                                    <div >
                                        <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                                <tr>   
                                                    <th class='w3-theme-l2'>Tên </th>
                                                    <td><?=$i_cus_Name;?></td>
                                                </tr>
                                                <tr>   
                                                    <th class='w3-theme-l2'>Địa chỉ </th>
                                                    <td><?=$i_cus_Address;?></td>
                                                </tr>
                                                <tr>   
                                                    <th class='w3-theme-l2'>SĐT</th>
                                                    <td><?=$invoice_customer_phone;?></td>
                                                </tr>
                                                
                                        </table>
                                    </div>
                                </div>             
                            </div>

                        <div class="w3-half w3-panel">                    
                            
                            <div id="history-invoices" class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:6px solid ">                
                                <div class="w3-panel">
                                    <h2 class="w3-center"><strong>Lịch sử mua hàng gần đây</strong></h2>
                                </div>
                                <div >
                                    <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                        <thead>
                                        <tr class='w3-theme-l2'>
                                            <th>Thời điểm</th>                                        
                                            <th>Mã hóa đơn</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            for ($cnt_ins = 0; $cnt_ins < $invs_count; $cnt_ins++){
                                                
                                            ?>
                                            <tr>
                                                <td><?=$invoice_recent_invs[$cnt_ins]['purchaseDate']?></td>
                                                <td><?=$invoice_recent_invs[$cnt_ins]['invCode']?></td>
                                                <td>
                                                    <?php
                                                        if ($invoice_recent_invs[$cnt_ins]['invCode'] == $invoice_code) {
                                                            //do nothing
                                                        } else {
                                                            if ($invoice_recent_invs[$cnt_ins]['invHiddenCode']) {
                                                                $url = "http://creta.work/thong-tin-don-hang/?code=".$invoice_recent_invs[$cnt_ins]['invHiddenCode'];
                                                            } else {
                                                                $url = "http://creta.work/thong-tin-don-hang/?code=".$invoice_recent_invs[$cnt_ins]['invCode'];
                                                            }
                                                            
                                                            $txt = "<a href='".$url."'><button class='w3-button w3-theme-l2 w3-round-xlarge'>Chi tiết</button></a>";
                                                            echo $txt; 
                                                        }
                                                    ?>
                                                </td>                                 
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

            <!-- Màn hình vừa -->
            <div id="origin" class="w3-panel w3-white  w3-hide-small w3-hide-large" style="color:black">
                <div class='w3-container'>
                    <a class="w3-right"><p>Xin chào, anh <?=$real_name?>!!!</p></a>                
                </div>
                <div class='w3-row'>
                    <div class='w3-panel w3-quarter'>
                        <div class='w3-panel w3-center'>
                            <img src="http://creta.work/wp-content/uploads/2021/05/logowp.png">
                        </div>
                    </div>
                    <div class='w3-panel w3-threequarter'>
                        <h1 class="w3-center"><strong>Chi tiết đơn hàng <?php echo $invoice_code;?></strong></h1>
                        <br>
                        <h6 class="w3-center"><i>"CRETA biết anh/chị có nhiều sự lựa chọn</i></h6>
                        <h6 class="w3-center"><i>Xin cảm ơn vì đã chọn chúng tôi hôm nay"</i></h6>
                    </div>
                        
                        
                </div>
                        <a href="https://creta.vn/"><button class="w3-button w3-right w3-<?=$color_status?> w3-round">Creta.vn</button></a>

                <div id="delivery-status" class="w3-container w3-white">        
                    <div  class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-<?=$color_status?>" style="border:8px solid" >
                        <div id="title" class="w3-container">                
                            <h2 class="w3-center"><strong>Tình hình giao vận</strong></h2>
                            
                        </div>

                        <div id="tracking-bar">            
                            <div class="container">
                                <!-- <article class="card"> -->
                                    <!-- <header class="card-header"><strong><a> Theo dõi giao vận</a></strong> </header> -->
                                    <!-- <div class="card-body"> -->
                                        <!-- <h6>Mã hóa đơn: <?=$invoice_code?></h6> -->
                                        
                                        <div class="track">
                                            <div class="step <?php if ($code_status>=1) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-file-invoice"></i> </span> <span class="text">Kho đã xác nhận</span> </div>
                                            <div class="step <?php if ($code_status>=2) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text"> Đã đóng hàng</span> </div>
                                            <div class="step <?php if ($code_status>=3) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Hàng đã giao cho bên vận chuyển </span> </div>
                                            <div class="step <?php if ($code_status>=4) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Khách đã nhận hàng</span> </div>
                                        </div>
                                        </br>
                                        </br>

                                        <article class="card">
                                            <div class="card-body row">
                                                <div class="col"> <strong>Thời gian dự kiến nhà xe chạy:</strong> <br> <?=$i_plan_crRealStart ?> </div>
                                                <div class="col"> <strong>Thời gian dự kiến gửi hàng cho nhà xe:</strong> <br><?=$i_plan_deTime?> </div>
                                                <div class="col"> <strong>Nhà xe nhận:</strong> <br> <?=$i_plan_crRealName?> <br> <i class="fa fa-phone"></i> <?=$i_plan_crPhone?> </div>
                                                
                                            
                                                
                                            </div>
                                        </article>

                                        <!-- <hr>
                                        <ul class="row">
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/iDwDQ4o.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">Dell Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$950 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/tVBy5Q0.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">HP Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$850 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/Bd56jKH.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">ACER Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$650 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                        </ul>
                                        <hr> <a href="#" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a> -->
                                    
                                    <!-- </div> -->
                                <!-- </article> -->
                            
                            
                            </br>
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

                <div id="history-invoices" class='w3-panel'>
                    <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:6px solid ">                
                        
                        <div class="w3-panel">
                            <h2 class="w3-center"><strong>Lịch sử mua hàng gần đây</strong></h2>
                        </div>
                        <div >
                            <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                <thead>
                                <tr class='w3-theme-l2'>
                                    <th>Thời điểm</th>                                        
                                    <th>Mã hóa đơn</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    for ($cnt_ins = 0; $cnt_ins < $invs_count; $cnt_ins++){
                                        
                                    ?>
                                    <tr>
                                        <td><?=$invoice_recent_invs[$cnt_ins]['purchaseDate']?></td>
                                        <td><?=$invoice_recent_invs[$cnt_ins]['invCode']?></td>
                                        <td>
                                            <?php
                                                if ($invoice_recent_invs[$cnt_ins]['invCode'] == $invoice_code) {
                                                    //do nothing
                                                } else {
                                                    if ($invoice_recent_invs[$cnt_ins]['invHiddenCode']) {
                                                        $url = "http://creta.work/thong-tin-don-hang/?code=".$invoice_recent_invs[$cnt_ins]['invHiddenCode'];
                                                    } else {
                                                        $url = "http://creta.work/thong-tin-don-hang/?code=".$invoice_recent_invs[$cnt_ins]['invCode'];
                                                    }
                                                    
                                                    $txt = "<a href='".$url."'><button class='w3-button w3-theme-l2 w3-round-xlarge'>Chi tiết</button></a>";
                                                    echo $txt; 
                                                }
                                            ?>
                                        </td>                                 
                                    </tr>
                                    <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                <div id="invoice-info" class="w3-container w3-white">
                    <div>
                        <div id="customer-info">

                            <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:6px solid ">                
                                    <div class="w3-panel">
                                        <h2 class="w3-center"><strong>Thông tin khách hàng</strong></h2>
                                    </div>
                                    <div >
                                        <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                                <tr>   
                                                    <th class='w3-theme-l2'>Tên </th>
                                                    <td><?=$i_cus_Name;?></td>
                                                </tr>
                                                <tr>   
                                                    <th class='w3-theme-l2'>Địa chỉ </th>
                                                    <td><?=$i_cus_Address;?></td>
                                                </tr>
                                                <tr>   
                                                    <th class='w3-theme-l2'>SĐT</th>
                                                    <td><?=$invoice_customer_phone;?></td>
                                                </tr>
                                                
                                        </table>
                                    </div>
                                </div>             
                            </div>

                        <div id = "history-log">                    
                            
                            <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:6px solid ">                
                                <div class="w3-panel">
                                    <h2 class="w3-center"><strong>Lịch sử thay đổi đơn hàng</strong></h2>
                                </div>
                                <div >
                                    <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                        <thead>
                                        <tr class='w3-theme-l2'>
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

            <!-- Màn hình nhỏ -->
            <div id="origin" class="w3-panel w3-white  w3-hide-large w3-hide-medium" style="color:black">
                <div class='w3-container'>
                    <a class="w3-right"><p>Xin chào, anh <?=$real_name?>!!!</p></a>                
                </div>
                <div class='w3-row'>
                    <div class='w3-panel w3-quarter'>
                        <div class='w3-panel w3-center'>
                            <img src="http://creta.work/wp-content/uploads/2021/05/logowp.png">
                        </div>
                    </div>
                    <div class='w3-panel w3-threequarter'>
                        <h1 class="w3-center"><strong>Chi tiết đơn hàng <?php echo $invoice_code;?></strong></h1>
                        <br>
                        <h6 class="w3-center"><i>"CRETA biết anh/chị có nhiều sự lựa chọn</i></h6>
                        <h6 class="w3-center"><i>Xin cảm ơn vì đã chọn chúng tôi hôm nay"</i></h6>
                    </div>
                        
                        
                </div>
                        <a href="https://creta.vn/"><button class="w3-button w3-right w3-<?=$color_status?> w3-round">Creta.vn</button></a>

                <div id="delivery-status" class="w3-container w3-white">        
                    <div  class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-<?=$color_status?>" style="border:8px solid" >
                        <div id="title" class="w3-container">                
                            <h2 class="w3-center"><strong>Tình hình giao vận</strong></h2>
                            
                        </div>

                        <div id="tracking-bar">            
                            <div class="container">
                                <!-- <article class="card"> -->
                                    <!-- <header class="card-header"><strong><a> Theo dõi giao vận</a></strong> </header> -->
                                    <!-- <div class="card-body"> -->
                                        <!-- <h6>Mã hóa đơn: <?=$invoice_code?></h6> -->
                                        
                                        <div class="track">
                                            <div class="step <?php if ($code_status>=1) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-file-invoice"></i> </span> <span class="text">Đã nhận</span> </div>
                                            <div class="step <?php if ($code_status>=2) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text"> Đã đóng hàng</span> </div>
                                            <div class="step <?php if ($code_status>=3) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Đang chuyển </span> </div>
                                            <div class="step <?php if ($code_status>=4) {echo 'active';}?>"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Đã tới khách</span> </div>
                                        </div>
                                        </br>
                                        </br>

                                        
                                            <div class="row">
                                                <strong>- Thời gian dự kiến nhà xe chạy:</strong> </br><?=$i_plan_crRealStart?> 
                                            </div>
                                            </br>
                                            <div class="row"> 
                                                <strong>- Thời gian dự kiến gửi hàng cho nhà xe:</strong> </br><?=$i_plan_deTime?> 
                                            </div>
                                            </br>   
                                            <div class="row"> 
                                                <strong>- Nhà xe nhận:</strong> 
                                                </br> 
                                                <?=$i_plan_crRealName?>   |
                                                
                                                <?=$i_plan_crPhone?> 
                                            </div>
                                                
                                            
                                                
                                            
                                        

                                        <!-- <hr>
                                        <ul class="row">
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/iDwDQ4o.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">Dell Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$950 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/tVBy5Q0.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">HP Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$850 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                            <li class="col-md-4">
                                                <figure class="itemside mb-3">
                                                    <div class="aside"><img src="https://i.imgur.com/Bd56jKH.png" class="img-sm border"></div>
                                                    <figcaption class="info align-self-center">
                                                        <p class="title">ACER Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$650 </span>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                        </ul>
                                        <hr> <a href="#" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a> -->
                                    
                                    <!-- </div> -->
                                <!-- </article> -->
                            
                            
                            </br>
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

                <div id="history-invoices" class='w3-panel'>
                    <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:6px solid ">                
                        
                        <div class="w3-panel">
                            <h2 class="w3-center"><strong>Lịch sử mua hàng gần đây</strong></h2>
                        </div>
                        <div >
                            <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                <thead>
                                <tr class='w3-theme-l2'>
                                    <th>Thời điểm</th>                                        
                                    <th>Mã hóa đơn</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    for ($cnt_ins = 0; $cnt_ins < $invs_count; $cnt_ins++){
                                        
                                    ?>
                                    <tr>
                                        <td><?=$invoice_recent_invs[$cnt_ins]['purchaseDate']?></td>
                                        <td><?=$invoice_recent_invs[$cnt_ins]['invCode']?></td>
                                        <td>
                                            <?php
                                                if ($invoice_recent_invs[$cnt_ins]['invCode'] == $invoice_code) {
                                                    //do nothing
                                                } else {
                                                    if ($invoice_recent_invs[$cnt_ins]['invHiddenCode']) {
                                                        $url = "http://creta.work/thong-tin-don-hang/?code=".$invoice_recent_invs[$cnt_ins]['invHiddenCode'];
                                                    } else {
                                                        $url = "http://creta.work/thong-tin-don-hang/?code=".$invoice_recent_invs[$cnt_ins]['invCode'];
                                                    }
                                                    
                                                    $txt = "<a href='".$url."'><button class='w3-button w3-theme-l2 w3-round-xlarge'>Chi tiết</button></a>";
                                                    echo $txt; 
                                                }
                                            ?>
                                        </td>                                 
                                    </tr>
                                    <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div id="invoice-info" class="w3-panel w3-white">
                    <div>
                        <div id="customer-info">

                            <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:6px solid ">                
                                    <div class="w3-panel">
                                        <h2 class="w3-center"><strong>Thông tin khách hàng</strong></h2>
                                    </div>
                                    <div >
                                        <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                                <tr>   
                                                    <th class='w3-theme-l2'>Tên </th>
                                                    <td><?=$i_cus_Name;?></td>
                                                </tr>
                                                <tr>   
                                                    <th class='w3-theme-l2'>Đ/c </th>
                                                    <td><?=$i_cus_Address;?></td>
                                                </tr>
                                                <tr>   
                                                    <th class='w3-theme-l2'>SĐT</th>
                                                    <td><?=$invoice_customer_phone;?></td>
                                                </tr>
                                                
                                        </table>
                                    </div>
                                </div>             
                            </div>

                        <div id="history-log">                    
                            
                            <div class="w3-panel w3-round-xlarge w3-theme-l5 w3-border-theme" style="border:6px solid ">                
                                <div class="w3-panel">
                                    <h2 class="w3-center"><strong>Lịch sử thay đổi đơn hàng</strong></h2>
                                </div>
                                <div >
                                    <table class="w3-table-all w3-striped w3-hoverable w3-border w3-card">
                                        <thead>
                                        <tr class='w3-theme-l2'>
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

        </div>

<?php?>



<!-- Trường hợp ko có code hoặc code sai -->
<?php } else {  ?>

            <!-- Hiển thị trang nhập code hóa đơn -->
        <div id="missing-code" class="w3-container" style="color:black">    
            <div id="title-2" class="w3-panel">
                
                <a href="https://creta.vn"><button class="w3-button left w3-green w3-round">Creta.vn</button></a>
                </br>
                <h1 class="w3-center">Thông tin hóa đơn</h1>
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