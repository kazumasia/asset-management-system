<?php

use CodeIgniter\Router\RouteCollection;

$routes->setAutoRoute(true);
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User::index');

$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
$routes->get('/admin/list', 'Admin::list', ['filter' => 'role:admin']);
$routes->get('edit/(:num)', 'PostController::edit/$1');
$routes->get('admin/delete/(:segment)', 'Admin::delete/$1', ['as' => 'delete_laporan']);

$routes->get('get-laporan-stats', 'PostController::getLaporanStats');
$routes->get('PostController/export', 'PostController::export');
$routes->get('PostController/fetchPaginationData', 'PostController::fetchPaginationData');

$routes->get('export-to-excel', 'PostController::export');

$routes->get('user/paginasi', 'PostController::paginasi');
$routes->get('admin/edit/(:num)', 'PostController::edit/$1');
$routes->post('admin/update', 'PostController::update');



$routes->get('get-assets-stats', 'PostController::GetAssetsStats');

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('user', 'UserManagementController::index');
    $routes->get('user/create', 'UserManagementController::create');
    $routes->post('user/store', 'UserManagementController::store');
    $routes->get('user/edit/(:num)', 'UserManagementController::edit/$1');
    $routes->post('user/update/(:num)', 'UserManagementController::update/$1');
    $routes->get('user/delete/(:num)', 'UserManagementController::delete/$1');
});





