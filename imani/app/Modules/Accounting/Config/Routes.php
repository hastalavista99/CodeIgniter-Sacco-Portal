<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->group('accounting', ['namespace' => 'Modules\Accounting\Controllers'], function ($routes) {
    $routes->get('trial-balance', 'ReportsController::trialBalance');
    $routes->get('balance-sheet', 'ReportsController::balanceSheet');
    $routes->post('journal-entry', 'JournalController::store');
});
