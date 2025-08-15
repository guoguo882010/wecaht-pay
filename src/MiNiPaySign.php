<?php

namespace RSHDSDK\WechatPay;

use Exception;

/**
 * 小程序支付签名生成
 *
 * https://pay.weixin.qq.com/doc/v3/merchant/4012365341
 */
class MiNiPaySign
{
    /**
     * 小程序 app id
     * @var string
     */
    protected $appId;

    /**
     * 预支付订单号
     * @var string
     */
    protected $prepayId;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $random;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param string $appId
     * @param string $prepayId
     * @param Config $config
     * @throws Exception
     */
    public function __construct(string $appId, string $prepayId, Config $config)
    {
        if (empty($appId) || empty($prepayId)) {
            throw new Exception('参数不能为空');
        }

        $this->config = $config;

        $this->appId = $appId;

        $this->prepayId = 'prepay_id=' . $prepayId;

        $this->timestamp = \time();

        $this->random = Helper::generateRandomHexString();
    }

    /**
     * @return string
     */
    protected function getJoinSignStr()
    {
        return $this->appId . "\n" .
            $this->timestamp . "\n" .
            $this->random . "\n" .
            $this->prepayId . "\n";
    }

    /**
     * @return array
     */
    public function getSing()
    {
        return [
            'timeStamp' => $this->timestamp,
            'nonceStr'  => $this->random,
            'package'   => $this->prepayId,
            'signType'  => 'RSA',
            'paySign'   => Helper::generateSign($this->getJoinSignStr(), $this->config->getPrivateKey()),
        ];
    }
}