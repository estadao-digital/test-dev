<?php

namespace App\Services;

use \DateTime;
use \Exception;

/**
 * This class contains basic set of methods for handling JSON Web Tokens (JWT).
 */
class JWTSimple
{
    /**
     * Encode JWT Token
     *
     * @return string
     * @throws Exception
     */
    public function encode()
    {
        $header = $this->base64EncodeURL(json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256',
        ]));
        $payload = $this->base64EncodeURL(json_encode([
            'exp' => (new DateTime("now"))->getTimestamp(),
            'uid' => rand(1, 100),
        ]));
        $key = env('APP_KEY', 'ab123');
        $sing = $this->base64EncodeURL(hash_hmac('sha256', "{$header}.{$payload}", $key, true));
        return ("{$header}.{$payload}.{$sing}");
    }

    /**
     * Decode JWT Token
     *
     * @param string $tokenEncoded Encoded token
     *
     * @return array
     *
     * @throws Exception
     */
    public function decode($tokenEncoded)
    {
        list($header, $payload, $sing) = explode('.', $tokenEncoded);

        if (!$header || !$payload || !$sing) {
            throw new Exception('invalid signature', 403);
        }

        return [
            'header' => json_decode($this->base64DecodeURL($header)),
            'payload' => json_decode($this->base64DecodeURL($payload)),
            'sing' => $this->base64DecodeURL($sing),
        ];
    }

    /**
     * Validate JWT Token
     *
     * @param string $tokenEncoded Encoded token
     *
     * @return boolean
     */
    public function validade($tokenEncoded)
    {
        $key = env('APP_KEY', 'ab123');

        list($header, $payload, $sing) = explode('.', $tokenEncoded);

        if (!$header || !$payload || !$sing) {
            return false;
        }

        $verifySing = hash_hmac('sha256', "{$header}.{$payload}", $key, true);
        return hash_equals($this->base64DecodeURL($sing), $verifySing);
    }

    /**
     * Encode Base64 URL
     *
     * @param string $value
     *
     * @return string
     */
    private function base64EncodeURL($value)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($value));
    }

    /**
     * Decode Base64 URL
     *
     * @param string $value
     *
     * @return string
     */
    private function base64DecodeURL($value)
    {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $value));
    }

}
