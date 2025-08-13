<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Config;

abstract class API
{
    /**
     * @var string
     */
    protected $requestUrl;

    /**
     * @var string
     */
    protected $wechatPayDomain = "https://api.mch.weixin.qq.com";

    /**
     * @var Config
     */
    protected $wechatPayConfig;
}