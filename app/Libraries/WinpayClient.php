<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WinpayClient
{
  protected $client;
  protected $config;

  public function __construct()
  {
    // hubungkan ke folder config dengan file winpay
    $this->config = config('Config\\Winpay');
    // memastikan untuk memilih sandbox atau production
    $baseUrl = $this->config->isProduction ? $this->config->productionUrl : $this->config->sandboxUrl;
    // membuat client
    $this->client = new Client(['base_uri' => $baseUrl]);
  }

  private function generateSignature(string $method, string $endpoint, array $requestBody, string $timestamp)
  {
    // Minify request body
    // JSON_UNSECAPED_SLASHES = menghasilkan garis miring tetap
    // JSON_UNESCAPED_UNICODE = menghasilkan unicode tetap
    $minifiedBody = json_encode($requestBody, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // SHA-256 hash dari body, encode ke hex, dan ubah ke lowercase
    $bodyHash = strtolower(hash('sha256', $minifiedBody));

    // Membuat stringToSign
    $stringToSign = implode(':', [
      strtoupper($method),
      $endpoint,
      $bodyHash,
      $timestamp,
    ]);

    // Baca private key
    $privateKey = file_get_contents($this->config->privateKeyPath);
    if (!$privateKey) {
      throw new \Exception('Private key not found');
    }

    // Generate signature dengan SHA256withRSA
    $rsa = openssl_pkey_get_private($privateKey);
    if (!$rsa) {
      throw new \Exception('Invalid private key');
    }

    openssl_sign($stringToSign, $signature, $rsa, OPENSSL_ALGO_SHA256);

    // Encode signature ke base64
    return base64_encode($signature);
  }

  public function request(string $method, string $endpoint, array $data = []): array
  {
    try {
      // Generate timestamp
      $timestamp = date('Y-m-d\TH:i:s+07:00');

      // Generate signature
      $signature = $this->generateSignature($method, $endpoint, $data, $timestamp);

      // Header autentikasi
      $headers = [
        'Content-Type' => 'application/json',
        'X-API-KEY' => $this->config->apiKey,
        'X-SECRET-KEY' => $this->config->secretKey,
        'X-TIMESTAMP' => $timestamp,
        'X-SIGNATURE' => $signature,
      ];

      $response = $this->client->request($method, $endpoint, [
        'headers' => $headers,
        'json' => $data,
      ]);

      return json_decode($response->getBody()->getContents(), true);
    } catch (RequestException $e) {
      log_message('error', 'Winpay API Error: ' . $e->getMessage());
      return [
        'success' => false,
        'message' => $e->getMessage(),
      ];
    } catch (\Exception $e) {
      log_message('error', 'Signature Error ' . $e->getMessage());
      return [
        'success' => false,
        'message' => $e->getMessage(),
      ];
    }
  }
}
