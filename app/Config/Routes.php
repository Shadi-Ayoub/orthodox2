<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->post('/change-password', 'AuthController::change_password');

