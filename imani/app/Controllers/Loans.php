<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\Auth;
use App\Models\GuarantorsModel;
use App\Models\LoansModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Loans extends BaseController
{
    public function index()
    {
        helper(['form, url']);

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Loan Application',
            'userInfo' => $userInfo,
        ];
        return view('loans/new', $data);
    }


    public function submit()
    {
        helper(['form']);
        $json = $this->request->getJSON(true);

        
        $loanModel = new LoansModel();
        $guarantorsModel = new GuarantorsModel();
        // Access form data
        $userId = $json['userId'];
        $name = $json['name'];
        $memberNumber = $json['memberNumber'];
        $memberID = $json['memberID'];
        $employer = $json['employer'];
        $station = $json['station'];
        $memberMobile = $json['memberMobile'];
        $memberEmail = $json['memberEmail'];
        $pobox = $json['memberNumber'];
        $poboxCode = $json['poboxCode'];
        $poboxCity = $json['poboxCity'];
        $loanType = $json['loanType'];
        $loanAmount = $json['loanAmount'];
        $repaymentPeriod = $json['repaymentPeriod'];
        $paymentMode = $json['paymentMode'];
        $bankName = $json['bankName'];
        $bankBranch = $json['bankBranch'];
        $accountName = $json['accountName'];
        $accountNumber = $json['accountNumber'];
        $paymentType = $json['paymentType'];
        $guarantors = $json['guarantors']; // Array of guarantors

        // Validate and insert data into the database
        $data = [
            'user_id' => $userId,
            'name' => $name,
            'member_number' => $memberNumber,
            'member_mobile' => $memberMobile,
            'member_email' => $memberEmail,
            'member_id' => $memberID,
            'employer' => $employer,
            'station' => $station,
            'po_box' => $pobox,
            'po_code' => $poboxCode,
            'po_city' => $poboxCity,
            'loan_type' => $loanType,
            'amount' => $loanAmount,
            'repay_period' => $repaymentPeriod,
            'payment_mode' => $paymentMode,
            'bank' => $bankName,
            'branch' => $bankBranch,
            'account_name' => $accountName,
            'account_number' => $accountNumber,
            'payment_type' => $paymentType,
            'loan_number' => '',
            'loan_status' => 'Pending'
            
        ];

        // Insert into database (loan table)
        $loanQuery = $loanModel->insert($data);

        // Loop through guarantors and insert each into guarantor table
        foreach ($guarantors as $guarantor) {
            $guarantorQuery = $guarantorsModel->insert([
                'member_name' => $guarantor['name'],
                'member_number' => $guarantor['number'],
                'member_mobile' => $guarantor['mobile'],
                'id_number' => $guarantor[''],
                'amount' => $guarantor[''],
                'loan_number' => $guarantor[''],
                'responded' => 'No'
            ]);
        }

        // Return response
        if(!$loanQuery) {
            return $this->response->setJSON(['error' => true]);
        }
        return $this->response->setJSON(['success' => true]);
    }
}
