<?php

namespace RSHDSDK\WechatPay\API;

use Exception;

/**
 * 提交退款申请后，推荐每间隔1分钟调用该接口查询一次退款状态，若超过5分钟仍是退款处理中状态，
 * 建议开始逐步衰减查询频率(比如之后间隔5分钟、10分钟、20分钟、30分钟……查询一次)。
 *
 * 文档
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791904
 */
class QueryRefundByOutRefundNo extends API
{
    /**
     * @var string
     */
    protected $path = '/v3/refund/domestic/refunds/%s';

    /**
     * @var string
     */
    protected $outTradeNo;

    /**
     * @param string $outTradeNo
     * @return array
     * @throws Exception
     */
    public function getRefundDetail(string $outTradeNo)
    {
        $this->outTradeNo = $outTradeNo;

        $header[] = $this->getGetSignHeader($this->getPath());

        return $this->http->get($this->getRequestUrl(), $header);
    }

    protected function getPath()
    {
        return sprintf($this->path, $this->outTradeNo);
    }
}