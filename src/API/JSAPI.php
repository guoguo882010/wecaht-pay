<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

/**
 * JSAPI支付，提供商户在微信客户端内部浏览器网页中使用微信支付收款的能力。
 * 在微信内使用浏览器访问或者小程序访问支付页面，使用jsapi调起支付
 */
class JSAPI
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
    protected $path = '/v3/pay/transactions/jsapi';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var array
     */
    protected $body;

    public function __construct(array $config, array $body)
    {
        $this->url = $this->domain . $this->path;

        $this->config = new Config($config);

        $this->body = $body;
    }

    public function getPrepayId()
    {
        $http = new HttpClient();
        $auth = new Auth('POST',$this->path, $this->config, $this->body);

        $header[] = $auth->getSignHeader();

        dump($http->post($this->url, $this->body,$header));
    }
}