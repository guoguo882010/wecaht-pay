<?php

namespace RSHDSDK\WechatPay\API;

use Exception;

/**
 * 微信支付订单号查询订单
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791899
 */
class OrderQueryByTransactionId extends API
{
    /**
     * @var string
     */
    protected $path = '/v3/pay/transactions/id/%s?mchid=%s';

    /**
     * @var string
     */
    protected $transactionsId;

    /**
     * @param string $transactionsId
     * @return array
     * @throws Exception
     */
    public function getOrderDetail(string $transactionsId)
    {
        $this->transactionsId = $transactionsId;

        $header[] = $this->getGetSignHeader($this->getPath());

        return $this->http->get($this->getRequestUrl(), $header);
    }

    protected function getPath()
    {
        return sprintf($this->path, $this->transactionsId, $this->wechatPayConfig->getMerchantId());
    }
}