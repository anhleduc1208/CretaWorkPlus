
<?php
    if ($_POST["deliveryStatus"]) {
        $delivery_status = $_POST["deliveryStatus"];
        $planInfo = array (
            0 => array()
        );
        $delivery_realtime = "";
        $log_history = array();
        $hd_test_id = 2621;
        update_post_meta($hd_test_id,'deliveryStatus',$delivery_status);
        update_post_meta($hd_test_id,'planInfo',$planInfo); 
        update_post_meta($hd_test_id,'deliveryRealTime',$delivery_realtime); 
        update_post_meta($hd_test_id,'logHistory',$log_history); 
        echo "<h5>reset thành công</h5>";
    }
?>
<h2>Reset hóa đơn test</h2>
<form method="post">
    <input type="hidden" name="deliveryStatus" value="CHO_LEN_KE_HOACH">
    <input type="submit" value="Reset">
</form>
