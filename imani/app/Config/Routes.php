<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\Members;
use App\Controllers\Payments;
use App\Controllers\LoginMember;
use App\Controllers\Agents;
use App\Controllers\SendSMS;
use App\Models\MemberLogin;

$routes->get('/', 'Home::index');

$routes->get('auth', [Auth::class, 'index']);
$routes->get('auth/login', [Auth::class, 'index']);
$routes->get('auth/(:segment)', [Auth::class, 'register']);
$routes->post('auth/(:segment)', [Auth::class, 'register']);
$routes->get('auth/(:segment)', [Auth::class, 'registerUser']);
$routes->post('auth/(:segment)', [Auth::class, 'registerUser']);
$routes->post('registerUser', [Auth::class, 'registerUser']);
$routes->get('registerUser', [Auth::class, 'registerUser']);

$routes->post('loginUser', [Auth::class, 'loginUser']);
$routes->get('loginUser', [Auth::class, 'loginUser']);

$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/members', [Members::class, 'index']);
    $routes->get('/payments', [Payments::class, 'index']);
    $routes->get('/users', [LoginMember::class, 'index']);
    $routes->get('/profile', [LoginMember::class, 'profile']);
    $routes->post('loginMember/changePass', [LoginMember::class, 'changePass']);
    $routes->get('/sms', [LoginMember::class, 'sms']);
    $routes->post('/newMember', [Members::class, 'newMember']);
    $routes->get('/agents', [Agents::class, 'index']);
    $routes->post('/newAgent', [Agents::class, 'newAgent']);
    $routes->get('/myPayments', [Payments::class, 'myPayments']);
    $routes->get('/editMember', [Members::class, 'editMember']);
    $routes->post('/updateMember', [Members::class, 'updateMember']);
    $routes->get('/sendsms', [SendSMS::class, 'sendsms']);
});

$routes->post('auth/uploadImage', [Auth::class, 'uploadImage']);

$routes->get('dashboard', [Dashboard::class, 'index']);


$routes->get('logout', [Auth::class, 'logout']);
