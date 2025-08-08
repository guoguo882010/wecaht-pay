<?php
namespace RSHDSDK\WechatPay;

class WechatPay
{
    protected $config;

    public function __construct($config)
    {
        if (empty($config)) {
            throw new \Exception('配置文件不能为空');
        }

        $this->config = $config;
    }

    public function miniPay()
    {

    }
}