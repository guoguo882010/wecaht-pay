<?php

namespace RSHDSDK\WechatPay;

use Exception;

class Helper
{
    /**
     * @param string $data 数据字符串
     * @param string $privateKey 私钥字符串
     * @return string
     */
    public static function generateSign($data, $privateKey)
    {
        // 生成签名
        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    /**
     * 生成一个请求随机串，例 BE7A9019098DC4FD998AFCAB84897622
     * @return string
     * @throws Exception
     */
    public static function generateRandomHexString($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            /** @phpstan-ignore-next-line */
            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}