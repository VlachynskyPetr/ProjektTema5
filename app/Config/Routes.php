<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Rider::index');
$routes->get('rider/info/(:num)', 'Rider::show/$1');