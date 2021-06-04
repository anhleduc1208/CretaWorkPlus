<?php
    wp_enqueue_script('wp-api');
?>
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-teal.css">
<div class="w3-responsive" style="color:black">
    <h3 class="w3-center">Danh sách tất cả các nhà xe của CRETA</h3>
    <h3>modifi local to hub</h3>
    </br>
    <a href="http://creta.work/carrier-add-new/"><button class="w3-btn w3-round-large w3-right w3-teal w3-hover-white">Thêm mới</button></a>
    </br>
    </br>

    <div class="w3-responsive w3-theme-l5">
        <table class="w3-table w3-striped w3-bordered  w3-hoverable  w3-theme-l5" >
            <tr class="w3-teal w3-large">
                <th>Mã</th>
                <th>Tên chành xe</th>
                        
                
                <th>Số điện thoại</th>
                
               
                <th>Giờ xe chạy</th>
                
                
                <th>Hành động</th>
            </tr>

            <?php
                $my_query_args = array(
                    'post_type' => 'cr_carrier',
                    // 'orderby'   => array(
                    //     'date' =>'ASC',
                    //     'menu_order'=>'DESC'
                    // ),
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'posts_per_page' => '-1'
                    // 'order' => 'DESC'
                );
                $carrier_query = new WP_Query($my_query_args);
                if ($carrier_query->have_posts()){
                    while ($carrier_query->have_posts()){
                        $carrier_query->the_post();
                        $carrier_id = get_the_ID();
                        $carrier_title = get_the_title();

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
                        $carrier_detail_link = 'http://creta.work/carrier-single-detail?code='.$carrier_code;
                        
                        //print_r($carrier_address);

                        ?>
                        <tr>
                            <td>
                                <?php echo $carrier_code;?>
                            </td>
                            <td>
                                <?php echo $carrier_real_name;?>
                            </td>                    
                                                     
                            <td>
                                <?php echo $carrier_phone;?>
                            </td>
                            
                           
                            <td>
                                <?php 
                                    for ($i = 0; $i <$cnt_start_time; $i++){
                                        echo '- ';
                                        echo ($carrier_start[$i]);
                                        echo '</br>';
                                    }           
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo $carrier_detail_link;?>"><button class="w3-btn w3-round-large w3-teal w3-hover-white">Chi tiết</button></a> |
                                <a href="<?php echo $carrier_edit_link;?>"><button class="w3-btn w3-round-large w3-gray w3-hover-white">Chỉnh sửa</button></a>
                                
                            </td>
                        </tr>
                        <?php            

                    }
                }
                wp_reset_postdata();
            ?>

        </table>
    </div>
</div>

