<?php

namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Models\Accounting\AccountsModel;
use App\Models\UserModel;

class AccountsController extends BaseController
{
    public function index()
    {
        $accountModel = new AccountsModel();
        $accounts = $accountModel->findAll();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => "Chart of Accounts",
            'userInfo' => $userInfo,
            'accounts' => $accounts
        ];
        return view('accounting/account_list', $data);
    }

    public function create()
    {
        helper('form');
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => "Create Account",
            'userInfo' => $userInfo,
        ];
        return view('accounting/account_create', $data);
    }

    public function store()
    {
        $validationRules = [
            'account_code' => 'required|is_unique[accounts.code]',
            'account_name' => 'required',
            'account_type' => 'required|in_list[asset,liability,equity,revenue,expense]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $accountModel = new AccountsModel();
        $accountModel->insert([
            'account_name' => $this->request->getPost('account_name'),
            'account_code' => $this->request->getPost('account_code'),
            'category' => $this->request->getPost('account_type'),
        ]);

        return redirect()->to('accounting/accounts')->with('success', 'Account created successfully.');
    }
    public function edit($id)
    {
        $accountModel = new AccountsModel();
        $account = $accountModel->find($id);

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        if (!$account) {
            return redirect()->back()->with('error', 'Account not found.');
        }
        $data = [
            'title' => 'Edit Account',
            'account' => $account,
            'userInfo' => $userInfo
        ];

        return view('accounting/account_edit', $data);
    }

    public function update($id)
    {
        $validationRules = [
            'account_name' => 'required',
            'account_type' => 'required|in_list[asset,liability,equity,revenue,expense]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $accountModel = new AccountsModel();
        $accountModel->update($id, [
            'name' => $this->request->getPost('account_name'),
            'type' => $this->request->getPost('account_type'),
        ]);

        return redirect()->to('accounting/accounts')->with('success', 'Account updated successfully.');
    }
}
