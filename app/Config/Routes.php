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

// Home
$routes->get('/home', 'Home::index');
