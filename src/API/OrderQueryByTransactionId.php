<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

class OrderQueryByTransactionId extends API
{
    /**
     * @var string
     */
    protected $path = '/v3/pay/transactions/id/';

    /**
     * @var string
     */
    protected $transactionsId;

    public function __construct(Config $config, $transactionsId)
    {
        $this->wechatPayConfig = $config;

        $this->requestUrl = $this->wechatPayDomain . $this->path . $transactionsId . '?mchid=' . $this->wechatPayConfig->getMerchantId();

        $this->transactionsId = $transactionsId;
    }

    public function getOrderDetail()
    {
        $http = new HttpClient();
        $auth = new Auth('GET',$this->path . $this->transactionsId . '?mchid=' . $this->wechatPayConfig->getMerchantId(), $this->wechatPayConfig);

        $header[] = $auth->getSignHeader();

        return $http->get($this->requestUrl,$header);
    }
}