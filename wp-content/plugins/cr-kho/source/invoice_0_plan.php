<?php
    include_once 'dev1_DucAnh/Classes/class_creta.php'
?>
<div class="w3-container w3-responsive" style="color:black">
<a href="http://creta.work/invoice-view-all/"><button class="w3-button w3-left w3-teal w3-round-xlarge">Trang hóa đơn</button></a>
</br>
<?php 
    /* 
    Xử lý update thông tin cho nhà xe
    */    
    //include_once("dev1/post_carrier.php");
    if ($_POST){                      
        $update_carrier_name = $_POST['carrierName'];
        $update_carrier_code = $_POST['carrierCode'];
        $update_carrier_address = $_POST['carrierAddress'];
        $update_carrier_address_arrive = $_POST['carrierArrive'];
        $update_carrier_period = $_POST['carrierPeriod'];
        $update_carrier_phone = $_POST['carrierPhone'];
        $update_carrier_start = $_POST['carrierStart'];
        $update_carrier_own_note = $_POST['carrierOwnNote'];
        $update_carrier_note = $_POST['carrierNote'];
        $update_delivery_time = $_POST['deliveryTime'];
        $update_delivery_storage = $_POST['deliveryStorage'];
        $update_delivery_status = $_POST['deliveryStatus'];
        $old_delivery_status = $_POST['oldDeliveryStatus'];
      
        // for ($x = 0; $x < $cnt_post_key; $x++){
        //     $str = 'start'.$x;            
        //     array_push($update_start, $_POST[$str]);
        // }
        
        $update_planinfo_data = array(
            0 => array (
                'carrierName' => $update_carrier_name,
                'carrierCode' => $update_carrier_code,
                'carrierAddress' => $update_carrier_address,
                'carrierArrive' => $update_carrier_address_arrive,
                'carrierPeriod' => $update_carrier_period,
                'carrierStart' => $update_carrier_start,
                'carrierOwnNote' => $update_carrier_own_note,
                'carrierPhone' => $update_carrier_phone,
                'carrierNote' => $update_carrier_note,
                'deliveryTime' => $update_delivery_time,
                'deliveryStorage' => $update_delivery_storage
                )
        );
       
        if ($_GET['code']) {
            $update_query_args = array(
                'post_type' => 'cr_invoice',
                'meta_query' => array(
                    array(
                        'key' => 'code',
                        'value' => $_GET['code'],
                        'compare' => '='
                    )
                )            
            );
            $update_query = new WP_Query($update_query_args);
            if ($update_query->have_posts()){
                while ($update_query->have_posts()){
                        $update_query->the_post();
                        $update_id = get_the_ID();

                        update_post_meta($update_id,'planInfo',$update_planinfo_data);   
                        update_post_meta($update_id,'deliveryStatus',$update_delivery_status); 
                        // $my_update_carrier = array(
                        //     'ID' => $update_id,
                        //     'post_title' => $update_title
                        // );
                        //wp_update_post($my_update_carrier); 
                        echo '<h2>Update thành công</h2>';
                        echo '</br>';
                }
            }
            wp_reset_postdata();

            $invoice_obj = new Cr_Invoice();
            if ($old_delivery_status == 'CHO_LEN_KE_HOACH') {
                $invoice_obj->logNormal($_GET['code'],'Hóa đơn vừa được lên kế hoạch, chuyển sang pha đóng gói');
            } else {
                $invoice_obj->logWarning($_GET['code'],'Kế hoạch giao vận của hóa đơn vừa được cập nhật lại. Lưu ý nhé!');
            }
            
        }  
?>
        <a href='http://creta.work/invoice-view-all/'><button class="w3-btn w3-round-large w3-teal w3-hover-white">Quay lại</button></a>
        </br>
        </br>
        </br>
<?php
    } 
    /* 
    Hiển thị thông tin nhà xe cần chỉnh sửa
    */ 
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
            while ($invoice_query->have_posts()){
                $invoice_query->the_post();
                $invoice_id = get_the_ID();
                $invoice_title = get_the_title();
                $invoice_code = get_post_meta($invoice_id,'code',true);
                $invoice_content_str = get_post_meta($invoice_id,'contentInvoice',true);     
                $invoice_planinfo1 = get_post_meta($invoice_id,'planInfo',true); 
                $invoice_planinfo =  $invoice_planinfo1[0];
                $invoice_customer_code = get_post_meta($invoice_id,'customerCode',true);
                $invoice_delivery_status = get_post_meta($invoice_id,'deliveryStatus',true);
                $invoice_delivery_status_VN = "";
                $color_status = "red";
                $css_url ="";
                switch ($invoice_delivery_status) {
                    case "CHO_LEN_KE_HOACH":
                        $color_status = "red";
                        $invoice_delivery_status_VN = "Chờ lên kế hoạch";
                        $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-red.css">';
                        break;
                    case "DANG_DONG_HANG":
                        $color_status = "yellow";
                        $invoice_delivery_status_VN = "Đang đóng hàng";
                        $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-yellow.css">';
                        break;
                    case "CHO_GIAO_HANG":
                        $color_status = "teal";
                        $invoice_delivery_status_VN = "Chờ giao hàng";
                        $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-teal.css">';
                        break;
                    case "DA_GIAO_VAN":
                        $color_status = "purple";
                        $invoice_delivery_status_VN = "Đã giao vận";
                        $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-purple.css">';
                        break;
                    case "HOAN_THANH":
                        $color_status = "green";
                        $invoice_delivery_status_VN = "Hoàn thành";
                        $css_url = '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-green.css">';
                        break;
                    default:
                }
                echo $css_url;

                $i_plan_crName = $invoice_planinfo['carrierName'];   
                $i_plan_crStart = $invoice_planinfo['carrierStart'];   

                $invoice_content_obj = json_decode($invoice_content_str,true);               
                $invoice_customer_note = $invoice_content_obj['description'];
                $invoice_customer_phone = $invoice_content_obj['invoiceDelivery']['contactNumber'];
                $invoice_customer_time_created = $invoice_content_obj['createdDate'];
                $timestamp = date("d/m/Y H:i A",strtotime($invoice_customer_time_created));
                $invoice_customer_address = $invoice_content_obj['invoiceDelivery']['address'];
                $invoice_customer_name = $invoice_content_obj['customerName'];
                $invoice_sale = $invoice_content_obj['soldByName'];
                
                wp_reset_postdata();
                // print_r($invoice_planinfo)   ;
                // echo "1";
                // echo $i_plan_crName;
                $cus_query_args = array(
                    'post_type' => 'cr_customer',
                    'meta_query' => array(
                        array(
                            'key' => 'code',
                            'value' => $invoice_customer_code,
                            'compare' => '='
                        )
                    )            
                );
                $invoice_customer_query = new WP_Query($cus_query_args);
                if ($invoice_customer_query->have_posts()){
                    while ($invoice_customer_query->have_posts()){
                        $invoice_customer_query->the_post();
                        $invoice_customer_id = get_the_ID();
                        $invoice_customer_title = get_the_title();                        
                        $invoice_customer_carrier_codes = get_post_meta($invoice_customer_id,'c_codes',true);
                       
                        $num =  count($invoice_customer_carrier_codes);
                        wp_reset_postdata();
                        if ($num >= 1) {
                            if (($num == 1)&&($invoice_customer_carrier_codes[0]['code'] == "")) { 
                                    /* Trường hợp khách hàng chưa được gán với chành xe nào hết */
                                    echo "</br>";                               
                                    echo "<h2>Khách hàng ". $invoice_customer_title ." chưa có gán với chành xe nào hết thì sao mà giao @@</h2></br>";
                                   
                                    echo "<a href='http://creta.work/khach-hang-danh-sach?code=".$invoice_customer_code."'><button class='w3-btn w3-round-large w3-teal w3-hover-white'>Bổ sung thông tin chành xe cho khách</button></a>";
                            } else { 
                                /* Truong hop day du thong tin */
                                /* Lấy thông tin các chành xe của khách hàng*/ 
                                $list_carriers_obj = array();  
                                

                                for ($x = 0 ; $x < $num ;  $x++) {
                                    $inv_cus_carrier_code =  $invoice_customer_carrier_codes[$x]['code'];
                                    $inv_cus_carrier_note = $invoice_customer_carrier_codes[$x]['note'];
                                    $cus_cr_query_args = array(
                                        'post_type' => 'cr_carrier',
                                        'meta_query' => array(
                                            array(
                                                'key' => 'code',
                                                'value' => $inv_cus_carrier_code,
                                                'compare' => '='
                                            )
                                        )            
                                    );
                                    $inv_cus_carrier_query = new WP_Query($cus_cr_query_args);
                                    if ($inv_cus_carrier_query->have_posts()){
                                        while ($inv_cus_carrier_query->have_posts()){
                                            $inv_cus_carrier_query->the_post();
                                            $inv_cus_carrier_id = get_the_ID();
                                            $inv_cus_carrier_title = get_the_title();                        
                                            $inv_cus_carrier_address_obj = get_post_meta($inv_cus_carrier_id,'address',true);
                                            $inv_cus_carrier_address = $inv_cus_carrier_address_obj[0]['address'];
                                            $inv_cus_carrier_arrive_address = $inv_cus_carrier_address_obj[0]['addressArrive'];
                                            $inv_cus_carrier_phone = $inv_cus_carrier_address_obj[0]['phone'];
                                            $inv_cus_carrier_time = $inv_cus_carrier_address_obj[0]['time'];
                                            $inv_cus_carrier_own_note = $inv_cus_carrier_address_obj[0]['note'];
                                            $inv_cus_carrier_start = $inv_cus_carrier_address_obj[0]['start'];
                                            $inv_cus_carrier_start_cnt = count($inv_cus_carrier_start); 
                                            $carrier_model = array(
                                                'code' => $inv_cus_carrier_code,
                                                'name' => $inv_cus_carrier_title,
                                                'address' => $inv_cus_carrier_address,
                                                'arriveAddress' => $inv_cus_carrier_arrive_address ,
                                                'phone' => $inv_cus_carrier_phone,
                                                'time' => $inv_cus_carrier_time,
                                                'ownNote' => $inv_cus_carrier_own_note,
                                                'start' => $inv_cus_carrier_start,
                                                'count' => $inv_cus_carrier_start_cnt,
                                                'note' => $inv_cus_carrier_note
                                            );
                                            array_push($list_carriers_obj,$carrier_model);  
                                            wp_reset_postdata();                                      
                                        }
                                    }

                                }    
                                
                                $list_carriers_json = json_encode($list_carriers_obj);
                           
                                echo '</br>';
                                


        /*------- xử lý hiển thị---------------  */
?>

    <div id="build-plan-for-invoice" class="w3-container">
        <div class="w3-row">
            <div class="w3-third w3-panel">
                
            </div> 
            <div class="w3-third w3-panel w3-round-xxlarge w3-<?php echo $color_status;?>">
                <div class="w3-panel">               
                <h2 class="w3-center ">Hóa Đơn: <?php echo $invoice_code;?> </h2>
                </div>
            </div>
            <div class="w3-third w3-panel">
            </div>
        </div>
        
        
        <div class='w3-row'>   

            <div id="info-invoice" class="w3-half w3-panel">
                <div class="w3-panel w3-theme-l5 w3-round-xxlarge w3-border w3-hover-border-<?=$color_status;?>">
                    <div class="w3-panel">
                        <h3 class="w3-center">Thông tin của hóa đơn</h3>
                    </div>
                    <div class="w3-panel">                        
                        <table class="w3-table-all w3-striped w3-bordered w3-hoverable w3-white">
                            <tr>
                                <th>Mã hóa đơn</th>
                                <td><?php echo $invoice_code;?></td>
                            </tr>
                            <tr>
                                <th>Tình trạng hóa đơn</th>
                                <td class="w3-<?php echo $color_status;?>"><?php echo $invoice_delivery_status_VN;?></td>
                            </tr>
                            <tr>
                                <th>Người lên đơn</th>
                                <td><?php echo $invoice_sale;?></td>
                            </tr>                    
                        
                            <tr>
                                <th>Thời điểm lên đơn</th>
                                <td><?php echo $timestamp;?></td>
                            </tr>

                            <tr>
                                <th>Lưu ý hóa đơn</th>
                                <td><?php echo $invoice_customer_note;?></td>
                            </tr>
                        </table>
                    </div>                    
                </div>
            </div>

            <div id="info-customer" class="w3-half w3-panel ">
                <div class="w3-panel w3-theme-l5 w3-round-xxlarge w3-border w3-hover-border-<?=$color_status;?>">
                    <div class="w3-panel">           
                        <h3 class="w3-center">Thông tin của khách hàng</h3>
                    </div>
                    <div class="w3-panel">                        
                        <table class="w3-table-all w3-striped w3-bordered w3-hoverable">                     
                            <tr>
                                <th>Code khách hàng</th>
                                <td><?php echo $invoice_customer_code;?></td>
                            </tr>
                            <tr>
                                <th>Tên khách hàng</th>
                                <td><?php echo $invoice_customer_name;?></td>
                            </tr>
                            <tr>
                                <th>Điện thoại</th>
                                <td><?php echo $invoice_customer_phone;?></td>
                            </tr>
                            <tr>
                                <th>Địa chỉ khách</th>
                                <td><?php echo $invoice_customer_address;?></td>
                            </tr>                           
                        </table>    
                    </div>                    
                </div>
            </div>
            
            

        </div>

        </br>
        <div id="plan-edit" class=" w3-theme-l4  w3-panel w3-round-xxlarge w3-border w3-hover-border-<?=$color_status;?>">
            </br>
            <h4 class="w3-center">Kế hoạch giao vận của hóa đơn</h4>
            </br>
            
            <p>(*)Lưu ý các chành xe dưới đây đã có sẵn với khách hàng này. Nếu muốn thêm mới hoặc chỉnh sửa chành xe cho khách thì nhấn vào nút "dưới đây"</p>
            <?php echo "<a target='_blank' href='http://creta.work/khach-hang-danh-sach?code=".$invoice_customer_code."'><button class='w3-btn w3-round-large w3-teal w3-hover-white'>dưới đây</button></a>";?>
            </br>
            </br>
            
            <form id="update-plan-form" method="post">
                <div class="w3-panel w3-theme-l4">
                    <table class="w3-table-all w3-striped w3-bordered ">
                        <tr>
                            <th>Chọn chành xe</th>
                            <td class="">
                                <select id="carrier-select" name="carrier" onchange="carrierChoose()" required>
                                    <option value="-1" <?php if ($i_plan_crName == "") { echo "selected";}?> >Choose one...</option>
                                <?php
                                    for ($y = 0 ; $y < $num; $y++) {
                                        if ($i_plan_crName == $list_carriers_obj[$y]['name'] ) {
                                            echo '<option value="'.$y.'" selected>'.$list_carriers_obj[$y]['name'].'</option>';
                                        } else {
                                            echo '<option value="'.$y.'">'.$list_carriers_obj[$y]['name'].'</option>';
                                        }                                
                                    }
                                ?>
                                </select>
                                <table id="table-carrier-info" class="w3-table w3-striped"> 
                                    
                                </table>
                            </td>

                        </tr>
                        <tr>
                            <th>Lên kế hoạch vận chuyển ra chành(*)</th>
                            <td>
                                </br>
                                <table>
                                    <tr>
                                        <th>Thời gian trễ nhất bắt đầu giao hàng(*)</th>
                                        <td>
                                            <input type="datetime-local" name="deliveryTime" required value="<?php echo $invoice_planinfo['deliveryTime'] ?>">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ kho lấy hàng đi giao(*)</th>
                                        <td>
                                            
                                            <select name="deliveryStorage">
                                                <option value="40 Bảy Hiền" <?php if ($invoice_planinfo['deliveryStorage'] == "40 Bảy Hiền") { echo "selected";}?> >40 Bảy Hiền</option>
                                                
                                                <option value="86 Lạc Long Quân" <?php if ($invoice_planinfo['deliveryStorage'] == "86 Lạc Long Quân") { echo "selected";}?> >86 Lạc Long Quân</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="hidden" name="deliveryStatus" value="<?php if ($invoice_delivery_status=='CHO_LEN_KE_HOACH') {echo 'DANG_DONG_HANG';} else {
                                                echo $invoice_delivery_status;
                                            } ?>">
                                            <input type="hidden" name="oldDeliveryStatus" value="<?php echo $invoice_delivery_status;?>">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table> 
                </div>               
                    <input type="submit" value="<?php if ($color_status=="red") {echo "Xác nhận";} else {echo "Cập nhật";}?>" class="w3-btn w3-round-xlarge w3-right w3-teal w3-hover-gray">          
           
               
            </form>     
            
            </br>
            
            </br>
        </div>
    </div>
    </br>
                                


<?php                            
                            }                            
            /*------- xử lý lỗi--------------- */
                        }   else {
                            echo "<h2>Khách hàng". $invoice_customer_code ." chưa có gán với chành xe nào hết thì sao mà giao @@</h2></br>";
                            echo $invoice_customer_code;
                            echo "123";
                            echo "<a href='http://creta.work/khach-hang-danh-sach?code=".$invoice_customer_code."'><button class='w3-btn w3-round-large w3-teal w3-hover-white'>Bổ sung Thông tin chành xe cho khách</button></a>";
                        }
                    }                    
                } else {
                    /* Trường hợp mã KH trong hóa đơn chưa có trong database của trang web -> thêm mới KH */
                    echo "<h2>Hóa đơn gì mà mã khách hàng lạ quá sao chơi @@</h2></br>";
                    echo "<h4>Vui lòng thêm mới khách hàng nhé</h4>";
                }
            }  
        }   else {
            /* Trường hợp code hóa đơn k đúng */           
            ?>
                <h2>Hình như mã hóa đơn sai rồi@@ tìm hoài k ra</h2>
                </br>
                <h4>Nhập lại mã hóa đơn nhé</h4>
                </br>
                <div class="w3-container">
                    <form method="GET">
                        <table class="w3-table-all w3-striped w3-bordered w3-hoverable">
                            <tr>
                                <th>
                                    <label for="invoice_code">Invoice code</label>
                                </th>
                                <td>
                                    <input type="text" id="invoice_code" name="code" value="HD">    
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2>
                                    <input class="w3-button w3-round-large w3-right w3-teal w3-hover-black" type="submit" value="Xác nhận">
                                </td>
                            </tr>     
                        </table>
                    </form>
                </div>
                </br>
                <div>
                <a href='http://creta.work/invoice-view-all/'><button class="w3-button w3-round w3-gray"> Quay lại danh sách hóa đơn</button></a>
                </div>


            <?php
        }
    wp_reset_postdata();
    } else {
        /* Trường hợp link k có code hóa đơn */
?>
    
    <h2>Nhập mã hóa đơn nhé</h2>
    </br>
        <div class="w3-container">
            <form method="GET">
                <table class="w3-table-all w3-striped w3-bordered w3-hoverable">
                    <tr>
                        <th>
                            <label for="invoice_code">Invoice code</label>
                        </th>
                        <td>
                            <input type="text" id="invoice_code" name="code" value="HD">    
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <input class="w3-button w3-round-large w3-right w3-teal w3-hover-black" type="submit" value="Xác nhận">
                        </td>
                    </tr>     
                </table>
            </form>
        </div>
    <div>
    <a href='http://creta.work/'><button class="w3-button w3-round w3-gray">Quay lại trang chủ</button></a>
    </div>
<?php
    }
?>
</div>

<script>
    var carriers_obj = <?php print_r($list_carriers_json);?>;
    var in1 = document.getElementById("carrier-select").value;
    var started = "<?php print_r($i_plan_crStart);?>" ;
    setTimeout(drawTable(in1),2000);

    function carrierChoose() {
        var index = document.getElementById("carrier-select").value;
        drawTable(index);
    }

    function drawTable(i) {
        var tbl_element = document.getElementById("table-carrier-info");
        
        var txt="";
        
        var x;
        if ( i >= 0) {
            var start = carriers_obj[i].start;
            var cnt = carriers_obj[i].count;
            
            txt = "<tr>";
            txt += "<th>Tên chành xe</th>";
            txt += "<td>" + carriers_obj[i].name;
            txt += "<input type='hidden' name='carrierName' value='" + carriers_obj[i].name + "'>";
            txt += "</td></tr>";

            txt +="<tr>";
            txt += "<th>Mã chành xe</th>";
            txt += "<td>" + carriers_obj[i].code;
            txt += "<input type='hidden' name='carrierCode' value='" + carriers_obj[i].code + "'>";
            txt += "</td></tr>";

            txt +="<tr>";
            txt += "<th>Địa chỉ chành xe</th>";
            txt += "<td>" + carriers_obj[i].address;
            txt += "<input type='hidden' name='carrierAddress' value='" + carriers_obj[i].address + "'>";
            txt += "</td></tr>";

            txt +="<tr>";
            txt += "<th>Địa chỉ đến chành xe</th>";
            txt += "<td>" + carriers_obj[i].arriveAddress;
            txt += "<input type='hidden' name='carrierArrive' value='" + carriers_obj[i].arriveAddress + "'>";
            txt += "</td></tr>";

            txt +="<tr>";
            txt += "<th>Số điện thoại</th>";
            txt += "<td>" + carriers_obj[i].phone;
            txt += "<input type='hidden' name='carrierPhone' value='" + carriers_obj[i].phone + "'>";
            txt += "</td></tr>";

            txt +="<tr>";
            txt += "<th>Thời gian di chuyển ra chành xe</th>";
            txt += "<td>" + carriers_obj[i].time;
            txt += "<input type='hidden' name='carrierPeriod' value='" + carriers_obj[i].time + "'>";
            txt += "</td></tr>";

            txt +="<tr>";
            txt += "<th>Lưu ý chung của chành xe</th>";
            txt += "<td>" + carriers_obj[i].ownNote;
            txt += "<input type='hidden' name='carrierOwnNote' value='" + carriers_obj[i].ownNote + "'>";
            txt += "</td></tr>";

            txt +="<tr>";
            txt += "<th>Lưu ý riêng của khách với chành xe</th>";
            txt += "<td>" + carriers_obj[i].note;
            txt += "<input type='hidden' name='carrierNote' value='" + carriers_obj[i].note + "'>";
            txt += "</td></tr>";

            txt +="<tr>";
            txt += "<th>Chọn khung giờ xe chạy</th>";
            txt += "<td>";
            txt += "<select id='start-carrier-select' name='carrierStart'>";
            for (x = 0 ; x < cnt; x++ ) {
                if (started == start[x]) {
                    txt += "<option value='" + start[x] + "' selected>" + start[x] + "</option>";
                } else {
                    txt += "<option value='" + start[x] + "'>" + start[x] + "</option>";
                }
                
            }
            txt += "</select></td></tr>";


        } else {
            txt ="";
        }
        tbl_element.innerHTML = txt;
    }
</script>

