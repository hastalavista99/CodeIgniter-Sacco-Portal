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

$routes->post('bank/receive', 'BankController::receive');
$routes->post('bank/validate', 'BankController::validateMember');
//Bank API Integration

$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->post('dashboard/updateMemberNo', 'Dashboard::updateMemberNo');
    $routes->post('excel/upload', 'Excel::upload');
    $routes->get('balances/upload', 'Excel::uploadPage');
    $routes->get('balances/upload/check', 'Excel::checkBalances');
    $routes->get('/payments', [Payments::class, 'index']);
    $routes->get('/payments/ac_bank', 'Payments::bankPayments');
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
    $routes->get('/settings', 'Settings::index');
    $routes->get('admin/settings', 'AdminSettingsController::getSettings',  ['filter' => 'permission:access_system_parameters']);
    $routes->post('admin/settings', 'AdminSettingsController::postSettings');
    $routes->post('admin/close-month', 'Settings::closeMonth', ['filter' => 'permission:close_month']);
    $routes->get('unauthorized', 'Pages::unauthorized');


    $routes->group('loans', function ($routes) {
        $routes->get('/', 'Loans::index');
        $routes->get('all', 'Loans::allLoans');
        $routes->get('view/(:num)', 'Loans::view/$1');
        $routes->get('type', 'Loans::loanTypes');
        $routes->get('type/view/(:num)', 'Loans::typeView/$1');
        $routes->get('type/settings', 'Loans::settingsPage');
        $routes->post('type/create', 'Loans::createLoantype');
        $routes->post('type/update/(:num)', 'Loans::updateLoantype/$1');
        $routes->get('get-interest/(:num)', 'Loans::getInterest/$1');
        $routes->post('application/submit', 'Loans::submit');
        $routes->get('approve/(:num)', 'Loans::approveLoan/$1');
        $routes->get('check-loan/(:num)', 'Loans::checkLoan/$1');
        $routes->get('amortization/loan/(:num)', 'Loans::amortizationSchedule/$1');
        $routes->get('amortization/pdf/loan/(:num)', 'Accounting\ReportsController::exportSchedulePdf/$1');
    });

    $routes->group('members', function ($routes) {
        $routes->get('/', 'Members::index');
        $routes->get('new', 'Members::new');
        $routes->post('create', 'Members::create');
        $routes->get('view/(:num)', 'Members::view/$1');
        $routes->get('edit/(:num)', 'Members::edit/$1');
        $routes->post('update/(:num)', 'Members::update/$1');
        $routes->get('generate/savings/(:num)', 'Members::generateSavingsStatement/$1');
        $routes->get('generate/loans/(:num)', 'Members::generateLoansStatement/$1');
        $routes->get('generate/shares/(:num)', 'Members::generateSharesStatement/$1');
        $routes->get('generate/transactions/(:num)', 'Members::generateTransactionsStatement/$1');
        $routes->get('generate/(:num)', 'Members::generateStatement/$1');
        $routes->post('sms', 'Members::smsMember');
        $routes->get('all-info/(:num)', 'Members::allMemberInfo/$1');
        $routes->get('import-page', 'ImportController::uploadPage');
        $routes->get('download-template', 'ImportController::downloadTemplate');
        $routes->post('import', 'ImportController::importMembers');
        $routes->get('download-savings-template', 'ImportController::downloadSavingsTemplate');
        $routes->get('download-shares-template', 'ImportController::downloadSharesTemplate');
        $routes->get('download-loans-template', 'ImportController::downloadLoansTemplate');
        $routes->get('download-entrance-fee-template', 'ImportController::downloadEntranceFeeTemplate');
        $routes->get('import-transactions-page', 'ImportController::importTransactionsPage');
        $routes->post('import-transactions', 'ImportController::importTransactions');
        $routes->post('preview-transactions', 'ImportController::previewTransactions');
    });

    $routes->group('accounting', function ($routes) {
        $routes->get('remittances/get-member/(:segment)', 'Members::getMember/$1');
        $routes->get('remittances/search-member-name', 'Members::searchMemberName');
        $routes->post('remittances/create', 'Accounting\JournalController::remittanceCreate');
        $routes->get('trial-balance', 'Accounting\ReportsController::trialBalance');
        $routes->get('balance-sheet', 'Accounting\ReportsController::balanceSheet');
        $routes->get('remittances', 'Accounting\JournalController::remittances');
        $routes->post('journal-entry', 'Accounting\JournalController::store');
        $routes->get('journals/page', 'Accounting\JournalController::page');
        $routes->get('journals/create', 'Accounting\JournalController::createPage');
        $routes->get('journals/create', 'Accounting\JournalController::createPage');
        $routes->get('journals/view/(:num)', 'Accounting\JournalController::view/$1');
        $routes->post('journal-entry', 'Accounting\JournalController::store');
        $routes->get('journal-entry/post/(:num)', 'Accounting\JournalController::post/$1');
        $routes->get('accounts', 'Accounting\AccountsController::index');
        $routes->get('accounts/create', 'Accounting\AccountsController::create');
        $routes->post('accounts/store', 'Accounting\AccountsController::store');
        $routes->get('accounts/edit/(:num)', 'Accounting\AccountsController::edit/$1');
        $routes->post('accounts/update/(:num)', 'Accounting\AccountsController::update/$1');
        $routes->get('accounts/page', 'Accounting\AccountsController::index');
        $routes->get('reports/trial-balance', 'Accounting\ReportsController::trialBalance');
        $routes->get('reports/trial-balance/pdf', 'Accounting\ReportsController::trialBalancePdf');
        $routes->get('reports/balance-sheet', 'Accounting\ReportsController::balanceSheet');
        $routes->get('reports/balance-sheet/pdf', 'Accounting\ReportsController::balanceSheetPdf');
        $routes->get('reports/income-statement', 'Accounting\ReportsController::incomeStatement');
        $routes->get('reports/income-statement/pdf', 'Accounting\ReportsController::incomeStatementPdf');
        $routes->get('reports/cashbook', 'Accounting\ReportsController::cashBook');
        $routes->get('reports/cashbook/pdf', 'Accounting\ReportsController::cashbookPdf');
        $routes->get('reports/value-balances/pdf', 'Accounting\ReportsController::valueBalancesPdf');
        $routes->get('reports/general-ledger', 'Accounting\ReportsController::generalLedger');
        $routes->post('reports/general-ledger', 'Accounting\ReportsController::generalLedger');
        $routes->get('reports/general-ledger/pdf', 'Accounting\ReportsController::generalLedgerPdf');
        $routes->get('reports/general-ledger/excel', 'Accounting\ReportsController::generalLedgerExcel');


    });

    $routes->group('staff', function ($routes) {
        $routes->get('/', 'StaffController::index');
        $routes->get('create', 'StaffController::create');
        $routes->post('store', 'StaffController::store');
        $routes->get('edit/(:num)', 'StaffController::edit/$1');
        $routes->post('update/(:num)', 'StaffController::update/$1');
        $routes->get('delete/(:num)', 'StaffController::delete/$1');
        $routes->get('view/(:num)', 'StaffController::view/$1');
        $routes->get('badge/(:num)', 'StaffController::badge/$1');

    });
    
});

$routes->post('auth/uploadImage', [Auth::class, 'uploadImage']);


$routes->get('logout', [Auth::class, 'logout']);
