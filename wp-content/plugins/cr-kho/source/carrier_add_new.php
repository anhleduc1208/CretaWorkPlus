<div class="w3-container w3-responsive" style="color:black">
<?php
    if ($_POST) {
        // $cnt_post_key = count($_POST) - 4;
        $new_code = $_POST['code'];
        $new_title = $_POST['title'];
        $new_address_0 = $_POST['address'];
        $new_address_arrive = $_POST['addressArrive'];
        $new_phone = $_POST['phone'];
        $new_time = $_POST['time'];
        $new_note = $_POST['note'];
        $new_start = $_POST['start'];

        // for ($x = 0; $x < $cnt_post_key; $x++){
        //     $str = 'start'.$x;            
        //     array_push($new_start, $_POST[$str]);
        // }

        $check_query_args = array(
            'post_type' => 'cr_carrier',
            'meta_query' => array(
                array(
                    'key' => 'code',
                    'value' => $new_code,
                    'compare' => '='
                )
            )            
        );
        $check_query = new WP_Query($check_query_args);
        $count = $check_query->found_posts;
        if (($count != 0)) {
            echo '<h3>Thất bại!!!Mã code đã tồn tại</h3>';
        }
        else {
            $new_address = array(
                '0' => array (
                    'address' => $new_address_0,
                    'addressArrive' => $new_address_arrive,
                    'phone' => $new_phone,
                    'time' => $new_time,
                    'note' => $new_note,
                    'start' => $new_start                    
                )
            );
    
            $postarr = array(
                'post_type' => 'cr_carrier',
                'post_title' => $new_title,
                'post_status' => 'publish'
            );
            $id = wp_insert_post($postarr);
            if ($id) {
                add_post_meta($id,'code',$new_code);
                add_post_meta($id,'address',$new_address);
                echo '<h3>Chúc mừng thêm mới chành xe '.$new_code.' đã thành công</h3>';
            }
        }

?>
        </br>
        <a href="http://creta.work/carriers-view-all/"><button class="w3-btn w3-round-large w3-teal w3-hover-white">Quay về</button></a> 
        </br>
<?php
    }
    //else {


?>
<div id="Form thêm mới" class="w3-center w3-pale-blue">
</br>
<h2 class="w3-center">Thêm mới nhà xe</h2>
</br>

 <!-- Form nhập thông tin của nhà xe mới-->
 <form  class="w3-container" method="post" >
    <table class="w3-table-all w3-striped w3-bordered   w3-hoverable">  
        <tr>
            <td>Mã</td>
            <td>
                <input type="text" name="code" required>        
                   
            </td>
        </tr>
        <tr>
            <td>Tên chành xe</td>
            <td>
                <input type="text" name="title" value="">           
            </td>
        </tr>
        <tr>
            <td>Địa chỉ chành</td>
            <td>
                <input type="text" name="address" value="">              
            </td>
        </tr>
        <tr>
            <td>Địa chỉ đến</td>
            <td>
                <input type="text" name="addressArrive" value="">              
            </td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td>
                <input type="text" name="phone" value="">              
            </td>
        </tr>
        <tr>
            <td>Thời gian di chuyển dự kiến</td>
            <td>
                <input type="text" name="time" value="">              
            </td>
        </tr>
        <tr>
            <td>Ghi chú</td>
            <td>
                <input type="text" name="note" value="">              
            </td>
        </tr>
        <tr>
            <td>Khung giờ xe chạy</td>
            <td>
                <table id="table-time-starts">
                </table>            
               
            </td>
        </tr>                 
    </table>
    <input class="w3-button w3-round-large w3-right w3-yellow w3-hover-gray" type="submit" value="Thêm">
</form>
</div>
<?php
    //}
?>
</div>
<script>    
    var tbl = document.getElementById("table-time-starts");   
    var cnt = 1; 
    drawTable(cnt);  
   
    function drawTable(i) {
        var txt="";
        var x;
        if (i == 0) {
            txt = '<tr>';
            txt += '<td><input type="time" name="start[]" value=""></td>'; 
            txt += '<td><button onClick="addTime()">ADD</button></td>';
            txt += '</tr>';              
        } else {
            for (x = 0; x < i; x++) {                
                txt += '<tr id="period-' + x + '">';
                txt += '<td ><input type="time" name="start[]" value=""></td>'; 
                txt += '<td><button class="w3-btn w3-centered w3-circle w3-green w3-xlarge w3-right w3-hover-pale-green" onclick="addTime(' + x + '); return false;">+</button></td>';
                txt += '<td><button class="w3-btn w3-centered w3-circle w3-red w3-xxlarge w3-left w3-hover-pale-red" onclick="delTime(' + x +' )">-</button></td>';
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
            new_tr += '<td><button class="w3-btn w3-centered w3-circle w3-green w3-xlarge w3-right w3-hover-white" onclick="addTime(' + c + '); return false;">+</button></td>';
            new_tr += '<td><button class="w3-btn w3-centered w3-circle w3-red w3-xxlarge w3-left w3-hover-white" onclick="delTime(' + c +' )">-</button></td>';
            new_tr += '</tr>';  
            cnt ++;
            ele.insertAdjacentHTML("afterend",new_tr);
            arrangeTable(cnt);
            return false;
        }
        else {
            return true;
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
            return true;
        }
    }

</script>
