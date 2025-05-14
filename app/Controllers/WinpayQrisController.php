<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionsQris;
use App\Services\WinpayService;

class WinpayQrisController extends BaseController
{
    protected $winpayService;
    protected $transactionModel;

    public function __construct()
    {
        $this->winpayService = new WinpayService();
        $this->transactionModel = new TransactionsQris();
    }

    public function createQris()
    {
        try {
            // Generate timestamp dari external ID
            $timestamp = date('c');
            $externalId = 'INV-' . time();

            // Siapkan payload
            $payload = [
                'amount' => $this->request->getPost('amount') ?? 10000,
                'customer_name' => $this->request->getPost('customer_name') ?? 'Abdul Aziz Firdaus',
                'customer_email' => $this->request->getPost('customer_email') ?? 'abdulfirdaus590@gmail.com',
                'customer_phone' => $this->request->getPost('customer_phone') ?? '081234567890',
                'order_id' => $externalId,
                'channel_id' => $this->winpayService->getChannelId()
            ];

            // debugging
            log_message('info', 'Winpay Request Payload: ' . json_encode($payload));

            // Generate signature
            $signature = $this->winpayService->generateSignature($timestamp, $payload);

            // Kirim request ke Winpay
            $response = $this->winpayService->sendRequest($payload, $timestamp, $externalId, $signature);

            // parse response ke string
            $parsedResponse = json_decode($response, true);

            // Simpan transaksi ke database yang sudah di buat di model transactions qris
            $this->transactionModel->insert([
                'external_id' => $externalId,
                'amount' => $payload['amount'],
                'status' => 'pending',
                'response' => $response
            ]);

            return $this->response->setJSON([
                'success' => true,
                'timestamp' => $timestamp,
                'external_id' => $externalId,
                'response' => $parsedResponse
            ]);
        } catch (\Throwable $th) {
            // debugging
            log_message('error', $th->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => true,
                'message' => 'Internal Server Error: ' . $th->getMessage()
            ]);
        }
    }
}
