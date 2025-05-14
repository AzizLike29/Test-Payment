<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Winpay;

class ProductController extends BaseController
{
    protected $winpayConfig;

    public function __construct()
    {
        $this->winpayConfig = new Winpay();
    }

    public function index()
    {
        return view('pages/products/transaction_products');
    }

    public function getDataProduct()
    {
        $productModel = new Product();
        $resultProduct = $productModel->findAll();

        return view('pages/products/results_transaction', [
            'products' => $resultProduct
        ]);
    }

    public function createQrisWinpay()
    {
        // Validasi input
        if (!$this->validate([
            'product_name' => 'required',
            'price' => 'required|numeric'
        ])) {
            return redirect()->back()->with('error', 'Invalid product data');
        }

        // Ambil data dari form
        $productName = $this->request->getPost('product_name');
        $price = $this->request->getPost('price');

        // Simpan transaksi ke database
        $productModel = new Product();
        $transactionData = [
            'product_name' => $productName,
            'price' => $price,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $productModel->save($transactionData);
        $transactionId = $productModel->getInsertID();

        // Kirim data untuk request ke winpay
        $url = $this->winpayConfig->isSandbox
            ? $this->winpayConfig->sandboxUrl . '/v1.0/qr/qr-mpm-generate'
            : $this->winpayConfig->productionUrl . '/v1.0/qr/qr-mpm-generate';

        $payload = [
            'transaction_id' => 'TRX-' . $transactionId . '-' . time(),
            'amount' => (int) $price,
            'merchant_id' => $this->winpayConfig->apiKey,
            'description' => 'Pembelian ' . $productName,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Generate signature
        $signature = hash_hmac('sha256', json_encode($payload), $this->winpayConfig->secretKey);

        // Request ke API winpay
        $client = \Config\Services::curlrequest();
        try {
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-KEY' => $this->winpayConfig->apiKey,
                    'X-SIGNATURE' => $signature
                ],
                'json' => $payload
            ]);

            $responseData = json_decode($response->getBody(), true);
            if ($response->getStatusCode() == 200 && isset($responseData['qris_url'])) {
                // Simpan QRIS URL atau data lain ke database
                $productModel->update($transactionId, ['qris_url' => $responseData['qris_url']]);

                // Redirect ke halaman QRIS atau template QR code
                return view('pages/products/qris_payment', [
                    'qris_url' => $responseData['qris_url'],
                    'transaction_id' => $payload['transaction_id'],
                    'product_name' => $productName,
                    'price' => $price
                ]);
            } else {
                return redirect()->back()->with('error', 'Failed to generate QRIS' . $responseData['message']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error connecting to winpay' . $e->getMessage());
        }
    }
}
