<?php

namespace RSHDSDK\WechatPay\Callback;

use Exception;
use RSHDSDK\WechatPay\Config;

/**
 * 支付成功通知回调
 * 文档
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791902
 */
class PaymentCallback
{
    /**
     * @param Config $config
     * @param CallbackData $callbackData
     * @return array
     * @throws Exception
     */
    public static function getDecryptedData(Config $config, CallbackData $callbackData)
    {
        return (new DecryptedCallback($config, $callbackData))->getDecryptedData();
    }
}