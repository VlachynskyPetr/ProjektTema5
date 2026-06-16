<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Hlavní stránka – spustí výpis všech jezdců
$routes->get('/', 'Rider::index');
// Detail jezdce – předá ID z URL do metody index2
$routes->get('rider/info/(:num)', 'Rider::index2/$1');
// Výpis jezdců podle místa narození – předá ID lokace do index3
$routes->get('rider/born/(:num)', 'Rider::index3/$1');
// TRASY PRO FORMULÁŘE A AKCE (CRUD)

// Zobrazení prázdného formuláře pro nového jezdce
$routes->get('polozka/pridat', 'Rider::add');
// Zpracování a uložení dat z formuláře nového jezdce
$routes->post('polozka/ulozit', 'Rider::store'); 
// Zobrazení formuláře pro úpravu konkrétního jezdce podle ID
$routes->get('polozka/upravit/(:num)', 'Rider::edit/$1');
// Uložení změn z editačního formuláře pro dané ID do DB
$routes->post('polozka/aktualizovat/(:num)', 'Rider::update/$1');
// Skrytí (soft delete) jezdce z databáze podle ID
$routes->get('polozka/smazat/(:num)', 'Rider::delete/$1');
