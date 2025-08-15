<?php

namespace RSHDSDK\WechatPay\API;

use Exception;

/**
 * 关闭订单
 * 文档
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791901
 */
class CloseOrder extends API
{
    /**
     * @var string
     */
    protected $path = '/v3/pay/transactions/out-trade-no/%s/close';

    /**
     * 商户订单号
     * @var string
     */
    protected $outTradeNo;

    /**
     * @param string $out_trade_no
     * @return void
     * @throws Exception
     */
    public function requestClose(string $out_trade_no)
    {
        $this->outTradeNo = $out_trade_no;

        $body = [
            'mchid' => $this->wechatPayConfig->getMerchantId(),
        ];

        $header[] = $this->getPostSignHeader($this->getPath(), $body);

        $this->http->post($this->getRequestUrl(), $body, $header);
    }

    protected function getPath()
    {
        return sprintf($this->path, $this->outTradeNo);
    }
}