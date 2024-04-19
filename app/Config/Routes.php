<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addRedirect('/', '/auth/register');

$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::register');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/forgot_password', 'Auth::forgotPassword');
$routes->post('/auth/forgot_password', 'Auth::forgotPassword');
$routes->get('/auth/reset_password', 'Auth::resetPassword');
$routes->post('/auth/reset_password', 'Auth::resetPassword');

// Home
$routes->get('/home', 'Home::index');
