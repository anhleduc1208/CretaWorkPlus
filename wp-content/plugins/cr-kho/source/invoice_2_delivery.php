<?php
    include_once 'dev1_DucAnh/Classes/class_creta.php'
?>

    <!-- Xử lý có post -->
<?php
    if ($_POST['deliveryStatus']) {
        $update_delivery_status = $_POST['deliveryStatus'];
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $real_time = date("d-m-Y H:i");
        
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

                          
                        update_post_meta($update_id,'deliveryStatus',$update_delivery_status); 
                        update_post_meta($update_id,'deliveryRealTime',$real_time);
                        
                        echo '<h2>Update thành công</h2>';
                        echo '</br>';
                }
            }
            wp_reset_postdata();

            $invoice_obj = new Cr_Invoice();
            $invoice_obj->logNormal($_GET['code'],'Đơn hàng đã được chuyển');
        }  
    }
?>

    <!-- Xử lý có get -->
<?php
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
                $invoice_code = get_post_meta($invoice_id,'code',true);
                $invoice_delivery_status = get_post_meta($invoice_id,'deliveryStatus',true);
                $invoice_delivery_status_VN = "";
                $color_status = "red";
                $state = 0;
                switch ($invoice_delivery_status) {
                    case "CHO_LEN_KE_HOACH":
                        $color_status = "red";
                        $invoice_delivery_status_VN = "Chờ lên kế hoạch";
                        $state = 0;
                        break;
                    case "DANG_DONG_HANG":
                        $color_status = "yellow";
                        $invoice_delivery_status_VN = "Đang đóng hàng";
                        $state = 1;
                        break;
                    case "CHO_GIAO_HANG":
                        $color_status = "teal";
                        $invoice_delivery_status_VN = "Chờ giao hàng";
                        $state = 2;
                        break;
                    case "DA_GIAO_VAN":
                        $color_status = "purple";
                        $invoice_delivery_status_VN = "Đã giao vận";
                        $state = 3;
                        break;
                    case "HOAN_THANH":
                        $color_status = "green";
                        $invoice_delivery_status_VN = "Hoàn thành";
                        $state = 4;
                        break;
                    default:
                }
                wp_reset_postdata();
    ?>       <!-- Xử lý hiển thị -->
            
         <div class="w3-container" style="color:black">
         <a href="http://creta.work/invoice-view-all/"><button class="w3-button w3-right w3-teal w3-round-xlarge">Trang hóa đơn</button></a>
         <a href="http://creta.work/invoice-single-detail/?code=<?=$invoice_code;?>"><button class="w3-button w3-left w3-<?=$color_status;?> w3-round-xlarge">Chi tiết đơn</button></a>
                <h2>Hóa đơn <?php echo $invoice_code;?></h2>
                </br>
                <h4>Tình trạng: <a class="w3-<?=$color_status?>"><?=$invoice_delivery_status_VN?></a></h4>
            
            <?php  
                if ($state==2) {
                ?>
                    </br>
                    </br>
                    <p>Hàng đã đóng xong. Tranh thủ giao hàng rồi bấm xác nhận dưới này nhé</p>
                    <form method="POST">
                        <input type="hidden" name="deliveryStatus" value="DA_GIAO_VAN">
                        <input type="submit" value="Giao hàng xong" class="w3-hover-red w3-<?=$color_status?>">
                    </form>
                <?php        
                }
            ?>

         </div>       

    <?php
            }
        }        
    } // if get code
?> 