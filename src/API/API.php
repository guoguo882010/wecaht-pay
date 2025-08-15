<?php

namespace RSHDSDK\WechatPay\API;

use Exception;
use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

abstract class API
{
    /**
     * @var string
     */
    protected $wechatPayDomain = "https://api.mch.weixin.qq.com";

    /**
     * @var Config
     */
    protected $wechatPayConfig;

    /**
     * @var HttpClient
     */
    protected $http;

    /**
     * @param Config $config
     * @throws Exception
     */
    public function __construct(Config $config)
    {
        $this->wechatPayConfig = $config;

        $this->http = new HttpClient();
    }

    /**
     * @param string $path
     * @return string
     * @throws Exception
     */
    protected function getGetSignHeader(string $path)
    {
        $auth = new Auth('GET', $path, $this->wechatPayConfig);

        return $auth->getSignHeader();
    }

    /**
     * @param string $path
     * @param array $body post数据
     * @return string
     * @throws Exception
     */
    protected function getPostSignHeader(string $path, array $body)
    {
        $auth = new Auth('POST', $path, $this->wechatPayConfig, $body);

        return $auth->getSignHeader();
    }

    /**
     * @return string
     */
    protected function getRequestUrl()
    {
        return $this->wechatPayDomain . $this->getPath();
    }

    abstract protected function getPath();
}