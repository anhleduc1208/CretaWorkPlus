<!-- <h1>abc</h1> -->
<?php
    include dirname( __FILE__ ) .'../../dev1_DucAnh/Classes/class_creta.php';
   
?>
<?php
    print_r($_GET);
    print_r($_POST);
    if ($_POST['code']){
        $level = $_POST['level'];
        $code = $_POST['code'];
        $description = $_POST['description'];
        echo $level;
        $invoice_obj = new Cr_Invoice();
        switch ($level){
            case 'Normal': 
                echo 'N';               
                $invoice_obj->logNormal($code,$description);
                echo 'N';
                break;
            case 'Warning':
                $invoice_obj->logWarning($code,$description);
                echo 'W';
                break;
            case 'Error':
                $invoice_obj->logError($code,$description);
                echo 'E';
                break;
            default:
                echo 'hehe';
        }
        
    } 
?>