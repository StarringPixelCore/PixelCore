<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/equipments', 'Dashboard::equipments');
$routes->get('/reservations', 'Dashboard::reservations');
$routes->get('/borrowed', 'Dashboard::borrowed');
$routes->get('/returned', 'Dashboard::returned');
