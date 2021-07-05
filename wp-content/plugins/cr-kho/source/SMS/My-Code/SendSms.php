<?php

include_once '../../src/Playsms/Webservices.php';
function sendSMS($phone,$msg) {
    error_reporting(E_ALL ^ E_NOTICE);

    $ws = new Playsms\Webservices();

    $ws->url = 'http://node.creta.work/playsms/index.php?app=ws';
    $ws->username = 'admin';
    $ws->password = 'asrkpVg10!';
    // echo '</br>';
    // echo "getToken";
    // echo '</br>';
    $ws->getToken();
    // print_r($ws->getData());

    // echo '</br>';

    if ($ws->getStatus()) {

        // echo "Send SMS:\n";
        //Transferido para a propria API WEBSERVICE.PHP
        //$ws->token = $ws->getData()->token;
        $ws->to = $phone;
        $ws->msg = $msg;
        $ws->sendSms();
        // echo $phone . ': '. $msg;
        //print_r($ws->getData());

    } else {
        // echo "Error code: " . $ws->getError() . "</br>";
        // echo "Error string: " . $ws->getErrorString() . "</br>";
    }

    //echo "\n";
    return;
}

function getCredit() {
    error_reporting(E_ALL ^ E_NOTICE);

    $ws = new Playsms\Webservices();

    $ws->url = 'http://node.creta.work/playsms/index.php?app=ws';
    $ws->username = 'admin';
    $ws->password = 'asrkpVg10!';

    echo "\ngetToken\n";
    $ws->getToken();
    print_r($ws->getData());

    echo "\n";

    if ($ws->getStatus()) {

        $ws->token = $ws->getData()->token;

        echo "Credit\n\n";
        $ws->getCredit();
        if ($ws->getStatus()) {
            $credit = $ws->getData()->credit;
            echo "Remaining credit for user " . $ws->username . ": " . $credit . "\n";
        } else {
            echo "Unable to check user credit\n";
        }

    } else {
        echo "Error code: " . $ws->getError() . "\n";
        echo "Error string: " . $ws->getErrorString() . "\n";
    }

    echo "\n";
    return $credit;
}
