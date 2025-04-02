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

    // get loan formula from the database
    public function getFormula()
    {
        $request = $this->request->getJSON();
        $loanType = $request->loanType;

        $loanModel = new \App\Models\LoanTypeModel();

        // Join loan_types with the formula table to fetch the formula
        $formulaData = $loanModel
            ->select('loan_formula.formula')
            ->join('loan_formula', 'loan_type.formula_id = loan_formula.id')
            ->where('loan_type.type', $loanType)
            ->first();

        
        if ($formulaData) {
            return $this->response->setJSON(['success' => true, 'formula' => $formulaData['formula']]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    // submission and procession of loan application data
    public function submit()
    {
        helper(['form', 'url']);
        $json = $this->request->getJSON(true);

        // Load models
        $typeModel = new LoanTypeModel();
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
        $pobox = $json['pobox'];
        $poboxCode = $json['poboxCode'];
        $poboxCity = $json['poboxCity'];
        $loanType = $json['loanType'];
        $loanFormula = $json['loanFormula'];
        $loanAmount = $json['loanAmount'];
        $repaymentPeriod = $json['repaymentPeriod'];
        $paymentMode = $json['paymentMode'];
        $bankName = $json['bankName'];
        $bankBranch = $json['bankBranch'];
        $accountName = $json['accountName'];
        $accountNumber = $json['accountNumber'];
        $paymentType = $json['paymentType'];
        $guarantors = $json['guarantors']; // Array of guarantors


        // calculate total and interest
        $getInterest = $typeModel->where('type', $loanType)->first();
        $interest = floatval($getInterest['rate'])/100;
        $loanInterest = floatval($json['loanAmount']) * $interest;
        $loanTotal = bcadd(strval($loanAmount), strval($loanInterest), 2);

        $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $loanReference = substr(str_shuffle($alpha_numeric), 0, 6);
        $applyDate = date('Y-m-d');

        // Validate and prepare data for insertion
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
            'interest' => $loanInterest,
            'total' => $loanTotal,
            'repay_period' => $repaymentPeriod,
            'payment_mode' => $paymentMode,
            'bank' => $bankName,
            'branch' => $bankBranch,
            'account_name' => $accountName,
            'account_number' => $accountNumber,
            'payment_type' => $paymentType,
            'loan_number' => $loanReference,
            'loan_status' => 'Pending',
            'apply_date' => $applyDate
        ];

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Insert into the loan table
        $loanQuery = $loanModel->insert($data);

        // Loop through guarantors and insert each into guarantor table
        foreach ($guarantors as $guarantor) {
            $guarantorQuery = $guarantorsModel->insert([
                'member_name' => $guarantor['name'],
                'member_number' => $guarantor['number'],
                'member_mobile' => $guarantor['mobile'],
                'id_number' => $guarantor['id'],
                'amount' => $guarantor['amount'],
                'loan_number' => $loanReference,
                'responded' => 'No'
            ]);

            $phone = $guarantor['mobile'];
            $gname = $guarantor['name'];
            $fname = explode(' ', $gname)[0];
            $loanee = explode(' ', $name)[0];
            $gamount = $guarantor['amount'];
            $msg = "Hello " . $fname . ", You are now a guarantor of Kshs " . number_format($gamount, 0, '.', ',') . " in the loan of " . $loanee . " worth Kshs" . number_format($loanAmount, 0, '.', ',') . ". Loan No. " . $loanReference . "\nContact the office for details\nRegards\nSacco";

            $sms = new SendSMS();
            $sms->sendSMS($phone, $msg);
        }

        // Complete the transaction
        $db->transComplete();

        // Check if the transaction was successful
        if ($db->transStatus() === FALSE) {
            // If any query failed, roll back and return an error
            return $this->response->setJSON(['error' => true]);
        }
        // If everything was successful, commit and return success
        return $this->response->setJSON(['success' => true]);
    }

    // apply loan page method
    public function new()
    {
        $loanModel = new LoansModel();
        $guarantorsModel = new GuarantorsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        // Query to get loans with guarantor counts
        $db = \Config\Database::connect();
        $builder = $db->table('loan_application');
        $builder->select('loan_application.*, COUNT(guarantors.loan_number) as guarantor_count');
        $builder->join('guarantors', 'guarantors.loan_number = loan_application.loan_number', 'left');
        $builder->groupBy('loan_application.loan_number');
        $loans = $builder->get()->getResultArray();
        $data = [
            'userInfo' => $userInfo,
            'loans' => $loans,
            'title' => 'Loan Applications',

        ];

        return view('loans/index', $data);
    }

    // retrive loan details
    public function details()
    {
        helper(['form', 'url']);

        $loanModel = new LoansModel();
        $userModel = new UserModel();
        $guarantorsModel = new GuarantorsModel();
        $id = $this->request->getGet('id');
        $loan = $loanModel->find($id);
        $guarantors = $guarantorsModel->where('loan_number', $loan['loan_number'])->findAll();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Loan Details - ' . $loan['loan_number'],
            'userInfo' => $userInfo,
            'loan' => $loan,
            'guarantors' => $guarantors
        ];
        return view('loans/loan_details', $data);
    }

    // this one worked, on localhost though, anyway its printing loan details to PDF
    public function printLoanPDF($loanId)
    {
        // Load models to fetch loan data
        $loanModel = new LoansModel();
        $guarantorsModel = new GuarantorsModel();

        // Fetch loan and guarantors data
        $loan = $loanModel->find($loanId);
        $guarantors = $guarantorsModel->where('loan_number', $loan['loan_number'])->findAll();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        // Get the image file and encode it to base64
        $path = base_url('assets/images/gloha-logo.png'); // Absolute URL or path
        $type = pathinfo($path, PATHINFO_EXTENSION); // Get the file extension (e.g., jpg, png)
        $data = file_get_contents($path); // Read the image file content
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // Prepare data for the view
        $data = [
            'loan' => $loan,
            'guarantors' => $guarantors,
            'title' => 'Loan Application Details',
            'userInfo' => $userInfo,
            'base64' => $base64
        ];

        // Load the HTML content from the view
        $html = view('loans/loan_details_export', $data);

        // Instantiate DOMPDF
        $dompdf = new \Dompdf\Dompdf();

        // Load the HTML content into DOMPDF
        $dompdf->loadHtml($html);

        // Set paper size and orientation (optional)
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Stream the PDF to the browser (open in a new tab with 'Attachment' => 0)
        $dompdf->stream('loan_details_' . $loan['loan_number'] . '.pdf', ['Attachment' => 0]); // 0 to open in new tab
    }


    // this one didn't work
    public function generatePdf($id)
    {
        // Load your data from the database, for example:
        $loanModel = new LoansModel();
        $userModel = new UserModel();
        $guarantorsModel = new GuarantorsModel();

        $loan = $loanModel->find($id);
        $guarantors = $guarantorsModel->where('loan_number', $loan['loan_number'])->findAll();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $data = [
            'title' => 'Loan Details - ' . $loan['loan_number'],
            'userInfo' => $userInfo,
            'loan' => $loan,
            'guarantors' => $guarantors
        ];

        // Create a new PDF document
        $pdf = new Pdf();

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Helvetica', '', 10);

        // Write HTML content (from your view, for example)
        $html = view('loans/loan_details_export', $data);

        // Write the HTML content to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output the PDF to the browser
        return $pdf->Output('loan_application.pdf', 'I'); // 'I' for inline, 'D' for download
    }

    // Loan approval
    public function approveLoan($id)
    {
        $loanModel = new LoansModel();
        $loan = $loanModel->find($id);
        $status = "Approved";

        if ($loan) {
            // Update the 'loan_status' field with the new status for the given loan ID
            $approve = $loanModel->update($id, ['loan_status' => $status]);

            if ($approve) {
                return redirect()->to('loans/details?id=' . $id)->with('success', 'Loan approved successfully.');
            } else {
                return redirect()->to('loans/details?id=' . $id)->with('fail', 'Could not approve loan. Please try again later.');
            }
        } else {
            return redirect()->to('loans/details?id=' . $id)->with('fail', 'Loan not found.');
        }
    }


    // Loan rejection
    public function rejectLoan($id)
    {
        $loanModel = new LoansModel();
        $loan = $loanModel->find($id);
        $status = "rejected";

        if ($loan) {
            // Update the 'loan_status' field with the new status for the given loan ID
            $approve = $loanModel->update($id, ['loan_status' => $status]);

            if ($approve) {
                return redirect()->to('loans/details?id=' . $id)->with('success', 'Loan rejected successfully.');
            } else {
                return redirect()->to('loans/details?id=' . $id)->with('fail', 'Could not reject loan. Please try again later.');
            }
        } else {
            return redirect()->to('loans/details?id=' . $id)->with('fail', 'Loan not found.');
        }
    }


    // Page for approved loans
    public function approved()
    {
        $loanModel = new LoansModel();
        $guarantorsModel = new GuarantorsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        // Query to get loans with guarantor counts
        $db = \Config\Database::connect();
        $builder = $db->table('loan_application');
        $builder->select('loan_application.*, COUNT(guarantors.loan_number) as guarantor_count');
        $builder->join('guarantors', 'guarantors.loan_number = loan_application.loan_number', 'left');
        $builder->where('loan_application.loan_status', 'approved');
        $builder->groupBy('loan_application.loan_number');
        $loans = $builder->get()->getResultArray();
        $data = [
            'userInfo' => $userInfo,
            'loans' => $loans,
            'title' => 'Approved Applications'
        ];

        return view('loans/index', $data);
    }

    public function createLoanType()
    {
        helper(['form', 'url']);

        $loanTypeModel = new LoanTypeModel();
        $loanName = $this->request->getPost('loanName');
        $interestRate = $this->request->getPost('rate');
        $formulaId = $this->request->getPost('formula');

        $data = [
            'type' => $loanName,
            'rate' => $interestRate,
            'formula_id' => $formulaId
        ];

        $query = $loanTypeModel->insert($data);
        if ($query) {
            return redirect()->to('loans/settings')->with('success', 'Saved successfully');
        } else {
            return redirect()->to('loans/settings')->with('fail', 'Something went wrong. Please try again later');
        }
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


    // view individual loans
    public function myLoans()
    {
        $loanModel = new LoansModel();
        $guarantorsModel = new GuarantorsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $phone = $userInfo['mobile'];

        // Query to get loans with guarantor counts
        $db = \Config\Database::connect();
        $builder = $db->table('loan_application');
        $builder->select('loan_application.*, COUNT(guarantors.loan_number) as guarantor_count');
        $builder->join('guarantors', 'guarantors.loan_number = loan_application.loan_number', 'left');
        $builder->where('loan_application.member_mobile', $phone);
        $builder->groupBy('loan_application.loan_number');
        $loans = $builder->get()->getResultArray();
        $data = [
            'userInfo' => $userInfo,
            'loans' => $loans,
            'title' => 'My Loans'
        ];

        return view('loans/index', $data);
    }
}
