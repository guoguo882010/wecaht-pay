<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

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
    protected $path = '/v3/refund/domestic/refunds/';

    /**
     * @var string
     */
    protected $outTradeNo;

    public function __construct(Config $config, $outTradeNo)
    {
        $this->wechatPayConfig = $config;

        $this->requestUrl = $this->wechatPayDomain . $this->path . $outTradeNo;

        $this->outTradeNo = $outTradeNo;
    }

    public function getRefundDetail()
    {
        $http = new HttpClient();
        $auth = new Auth('GET',$this->path . $this->outTradeNo, $this->wechatPayConfig);

        $header[] = $auth->getSignHeader();

        return $http->get($this->requestUrl,$header);
    }
}