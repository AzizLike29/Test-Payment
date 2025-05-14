<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Winpay extends BaseConfig
{
    public $apiKey = '4d0cba482565a4380286a889';
    public $secretKey = '48fac6002005607b7ba79d210ef38d1c36b433cc';
    public $sandboxUrl = 'https://sandbox-api.bmstaging.id';
    public $productionUrl = 'https://merchant.winpay.id';
    // test product
    public $isSandbox = true;
    // test pembayaran
    public $isProduction = false;
    public $privateKeyPath = FCPATH . 'app/Config/private_key.pem';
    public $supportedPaymentMethods = [
        'BNI',
        'BRI',
        'MANDIRI',
        'BCA',
        'PERMATA',
        'BNI_SYARIAH',
        'MANDIRI_SYARIAH',
        'BRI_SYARIAH',
        'BCA_SYARIAH',
    ];
}
