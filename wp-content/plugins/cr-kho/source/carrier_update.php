<div class="w3-container w3-responsive" style="color:black">
<?php 
    /* 
    Xử lý update thông tin cho nhà xe
    */    
    //include_once("dev1/post_carrier.php");
    if ($_POST){                      
        $update_title = $_POST['title'];
        $update_address_0 = $_POST['address'];
        $new_address_arrive = $_POST['addressArrive'];
        $update_phone = $_POST['phone'];
        $update_time = $_POST['time'];
        $update_note = $_POST['note'];
        $update_start = $_POST['start'];
      
        // for ($x = 0; $x < $cnt_post_key; $x++){
        //     $str = 'start'.$x;            
        //     array_push($update_start, $_POST[$str]);
        // }
        
        $update_address = array(
            '0' => array (
                'address' => $update_address_0,
                'addressArrive' => $new_address_arrive,
                'phone' => $update_phone,
                'time' => $update_time,
                'note' => $update_note,
                'start' => $update_start
                )
            
        );
       
        if ($_GET['code']) {
            $update_query_args = array(
                'post_type' => 'cr_carrier',
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

                        update_post_meta($update_id,'address',$update_address);   

                        $my_update_carrier = array(
                            'ID' => $update_id,
                            'post_title' => $update_title
                        );
                        wp_update_post($my_update_carrier); 
                        echo '<h2>Update thành công</h2>';
                        echo '</br>';
                }
            }
            wp_reset_postdata();
        }  
?>

    <a href='http://creta.work/carriers-view-all/'><button class="w3-btn w3-round-large w3-teal w3-hover-white">Quay lại</button></a>
    </br>
    </br>
    </br>

<?php
    } 
    


    /* 
    Hiển thị thông tin nhà xe cần chỉnh sửa
    */ 
    if ($_GET['code']) {    
        echo '<div>';
        echo '<h2>Đây là trang chỉnh sửa chành xe mã số: ';
        echo $_GET['code'];
        
        echo '</h2></div></br>'; 

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
            while ($carrier_query->have_posts()){
                $carrier_query->the_post();
                $carrier_id = get_the_ID();
                $carrier_title = get_the_title();

                $carrier_code = get_post_meta($carrier_id,'code',true);
                $carrier_address = get_post_meta($carrier_id,'address',true);
                $carrier_address_0 = $carrier_address['0']['address'];
                $carrier_address_arrive = $carrier_address['0']['addressArrive'];
                $carrier_phone = $carrier_address['0']['phone'];
                $carrier_time = $carrier_address['0']['time'];
                $carrier_note = $carrier_address['0']['note'];
                $carrier_start= $carrier_address['0']['start'];    
                $cnt_start_time = count($carrier_start);      

?>


    <!-- Form nhập thông tin cần chỉnh sửa của nhà xe -->
<form class="w3-container" id="update-form" method="post">
    <table class="w3-table-all w3-striped w3-bordered   w3-hoverable">  
        <tr>
            <td>Mã</td>
            <td>
               
                <?php echo $carrier_code;?>    
            </td>
        </tr>
        <tr>
            <td>Tên chành xe</td>
            <td>
                <input class="w3-input w3-border w3-round-large" type="text" name="title" value="<?php echo $carrier_title;?>">           
            </td>
        </tr>
        <tr>
            <td>Địa chỉ chành</td>
            <td>
                <input type="text" name="address" value="<?php echo $carrier_address_0;?>">              
            </td>
        </tr>
        <tr>
            <td>Địa chỉ đến</td>
            <td>
                <input type="text" name="addressArrive" value="<?php echo $carrier_address_arrive;?>">              
            </td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td>
                <input type="text" name="phone" value="<?php echo $carrier_phone;?>">              
            </td>
        </tr>
        <tr>
            <td>Thời gian di chuyển dự kiến</td>
            <td>
                <input type="text" name="time" value="<?php echo $carrier_time;?>">              
            </td>
        </tr>
        <tr>
            <td>Ghi chú</td>
            <td>
                <input type="textarea" name="note" value="<?php echo $carrier_note;?>">              
            </td>
        </tr>
        <tr>
            <td>Khung giờ xe chạy</td>
            <td>
                <table class="w3-table" id="table-time-starts">      
                      
                </table>
            </td>
          
        </tr>                 
    </table>
    
    <input class="w3-button w3-round-large w3-right w3-teal w3-hover-gray" type="submit" value="Xác nhận">
</form>

<?php       
        }
    }
    wp_reset_postdata();
    } else {
?>
    <h2>Nhập thông tin mã nhà giao vận nhé</h2>
    </br>
        <div class="w3-container">
            <form method="GET">
                <table class="w3-table-all w3-striped w3-bordered w3-hoverable">
                    <tr>
                        <th>
                            <label for="carrier_code">Carrier code</label>
                        </th>
                        <td>
                            <input type="text" id="carrier_code" name="code" value="GV">    
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
    <a href='http://creta.work/carriers-view-all/'><button class="w3-btn w3-round-large w3-teal w3-hover-white" >Quay lại DS chành xe</button></a>
    </div>
<?php
    }
?>

<script>
    var cnt;
    var tbl = document.getElementById("table-time-starts");
    cnt = <?php print_r($cnt_start_time);?> ;  
    mn = <?php echo json_encode($carrier_start);?>;   
    drawTable(cnt);  
   
    function drawTable(i) {
        var txt="";                
                    
        var x;
        if (i == 0) {
            txt = '<tr>';
            txt += '<td><input type="time" name="start0" value=""></td>'; 
            txt += '<td><button class="w3-btn w3-centered w3-circle w3-green w3-xlarge w3-right w3-hover-white" onClick="addTime(0); return false;">+</button></td>';
            txt += '</tr>';              
        } else {
            for (x = 0; x < i; x++) {                
                txt += '<tr id="period-' + x + '">';               
                txt += '<td><input type="time" name="start[]" value="' + mn[x]+'"></td>';                 
                txt += '<td><button class="w3-btn w3-centered w3-circle w3-green w3-xlarge w3-right w3-hover-white" onclick="addTime(' + x + '); return false;">+</button></td>';
                
                txt += '<td><button class="w3-btn w3-centered w3-circle w3-red w3-xxlarge w3-left w3-hover-white" onclick="delTime(' + x +' ); return false;">-</button></td>';
                
                txt += '</tr>';  
            }
        }
        tbl.innerHTML = txt;
    }

    function arrangeTable(dem) {        
        var cou;
        for (cou = 0; cou < dem; cou++){
            var tr_children = document.getElementById("table-time-starts").children[0].children;
            tr_children[cou].id = "period-" + cou;
            
            var td_children = tr_children[cou].children;
            var inp1 = td_children[0].children;
            var str1 = "start[]";
            var str2 = "addTime(" + cou + "); return false;";
            var str3 = "delTime(" + cou + ")"; 
            var but1 = td_children[1].children;
            var but2 = td_children[2].children;
            inp1[0].setAttribute("name",str1);
            but1[0].setAttribute("onclick",str2);
            but2[0].setAttribute("onclick",str3);            
        }
    }

    function addTime(vrr=0){
        if (vrr>=0) {
            var str_period = "period-"+ vrr;
            var ele = document.getElementById(str_period);
            var c = vrr + 100;
            var new_tr = '<tr id="period-' + c + '">';
            new_tr += '<td><input type="time" name="start[]" value=""></td>'; 
            new_tr += '<td><button class="w3-btn w3-circle w3-green w3-xlarge w3-right w3-hover-white" onclick="addTime(' + c + '); return false;">+</button></td>';
            new_tr += '<td><button class="w3-btn w3-circle w3-red w3-xxlarge w3-left w3-hover-white" onclick="delTime(' + c +' ); return false;">-</button></td>';
            new_tr += '</tr>';  
            cnt ++;
            ele.insertAdjacentHTML("afterend",new_tr);
            arrangeTable(cnt);
            return false;
        }
        else {
            return false;
        }        
    }

    function delTime(j) {
        if (cnt>1) {
            var txt = "#period-" + j ;
            $(txt).remove();
            cnt --;
            arrangeTable(cnt);
            return false;
            
        } else if (cnt == 1) { 
                    
            return false;   
        } else {
            return false;
        }
    }

</script>
</div>

