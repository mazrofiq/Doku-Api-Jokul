<?php
namespace DOKU;
require_once('DOKU/Service/BcaVa.php');
require_once('DOKU/Service/CreditCard.php');
require_once('DOKU/Service/MandiriVa.php');
require_once('DOKU/Service/JokulCheckout.php');
require_once('DOKU/Service/OVO.php');

use DOKU\Service\VirtualAccount;

use DOKU\Service\MandiriVa;

use DOKU\Service\DokuVa;

use DOKU\Service\BcaVa;

use DOKU\Service\BsiVa;

use DOKU\Service\CreditCard;

use DOKU\Service\JokulCheckout;

use DOKU\Service\OVO;

class Client
{
    /**
     * @var array
     */
    private $config = array();

    public function isProduction($value)
    {
        $this->config['environment'] = $value;
    }

    public function setClientID($clientID)
    {
        $this->config['client_id'] = $clientID;
    }

    public function setSharedKey($key)
    {
        $this->config['shared_key'] = $key;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function generateJC($params)
    {
        $this->config = $this->getConfig();
        // var_dump($this->config); die;
        //$this->config = $this->getConfig();
        return JokulCheckout::generated($this->config, $params);
    }

    public function generateCrediCard($params)
    {
        // var_dump($this->config); die;
        // $this->config = $this->getConfig();
        return CreditCard::generated($this->config, $params);
    }

    public function generateMandiriVa($params)
    {
        $this->config = $this->getConfig();
        return MandiriVa::generated($this->config, $params);
    }


    public function generateOvo($params)
    {
        $this->config = $this->getConfig();
        return OVO::generated($this->config, $params);
    }

    public function generateDokuVa($params)
    {
        $this->config = $this->getConfig();
        return DokuVa::generated($this->config, $params);
    }

    public function generateBsiVa($params)
    {
        $this->config = $this->getConfig();
        return BsiVa::generated($this->config, $params);
    }

    public function generateBcaVa($params)
    {
        $this->config = $this->getConfig();
        return BcaVa::generated($this->config, $params);
    }
}
