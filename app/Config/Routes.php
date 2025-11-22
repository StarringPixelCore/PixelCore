<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes for Dashboard controller
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');

// Routes for fetching the items in sidebar
$routes->get('/equipments', 'Dashboard::equipments');
$routes->get('/reservations', 'Dashboard::reservations');
$routes->get('/borrowed', 'Dashboard::borrowed');
$routes->get('/returned', 'Dashboard::returned');

// Routes for login and register 
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginPost');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerPost');
$routes->get('/logout', 'Auth::logout');

// Routes for user profile
$routes->get('profile', 'Auth::profile');  
$routes->post('profile/update-picture', 'Auth::updatePicture');
$routes->post('profile/update-password', 'Auth::updatePassword');
$routes->post('profile/remove-picture', 'Auth::removePicture');

// Routes for Users controller
$routes->get('users', 'Users::index');
$routes->get('users/add', 'Users::add');
$routes->post('users/insert', 'Users::insert');
$routes->get('users/view/(:num)', 'Users::view/$1');
$routes->get('users/edit/(:num)', 'Users::edit/$1');
$routes->post('users/update/(:num)', 'Users::update/$1');
$routes->get('users/delete/(:num)', 'Users::delete/$1');

// Routes for ___