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
$routes->get('/forgot-password', 'Auth::forgotPassword');
$routes->post('/forgot-password', 'Auth::forgotPasswordPost');
$routes->get('/reset-password/(:segment)', 'Auth::resetPassword/$1');
$routes->post('/reset-password/(:segment)', 'Auth::resetPasswordPost/$1');

// Routes for user profile
$routes->get('profile', 'Auth::profile');  
$routes->get('profile/change-password', 'Auth::changePassword');
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
$routes->get('users/verify/(:any)', 'Users::verify/$1');

// Routes for Equipment controller
$routes->get('equipment', 'Equipment::index');
$routes->get('equipment/add', 'Equipment::add');
$routes->post('equipment/insert', 'Equipment::insert');
$routes->get('equipment/view/(:num)', 'Equipment::view/$1');
$routes->get('equipment/edit/(:num)', 'Equipment::edit/$1');
$routes->post('equipment/update/(:num)', 'Equipment::update/$1');
$routes->get('equipment/delete/(:num)', 'Equipment::delete/$1');
$routes->get('equipment/reactivate/(:num)', 'Equipment::reactivate/$1');

// Routes for Borrow controller
$routes->get('borrow', 'Borrow::index');
$routes->post('borrow/submit', 'Borrow::submit');
$routes->get('borrow/received/(:num)', 'Borrow::received/$1');
$routes->get('borrow/returned/(:num)', 'Borrow::returned/$1');