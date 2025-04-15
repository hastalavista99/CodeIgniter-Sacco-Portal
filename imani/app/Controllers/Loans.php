<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\Auth;
use App\Models\GuarantorsModel;
use App\Models\LoansModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use App\Libraries\Pdf;
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
        $formulaModel = new LoanFormulaModel();
        $loanType = new LoanTypeModel();
        $types = $loanType->findAll();

        $data = [
            'title' => 'Loan Application',
            'userInfo' => $userInfo,
            'types' => $types
        ];
        return view('loans/new', $data);
    }

    public function settingsPage() 
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data= [
            'title' => 'Loan Settings',
            'userInfo' => $userInfo
        ];
        return view('loans/loan_type_add', $data);
    }

    public function loanSettings()
    {
        helper(['form', 'url']);
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $typeModel = new LoanTypeModel();
        $loanTypes = $typeModel
            ->select('loan_type.id as loan_type_id, loan_type.*, loan_formula.id as formula_id, loan_formula.formula as formula_name, loan_formula.*')
            ->join('loan_formula', 'loan_type.formula_id = loan_formula.id')
            ->findAll();

        $formulaModel = new LoanFormulaModel();
        $formulas = $formulaModel->findAll();

        $data = [
            'title' => 'Loan Settings',
            'types' => $loanTypes,
            'userInfo' => $userInfo,
            'formulas' => $formulas
        ];

        return view('loans/settings', $data);
    }

}
