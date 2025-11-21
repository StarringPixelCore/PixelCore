<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');

//for fetching the items in sidebar
$routes->get('/equipments', 'Dashboard::equipments');
$routes->get('/reservations', 'Dashboard::reservations');
$routes->get('/borrowed', 'Dashboard::borrowed');
$routes->get('/returned', 'Dashboard::returned');

/*For login and register */
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginPost');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerPost');
$routes->get('/logout', 'Auth::logout');

//for user profile
$routes->get('profile', 'Auth::profile');  

$routes->post('profile/update-picture', 'Auth::updatePicture');
$routes->post('profile/update-password', 'Auth::updatePassword');
$routes->post('profile/remove-picture', 'Auth::removePicture');



