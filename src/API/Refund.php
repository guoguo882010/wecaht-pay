<?php

namespace RSHDSDK\WechatPay\API;

use Exception;
use RSHDSDK\WechatPay\Auth;
use RSHDSDK\WechatPay\Config;
use RSHDSDK\WechatPay\HttpClient;

/**
 * 微信退款
 * 文档地址：
 * https://pay.weixin.qq.com/doc/v3/merchant/4012791903
 */
class Refund extends API
{
    /**
     * @var string
     */
    protected $path = '/v3/refund/domestic/refunds';

    /**
     * @var array
     */
    protected $body;

    /**
     * @param Config $config
     * @param array $body
     * @throws Exception
     */
    public function __construct(Config $config, array $body)
    {
        $this->requestUrl = $this->wechatPayDomain . $this->path;

        $this->wechatPayConfig = $config;

        $this->body = $body;

        $this->verify();
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function verify()
    {
        $transaction_id = $this->body['transaction_id'] ?? '';
        $out_trade_no = $this->body['out_trade_no'] ?? '';
        $out_refund_no = $this->body['out_refund_no'] ?? '';
        $total = $this->body['amount']['total'] ?? '';
        $currency = $this->body['amount']['currency'] ?? '';

        if (empty($transaction_id) && empty($out_trade_no)) {
            throw new Exception('transaction_id 和 out_trade_no 必须二选一');
        }

        if (empty($out_refund_no)) {
            throw new Exception('out_refund_no 退款订单号不能为空');
        }

        if (empty($total)) {
            throw new Exception('total 退款金额不能为空');
        }

        if (is_int($total)) {
            throw new Exception('total 退款金额不是整数');
        }

        if (empty($currency)) {
            $this->body['amount']['currency'] = 'CNY';
        }
    }

    public function requestRefund()
    {
        $http = new HttpClient();
        $auth = new Auth('POST',$this->path, $this->wechatPayConfig, $this->body);

        $header[] = $auth->getSignHeader();

        return $http->post($this->requestUrl, $this->body,$header);
    }
}