<?php
namespace RSHDSDK\WechatPay;

use Exception;
use RSHDSDK\WechatPay\API\CloseOrder;
use RSHDSDK\WechatPay\API\JSAPI;
use RSHDSDK\WechatPay\API\OrderQueryByOutTradeNo;
use RSHDSDK\WechatPay\API\OrderQueryByTransactionId;
use RSHDSDK\WechatPay\API\QueryRefundByOutRefundNo;
use RSHDSDK\WechatPay\API\Refund;
use RSHDSDK\WechatPay\Callback\CallbackData;
use RSHDSDK\WechatPay\Callback\PaymentCallback;
use RSHDSDK\WechatPay\Callback\RefundCallback;

class WechatPay
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        if (empty($config)) {
            throw new Exception('配置文件不能为空');
        }

        $this->config = new Config($config);
    }

    /**
     * 调起小程序支付
     * @param string $appId
     * @param array $body
     * @return array
     * @throws Exception
     */
    public function miniPayJSAPI(string $appId, array $body)
    {
        $prepayId = (new JSAPI($this->config))->getPrepayId($body);

        return (new MiNiPaySign($appId, $prepayId, $this->config))->getSing();
    }

    /**
     * 申请退款
     * @param array $body
     * @return array
     * @throws Exception
     */
    public function refund(array $body)
    {
        return (new Refund($this->config))->requestRefund($body);
    }

    /**
     * 根据商户订单号查询订单
     * @param string $outTradeNo
     * @return array
     * @throws Exception
     */
    public function OrderQueryByOutTradeNo(string $outTradeNo)
    {
        return (new OrderQueryByOutTradeNo($this->config))->getOrderDetail($outTradeNo);
    }

    /**
     * 根据微信订单号查询订单
     * @param string $transactionsId
     * @return array
     * @throws Exception
     */
    public function OrderQueryByTransactionId(string $transactionsId)
    {
        return (new OrderQueryByTransactionId($this->config))->getOrderDetail($transactionsId);
    }

    /**
     * 根据商户订单号查询退款状态
     * @param string $outTradeNo
     * @return array
     * @throws Exception
     */
    public function QueryRefundByOutRefundNo(string $outTradeNo)
    {
        return (new QueryRefundByOutRefundNo($this->config))->getRefundDetail($outTradeNo);
    }

    /**
     * 根据商户订单号关闭订单
     * @param string $outTradeNo
     * @return void
     * @throws Exception
     */
    public function CloseOrder(string $outTradeNo)
    {
        (new CloseOrder($this->config))->requestClose($outTradeNo);
    }

    /**
     * 支付回调获取解密
     * @param array $callbackData
     * @return array
     * @throws Exception
     */
    public function PaymentCallback(array $callbackData)
    {
        return PaymentCallback::getDecryptedData($this->config, new CallbackData($callbackData));
    }

    /**
     * 退款回调获取解密数据
     * @param array $callbackData
     * @return array
     * @throws Exception
     */
    public function RefundCallback(array $callbackData)
    {
        return RefundCallback::getDecryptedData($this->config, new CallbackData($callbackData));
    }
}