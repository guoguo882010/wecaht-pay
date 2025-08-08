<?php

namespace RSHDSDK\WechatPay;

use Exception;

class Auth
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $random;

    /**
     * @var array
     */
    protected $body;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param string $method
     * @param string $path
     * @param Config $config
     * @param array $body
     * @throws Exception
     */
    public function __construct($method, $path, Config $config, $body = [])
    {
        $this->method = $method;

        $this->path = $path;

        //$this->random = '593BEC0C930BF1AFEB40B4A08C8FB242';
        $this->random = Helper::generateRandomHexString();

        //$this->timestamp = 1554208460;
        $this->timestamp = \time();

        $this->body = $body;

        $this->config = $config;
    }

    public function getJoinStr()
    {
        //双引号才是真正的换行符
        $str = strtoupper($this->method) . "\n".
            $this->path . "\n".
            $this->timestamp . "\n".
            $this->random . "\n";

        if (empty($this->body)) {
            $str .= "\n";
        } else {
            $str .= json_encode($this->body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        }

        return $str;
    }

    /**
     * @return string
     */
    public function getSignBase64()
    {
        return Helper::generateSign($this->getJoinStr(), $this->config->getPrivateKey());
    }

    /**
     * 获取微信认证请求头
     * @return string
     * @throws Exception
     */
    public function getSignHeader()
    {
        $herder = 'Authorization: ';
        $herder .= 'WECHATPAY2-SHA256-RSA2048 ';
        $herder .= 'mchid="' . $this->config->getMerchantId() . '",';
        $herder .= 'nonce_str="' . $this->random . '",';
        $herder .= 'signature="' . $this->getSignBase64() . '",';
        $herder .= 'timestamp="' . $this->timestamp . '",';
        $herder .= 'serial_no="'. $this->config->getCert()->getSerialNumber() .'"';
        //$herder .= 'serial_no="408B07E79B8269FEC3D5D3E6AB8ED163A6A380DB"';

        return $herder;
    }
}