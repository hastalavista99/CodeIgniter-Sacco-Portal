<?php

namespace App\Controllers;

use App\Models\MembersModel;
use App\Models\PaymentsModel;
use App\Models\UserModel;
use App\Libraries\Hash;
use App\Controllers\SendSMS;
use App\Controllers\BaseController;
use App\Models\BeneficiaryModel;
use App\Models\Accounting\SavingsAccountModel;
use App\Models\Accounting\SharesAccountModel;
use App\Models\LoanApplicationModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\OrganizationModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\Accounting\TransactionsModel;


class Members extends BaseController
{
    public function index()
    {
        $model = model(MembersModel::class);
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'members'  => $model->findAll(),
            'title' => 'Members',
            'userInfo' => $userInfo,
        ];

        return view('members/index', $data);
    }


    public function create()
    {
        log_message('debug', 'Request method received: ' . $this->request->getMethod());

        // Handle form submission
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        // Handle file upload first
        $photoPath = null;
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads', $newName);
            $photoPath = 'uploads/' . $newName;
        }

        // Prepare member data
        $memberData = [
            'member_number' => $this->request->getPost('memberNumber'),
            'first_name' => $this->request->getPost('firstName'),
            'last_name' => $this->request->getPost('lastName'),
            'dob' => $this->request->getPost('dob'),
            'join_date' => $this->request->getPost('joinDate'),
            'gender' => $this->request->getPost('gender'),
            'nationality' => $this->request->getPost('nationality'),
            'marital_status' => $this->request->getPost('maritalStatus'),
            'id_number' => $this->request->getPost('idNumber'),
            'terms_accepted' => $this->request->getPost('termsAccepted'),
            'email' => $this->request->getPost('email'),
            'phone_number' => $this->request->getPost('phoneNumber'),
            'alternate_phone' => $this->request->getPost('alternatePhone'),
            'street_address' => $this->request->getPost('streetAddress'),
            'address_line2' => $this->request->getPost('addressLine2'),
            'city' => $this->request->getPost('city'),
            'county' => $this->request->getPost('county'),
            'zip_code' => $this->request->getPost('zipCode'),
            'photo_path' => $photoPath,
        ];

        $mobile = $this->request->getPost('phoneNumber');
        $fname = $this->request->getPost('firstName');
        $memberNumber = $this->request->getPost('memberNumber');
        $email = $this->request->getPost('email');


        $benFirstName = $this->request->getPost('beneficiaryFirstName');
        if (isset($benFirstName)) {
            // Prepare beneficiary data
            $beneficiaryData = [
                'first_name' => $this->request->getPost('beneficiaryFirstName'),
                'last_name' => $this->request->getPost('beneficiaryLastName'),
                'dob' => $this->request->getPost('beneficiaryDOB'),
                'phone_number' => $this->request->getPost('beneficiaryPhone'),
                'relationship' => $this->request->getPost('beneficiaryRelationship'),
                'is_beneficiary' => $this->request->getPost('isBeneficiary'),
                'entitlement_percentage' => $this->request->getPost('entitlementPercentage'),
            ];
        }

        $model = new MembersModel();

        // Validate and save
        if (!$model->validate($memberData)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $model->errors()
            ]);
        }

        if (isset($benFirstName)) {
            $memberId = $model->insertMemberWithBeneficiary($memberData, $beneficiaryData);
        } else {
            $memberId = $model->insert($memberData);
        }

        if ($memberId) {
            // Create member savings account
            $this->createMemberSavingsAccount($memberId);

            // Create share capital account
            $this->createMemberShareAccount($memberId);

            $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $pass = substr(str_shuffle($alpha_numeric), 0, 8);

            $createUser = new \App\Models\UserModel();
            new \App\Libraries\Hash();

            $data = [
                'user' => $fname,
                'name' => $fname,
                'member_no' => $memberNumber,
                'email' => $email? $email : '',
                'mobile' => $mobile,
                'password' => Hash::encrypt($pass),
                'role' => 'member',
            ];
            $createUser->save($data);

            $smsModel = new SendSMS();
            $msg = "Hi, $fname \n Welcome to Imaniline Sacco Login to https://sacco.imanilinesacco.co.ke to view your transactions.\nMember Number: $memberNumber \nPassword: $pass\n Regards \n Imaniline Sacco Manager";

            $sendSMSStatus = $smsModel->sendSMS($mobile, $msg);

            if($sendSMSStatus) {
                return $this->response->setStatusCode(201)->setJSON([
                'success' => true,
                'message' => 'Member created and notified successfully',
                'member_id' => $memberId
            ]);
            }
            return $this->response->setStatusCode(201)->setJSON([
                'success' => true,
                'message' => 'Member created successfully',
                'member_id' => $memberId
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to create member'
            ]);
        }
    }

    private function createMemberSavingsAccount(int $memberId)
    {
        $savingsAccountModel = new SavingsAccountModel();

        // The main control account ID for member savings (from your chart of accounts)
        $savingsControlAccountId = 74;

        // Optional: Generate a unique account number (you can customize this)
        $accountNumber = 'SAV' . str_pad($memberId, 5, '0', STR_PAD_LEFT);

        $data = [
            'member_id' => $memberId,
            'account_id' => $savingsControlAccountId,
            'account_number' => $accountNumber,
            'account_type' => 'normal', // optional
        ];

        return $savingsAccountModel->insert($data);
    }

    private function createMemberShareAccount(int $memberId)
    {
        $shareAccountModel = new SharesAccountModel();

        // The main control account ID for share capital
        $shareCapitalAccountId = 73;

        $data = [
            'member_id' => $memberId,
            'account_id' => $shareCapitalAccountId,
            'shares_owned' => 0, // start with zero, increase on deposit
        ];

        return $shareAccountModel->insert($data);
    }



    public function new()
    {
        helper('form');

        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Create Member',
            'userInfo' => $userInfo
        ];

        return view('members/create', $data);
    }

    public function getMember($memberNo)
    {
        $model = new MembersModel();
        $member = $model->where('member_number', $memberNo)->first();

        if ($member) {
            return $this->response->setJSON([
                'id' => $member['id'],
                'name' => $member['first_name'] . " " .  $member['last_name'],
                'mobile' => $member['phone_number']
            ]);
        }

        return $this->response->setJSON(['error' => 'Member not found'])->setStatusCode(404);
    }


    public function view($id)
    {
        helper('form');


        $memberModel = new MembersModel();
        $savingsModel = new SavingsAccountModel();
        $sharesModel = new SharesAccountModel();
        $loanModel = new LoanApplicationModel();

        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);


        $member = $memberModel->find($id);
        if (!$member) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Member not found");
        }

        $savings = $savingsModel->getMemberSavingsTotal($id);
        $shares = $sharesModel->getMemberSharesTotal($id);
        $loans = $loanModel->getMemberLoanSummary($id);
        $data = [
            'member' => $member,
            'savings' => $savings,
            'shares' => $shares,
            'loans' => $loans,
            'title' => 'Member View - ' . $member['first_name'] . " " . $member['last_name'],
            'userInfo' => $userInfo
        ];

        return view('members/view', $data);
    }

    public function edit($id)
    {
        helper('form');

        $memberModel = new MembersModel();
        $memberData = $memberModel->find($id);

        $beneficiaryModel = new BeneficiaryModel();
        $beneficiary = $beneficiaryModel->where('member_id', $id)->first();

        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Edit Member - ' . $memberData['member_number'],
            'member' => $memberData,
            'userInfo' => $userInfo,
            'beneficiary' => $beneficiary
        ];

        return view('members/create', $data);
    }

    public function update()
    {
        log_message('debug', 'Update method called: ' . $this->request->getMethod());

        // Handle form submission
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        // Get member ID
        $memberId = $this->request->getPost('member_id');
        if (!$memberId) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Member ID is required'
            ]);
        }

        $model = new MembersModel();

        // Check if member exists
        $existingMember = $model->find($memberId);
        if (!$existingMember) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }

        // Handle file upload 
        $photoPath = $existingMember['photo_path']; // Default to existing photo
        $photo = $this->request->getFile('photo');

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            // Upload new photo
            $newName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads', $newName);
            $photoPath = 'uploads/' . $newName;

            // Delete old photo if it exists
            if ($existingMember['photo_path'] && file_exists(WRITEPATH . $existingMember['photo_path'])) {
                unlink(WRITEPATH . $existingMember['photo_path']);
            }
        } elseif ($this->request->getPost('existing_photo')) {
            // Keep existing photo
            $photoPath = $this->request->getPost('existing_photo');
        }

        // Prepare member data
        $memberData = [
            'member_number' => $this->request->getPost('memberNumber'),
            'first_name' => $this->request->getPost('firstName'),
            'last_name' => $this->request->getPost('lastName'),
            'dob' => $this->request->getPost('dob'),
            'join_date' => $this->request->getPost('joinDate'),
            'gender' => $this->request->getPost('gender'),
            'nationality' => $this->request->getPost('nationality'),
            'marital_status' => $this->request->getPost('maritalStatus'),
            'id_number' => $this->request->getPost('idNumber'),
            'terms_accepted' => $this->request->getPost('termsAccepted'),
            'email' => $this->request->getPost('email'),
            'phone_number' => $this->request->getPost('phoneNumber'),
            'alternate_phone' => $this->request->getPost('alternatePhone'),
            'street_address' => $this->request->getPost('streetAddress'),
            'address_line2' => $this->request->getPost('addressLine2'),
            'city' => $this->request->getPost('city'),
            'county' => $this->request->getPost('county'),
            'zip_code' => $this->request->getPost('zipCode'),
            'photo_path' => $photoPath,
        ];

        // Prepare beneficiary data if provided
        $benFirstName = $this->request->getPost('beneficiaryFirstName');
        if ($benFirstName) {
            $beneficiaryData = [
                'first_name' => $this->request->getPost('beneficiaryFirstName'),
                'last_name' => $this->request->getPost('beneficiaryLastName'),
                'dob' => $this->request->getPost('beneficiaryDOB'),
                'phone_number' => $this->request->getPost('beneficiaryPhone'),
                'relationship' => $this->request->getPost('beneficiaryRelationship'),
                'is_beneficiary' => $this->request->getPost('isBeneficiary'),
                'entitlement_percentage' => $this->request->getPost('entitlementPercentage'),
                'member_id' => $memberId
            ];
        }

        // Validate and save
        if (!$model->validate($memberData)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $model->errors()
            ]);
        }

        try {
            $model->db->transStart();

            // Update member data
            $model->update($memberId, $memberData);

            // Handle beneficiary data if provided
            if (isset($benFirstName)) {
                $beneficiaryModel = new BeneficiaryModel();

                // Check if this member already has a beneficiary
                $existingBeneficiary = $beneficiaryModel->where('member_id', $memberId)->first();

                if ($existingBeneficiary) {
                    // Update existing beneficiary
                    $beneficiaryModel->update($existingBeneficiary['id'], $beneficiaryData);
                } else {
                    // Insert new beneficiary
                    $beneficiaryModel->insert($beneficiaryData);
                }
            }

            $model->db->transComplete();

            if ($model->db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Member updated successfully',
                'member_id' => $memberId
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update member: ' . $e->getMessage());

            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to update member: ' . $e->getMessage()
            ]);
        }
    }


    public function generateStatement($memberId)
    {
        try {
            $memberModel = new MembersModel();
            $orgModel = new OrganizationModel();
            $journalModel = new JournalDetailsModel();
            $savingsModel = new SavingsAccountModel();
            $sharesModel = new SharesAccountModel();
            $loanModel = new LoanApplicationModel();

            // Fetch member
            $member = $memberModel->find($memberId);
            if (!$member) {
                return $this->response->setStatusCode(404)->setBody('Member not found.');
            }

            // Fetch organization profile
            $organization = $orgModel->first();
            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
            }

            // Fetch transactions
            if (!method_exists($journalModel, 'getMemberTransactionDetails')) {
                return $this->response->setStatusCode(500)->setBody('Transaction retrieval method not implemented.');
            }

            $transactions = $journalModel->getMemberTransactionDetails($memberId);
            $savings = $savingsModel->getMemberSavingsTotal($memberId);
            $shares = $sharesModel->getMemberSharesTotal($memberId);
            $loans = $loanModel->getMemberLoanSummary($memberId);
            if (empty($transactions)) {
                // Optional: Render PDF anyway, or abort
                log_message('warning', "No transactions found for member ID: {$memberId}");
            }

            $data = [
                'member' => $member,
                'organization' => $organization,
                'transactions' => $transactions,
                'savings' => $savings,
                'shares' => $shares,
                'loan_balance' => $loans
            ];

            // Generate PDF
            $html = view('members/pdf', $data);

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($dompdf->output());
        } catch (\Throwable $e) {
            log_message('error', 'Error generating statement: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setBody('An unexpected error occurred. Please try again later.');
        }
    }

    public function generateSavingsStatement($id = null)
    {
        try {
            $memberModel = new MembersModel();
            $orgModel = new OrganizationModel();
            $journalModel = new JournalDetailsModel();
            $savingsModel = new SavingsAccountModel();
            $transactionsModel = new TransactionsModel();

            // Fetch member
            $member = $memberModel->find($id);
            if (!$member) {
                return $this->response->setStatusCode(404)->setBody('Member not found.');
            }

            // Fetch organization profile
            $organization = $orgModel->first();
            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
            }

            // Fetch savings
            $transactions = $transactionsModel->getSavingsTransactions($member['member_number']);


            $data = [
                'member' => $member,
                'organization' => $organization,
                'transactions' => $transactions,
            ];

            // Generate PDF
            $html = view('members/savings_pdf', $data);

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($dompdf->output());
        } catch (\Throwable $e) {
            log_message('error', 'Error generating statement: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setBody('An unexpected error occurred. Please try again later.');
        }
    }

    public function generateSharesStatement($id = null)
    {
        try {
            $memberModel = new MembersModel();
            $orgModel = new OrganizationModel();
            $journalModel = new JournalDetailsModel();
            $savingsModel = new SavingsAccountModel();
            $transactionsModel = new TransactionsModel();

            // Fetch member
            $member = $memberModel->find($id);
            if (!$member) {
                return $this->response->setStatusCode(404)->setBody('Member not found.');
            }

            // Fetch organization profile
            $organization = $orgModel->first();
            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
            }

            // Fetch savings
            $transactions = $transactionsModel->getSharesTransactions($member['member_number']);


            $data = [
                'member' => $member,
                'organization' => $organization,
                'transactions' => $transactions,
            ];

            // Generate PDF
            $html = view('members/shares_pdf', $data);

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($dompdf->output());
        } catch (\Throwable $e) {
            log_message('error', 'Error generating statement: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setBody('An unexpected error occurred. Please try again later.');
        }
    }

    public function generateLoansStatement($id = null) {}

    public function generateTransactionsStatement($id = null)
    {

        try {
            $memberModel = new MembersModel();
            $orgModel = new OrganizationModel();
            $journalModel = new JournalDetailsModel();

            $member = $memberModel->find($id);

            if (!$member) {
                return $this->response->setStatusCode(404)->setBody('Member not found.');
            }

            // Fetch organization profile
            $organization = $orgModel->first();
            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
            }
            $transactions = $journalModel->getAllTransactions($member['member_number']);

            $data = [
                'member' => $member,
                'organization' => $organization,
                'transactions' => $transactions,
            ];

            // Generate PDF
            $html = view('members/transactions_pdf', $data);

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($dompdf->output());
        } catch (\Throwable $e) {
            log_message('error', 'Error generating statement: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setBody('An unexpected error occurred. Please try again later.');
        }
    }


    public function smsMember()
    {
        $request = $this->request;

        $phone = $request->getJSON()->phone ?? null;
        $message = $request->getJSON()->message ?? null;

        if (!$phone || !$message) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Phone or message is missing.'
            ]);
        }

        $smsController = new SendSMS();
        $smsSent = $smsController->sendSMS($phone, $message);

        if ($smsSent) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'SMS sent successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to send SMS.'
            ]);
        }
    }
}
