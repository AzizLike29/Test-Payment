<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Libraries\WinpayClient;

class Payment extends BaseController
{
    protected $winpay;
    protected $transactionModel;

    public function __construct()
    {
        $this->winpay = new WinpayClient();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        return view('pages/payment_form');
    }

    public function createVA()
    {
        $data = [
            'merchantId' => '171000072',
            'partnerReferenceNo' => 'ORDER_' . time(),
            'amount' => [
                'value' => $this->request->getPost('amount') . '.00',
                'currency' => 'IDR',
            ],
            'bankCode' => $this->request->getPost('bank'),
            'customerName' => $this->request->getPost('name'),
            'customerPhone' => $this->request->getPost('phone'),
            'customerEmail' => $this->request->getPost('email'),
            'expiryTime' => date('Y-m-d\TH:i:s+07:00', strtotime('+1 hour')),
        ];

        // Simpan transaksi ke database
        $this->transactionModel->insert([
            'partner_reference_no' => $data['partnerReferenceNo'],
            'amount' => $data['amount']['value'],
            'status' => 'PENDING',
        ]);

        // Kirim request ke winpay
        $response = $this->winpay->request('POST', 'transfer-va/create-va');

        if ($response['success']) {
            $vaNumber = $response['data']['virtualAccountNo'];

            // Update transaksi dengan nomor VA
            $this->transactionModel->update(
                ['partner_reference_no' => $data['partnerReferenceNo']],
                ['va_number' => $vaNumber]
            );

            return view('pages/payment_result', [
                'status' => 'success',
                'va_number' => $vaNumber,
                'amount' => $data['amount']['value'],
                'bank' => $data['bankCode'],
            ]);
        } else {
            return view('pages/payment_result', [
                'status' => 'error',
                'message' => $response['message'],
            ]);
        }
    }

    public function callback()
    {
        $input = $this->request->getJSON(true);

        // Validasi signature
        $receivedSignature = $this->request->getHeaderLine('X-SIGNATURE');
        $timestamp = $this->request->getHeaderLine('X-TIMESTAMP');

        $minifiedBody = json_encode($input, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $bodyHash = strtolower(hash('sha256', $minifiedBody));
        $stringToSign = implode(':', [
            'POST',
            'payment/callback',
            $bodyHash,
            $timestamp,
        ]);

        // Update status transaksi
        $this->transactionModel->update(
            ['partner_reference_no' => $input['partnerReferenceNo']],
            ['status' => $input['status']]
        );

        return $this->response->setJSON(['status' => 'success']);
    }
}
