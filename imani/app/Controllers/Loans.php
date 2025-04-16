<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\Auth;
use App\Models\GuarantorsModel;
use App\Models\LoansModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use App\Libraries\Pdf;
use App\Models\InterestTypeModel;
use App\Models\LoanFormulaModel;
use App\Models\LoanTypeModel;
use CodeIgniter\HTTP\ResponseInterface;

class Loans extends BaseController
{
    // apply form page
    public function index()
    {
        helper(['form, url']);

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $loanType = new LoanTypeModel();
        $types = $loanType->findAll();

        $data = [
            'title' => 'Loan Application',
            'userInfo' => $userInfo,
            'loanTypes' => $types
        ];
        return view('loans/new', $data);
    }

    public function settingsPage()
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $interestTypeModel = new InterestTypeModel();
        $interestTypes = $interestTypeModel->findAll();

        $data = [
            'title' => 'Loan Settings',
            'userInfo' => $userInfo,
            'interestTypes' => $interestTypes
        ];
        return view('loans/loan_type_add', $data);
    }

    public function createLoanType()
    {
        $request = $this->request;

        $data = [
            'loan_name' => $request->getPost('loan-name'),
            'service_charge' => $request->getPost('service-charge'),
            'interest_type_id' => $request->getPost('interest-type'),
            'interest_rate' => $request->getPost('interest-rate'),
            'insurance_premium' => $request->getPost('insurance-premium'),
            'crb_amount' => $request->getPost('crb'),
            'min_repayment_period' => $request->getPost('minimum-repayment-period'),
            'max_repayment_period' => $request->getPost('maximum-repayment-period'),
            'min_loan_limit' => $request->getPost('minimum-loan-limit'),
            'max_loan_limit' => $request->getPost('maximum-loan-limit'),
            'description' => $request->getPost('description'),
        ];

        // Save $data to your DB using model
        $model = new \App\Models\LoanTypeModel();
        $model->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }


    // public function loanSettings()
    // {
    //     helper(['form', 'url']);
    //     $userModel = new UserModel();
    //     $loggedInUserId = session()->get('loggedInUser');
    //     $userInfo = $userModel->find($loggedInUserId);

    //     $typeModel = new LoanTypeModel();
    //     $loanTypes = $typeModel
    //         ->select('loan_type.id as loan_type_id, loan_type.*, loan_formula.id as formula_id, loan_formula.formula as formula_name, loan_formula.*')
    //         ->join('loan_formula', 'loan_type.formula_id = loan_formula.id')
    //         ->findAll();

    //     $formulaModel = new LoanFormulaModel();
    //     $formulas = $formulaModel->findAll();

    //     $data = [
    //         'title' => 'Loan Settings',
    //         'types' => $loanTypes,
    //         'userInfo' => $userInfo,
    //         'formulas' => $formulas
    //     ];

    //     return view('loans/settings', $data);
    // }
}
