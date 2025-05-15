<?php

/**
 * @var RouteCollection $routes
 */

namespace Config;
// Buat instance router
$routes = Services::routes();

// Load routes otomatis dari environment
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
  require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
$routes->get('/', 'Payment::index');
$routes->post('payment/createVA', 'Payment::createVA');
$routes->post('payment/callbackVA', 'Payment::callback');
$routes->post('product/createQrisWinpay', 'ProductController::createQrisWinpay');
$routes->get('payment/payment_result', 'Payment::createVA');
$routes->get('/products', 'ProductController::index');
$routes->get('products/results', 'ProductController::getDataProduct');

// winpay QRIS
$routes->get('/winpay/response', 'WinpayQrisController::index');
$routes->post('/api/winpay/create-qris', 'WinpayQrisController::createQris');
