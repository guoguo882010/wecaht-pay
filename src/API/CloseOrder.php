<?php

namespace RSHDSDK\WechatPay\API;

use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

/**
 * 关闭订单
 * 文档
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791901
 */
class CloseOrder extends API
{
    protected $path = '/v3/pay/transactions/out-trade-no/%s/close';

    public function __construct(Config $config, string $out_trade_no)
    {
        $this->path = sprintf($this->path, $out_trade_no);

        $this->requestUrl = $this->wechatPayDomain . $this->path;

        $this->wechatPayConfig = $config;
    }

    public function requestClose()
    {
        $body = [
            'mchid' => $this->wechatPayConfig->getMerchantId(),
        ];

        $http = new HttpClient();
        $auth = new Auth('POST',$this->path, $this->wechatPayConfig, $body);

        $header[] = $auth->getSignHeader();

        $http->post($this->requestUrl, $body,$header);
    }
}