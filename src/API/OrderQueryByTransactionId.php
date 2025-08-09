<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

class OrderQueryByTransactionId
{
    /**
     * @var string
     */
    protected $domain = "https://api.mch.weixin.qq.com";

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $path = '/v3/pay/transactions/id/';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $transactionsId;

    public function __construct(array $config, $transactionsId)
    {


        $this->config = new Config($config);

        $this->url = $this->domain . $this->path . $transactionsId . '?mchid=' . $this->config->getMerchantId();

        $this->transactionsId = $transactionsId;
    }

    public function getOrderDetail()
    {
        $http = new HttpClient();
        $auth = new Auth('GET',$this->path . $this->transactionsId . '?mchid=' . $this->config->getMerchantId(), $this->config);

        $header[] = $auth->getSignHeader();

        dump($http->get($this->url,$header));
    }
}