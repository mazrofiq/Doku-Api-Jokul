<?php

namespace DOKU\Common;
require_once('DOKU/Common/Config.php');
require_once('DOKU/Common/Utils.php');

use DOKU\Common\Config;

use DOKU\Common\Utils;

class PaycodeGenerator
{

    public static function post($config, $params)
    {
        $header = array();
        if($params['targetPath'] == '/credit-card/v1/payment-page'){

            $data = array(
                "order" => array(
                    "invoice_number" => $params['invoiceNumber'],
                ),
                "customer" => array(
                    "name" => trim($params['customerName']),
                    "email" => $params['customerEmail']
                )
            );

        }elseif($params['targetPath'] == '/ovo-emoney/v1/payment'){
            $data = array(
                "client" => array(
                    "id" => $config['client_id'],
                ),
                "order" => array(
                    "invoice_number" => $params['invoiceNumber'],
                    "amount" => $params['amount']
                ),
                "ovo_info" => array(
                    "ovo_id" => $params['ovo_id']
                ),
                "security" => array(
                    "check_sum" => $params['check_sum']
                )
            );
        }else{
            $data = array(
                "order" => array(
                    "invoice_number" => $params['invoiceNumber'],
                ),
                "virtual_account_info" => array(
                    "expired_time" => $params['expiryTime'],
                    "reusable_status" => $params['reusableStatus'],
                    "info1" => $params['info1'],
                    "info2" => $params['info2'],
                    "info3" => $params['info3'],
                ),
                "customer" => array(
                    "name" => trim($params['customerName']),
                    "email" => $params['customerEmail']
                ),
                "additional_info" => array(
                    "integration" => array(
                        "name" => "php-library",
                        "version" => "2.1.0"
                    ),
                    "doku_wallet_notify_url" => "https://dw-notify.free.beeceptor.com"
                )
            );
        }
        

        if (isset($params['amount'])) {
            $data['order']["amount"] = $params['amount'];
        } else {
            $data['order']["min_amount"] = $params['min_amount'];
            $data['order']["max_amount"] = $params['min_amount'];
        }

        if (isset($params['payment_due_date'])) {
            $data['payment']["payment_due_date"] = $params['payment_due_date'];
        }
        $test = rand(1, 100000); 
        $requestId = "test".$test;
        $dateTime = gmdate("Y-m-d H:i:s");
        $dateTime = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($dateTime, 0, 19) . "Z";

        $getUrl = Config::getBaseUrl($config['environment']);

        $targetPath = $params['targetPath'];
        $url = $getUrl . $targetPath;

        $header['Client-Id'] = $config['client_id'];
        $header['Request-Id'] = $requestId;
        $header['Request-Timestamp'] = $dateTimeFinal;
        $signature = Utils::generateSignature($header, $targetPath, json_encode($data), $config['shared_key']);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Signature:' . $signature,
            'Request-Id:' . $requestId,
            'Client-Id:' . $config['client_id'],
            'Request-Timestamp:' . $dateTimeFinal,
            'Request-Target:' . $targetPath,

        ));

        $responseJson = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if (is_string($responseJson) && $httpcode == 200) {
            return json_decode($responseJson, true);
            //echo $responseJson;
        } else {
            echo $responseJson;
            return null;
        }
    }
}
