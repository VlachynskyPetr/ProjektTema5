<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Rider::index');
$routes->get('rider/info/(:num)', 'Rider::index2/$1');
$routes->get('rider/born/(:num)', 'Rider::index3/$1');

// Trasy pro formuláře a akce (CRUD)
$routes->get('polozka/pridat', 'Rider::add');
$routes->post('polozka/ulozit', 'Rider::store'); // Zde nesmí být "uložit"
$routes->get('polozka/upravit/(:num)', 'Rider::edit/$1');
$routes->post('polozka/aktualizovat/(:num)', 'Rider::update/$1');
$routes->get('polozka/smazat/(:num)', 'Rider::delete/$1');