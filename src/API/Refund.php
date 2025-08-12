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
class Refund
{
    /**
     * @var string
     */
    protected $domain = "https://api.mch.weixin.qq.com";

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $path = '/v3/refund/domestic/refunds';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var array
     */
    protected $body;

    /**
     * @param array $config
     * @param array $body
     * @throws Exception
     */
    public function __construct(array $config, array $body)
    {
        $this->url = $this->domain . $this->path;

        $this->config = new Config($config);

        $transaction_id = $body['transaction_id'] ?? '';
        $out_trade_no = $body['out_trade_no'] ?? '';
        $out_refund_no = $body['out_refund_no'] ?? '';
        $total = $body['amount']['total'] ?? '';
        $currency = $body['amount']['currency'] ?? '';

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
            $body['amount']['currency'] = 'CNY';
        }

        $this->body = $body;
    }

    public function requestRefund()
    {
        $http = new HttpClient();
        $auth = new Auth('POST',$this->path, $this->config, $this->body);

        $header[] = $auth->getSignHeader();

        dump($http->post($this->url, $this->body,$header));
    }
}