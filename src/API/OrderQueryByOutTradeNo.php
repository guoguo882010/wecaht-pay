<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

class OrderQueryByOutTradeNo extends API
{
    /**
     * @var string
     */
    protected $path = '/v3/pay/transactions/out-trade-no/';

    /**
     * @var string
     */
    protected $outTradeNo;

    public function __construct(Config $config, $outTradeNo)
    {
        $this->wechatPayConfig = $config;

        $this->requestUrl = $this->wechatPayDomain . $this->path . $outTradeNo . '?mchid=' . $this->wechatPayConfig->getMerchantId();

        $this->outTradeNo = $outTradeNo;
    }

    public function getOrderDetail()
    {
        $http = new HttpClient();
        $auth = new Auth('GET',$this->path . $this->outTradeNo . '?mchid=' . $this->wechatPayConfig->getMerchantId(), $this->wechatPayConfig);

        $header[] = $auth->getSignHeader();

        return $http->get($this->requestUrl,$header);
    }
}