<!-- <h1>abc</h1> -->
<?php
    include dirname( __FILE__ ) .'../../dev1_DucAnh/Classes/class_creta.php';   
?>
<?php
    //print_r($_GET);
    //print_r($_POST);
    if ($_POST['cusCode']){
        $method = $_POST['method'];
        $cusCode = $_POST['cusCode'];
        $invCode = $_POST['invCode'];
        $purchaseDate = $_POST['purchaseDate'];
        
        
        $customer_obj = new Cr_Customer();
        switch ($method){
            case 'add':                                
                $customer_obj->addInvoice($cusCode,$invCode,$purchaseDate);
                //echo 'add';
                break;
            case 'delete':
                $customer_obj->delInvoice($cusCode,$invCode);
                //echo 'del';
                break;            
            default:
                //echo 'hehe';
        }
        
    } 
?>