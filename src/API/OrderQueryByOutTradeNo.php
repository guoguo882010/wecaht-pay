<?php

namespace RSHDSDK\WechatPay\API;

use Exception;

/**
 * 商户订单号查询订单
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791900
 */
class OrderQueryByOutTradeNo extends API
{
    /**
     * @var string
     */
    protected $path = '/v3/pay/transactions/out-trade-no/%s?mchid=%s';

    /**
     * @var string
     */
    protected $outTradeNo;

    /**
     * @param string $outTradeNo
     * @return array
     * @throws Exception
     */
    public function getOrderDetail(string $outTradeNo)
    {
        $this->outTradeNo = $outTradeNo;

        $header[] = $this->getGetSignHeader($this->getPath());

        return $this->http->get($this->getRequestUrl(), $header);
    }

    protected function getPath()
    {
        return sprintf($this->path, $this->outTradeNo, $this->wechatPayConfig->getMerchantId());
    }
}