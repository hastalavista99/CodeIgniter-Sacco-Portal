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
use App\Controllers\Commissions;
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
$routes->get('set/user', 'Auth::setUser');
$routes->get('set/success', 'Auth::setSuccess');
$routes->post('set/user/save', 'Auth::setSave');
$routes->post('loginUser', [Auth::class, 'loginUser']);
$routes->get('loginUser', [Auth::class, 'loginUser']);
$routes->get('confirm/user', [Auth::class, 'confirmUser']);
$routes->post('check/user', 'Auth::checkUser');
$routes->get('confirm/otp', "Auth::confirmOTP");
$routes->post('check/otp', 'Auth::checkOTP');
$routes->get('check/otp/resend', 'Auth::resendOTP');
$routes->get('password/forgot', 'Auth::changeAuth');
$routes->post('renew/password', 'Auth::resetPassword');
$routes->post('malipo/account', 'Integrations::account');
$routes->post('malipo/advise', 'Integrations::advise');

$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->post('dashboard/updateMemberNo', 'Dashboard::updateMemberNo');
    $routes->post('excel/upload', 'Excel::upload');
    $routes->get('balances/upload', 'Excel::uploadPage');
    $routes->get('balances/upload/check', 'Excel::checkBalances');
    $routes->get('/members', [Members::class, 'index']);
    $routes->get('/payments', [Payments::class, 'index']);
    $routes->get('payments/shares', [Payments::class, 'shares']);
    $routes->get('payments/deposits', [Payments::class, 'deposits']);
    $routes->get('payments/repayments', [Payments::class, 'repayments']);
    $routes->get('payments/group', [Payments::class, 'group']);
    $routes->get('payments/details/(:any)', 'Payments::payDetails/$1');
    $routes->get('editPay', [Payments::class, 'editPage']);
    $routes->get('filterPay', [Payments::class, 'filter']);
    $routes->post('updatePayment', [Payments::class, 'updatePay']);
    $routes->post('payments/export', [Payments::class, 'export']);
    $routes->get('/users', [LoginMember::class, 'index']);
    $routes->get('/editUser', [Auth::class, 'editUser']);
    $routes->post('/updateUser', [Auth::class, 'updateUser']);
    $routes->get('/profile', [LoginMember::class, 'profile']);
    $routes->get('loans/apply', 'Loans::index');
    $routes->get('loans/new', 'Loans::new');
    $routes->get('loans/approve/(:num)', 'Loans::approveLoan/$1');
    $routes->get('loans/reject/(:num)', 'Loans::rejectLoan/$1');
    $routes->get('loans/approved', 'Loans::approved');
    $routes->get('loans/my_loans', 'Loans::myLoans');
    $routes->post('loans/submit', 'Loans::submit');
    $routes->post('loans/type/create', 'Loans::createLoanType');
    $routes->get('loans/details', 'Loans::details');
    $routes->get('loans/settings', 'Loans::loanSettings');
    $routes->post('loans/getFormula', 'Loans::getFormula');
    $routes->get('loans/print-pdf/(:num)', 'Loans::printLoanPDF/$1');
    $routes->get('loan/pdf', 'Loans::generatePdf');
    $routes->post('loginMember/changePass', [LoginMember::class, 'changePass']);
    $routes->get('/sms', [LoginMember::class, 'sms']);
    $routes->post('/newMember', [Members::class, 'newMember']);
    $routes->post('/newUser', [LoginMember::class, 'newUser']);
    $routes->get('/agents', [Agents::class, 'index']);
    $routes->get('agent/commissions', [Commissions::class, 'index']);
    $routes->get('agent/myCommissions', [Commissions::class, 'individual']);
    $routes->post('/newAgent', [Agents::class, 'newAgent']);
    $routes->get('/editAgent', [Agents::class, 'editAgent']);
    $routes->get('/deleteAgent', [Agents::class, 'deleteAgent']);
    $routes->post('/updateAgent', [Agents::class, 'updateAgent']);
    $routes->get('/myPayments', [Payments::class, 'myPayments']);
    $routes->get('/editMember', [Members::class, 'editMember']);
    $routes->get('/deleteMember', [Members::class, 'deleteMember']);
    $routes->post('/updateMember', [Members::class, 'updateMember']);
    $routes->get('/sendsms', [SendSMS::class, 'sendsms']);
});

$routes->post('auth/uploadImage', [Auth::class, 'uploadImage']);


$routes->get('logout', [Auth::class, 'logout']);
