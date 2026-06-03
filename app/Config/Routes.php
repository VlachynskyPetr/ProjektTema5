<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Rider::index');
$routes->get('rider/info/(:num)', 'Rider::index2/$1');
$routes->get('rider/born/(:num)', 'Rider::index3/$1');