<?php

namespace App\Services;

use Codeigniter\Config\Services;

class WinpayService
{
  protected $apiUrl;
  protected $partnerId;
  protected $channelId;
  protected $privateKeyPath;
  protected $endpoint = '/v1.0/qr/qr-mpm-generate';

  public function __construct()
  {
    $this->apiUrl = env('WINPAY_API_URL');
    $this->partnerId = env('WINPAY_PARTNER_ID');
    $this->channelId = env('WINPAY_CHANNEL_ID');
    $this->privateKeyPath = FCPATH . '../' . env('WINPAY_PRIVATE_KEY_PATH', 'app/Keys/private_key.pem');
  }

  public function generateSignature($timestamp, $payload)
  {
    $httpMethod = 'POST';
    $minifiedPayload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $hashedBody = strtolower(bin2hex(hash('sha256', $minifiedPayload, true)));
    $stringToSign = implode(':', [$httpMethod, $this->endpoint, $hashedBody, $timestamp]);

    $privateKey = file_get_contents($this->privateKeyPath);
    $privKey = openssl_get_privatekey($privateKey);
    if ($privKey === false) {
      throw new \Exception('Failed to load private key');
    }

    $signature = '';
    if (!openssl_sign($stringToSign, $signature, $privKey, OPENSSL_ALGO_SHA256)) {
      throw new \Exception('Failed to generate signature');
    }

    return base64_encode($signature);
  }

  public function sendRequest($payload, $timestamp, $externalId, $signature)
  {
    $headers = [
      'X-TIMESTAMP' => $timestamp,
      'X-SIGNATURE' => $signature,
      'X-PARTNER-ID' => $this->partnerId,
      'X-EXTERNAL-ID' => $externalId,
      'CHANNEL-ID' => $this->channelId,
      'Content-Type' => 'application/json',
    ];

    log_message('info', 'Winpay API Request: ' . json_encode([
      'url' => $this->apiUrl . $this->endpoint,
      'headers' => $headers,
      'payload' => $payload
    ]));

    $client = \Config\Services::curlrequest();
    try {
      $response = $client->post($this->apiUrl . $this->endpoint, [
        'headers' => $headers,
        'json' => $payload,
        'verify' => true,
      ]);

      $statusCode = $response->getStatusCode();
      $body = $response->getBody();

      log_message('info', 'Winpay API Response: Status ' . $statusCode . ', Body: ' . $body);

      if ($statusCode >= 400) {
        throw new \Exception('API request failed with status: ' . $statusCode . ', body: ' . $body);
      }

      return $body;
    } catch (\Throwable $th) {
      log_message('error', 'API request failed: ' . $th->getMessage());
      throw new \Exception('API request failed: ' . $th->getMessage());
    }
  }
}
