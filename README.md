# 微信支付

---

**安装**
```shell
composer require guoguo882010/wecaht-pay
```

**使用方法**

```php

$config = [

    //商户号
    'mch_id'      => 1111,
    
    // 商户API证书
    'private_key' => __DIR__ . '/test_key.pem',
    'certificate' => __DIR__ . '/test_cert.pem',
    
    // v3 API 秘钥
    'secret_key'  => 'xxxxx',
];

$pay = new \RSHDSDK\WechatPay\WechatPay($config);

//获取调取小程序支付所需参数
$body = [
    'appid'        => 'wxd333333',
    'mchid'        => '333333',//商户号
    'description'  => 'Image形象店-深圳腾大-QQ公仔',
    'out_trade_no' => '121775250128',//商户订单号
    'notify_url'   => 'https://www.weixin.qq.com/wxpay/pay.php',//回调地址
    'amount'       => [
        'total'    => 100,//金额
        'currency' => 'CNY',//货币固定是CNY
    ],
    'payer'        => [
        'openid' => 'oUpF8uMuAJO_M2pxb1Q9zNjWeS6o'//用户微信openid
    ]
];
$pay->miniPayJSAPI('小程序appid', $body);

//申请退款
$body = [
    //transaction_id 和 out_trade_no 二选一
    'transaction_id' => '微信订单号',
    'out_trade_no'   => '商户订单号',
    'out_refund_no'  => '商户系统内部的退款单号',
    'notify_url'     => '回调地址',
    'amount' => [
            'total'=>100//退款金额
            'currency'=>'CNY'//货币固定是CNY
        ],
];
$pay->refund($body);

//根据商户订单号查询订单
$pay->OrderQueryByOutTradeNo('商户订单号');

//根据微信订单号查询订单
$pay->OrderQueryByTransactionId('微信订单号');

//根据商户订单号查询退款状态
$pay->QueryRefundByOutRefundNo('商户订单号');

//根据商户订单号关闭订单，无返回值
$pay->CloseOrder('商户订单号');

//支付回调获取解密
$pay->PaymentCallback('待解密数据数组');

//退款回调获取解密数据
$pay->RefundCallback('待解密数据数组');
```