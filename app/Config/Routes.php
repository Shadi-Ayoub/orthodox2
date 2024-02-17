<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/admin/error/graphql', 'ErrorController::graphql', ['filter' => 'auth:admin, error']);

$routes->match(['get', 'post'], '/admin/login', 'AuthController::login');
$routes->match(['get', 'post'], '/login', 'AuthController::login');

$routes->get('/admin/logout', 'AuthController::logout');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/admin/dashboard', 'AdminController::index', ['filter' => 'auth:admin, dashboard']);
$routes->get('/dashboard', 'AdminController::index', ['filter' => 'auth:admin, dashboard']);

$routes->get('/admin/congregations', 'CongregationsController::index', ['filter' => 'auth:admin, congregations']);

$routes->get('/admin/settings', 'SettingsController::index', ['filter' => 'auth:admin, settings']);
$routes->post('/admin/settings/reset', 'SettingsController::reset', ['filter' => 'auth:admin, settings']);
$routes->post('/admin/settings/save', 'SettingsController::save', ['filter' => 'auth:admin, settings']);

$routes->get('/settings', 'SettingsController::index', ['filter' => 'auth:admin, settings']);
$routes->post('/settings/reset', 'SettingsController::reset', ['filter' => 'auth:admin, settings']);
$routes->post('/settings/save', 'SettingsController::save', ['filter' => 'auth:admin, settings']);

$routes->match(['get', 'post'], '/admin/change-password', 'AuthController::change_password', ['filter' => 'auth:admin, change_password']);
$routes->match(['get', 'post'], '/change-password', 'AuthController::change_password', ['filter' => 'auth:admin, change_password']);

$routes->match(['get', 'post'], '/admin/mfa-setup', 'AuthController::mfa_setup', ['filter' => 'auth:admin, mfa_setup']);
$routes->match(['get', 'post'], '/mfa-setup', 'AuthController::mfa_setup', ['filter' => 'auth:admin, mfa_setup']);

$routes->match(['get', 'post'], '/admin/mfa-code-entry', 'AuthController::mfa_code_entry', ['filter' => 'auth:admin, mfa_code_entry']);
$routes->match(['get', 'post'], '/mfa-code-entry', 'AuthController::mfa_code_entry', ['filter' => 'auth:admin, mfa_code_entry']);