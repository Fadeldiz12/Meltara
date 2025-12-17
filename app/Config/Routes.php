<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================= HOME =================
$routes->get('/', 'HomeController::index');

// ================= MENU =================
$routes->get('/menu', 'MenuController::index');
$routes->get('/menu/kategori/(:num)', 'MenuController::kategori/$1');
$routes->get('/menu/detail/(:num)', 'MenuController::detail/$1');

// ================= AUTH CUSTOMER =================
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::loginProcess');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::registerProcess');
$routes->get('/logout', 'AuthController::logout');

// ================= PASSWORD =================
$routes->get('/forgot-password', 'AuthController::forgotPassword');
$routes->post('/forgot-password', 'AuthController::processForgotPassword');
$routes->get('/reset-password/(:any)', 'AuthController::resetPassword/$1');
$routes->post('/reset-password', 'AuthController::processResetPassword');

   // ================= ADMIN AUTH =================
$routes->get('admin/login', 'Admin\AuthController::login');
$routes->post('admin/login', 'Admin\AuthController::loginProcess');
$routes->get('admin/logout', 'Admin\AuthController::logout');


// ================= ADMIN AREA =================
$routes->group('admin', ['filter' => 'authadmin'], function ($routes) {

    $routes->get('dashboard', 'Admin\Dashboard::index2');
 

    // PRODUCTS
    $routes->get('products', 'Admin\AdminProduct::index');
    $routes->get('products/add', 'Admin\AdminProduct::add');
    $routes->post('products/store', 'Admin\AdminProduct::store');
    $routes->get('products/edit/(:num)', 'Admin\AdminProduct::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\AdminProduct::update/$1');
    $routes->get('products/delete/(:num)', 'Admin\AdminProduct::delete/$1');

    // SETTINGS
    $routes->get('system-setting', 'Admin\Systemsetting::index');
    $routes->post('system-setting/save', 'Admin\Systemsetting::save');

    // ================= ORDER MANAGEMENT =================
    $routes->get('orders', 'Admin\Order::index');
    $routes->get('orders/(:num)', 'Admin\Order::detail/$1');

    // 🔥 PAYMENT VERIFICATION (MATCH orderdetail.php)
    $routes->post('order/approvePayment/(:num)', 'Admin\Order::approvePayment/$1');
    $routes->post('order/rejectPayment/(:num)', 'Admin\Order::rejectPayment/$1');

    // 🔥 DELIVERY STATUS
    $routes->post('order/updateDeliveryStatus/(:num)', 'Admin\Order::updateDeliveryStatus/$1');

    // REVIEWS
    $routes->get('reviews', 'Admin\Review::index');
    $routes->get('reviews/approve/(:num)', 'Admin\Review::approve/$1');
    $routes->get('reviews/reject/(:num)', 'Admin\Review::reject/$1');
    $routes->get('reviews/delete/(:num)', 'Admin\Review::delete/$1');

    // REPORTS
    $routes->get('reports', 'Admin\Report::index');
    $routes->get('reports/export/pdf', 'Admin\Report::exportPdf');
});

// ================= PUBLIC =================

// CART
$routes->get('/cart', 'CartController::index');
$routes->post('/cart/add', 'CartController::add');
$routes->post('/cart/update', 'CartController::update');
$routes->post('/cart/remove', 'CartController::remove');

// PRODUCT
$routes->get('/product/(:num)', 'ProductController::detail/$1');

// CHECKOUT
$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/process', 'CheckoutController::process');

// ================= CUSTOMER ORDER =================

// 🔥 DAFTAR PESANAN USER (FIX ERROR pesanan)
$routes->get('pesanan', 'OrderController::index', ['filter' => 'authCustomer']);

// 🔥 DETAIL PESANAN USER
$routes->get('pesanan/(:num)', 'OrderController::detail/$1', ['filter' => 'authCustomer']);

// 🔥 UPLOAD BUKTI PEMBAYARAN
$routes->post('pesanan/upload_proof/(:num)', 'OrderController::uploadProof/$1', ['filter' => 'authCustomer']);
// ORDER DETAIL CUSTOMER (FIX)
$routes->get('order_detail/(:num)', 'OrderController::detail/$1', ['filter' => 'authCustomer']);

// REVIEW
$routes->get('review/(:num)','ReviewController::index/$1',['filter'=> 'authCustomer']);
$routes->post('/review/save', 'ReviewController::save');
$routes->post('admin/order/updateOrderStatus/(:num)', 'Admin\Order::updateOrderStatus/$1');

// ================= ORDER HISTORY =================
$routes->get('histori', 'OrderController::history', ['filter' => 'authCustomer']);


