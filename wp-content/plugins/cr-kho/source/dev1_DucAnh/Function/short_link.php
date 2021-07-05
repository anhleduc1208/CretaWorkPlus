<?php 
    function post($url, $data){
        $ch = curl_init($url);

        // Setup request to send json via POST
        $payload = json_encode($data);
        
        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        
        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        
        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute the POST request
        $result = curl_exec($ch);
        
        // Close cURL resource
        curl_close($ch);
        return $result;
    }
    function general_short_link($long){
        $general = json_decode(post("https://creta.link/general", array()), true);
        $ret = json_decode(post("https://creta.link", array(
            "long"=> $long,
            "short" => $general["short"]
        )), true);
        if($ret["data"] == "OK"){
            return "https://creta.link/".$general["short"];
        } else {
            return "";
        }
    }
?>