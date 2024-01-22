<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->match(['get', 'post'], '/admin/login', 'AuthController::login'); // Admin login

$routes->match(['get', 'post'], '/login', 'AuthController::login'); // User login

$routes->get('/admin', 'AdminController::index', ['filter' => 'auth:admin']);

$routes->get('/admin/settings', 'AdminController::settings', ['filter' => 'auth:admin']);

$routes->match(['get', 'post'], '/change-password', 'AuthController::change_password', ['filter' => 'auth:change_password']);

$routes->match(['get', 'post'], '/mfa-setup', 'AuthController::mfa_setup', ['filter' => 'auth:mfa_setup']);

$routes->match(['get', 'post'], '/mfa-code-entry', 'AuthController::mfa_code_entry', ['filter' => 'auth:mfa_code_entry']);

$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth:logout']);
