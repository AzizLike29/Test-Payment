<?php

define('FCPATH', dirname(__DIR__) . '/');

$privateKeyPath = FCPATH . 'app/Keys/private_key.pem';

$httpMethod = 'POST';
$endpointUrl = '/v1.0/qr/qr-mpm-generate';
$timestamp = '2025-05-15T23:33:00+07:00';

$payload = [
  "partnerReferenceNo" => "QR-20250516-123456",
  "terminalId" => "TERM GIGIH",
  "subMerchantId" => "171000072",
  "amount" => [
    "value" => "50000.00",
    "currency" => "IDR"
  ],
  "validityPeriod" => "2025-05-16T01:33:00+07:00",
  "additionalInfo" => [
    "isStatic" => false
  ]
];

$minifiedPayload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$hashedBody = strtolower(bin2hex(hash('sha256', $minifiedPayload, true)));
$stringToSign = implode(':', [$httpMethod, $endpointUrl, $hashedBody, $timestamp]);

$privateKey = file_get_contents($privateKeyPath);
if ($privateKey === false) {
  die("Gagal membaca file private key di path: $privateKeyPath");
}

$privKey = openssl_get_privatekey($privateKey);
if ($privKey === false) {
  die('Gagal memuat private key (format salah atau tidak valid)');
}

$signature = '';
if (!openssl_sign($stringToSign, $signature, $privKey, OPENSSL_ALGO_SHA256)) {
  die('Gagal membuat signature');
}

$encodedSignature = base64_encode($signature);
echo 'Signature: ' . $encodedSignature . PHP_EOL;
