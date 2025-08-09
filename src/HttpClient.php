<?php

namespace RSHDSDK\WechatPay;

use Exception;

class HttpClient
{
    /**
     * 发送HTTP请求
     * @param string $method 请求方法 GET/POST/PUT/DELETE等
     * @param string $url 完整的请求URL
     * @param array|null $body 请求体数据，GET请求可传null
     * @param array $headers 自定义请求头
     * @param array $options 额外的cURL选项
     * @return array|string 返回响应数据(自动尝试JSON解码)
     * @throws Exception
     */
    public function request($method, $url, $body = null, array $headers = [], array $options = [])
    {
        // 准备请求体，这里必须要和生成签名的时候一模一样
        $bodyStr = $body ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '';

        // 设置默认头
        $defaultHeaders = [
            'Accept: application/json',
            'User-Agent: PHP/' . PHP_VERSION
        ];

        // 如果是POST/PUT且没有指定Content-Type，自动添加
        if (($method === 'POST' || $method === 'PUT') &&
            !$this->hasHeader('Content-Type', $headers)) {
            $defaultHeaders[] = 'Content-Type: application/json';
        }

        $headers = array_merge($defaultHeaders, $headers);

        // 初始化cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/curl_ca_cert.pem');

        // 设置自定义cURL选项
        foreach ($options as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        // 设置请求方法
        if ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($bodyStr) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyStr);
            }
        }

        // 执行请求
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("cURL请求失败: " . $error);
        }

        // 处理响应
        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $result = $response;
        }

        if ($httpCode >= 400) {
            $errorMsg = is_array($result) ? (isset($result['message']) ? $result['message'] : $response) : $response;
            throw new Exception("API请求失败({$httpCode}): " . $errorMsg);
        }

        return $result;
    }

    /**
     * GET请求快捷方法
     * @param string $url 请求URL
     * @param array $headers 自定义请求头
     * @param array $options 额外的cURL选项
     * @return array|string
     * @throws Exception
     */
    public function get($url, array $headers = [], array $options = [])
    {
        return $this->request('GET', $url, null, $headers, $options);
    }

    /**
     * POST请求快捷方法
     * @param string $url 请求URL
     * @param array $body 请求体数据
     * @param array $headers 自定义请求头
     * @param array $options 额外的cURL选项
     * @return array|string
     * @throws Exception
     */
    public function post($url, array $body, array $headers = [], array $options = [])
    {
        return $this->request('POST', $url, $body, $headers, $options);
    }

    /**
     * 检查头是否存在
     * @param string $needle
     * @param array $headers
     * @return bool
     */
    private function hasHeader($needle, array $headers)
    {
        $needle = strtolower($needle);
        foreach ($headers as $header) {
            if (stripos($header, $needle) === 0) {
                return true;
            }
        }
        return false;
    }
}