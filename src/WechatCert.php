<?php

namespace RSHDSDK\WechatPay;

use Exception;

class WechatCert
{
    /**
     * @var array
     */
    protected $certInfo;

    /**
     * @var string
     */
    protected $certStr;

    /**
     * @param string $cert 证书字符串 或 证书文件路径
     * @throws Exception
     */
    public function __construct($cert)
    {
        if (empty($cert)) {
            throw new Exception('证书不能为空');
        }

        // 如果传入的是文件路径，则读取文件内容
        if (strpos($cert, '-----BEGIN CERTIFICATE-----') === false && is_file($cert)) {
            $this->certStr = file_get_contents($cert);
        } else {
            $this->certStr = $cert;
        }

        $this->certInfo = openssl_x509_parse($this->certStr);
    }

    /**
     * 获取证书字符串
     * @return string
     */
    public function getCertStr()
    {
        return $this->certStr;
    }

    /**
     * 证书序列号
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->certInfo['serialNumberHex'] ?? '';
    }

    /**
     * 商户id
     * @return string
     */
    public function getMerchantId()
    {
        return $this->certInfo['subject']['CN'] ?? '';
    }

    /**
     * 商户名称
     * @return string
     */
    public function getMerchantName()
    {
        return $this->certInfo['subject']['OU'] ?? '';
    }
}