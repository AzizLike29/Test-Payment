<?php

namespace App\Controllers;

use App\Services\WinpayService;
use App\Models\TransactionsQris;
use App\Controllers\BaseController;

class WinpayQrisController extends BaseController
{
    protected $winpayService;

    public function __construct()
    {
        $this->winpayService = new WinpayService();
    }

    public function createQris()
    {
        try {
            $payload = [
                'partnerReferenceNo' => 'QR-' . date('Ymd') . '-' . uniqid(),
                'terminalId' => 'TERM GIGIH',
                'subMerchantId' => '170041',
                'merchantId' => env('WINPAY_MERCHANT_ID'),
                'amount' => [
                    'value' => 50000.00,
                    'currency' => 'IDR'
                ],
                'validityPeriod' => '2025-05-17T21:30:00+07:00',
                'additionalInfo' => [
                    'isStatic' => false
                ]
            ];

            $timestamp = date('c');
            $externalId = 'EXT-' . date('Ymd') . '-' . uniqid();
            $signature = $this->winpayService->generateSignature($timestamp, $payload);
            $response = $this->winpayService->sendRequest($payload, $timestamp, $externalId, $signature);

            $responseData = json_decode($response, true);
            if (empty($responseData['data'])) {
                log_message('warning', 'API returned null data: ' . $response);
            }

            $this->saveToDatabase($payload, $externalId, $timestamp, $responseData);

            return $this->response->setJSON([
                'status' => 'success',
                'timestamp' => $timestamp,
                'external_id' => $externalId,
                'data' => $responseData
            ]);
        } catch (\Exception $e) {
            log_message('error', 'QRIS Creation Failed: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    protected function saveToDatabase($payload, $externalId, $timestamp, $responseData)
    {
        $transactionsQris = new TransactionsQris();

        $data = [
            'partner_reference_no' => $payload['partnerReferenceNo'],
            'external_id' => $externalId,
            'terminal_id' => $payload['terminalId'],
            'sub_merchant_id' => $payload['subMerchantId'],
            'amount' => $payload['amount']['value'],
            'currency' => $payload['amount']['currency'],
            'validity_period' => $payload['validityPeriod'],
            'is_static' => $payload['additionalInfo']['isStatic'],
            'timestamp' => $timestamp,
            'response_data' => json_encode($responseData),
            'status' => isset($responseData['status']) && $responseData['status'] === 'success' ? 'success' : 'pending'
        ];

        $transactionsQris->insert($data);
        log_message('info', 'Transaction saved to database: ' . $payload['partnerReferenceNo']);
    }
}
