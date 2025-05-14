<?php

namespace App\Services;

use Codeigniter\Config\Services;

class WinpayService
{
  private $partnerId;
  private $privateKeyPath;
  private $apiUrl;
  private $channelId;

  public function __construct()
  {
    $this->partnerId = env('WINPAY_PARTNER_ID');
    $this->privateKeyPath = ROOTPATH . env('WINPAY_PRIVATE_KEY_PATH');
    $this->apiUrl = env('WINPAY_API_URL');
    $this->channelId = env('WINPAY_CHANNEL_ID');
  }

  public function getChannelId()
  {
    return $this->channelId;
  }

  public function generateSignature($timestamp, $payload)
  {
    $httpMethod = 'POST';
    $endpointUrl = '/v1.0/qr/qr-mpm-generate';
    $minifiedPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);
    $hashedBody = strtolower(bin2hex((hash('sha256', $minifiedPayload))));
    $stringToSign = implode(':', [$httpMethod, $endpointUrl, $hashedBody, $timestamp]);

    $privateKey = file_get_contents($this->privateKeyPath);
    $privKey = openssl_get_privatekey($privateKey);
    if ($privKey === false) {
      throw new \Exception('failed to load private key');
    }

    openssl_sign($stringToSign, $signature, $privKey, OPENSSL_ALGO_SHA256);
    $privKey = null;
    return base64_encode($signature);
  }

  public function sendRequest($payload, $timestamp, $externalId, $signature)
  {
    $headers = [
      "X-TIMESTAMP: $timestamp",
      "X-SIGNATURE: $signature",
      "X-PARTNER-ID: {$this->partnerId}",
      "X-EXTERNAL-ID: $externalId",
      "CHANNEL-ID: {$this->channelId}",
      "Content-Type: application/json",
    ];

    $client = \Config\Services::curlrequest();
    try {
      $response = $client->post($this->apiUrl, [
        'headers' => $headers,
        'json' => $payload
      ]);
      return $response->getBody();
    } catch (\Throwable $th) {
      throw new \Exception("API request failed: " . $th->getMessage());
    }
  }
}
