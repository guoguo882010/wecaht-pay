<?php

namespace RSHDSDK\WechatPay;

use Exception;

class Config
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     * @throws Exception
     */
    public function __construct($config)
    {
        if (empty($config)) {
            throw new Exception('配置文件不能为空');
        }

        $this->config = $config;
    }

    /**
     * 获取商户号
     * @return string
     */
    public function getMerchantId()
    {
        return $this->config['mch_id'] ?? '';
    }

    /**
     * 获取 api 秘钥
     * @return string
     */
    public function getSecretKey()
    {
        return $this->config['secret_key'] ?? '';
    }

    /**
     * 获取私钥字符串
     * @return string
     */
    public function getPrivateKey()
    {
        $key = $this->config['private_key'] ?? '';

        if (strpos($key, '-----BEGIN PRIVATE KEY-----') === false && is_file($key)) {
            $str = file_get_contents($key);
        } else {
            $str = $key;
        }

        return $str;
    }

    /**
     * 获取证书类
     * @return WechatCert
     * @throws Exception
     */
    public function getCert()
    {
        $cert = $this->config['certificate'] ?? '';
        if (strpos($cert, '-----BEGIN CERTIFICATE-----') === false && is_file($cert)) {
            $str = file_get_contents($cert);
        } else {
            $str = $cert;
        }

        $c = new WechatCert($str);

        return $c;
    }
}