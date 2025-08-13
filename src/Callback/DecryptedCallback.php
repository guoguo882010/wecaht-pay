<?php

namespace RSHDSDK\WechatPay\Callback;

use RSHDSDK\WechatPay\Config;
use Exception;

class DecryptedCallback
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var CallbackData
     */
    protected $callbackData;

    /**
     * @param Config $config
     * @param CallbackData $callback_data
     * @throws Exception
     */
    public function __construct(Config $config, CallbackData $callback_data)
    {
        $this->config = $config;

        $this->callbackData = $callback_data;

        $this->verify();
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function verify()
    {
        if (empty($this->config->getSecretKey())) {
            throw new Exception('API V3 秘钥不能为空');
        }

        if (empty($this->callbackData->getCiphertext())) {
            throw new Exception('ciphertext 解密数据不能为空');
        }

        if (empty($this->callbackData->getNonce())) {
            throw new Exception('nonce 解密随机串不能为空');
        }
    }

    /**
     * 获取解密数据
     * @return array
     * @throws Exception
     */
    public function getDecryptedData()
    {
        $aes = new AesUtil($this->config->getSecretKey());
        $json = $aes->decryptToString($this->callbackData->getAssociatedData(),
            $this->callbackData->getNonce(), $this->callbackData->getCiphertext());

        return json_decode($json, true);
    }
}