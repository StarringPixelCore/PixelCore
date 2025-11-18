<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/equipments', 'Equipments::index');
$routes->get('/reservations', 'Reservations::index');
$routes->get('/borrowed', 'Borrowed::index');
$routes->get('/returned', 'Returned::index');
