<?php

namespace RSHDSDK\WechatPay\Callback;

use Exception;
use RSHDSDK\WechatPay\Config;

/**
 * 退款结果回调
 * 文档
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791906
 */
class RefundCallback
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