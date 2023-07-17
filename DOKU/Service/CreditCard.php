<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGenerator;

class CreditCard
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/credit-card/v1/payment-page';
        $params['callback_url'] = 'localhost/success';
        return PaycodeGenerator::post($config, $params);
    }
}
