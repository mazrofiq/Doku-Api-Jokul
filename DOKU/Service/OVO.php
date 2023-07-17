<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGenerator;

class OVO
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/ovo-emoney/v1/payment';
        $params['check_sum'] = hash('sha256',$params['amount'].$config['client_id'].$params['invoiceNumber'].$params['ovo_id'].$config['shared_key']);
        return PaycodeGenerator::post($config, $params);
    }
}
