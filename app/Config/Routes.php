<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);
$routes->get('invoice/(:num)', 'TransaksiController::cetak_invoice/$1');
$routes->post('transaksi/upload-bukti/(:num)', 'TransaksiController::uploadBukti/$1');
$routes->post('keranjang/add', 'TransaksiController::cart_add');

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);

$routes->post('admin/update-status/(:num)', 'AdminController::updateStatus/$1');
$routes->get('admin/order', 'TransaksiController::kelolaKonsumen');


$routes->get('transaksi/kirim/(:num)', 'TransaksiController::kirim/$1');
$routes->get('transaksi/selesai/(:num)', 'TransaksiController::selesai/$1');
$routes->post('transaksi/upload-bukti/(:num)', 'TransaksiController::uploadBukti/$1');

$routes->get('faq', 'home::faq', ['filter' => 'auth']);
$routes->get('profile', 'home::profile', ['filter' => 'auth']);
$routes->get('contact', 'home::contact', ['filter' => 'auth']);

$routes->get('auth/google', 'AuthController::googleLogin');
$routes->get('auth/google-callback', 'AuthController::googleCallback');

$routes->get('admin-panel', 'AdminController::index', ['filter' => 'role:admin']);
$routes->get('profile', 'Home::profile', ['filter' => 'role:member']);

$routes->get('laporan', 'TransaksiController::laporan', ['filter' => 'role:admin']);
    
$routes->group('api', function ($routes) {
    $routes->post('monthly', 'ApiController::monthly');
});

$routes->get('admin/export-periodik/pdf', 'TransaksiController::exportPeriodikPDF');
$routes->get('admin/export-periodik/excel', 'TransaksiController::exportPeriodikExcel');

