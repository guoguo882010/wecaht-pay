<?php

namespace RSHDSDK\WechatPay\Callback;

use Exception;

class CallbackData
{
    /**
     * @var array
     */
    protected $callbackData;

    /**
     * @param array $callbackData 回调数据
     * @throws Exception
     */
    public function __construct(array $callbackData)
    {
        if (empty($callbackData)) {
            throw new Exception('回调数据不能为空');
        }

        $this->callbackData = $callbackData;
    }

    /**
     * 回调通知的唯一编号
     * @return string
     */
    public function getId()
    {
        return $this->callbackData['id'] ?? '';
    }

    /**
     * 本次回调通知创建的时间
     * @return string
     */
    public function getCreateTime()
    {
        return $this->callbackData['create_time'] ?? '';
    }

    /**
     * 通知的资源数据类型，退款成功通知为encrypt-resource
     * @return string
     */
    public function getResourceType()
    {
        return $this->callbackData['resource_type'] ?? '';
    }

    /**
     * 退款回调通知的类型
     * REFUND.SUCCESS：退款成功通知
     * REFUND.ABNORMAL：退款异常通知
     * REFUND.CLOSED：退款关闭通知
     * @return string
     */
    public function getEventType()
    {
        return $this->callbackData['event_type'] ?? '';
    }

    /**
     * 微信支付对回调内容的摘要备注
     * @return string
     */
    public function getSummary()
    {
        return $this->callbackData['summary'] ?? '';
    }

    /**
     * 回调数据密文的加密算法类型，目前为AEAD_AES_256_GCM，开发者需要使用同样类型的数据进行解密
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->callbackData['resource']['algorithm'] ?? '';
    }

    /**
     * 加密前的对象类型，为refund。
     * @return string
     */
    public function getOriginalType()
    {
        return $this->callbackData['resource']['original_type'] ?? '';
    }

    /**
     * Base64编码后的回调数据密文，商户需Base64解码并使用APIV3密钥解密
     * @return mixed|string
     */
    public function getCiphertext()
    {
        return $this->callbackData['resource']['ciphertext'] ?? '';
    }

    /**
     * 参与解密的随机串。
     * @return string
     */
    public function getNonce()
    {
        return $this->callbackData['resource']['nonce'] ?? '';
    }

    /**
     * 参与解密的附加数据，该值可能为空。
     * @return string
     */
    public function getAssociatedData()
    {
        return $this->callbackData['resource']['associated_data'] ?? '';
    }
}