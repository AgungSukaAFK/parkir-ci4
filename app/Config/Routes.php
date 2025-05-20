<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Parkir::index');
$routes->post('/parkir/simpan', 'Parkir::simpan');
$routes->get('/parkir/keluar/(:num)', 'Parkir::keluar/$1');
$routes->get('/penghasilan', 'Parkir::penghasilan');
