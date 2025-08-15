<?php

namespace RSHDSDK\WechatPay\API;

use Exception;

/**
 * JSAPI支付，提供商户在微信客户端内部浏览器网页中使用微信支付收款的能力。
 * 在微信内使用浏览器访问或者小程序访问支付页面，使用jsapi调起支付
 *
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791897
 */
class JSAPI extends API
{
    /**
     * @var string
     */
    protected $path = '/v3/pay/transactions/jsapi';

    /**
     * @param array $body
     * @return array|string
     * @throws Exception
     */
    public function getPrepayId(array $body)
    {
        $header[] = $this->getPostSignHeader($this->getPath(), $body);

        $result = $this->http->post($this->getRequestUrl(), $body, $header);

        return $result['prepay_id'] ?? '';
    }

    protected function getPath()
    {
        return $this->path;
    }
}