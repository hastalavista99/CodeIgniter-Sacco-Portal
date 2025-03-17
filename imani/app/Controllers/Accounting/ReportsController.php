<?php

namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\UserModel;

class ReportsController extends BaseController
{
    public function trialBalance()
    {
        $accountModel = new AccountsModel();
        $accounts = $accountModel->findAll();

        $trialBalance = [];

        foreach ($accounts as $account) {
            $debitSum = (new JournalDetailsModel())->where('account_id', $account['id'])->selectSum('debit')->get()->getRow()->debit ?? 0;
            $creditSum = (new JournalDetailsModel())->where('account_id', $account['id'])->selectSum('credit')->get()->getRow()->credit ?? 0;

            $trialBalance[] = [
                'account_name' => $account['name'],
                'debit' => $debitSum,
                'credit' => $creditSum
            ];
        }

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Trial Balance',
            'userInfo' => $userInfo,
            'trialBalance' => $trialBalance
        ];

        return view('accounting/trial_balance', $data);
    }
}


