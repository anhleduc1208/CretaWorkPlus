<!-- Lấy thông tin back end -->
<?php
    $check_code_wrong= false;
    if ($_GET['code']) {       
        $my_query_args = array(
            'post_type' => 'cr_carrier',
            'meta_query' => array(
                array(
                    'key' => 'code',
                    'value' => $_GET['code'],
                    'compare' => '='
                )
            )            
        );
        $carrier_query = new WP_Query($my_query_args);
        if ($carrier_query->have_posts()){
            $check_code_wrong = false;
            while ($carrier_query->have_posts()){
                $carrier_query->the_post();
                $carrier_id = get_the_ID();
                $carrier_title = get_the_title();
                /*--Start-Lấy thông tin để hiển thị--*/

                $carrier_code = get_post_meta($carrier_id,'code',true);
                $carrier_address_obj = get_post_meta($carrier_id,'address',true);
                $carrier_address_0 = $carrier_address_obj['0'];
                $carrier_address = $carrier_address_0['address'];
                $carrier_address_arrive = $carrier_address_0['addressArrive'];
                $carrier_time = $carrier_address_0['time'];
                $carrier_phone = $carrier_address_0['phone'];
                $carrier_note = $carrier_address_0['note'];
                $carrier_start= $carrier_address_0['start'];
                $cnt_start_time = count($carrier_start);
                $carrier_real_name = substr($carrier_title,7);
                $carrier_edit_link = 'http://creta.work/carrier-update?code='.$carrier_code;
                            
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
    
    ?>

            <!-- Hiển thị đơn -->
        <div id="main" class="w3-container w3-responsive " style="color:black">
            
            <div id="title" class="w3-panel">
                <a href="http://creta.work/carriers-view-all/"><button class="w3-button w3-teal w3-right w3-round">Trang chành xe</button></a>
                <h2>Thông tin chành xe <?=$carrier_title;?></h2>
                
            </div>
            <div id="table" class="w3-panel">
                <table class="w3-table w3-bordered w3-striped">
                    <tr>
                        <th>Mã nhà xe</th>
                        <td><?=$carrier_code?></td>
                    </tr>
                    <tr>
                        <th>Tên nhà xe</th>
                        <td><?=$carrier_real_name?></td>
                    </tr>
                    <tr>
                        <th>Địa chỉ</th>
                        <td><?=$carrier_address?></td>
                    </tr>
                    <tr>
                        <th>Địa chỉ đến</th>
                        <td><?=$carrier_address_arrive?></td>
                    </tr>
                    <tr>
                        <th>Số điện thoại</th>
                        <td><?=$carrier_phone?></td>
                    </tr>
                    <tr>
                        <th>Thời gian di chuyển dự kiến từ Creta đến nhà xe</th>
                        <td><?=$carrier_time?></td>
                    </tr>
                    <tr>
                        <th>Ghi chú</th>
                        <td><?=$carrier_note?></td>
                    </tr>
                    <tr>
                        <th>Các thời điểm khởi hành</th>
                        <td>
                            <?php 
                                for ($i = 0; $i <$cnt_start_time; $i++){
                                    echo '- ';
                                    echo ($carrier_start[$i]);
                                    echo '</br>';
                                }           
                            ?>
                        </td>
                    </tr>

                </table>
            </div>
            <div id="button" class="w3-panel">
                <a href="<?=$carrier_edit_link?>"><button class="w3-button w3-teal w3-right w3-round">Chỉnh sửa</button></a>                
            </div>

        </div>


<!-- Trường hợp ko có code hoặc code sai -->
<?php } else {  ?>

            <!-- Hiển thị trang nhập code hóa đơn -->
        <div id="missing-code" class="w3-container" style="color:black">    
            <div id="title-2" class="w3-panel">
                
                <a href="http://creta.work/carriers-view-all/"><button class="w3-button left w3-teal w3-round">Trang chành xe</button></a>
                </br>
                <h1 class="w3-center">Thông tin chi tiết chành xe</h1>
                </br>
                <h5><?php if($check_code_wrong==true) {echo "Chành xe k tồn tại, nhập lại nhé:";}?></h5>  
           
            </div>

            <div class="w3-row">
                <div class="w3-quarter w3-panel">
                    <h2>Nhập mã chành xe: </h2>       
                </div>
                <div id="form-code" class="w3-panel w3-quarter ">
                    <form method="get">
                        <input type="text" name="code" value="<?php if ($_GET['code']) {echo $_GET['code'];} else {echo "GV";}?>"> 
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