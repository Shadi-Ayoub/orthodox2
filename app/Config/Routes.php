<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/error/graphql', 'ErrorController::graphql', ['filter' => 'auth:graphql']);

$routes->match(['get', 'post'], '/login/admin', 'AuthController::login');
$routes->match(['get', 'post'], '/login', 'AuthController::login');

$routes->get('/admin', 'AdminController::index', ['filter' => 'auth:admin']);

$routes->get('/settings', 'AdminController::settings', ['filter' => 'auth:settings']);
$routes->post('/settings/reset', 'AdminController::settings_reset', ['filter' => 'auth:settings']);
$routes->post('/settings/save', 'AdminController::settings_save', ['filter' => 'auth:settings']);

$routes->match(['get', 'post'], '/change-password', 'AuthController::change_password', ['filter' => 'auth:change_password']);

$routes->match(['get', 'post'], '/mfa-setup', 'AuthController::mfa_setup', ['filter' => 'auth:mfa_setup']);

$routes->match(['get', 'post'], '/mfa-code-entry', 'AuthController::mfa_code_entry', ['filter' => 'auth:mfa_code_entry']);

$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth:logout']);
