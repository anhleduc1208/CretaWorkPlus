<?php
    
    class Cr_Creta
    {
        /*-------Properties-------- */
            protected $code;
            protected $id;
            protected $post_type;
            protected $data_fields;
            protected $creta_wp_query;
            protected $creta_logger;
            
        /*-------Methods-------- */
            public function __CONSTRUCT(){
                $this->creta_wp_query = new WP_Query();
            }
            public function getCode() {
                return $this->code;
            }
                // public function setCode($code) {
                //     $this->code = $code;
                // }
            public function getID() {
                return $this->id;
            }
            public function getPostType() {
                return $this->post_type;
            }
            public function getDataFields() {
                return $this->data_fields;
            }
                
            
            public function findIdByCode() {
                $count = 0;
                $found_ids = array();
                $my_query_args = array(
                    'post_type' => $this->post_type,
                    'meta_query' => array(
                        array(
                            'key' => 'code',
                            'value' => $this->code,
                            'compare' => '='
                        )
                    )            
                );
                
                $this->creta_wp_query->query($my_query_args);
                if ($this->creta_wp_query->have_posts()) {
                    while ($this->creta_wp_query->have_posts()) {
                        $this->creta_wp_query->the_post();
                        $count++;
                        $single_id = get_the_ID();
                        array_push($found_ids,$single_id);
                    }
                }              
                wp_reset_postdata();
                
                $result = array (
                    'count' => $count,
                    'id' => $found_ids
                );
                return $result;
            }           

            public function getDataByCode($code) {
                $this->code = $code;
                $data_fields = $this->data_fields;
                $data_length = count($data_fields);
                $post_type = $this->$post_type;

                $rs = $this->findIdByCode();
                $result = array();

                if ($rs['count'] == 1) {

                    $this->id = $rs['id'][0];

                    $this_id = $this->id;
                        $result['id'] = $this_id;

                    $this_title = get_the_title($this_id);
                        $result['title'] = $this_title;

                    for ($x = 2; $x<$data_length ; $x++) {
                        $key = $data_fields[$x];
                        $value = get_post_meta($this_id,$data_fields[$x],true); 
                        $result[$key] = $value;
                    }                    
                }
                return $result;
            }

            public function createData($data,$is_unique_code) {
                if ( array_key_exists('code',$data) ) {                
                    $the_title = $data['title'];
                    $the_code = $data['code'];
                    $data_fields = $this->data_fields;
                    $data_length = count($data_fields);
                    $post_type = $this->post_type;

                    if ($is_unique_code == true) {

                        $check_code_args = array (
                            'post_type' => 'cr_carrier',
                            'meta_query' => array(
                                array(
                                    'key' => 'code',
                                    'value' => $the_code,
                                    'compare' => '='
                                )
                            ) 
                        );

                        $this->creta_wp_query->query($check_code_args);
                        $found_code = $this->creta_wp_query->found_posts;

                        if ( ($found_code  != 0 ) ){
                            echo '<h3>Thất bại!!!Mã code đã tồn tại</h3>';
                        }   else {

                            $post_arr = array(
                                'post_type' => $post_type,
                                'post_title' => $the_title,
                                'post_status' => 'publish'
                            );
        
                            $created_id = wp_insert_post($post_arr);
        
                            if ($created_id){
                                for ($x = 2; $x < $data_length; $x++) {
                                    $key = $data_fields[$x];                        
                                    if ( array_key_exists($key,$data) ) {
                                        add_post_meta($created_id,$key,$data[$key]);
                                    }
                                } 
                            }
                        }
                    } else {
                        $post_arr = array(
                            'post_type' => $post_type,
                            'post_title' => $the_title,
                            'post_status' => 'publish'
                        );
    
                        $created_id = wp_insert_post($post_arr);
                        //print_r($data_fields);
                        //print_r($created_id);
                        if ($created_id) {
                            for ($x = 2; $x < $data_length; $x++) {
                                $key = $data_fields[$x];                        
                                if ( array_key_exists($key,$data) ) {
                                    add_post_meta($created_id,$key,$data[$key]);
                                }
                            } 
                        }
                    }
                    
                }
            }

            public function updateDataByCode($code,$update_data) {
                $this->code = $code;
                $data_fields = $this->data_fields;
                $data_length = count($data_fields);
                $post_type = $this->$post_type;

                $rs = $this->findIdByCode();
                if ($rs['count'] == 1) {
                    $this->id = $rs['id'][0];
                    $this_id = $this->id;  
                    
                    if ( array_key_exists('title',$update_data) ){
                        $my_update_invoice = array(
                            'ID' => $this_id,
                            'post_title' => $update_data['title']
                        );
                        wp_update_post($my_update_invoice); 
                    }

                    for ($x = 3; $x < $data_length; $x++) {
                        $key = $data_fields[$x];                        
                        if ( array_key_exists($key,$update_data) ) {
                            update_post_meta($this_id,$key,$update_data[$key]);
                        }
                    }                   
                }
                return ;
            }

            public function deleteDataByCode($code) {            
                $this->code = $code;
                $rs = $this->findIdByCode();
                if ($rs['count'] == 1) {
                    $this->id = $rs['id'][0];
                    $this_id = $this->id;
                    /** dù true hay false gì cũng bị xóa thẳng tay  @@*/
                    wp_delete_post($this_id, false);
                }
                return;                
            }

            public function findIdsByArgs($args) {
                $count = 0;
                $found_ids = array();
                $my_query_args = array(
                    'post_type' => $this->post_type,                               
                );
                if (array_key_exists('posts_per_page',$args)) {
                    $my_query_args['posts_per_page'] = $args['posts_per_page'];
                }
                if (array_key_exists('offset',$args)) {
                    $my_query_args['offset'] = $args['offset'];
                }
                if (array_key_exists('order',$args)) {
                    $my_query_args['order'] = $args['order'];
                }
                if (array_key_exists('orderby',$args)) {
                    $my_query_args['orderby'] = $args['orderby'];
                }
                if (array_key_exists('',$args)) {
                    $my_query_args[''] = $args[''];
                }
                if (array_key_exists('',$args)) {
                    $my_query_args[''] = $args[''];
                }

                $this->creta_wp_query->query($my_query_args);
                if ($this->creta_wp_query->have_posts()) {
                    while ($this->creta_wp_query->have_posts()) {
                        $this->creta_wp_query->the_post();
                        $count++;
                        $single_id = get_the_ID();
                        array_push($found_ids,$single_id);
                    }
                }
                wp_reset_postdata();
                
                $result = array (
                    'count' => $count,
                    'id' => $found_ids
                );
                return $result;
            }

            
    }

    class Cr_Creta_Logged_Child extends Cr_Creta
    {
        protected $creta_logger;

        public function logNormal($code,$description) {                
            $this->code = $code;
            $data_fields = $this->data_fields;
            $data_length = count($data_fields);
            $post_type = $this->$post_type;
            $log_data_raw = $this->creta_logger->createLog($code,$this->post_type,$description,'Normal');
                $log_data = array(
                    'datetime' => $log_data_raw['datetime'],
                    'description' => $log_data_raw['description'],
                    'dangerousLevel' => $log_data_raw['dangerousLevel']
                );

            $rs = $this->findIdByCode();
            if ($rs['count'] == 1) {
                $this->id = $rs['id'][0];
                $this_id = $this->id;  
                
                $old_log_data = get_post_meta($this_id,'logHistory',true);           
                if ($old_log_data) {
                    array_unshift($old_log_data,$log_data);  
                } else {
                    $old_log_data = array($log_data);
                }                                      
                update_post_meta($this_id,'logHistory',$old_log_data);
                // $refresh_log_data = array();
                // update_post_meta($this_id,'logHistory',$refresh_log_data);
            }
        }

        public function logWarning($code,$description) {            
            $this->code = $code;
       
            $post_type = $this->$post_type;
            $log_data_raw = $this->creta_logger->createLog($code,$this->post_type,$description,'Warning');
                $log_data = array(
                    'datetime' => $log_data_raw['datetime'],
                    'description' => $log_data_raw['description'],
                    'dangerousLevel' => $log_data_raw['dangerousLevel']
                );

            $rs = $this->findIdByCode();
            if ($rs['count'] == 1) {
                $this->id = $rs['id'][0];
                $this_id = $this->id;  
                
                $old_log_data = get_post_meta($this_id,'logHistory',true);  
                if ($old_log_data) {
                    array_unshift($old_log_data,$log_data);  
                } else {
                    $old_log_data = array($log_data);
                }
                                                    
                update_post_meta($this_id,'logHistory',$old_log_data);
                // $refresh_log_data = array();
                // update_post_meta($this_id,'logHistory',$refresh_log_data);
            }
        }

        public function logError($code,$description) {            
            $this->code = $code;           
            $post_type = $this->$post_type;
            $log_data_raw = $this->creta_logger->createLog($code,$this->post_type,$description,'Error');
                $log_data = array(
                    'datetime' => $log_data_raw['datetime'],
                    'description' => $log_data_raw['description'],
                    'dangerousLevel' => $log_data_raw['dangerousLevel']
                );

            $rs = $this->findIdByCode();
            if ($rs['count'] == 1) {
                $this->id = $rs['id'][0];
                $this_id = $this->id;  
                
                $old_log_data = get_post_meta($this_id,'logHistory',true);           
                if ($old_log_data) {
                    array_unshift($old_log_data,$log_data);  
                } else {
                    $old_log_data = array($log_data);
                }                                 
                update_post_meta($this_id,'logHistory',$old_log_data);
            }
        }
    }

    class Cr_Invoice extends Cr_Creta_Logged_Child
    {  
        protected $invoice_logger;
        protected $hidden_code;
        function __CONSTRUCT(){
            $this->post_type = 'cr_invoice';  
            $this->data_fields = array(
                'id',
                'title',
                'code',
                'statusInv',
                'purchaseDate',
                'deliveryStatus',
                'deliveryRealTime',
                'contentInvoice',
                'customerCode',
                'customerInfo',
                'planInfo',
                'hiddenCode',
                'logHistory'
            ); 
            $this->creta_wp_query = new WP_Query();  
            $this->creta_logger = new Cr_Logger();       
        }

         /*-------Methods-------- */  
        public function productList($code){
            $this->code = $code;
            $product_list = array();
            $invoice = $this->getDataByCode($code);
            $inv_content_str = $invoice['contentInvoice'];
            $inv_content_obj = json_decode($inv_content_str,true);
            $product_list_raw = $inv_content_obj['invoiceDetails'];
            $cnt = count($product_list_raw);
            for ($x=0; $x<$cnt; $x++){
                $single = array(
                    'code' => $product_list_raw[$x]['productCode'],
                    'name' => $product_list_raw[$x]['productName'],
                    'quantity' => $product_list_raw[$x]['quantity'],
                    'price' => $product_list_raw[$x]['price'],
                    'subtotal' => $product_list_raw[$x]['subtotal']
                );
                array_push($product_list,$single);
            }
            //print_r($inv_content_obj);
            return $product_list;
        }

        protected function findIdByHiddenCode() {
            $count = 0;
            $found_ids = array();
            $my_query_args = array(
                'post_type' => $this->post_type,
                'meta_query' => array(
                    array(
                        'key' => 'hiddenCode',
                        'value' => $this->hidden_code,
                        'compare' => '='
                    ),
                    array(
                        'key' => 'statusInv',
                        'value' => 'official',
                        'compare' => '='
                    )
                    
                )            
            );
            
            $this->creta_wp_query->query($my_query_args);
            if ($this->creta_wp_query->have_posts()) {
                while ($this->creta_wp_query->have_posts()) {
                    $this->creta_wp_query->the_post();
                    $count++;
                    $single_id = get_the_ID();
                    array_push($found_ids,$single_id);
                }
            }              
            wp_reset_postdata();
            
            $result = array (
                'count' => $count,
                'id' => $found_ids
            );
            return $result;
        }  

        public function getDataByHiddenCode($hiddenCode) {
            $this->hidden_code = $hiddenCode;
            $data_fields = $this->data_fields;
            $data_length = count($data_fields);
            $post_type = $this->$post_type;

            $rs = $this->findIdByHiddenCode();
            $result = array();

            if ($rs['count'] == 1) {

                $this->id = $rs['id'][0];

                $this_id = $this->id;
                    $result['id'] = $this_id;

                $this_title = get_the_title($this_id);
                    $result['title'] = $this_title;

                for ($x = 2; $x<$data_length ; $x++) {
                    $key = $data_fields[$x];
                    $value = get_post_meta($this_id,$data_fields[$x],true); 
                    $result[$key] = $value;
                }                    
            }
            return $result;
        }

        public function getHiddenCodeByCode($code){
            $inv = $this->getDataByCode($code);
            return $inv['hiddenCode'];
        }

        public function findRecentInvoices($code,$num) {
            
            $the_invoice = $this->getDataByCode($code);
            //print_r($the_invoice);
            $cus_code = $the_invoice['customerCode'];
            $customer_obj = new Cr_Customer();
            $recent_invoices = $customer_obj->recentInvoices($cus_code);
            //$recent_invoices = $the_customer['recentInvoices'];
            //print_r($recent_invoices);
            $cnt = count($recent_invoices);
            $limit = 0;
            if ($num >= $cnt) {
                $limit = $cnt;
            } else {
                $limit = $num;
            }
            $recent_invoices_full = array();
            for ($x = 0; $x < $limit; $x++) {
                $inv_code = $recent_invoices[$x]['invCode'];
                $inv_date = $recent_invoices[$x]['purchaseDate'];
                $inv_hidden_code = $this->getHiddenCodeByCode($inv_code);
                $single = array(
                    'invCode' => $inv_code,
                    'purchaseDate' => str_replace("T"," ",$inv_date),
                    'invHiddenCode' => $inv_hidden_code,
                );
                array_push($recent_invoices_full,$single);
            }
            return $recent_invoices_full; 
        }
        
    }

    class Cr_Carrier extends Cr_Creta_Logged_Child
    {
        function __CONSTRUCT(){
            $this->post_type = 'cr_carrier';
            $this->data_fields = array(
                'id',
                'title',
                'code',
                'address'                
            );       
            $this->creta_wp_query = new WP_Query();        
        }

        /*-------Methods-------- */ 


    }

    class Cr_Customer extends Cr_Creta_Logged_Child
    {
        function __CONSTRUCT(){
            $this->post_type = 'cr_customer';
            $this->data_fields = array(
                'id',
                'title',
                'code',
                'c_codes',
                'customerInfo',
                'recentInvoices'                
            );      
            $this->creta_wp_query = new WP_Query();      
        }

        /*-------Methods-------- */
        public function recentInvoices($cus_code) {
            //$this->code = $cus_code;
            $data = $this->getDataByCode($cus_code);
            //print_r($data);
            return $data['recentInvoices'];
        }

        public function addInvoice($cus_code,$inv_code,$date) {
            $old_recent_invoices = $this->recentInvoices($cus_code);
            
            $new_inv = array (
                'invCode' => $inv_code,
                'purchaseDate' => $date
            );
            
            if ($old_recent_invoices) {                
                $i = 0;
                $cnt = count($old_recent_invoices);
                for ($x = 0; $x < $cnt; $x++) {
                    if ($old_recent_invoices[$x]['invCode']==$inv_code) {
                        $i++;
                    }
                }

                if ($i == 0) {
                    array_unshift($old_recent_invoices,$new_inv);
                } else {
                    // do nothing
                    //echo 'co code r';
                }
            } else {
                $old_recent_invoices = array($new_inv);
            }
            //echo $this->id;
            update_post_meta($this->id,'recentInvoices', $old_recent_invoices);
            return;
        }

        public function delInvoice($cus_code,$inv_code) {
            $old_recent_invoices = $this->recentInvoices($cus_code); 
          
            print_r($old_recent_invoices);
           
            if ($old_recent_invoices) {
                $cnt = count($old_recent_invoices);
                for ($x = 0; $x < $cnt; $x++){
                    if ($old_recent_invoices[$x]['invCode']==$inv_code) {
                        if ($x == 0){
                            array_shift($old_recent_invoices);
                        } else {
                            array_splice($old_recent_invoices,$x);  
                        }             
                                               
                    }
                }
            } else {
                $old_recent_invoices = array();  
                            
            }    
            print_r($old_recent_invoices);        
            update_post_meta($this->id,'recentInvoices', $old_recent_invoices);
            return;
        }

    }

    class Cr_Logger extends Cr_Creta
    {
        protected $log_data;

        function __CONSTRUCT() {
            $this->post_type = 'cr_log';
            $this->data_fields = array(
                'id',
                'title',
                'code',
                'type',
                'datetime',
                'description',
                'dangerousLevel'
            );
            $this->creta_wp_query = new WP_Query();
        }

        public function createLog($code,$type,$description,$dangerousLevel) {
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $real_time = date("d/m/Y H:i:s");
            $title = $code.': '.$description.' - '.$dangerousLevel;
            $log_data = array(
                'title' => $title,
                'code' => $code,
                'type' => $type,
                'description' => $description,
                'dangerousLevel' => $dangerousLevel,
                'datetime' => $real_time
            );
            $this->code = $code;
            
            $this->createData($log_data,false);
            
            return $log_data;
        }

        

        protected function saveLogToSingleCode() {

        }

    }
?>
