<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

class OrderQueryByOutTradeNo
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
    protected $path = '/v3/pay/transactions/out-trade-no/';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $outTradeNo;

    public function __construct(array $config, $outTradeNo)
    {


        $this->config = new Config($config);

        $this->url = $this->domain . $this->path . $outTradeNo . '?mchid=' . $this->config->getMerchantId();

        $this->outTradeNo = $outTradeNo;
    }

    public function getOrderDetail()
    {
        $http = new HttpClient();
        $auth = new Auth('GET',$this->path . $this->outTradeNo . '?mchid=' . $this->config->getMerchantId(), $this->config);

        $header[] = $auth->getSignHeader();

        dump($http->get($this->url,$header));
    }
}