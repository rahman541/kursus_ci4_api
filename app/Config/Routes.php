<?php

use CodeIgniter\Router\RouteCollection;

/*
 *
 * http://localhost/ci4api/zone1
 *
 * http://localhost/ci4api/db_connect
 *
 */

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', [\App\Controllers\Home::class, 'index']);
$routes->get('/zone', [\App\Controllers\Home::class, 'zone']);
$routes->get('/zone1', [\App\Controllers\Home::class, 'zone1']);
$routes->get('/db_connect', [\App\Controllers\Home::class, 'dbConnection']);

$routes->resource('student');
