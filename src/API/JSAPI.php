<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

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
        $a = new HttpClient();
        $b = new Auth('POST',$this->path, $this->config, $this->body);
        dump($b->getJoinStr());
        dump($b->getSignBase64());
        $header[] = $b->getSignHeader();

        dump($a->post($this->url, $this->body,$header));
    }
}