<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BalancesModel;
use App\Models\PaymentsModel;
use App\Models\UserModel;
use App\Models\MembersModel;
use App\Models\Accounting\TransactionsModel;
use App\Models\Accounting\SavingsAccountModel;
use App\Models\Accounting\SharesAccountModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanRepaymentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {

        $paymentsModel = new PaymentsModel();
        $memberModel = new MembersModel();
        $savingsModel = new SavingsAccountModel();
        $sharesModel = new SharesAccountModel();
        $loanModel = new LoanApplicationModel();
        $transactionsModel = new TransactionsModel();

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        if ($userInfo['role'] === 'member') {
            $member = $memberModel->where('member_number', $userInfo['member_no'])->first();
            $memberId = $member['id'];

            $savings = $savingsModel->getMemberSavingsTotal($memberId);
            $shares = $sharesModel->getMemberSharesTotal($memberId);
            $loans = $loanModel->getMemberLoanSummary($memberId);
            $transactions = $transactionsModel->getRecentTransactions($member['member_number']);
        } else {
            $savings = 0;
            $shares = 0;
            $loans = 0;
        }

        // Check if member_no exists and is not empty
        $hasMemberNo = !empty($userInfo['member_no']);

        if ($hasMemberNo) {

            $payments = $paymentsModel
                ->where('SUBSTRING(BillRefNumber, -10) =', $userInfo['mobile'])
                ->orderBy('mp_date', 'DESC')
                ->findAll(5);
        } else {

            $payments = [];
        }

        $data = [
            'title' => 'Dashboard',
            'userInfo' => $userInfo,
            'savings' => $savings,
            'shares' => $shares,
            'loans' => $loans,
            'payments' => $payments,
            'hasMemberNo' => $hasMemberNo,
            'member' => $member ?? null,
        ];
        return view('dashboard/index', $data);
    }

    // save the member number from the dashboard modal
    public function updateMemberNo()
    {
        if ($this->request->isAJAX()) {
            $memberNo = strtoupper($this->request->getPost('member_no'));
            $loggedInUserId = session()->get('loggedInUser');

            $userModel = new UserModel();

            try {
                $userModel->update($loggedInUserId, ['member_no' => $memberNo]);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Member number updated successfully'
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update member number'
                ]);
            }
        }
    }
}
