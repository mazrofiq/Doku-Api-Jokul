<?php

namespace DOKU\Service;
require_once('DOKU/Common/PaycodeGenerator.php');

use DOKU\Common\PaycodeGenerator;

class JokulCheckout
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/checkout/v1/payment';
        $params['callback_url'] = 'localhost/jokul';
        $params['payment_due_date'] = 180;
        return PaycodeGenerator::post($config, $params);
    }
}
