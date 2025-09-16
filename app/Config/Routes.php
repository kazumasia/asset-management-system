<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(true);

// Rute default
$routes->get('/', 'User::index');

// Rute khusus untuk admin dengan filter akses admin
// Rute khusus untuk admin dengan filter akses admin
// Dashboard dan Detail
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->get('/admin/list', 'Admin::list', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->get('edit/(:num)', 'PostController::edit/$1');
$routes->get('admin/delete/(:segment)', 'Admin::delete/$1', ['as' => 'delete_laporan']);

$routes->get('/admin/asset-plan', 'AssetPlanController::index');
$routes->get('/admin/asset-plan/create', 'AssetPlanController::create');
$routes->post('/admin/asset-plan/store', 'AssetPlanController::store');
$routes->get('/admin/asset-plan/edit/(:num)', 'AssetPlanController::edit/$1');
$routes->post('/admin/asset-plan/update/(:num)', 'AssetPlanController::update/$1');
$routes->get('/admin/asset-plan/delete/(:num)', 'AssetPlanController::delete/$1');

$routes->get('get-laporan-stats', 'PostController::getLaporanStats');
$routes->get('PostController/export', 'PostController::export');
$routes->get('PostController/fetchPaginationData', 'PostController::fetchPaginationData');
$routes->get('test-email', 'PostController::testEmail');

$routes->get('export-to-excel', 'PostController::export');

$routes->get('user/paginasi', 'PostController::paginasi');
$routes->get('admin/edit/(:num)', 'PostController::edit/$1');
$routes->post('admin/update', 'PostController::update');

$routes->group('admin', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS'], function ($routes) {
    $routes->get('users/add', 'Users::add'); // Route untuk menampilkan form tambah user
    $routes->post('users/save', 'Users::save'); // Route untuk menyimpan user
    $routes->get('users', 'Users::index'); // Route untuk menampilkan daftar user (jika ada fungsi index)
    $routes->get('users', 'Users::index');   // Daftar/List Users hanya bisa diakses oleh admin
    $routes->get('users/activate', 'Users::activate'); // Aksi aktivasi user
    $routes->get('users/changePassword/(:num)', 'Users::changePassword/$1'); // Aksi ganti password
    $routes->post('users/setPassword', 'Users::setPassword'); // Proses set password

});

// $routes->post('/admin/asset-plan/filterByMonth', 'AssetPlanController::filterByMonth');
// $routes->get('/admin/asset-plan/filterByMonth', 'AssetPlanController::filterByMonth');
$routes->get('/admin/asset-plan/getData', 'AssetPlanController::getData');
$routes->get('/admin/asset-plan/filterByMonth', 'AssetPlanController::filterByMonth');
$routes->post('/admin/asset-plan/updateStatus/(:num)', 'AssetPlanController::updateStatus/$1');

// Rute Laporan
$routes->get('get-laporan-stats', 'PostController::getLaporanStats');
$routes->get('export-to-excel', 'PostController::export');
$routes->get('user/paginasi', 'PostController::paginasi');
$routes->get('get-assets-stats', 'PostController::GetAssetsStats');

$routes->get('admin/asset_acquisition', 'AssetAcquisitionController::index'); // Menampilkan daftar pengajuan
$routes->get('admin/asset_acquisition/create', 'AssetAcquisitionController::create'); // Form pengajuan akuisisi
$routes->post('admin/asset_acquisition/store', 'AssetAcquisitionController::store'); // Simpan pengajuan akuisisi
$routes->get('approve/(:num)', 'AssetAcquisitionController::approve/$1'); // Setujui akuisisi
$routes->get('reject/(:num)', 'AssetAcquisitionController::reject/$1'); // Tolak akuisisi
$routes->get('admin/asset_acquisition/loadData', 'AssetAcquisitionController::loadData');

$routes->get('admin/asset_usage', 'AssetUsageController::index'); // Menampilkan daftar penggunaan aset
$routes->get('admin/asset_usage/create', 'AssetUsageController::create'); // Menampilkan form penggunaan aset
$routes->post('admin/asset_usage/delete/(:num)', 'AssetUsageController::delete/$1'); // Menampilkan form penggunaan aset
$routes->post('admin/asset_usage/store', 'AssetUsageController::store'); // Menyimpan penggunaan aset
$routes->get('admin/asset_usage/loadData', 'AssetUsageController::loadData'); // Mengambil data penggunaan aset (AJAX)
$routes->post('admin/asset_usage/complete/(:num)', 'AssetUsageController::selesai/$1');
$routes->get('/admin/asset_usage/ubah/(:num)', 'AssetUsageController::edit/$1');
$routes->post('admin/asset_usage/update/(:num)', 'AssetUsageController::update/$1');


// Menampilkan halaman kalender
$routes->get('admin/calendar', 'CalendarController::index');

// Mengambil data event untuk kalender (AJAX)
$routes->get('admin/calendar/events', 'CalendarController::getEvents');

$routes->get('admin/assets', 'PostController::ListAsset');
$routes->get('assets/data', 'AssetController::getAssetsData');
$routes->get('api/assets', 'AssetController::getAssetList');

$routes->get('admin/AssetController/create', 'AssetController::create');
$routes->post('assets/store', 'AssetController::store');
$routes->get('assets/edit/(:num)', 'AssetController::edit/$1');
$routes->post('assets/update/(:num)', 'AssetController::update/$1');
$routes->post('assets/delete/(:num)', 'AssetController::delete/$1');

$routes->put('assets/update/(:num)', 'AssetController::update/$1');


$routes->group('admin', function ($routes) {
    $routes->get('asset_maintenance', 'AssetMaintenanceController::index'); // Lihat daftar pemeliharaan
    $routes->get('asset_maintenance/create', 'AssetMaintenanceController::create'); // Form tambah pemeliharaan
    $routes->post('asset_maintenance/store', 'AssetMaintenanceController::store'); // Simpan pemeliharaan baru
    $routes->get('asset_maintenance/edit/(:num)', 'AssetMaintenanceController::edit/$1'); // Form edit pemeliharaan
    $routes->post('asset_maintenance/update/(:num)', 'AssetMaintenanceController::update/$1'); // Update pemeliharaan
    $routes->post('asset_maintenance/updateStatus/(:num)', 'AssetMaintenanceController::updateStatus/$1');
    $routes->post('asset_maintenance/delete/(:num)', 'AssetMaintenanceController::delete/$1'); // Hapus pemeliharaan
});
$routes->get('admin/notifications', 'NotificationController::index'); // Lihat notifikasi
$routes->post('admin/notifications/read/(:num)', 'NotificationController::markAsRead/$1'); // Tandai sebagai dibaca
$routes->get('cronjob/sendMaintenanceReminders', 'CronJob::sendMaintenanceReminders');


$routes->post('api/check-nup', 'PostController::checkNup');

// app/Config/Routes.php

$routes->get('/admin/asset_disposal', 'AssetDisposalController::index', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->get('/admin/asset_disposal/create', 'AssetDisposalController::create', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->post('/admin/asset_disposal/store', 'AssetDisposalController::store', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->get('/admin/asset_disposal/show/(:num)', 'AssetDisposalController::show/$1', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->post('/admin/asset_disposal/approve/(:num)', 'AssetDisposalController::approve/$1', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->get('/admin/asset_disposal/reject/(:num)', 'AssetDisposalController::reject/$1', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->get('/admin/asset_disposal/getDetail/(:num)', 'AssetDisposalController::getDetail/$1', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);
$routes->post('/admin/asset_disposal/delete/(:num)', 'AssetDisposalController::delete/$1', ['filter' => 'role:admin,pimpinan,Tata Usaha,IPDS']);



$routes->post('send-email', 'PostController::sendEmail');    // Kirim Email


$routes->get('notification/getNotifications', 'NotificationController::getNotifications');
$routes->post('notification/markAsRead/(:num)', 'NotificationController::markAsRead/$1');


$routes->get('admin/asset-plan/export', 'AssetPlanController::export');
$routes->get('admin/asset_maintenance/export', 'AssetMaintenanceController::export');


$routes->get('/admin/asset_disposal/export', 'AssetDisposalController::export');
$routes->get('admin/assets/export', 'AssetController::exportAssets');

$routes->get('admin/asset_usage/export', 'AssetUsageController::export');



