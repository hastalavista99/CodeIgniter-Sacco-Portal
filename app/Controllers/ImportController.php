<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MembersModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Accounting\TransactionsModel;
use App\Models\Accounting\SharesAccountModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\Accounting\JournalEntryModel;
use App\Models\Accounting\SavingsAccountModel;
use App\Controllers\Accounting\JournalService;
use App\Controllers\LoanService;
use App\Models\LoansModel;
use App\Libraries\Hash;

class ImportController extends BaseController
{
    public function uploadPage()
    {
        $userModel = new \App\Models\UserModel();
        $loggeinUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggeinUserId);

        if (!$userInfo) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Import Members',
            'userInfo' => $userInfo,
        ];
        return view('members/import_page', $data);
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'member_number',
            'first_name',
            'last_name',
            'dob',
            'join_date',
            'gender',
            'nationality',
            'id_number',
            'email',
            'phone_number',
            'street_address',
            'city',
            'county',
            'zip_code'
        ];

        $sheet->fromArray($headers, NULL, 'A1');
        $sheet->fromArray([
            'M0001',
            'Jane',
            'Doe',
            '1990-01-01',
            '2024-01-01',
            'female',
            'Kenyan',
            '12345678',
            'jane@example.com',
            '0722000000',
            '123 Main St',
            'Nairobi',
            'Nairobi',
            '00100'
        ], NULL, 'A2');

        $writer = new Xlsx($spreadsheet);
        $filename = 'members_import_template.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$filename}");
        $writer->save('php://output');
        exit;
    }

    public function downloadSavingsTemplate()
    {
        return $this->generateTransactionTemplate('savings_import_template.xlsx', 'savings');
    }

    public function downloadSharesTemplate()
    {
        return $this->generateTransactionTemplate('shares_import_template.xlsx', 'share_deposits');
    }

    public function downloadLoansTemplate()
    {
        return $this->generateTransactionTemplate('loans_import_template.xlsx', 'loans', true);
    }

    public function downloadEntranceFeeTemplate()
    {
        return $this->generateTransactionTemplate('entrance_fee_template.xlsx', 'entrance_fee');
    }

    private function generateTransactionTemplate($filename, $service, $includeLoanId = false)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['member_number'];
        if ($includeLoanId) $headers[] = 'loan_id';
        $headers = array_merge($headers, [
            'transaction_type', // cash, coucher, journal
            'amount',
            'payment_method',   // cash, bank, mobile
            'transaction_date',
            'description',
            'service_transaction' // auto-filled, hidden
        ]);

        $sheet->fromArray($headers, NULL, 'A1');

        $sample = ['M0001'];
        if ($includeLoanId) $sample[] = '101';
        $sample = array_merge($sample, ['cash', 5000, 'mobile', '2025-06-01', 'Imported transaction', $service]);

        $sheet->fromArray($sample, NULL, 'A2');

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$filename}");
        $writer->save('php://output');
        exit;
    }

    public function importMembers()
    {
        $file = $this->request->getFile('import_file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file upload.');
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            array_shift($data);

            if (empty($data)) {
                return redirect()->back()->with('error', 'The uploaded file is empty or improperly formatted.');
            }

            $membersModel = new MembersModel();
            $imported = 0;
            $skipped = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                if (empty($row['A']) || empty($row['B']) || empty($row['C']) || empty($row['D']) || empty($row['E']) || empty($row['F']) || empty($row['G']) || empty($row['H']) || empty($row['I']) || empty($row['J']) || empty($row['K']) || empty($row['L']) || empty($row['M']) || empty($row['N'])) {
                    $errors[] = "Row " . ($index + 2) . " has missing required fields.";
                    continue;
                }

                $member = [
                    'member_number'    => $row['A'],
                    'first_name'       => $row['B'],
                    'last_name'        => $row['C'],
                    'dob'              => $row['D'],
                    'join_date'        => $row['E'],
                    'gender'           => $row['F'],
                    'nationality'      => $row['G'],
                    'id_number'        => $row['H'],
                    'email'            => $row['I'],
                    'phone_number'     => $row['J'],
                    'street_address'   => $row['K'],
                    'city'             => $row['L'],
                    'county'           => $row['M'],
                    'zip_code'         => $row['N'],
                    'is_active'        => 1,
                ];

                $existing = $membersModel->where('member_number', $member['member_number'])->first();
                if ($existing) {
                    $skipped++;
                    continue;
                }

                $memberId = $membersModel->insert($member);
                if (!$memberId) {
                    $errors[] = "Failed to import member on row " . ($index + 2);
                    continue;
                } else {
                    $this->createMemberSavingsAccount($memberId);

                    // Create share capital account
                    $this->createMemberShareAccount($memberId);

                    $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $pass = substr(str_shuffle($alpha_numeric), 0, 8);

                    $createUser = new \App\Models\UserModel();
                    new \App\Libraries\Hash();

                    $data = [
                        'user' => $member['first_name'],
                        'name' => $member['first_name'],
                        'member_no' => $member['member_number'],
                        'email' => $member['email'] ? $member['email'] : '',
                        'mobile' => $member['phone_number'],
                        'password' => Hash::encrypt($pass),
                        'role' => 'member',
                    ];
                    $createUser->save($data);

                    $smsModel = new SendSMS();
                    $msg = "Hi, " . $member['first_name'] . ", \n Welcome to Sacco Manager, Login to https://pay.macrologicsys.com/sacco to view your transactions.\nMember Number: " . $member['member_number'] . ", \nPassword: $pass\n Regards \n Sacco Manager";

                    $smsModel->sendSMS($member['phone_number'], $msg);
                }

                $imported++;
            }

            $summary = "$imported member(s) imported successfully.";
            if ($skipped > 0) $summary .= " $skipped duplicates skipped.";
            if (!empty($errors)) $summary .= " Errors: " . implode(' ', $errors);

            return redirect()->back()->with('message', $summary);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error processing file: ' . $e->getMessage());
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

    public function importTransactionsPage()
    {
        $userModel = new \App\Models\UserModel();
        $loggedinUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedinUserId);

        if (!$userInfo) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Import Transactions',
            'userInfo' => $userInfo,
        ];

        return view('accounting/import_transactions', $data);
    }


    public function previewTransactions()
    {
        $userModel = new \App\Models\UserModel();
        $loggedinUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedinUserId);

        if (!$userInfo) {
            return redirect()->to('/login');
        }


        $file = $this->request->getFile('import_file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file upload.');
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $headers = array_shift($data);

            // check the headers are correct
            $actualHeaders = array_map('strtolower', array_map('trim', array_values($headers)));
            $expectedHeaders = ['member_number', 'transaction_type', 'amount', 'payment_method', 'transaction_date', 'description', 'service_transaction'];

            $hasLoanId = in_array('loan_id', $actualHeaders);
            if ($hasLoanId) {
                array_splice($expectedHeaders, 1, 0, 'loan_id'); // insert after member_number
            }

            if ($actualHeaders !== $expectedHeaders) {
                return redirect()->back()->with('error', 'Invalid Excel headers. Please use the official template to avoid missing or misordered columns.');
            }

            // Check if the data is empty
            if (empty($data)) {
                return redirect()->back()->with('error', 'The uploaded file is empty or improperly formatted.');
            }

            $preview = [];

            foreach ($data as $index => $row) {
                $preview[] = $row;
            }

            // Save file to temporary location
            $filename = 'transactions_' . time() . '.xlsx';
            $file->move(WRITEPATH . 'uploads', $filename);

            return view('accounting/preview_transactions', [
                'headers' => $headers,
                'rows' => $preview,
                'tempFile' => $filename,
                'title' => 'Preview Transactions',
                'userInfo' => $userInfo,
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Preview failed: ' . $e->getMessage());
        }
    }

    public function importTransactions()
    {
        $tempFile = $this->request->getPost('tempFile');
        $filePath = WRITEPATH . 'uploads/' . $tempFile;

        if (!$tempFile || !file_exists($filePath)) {
            return redirect()->to('members/import-transactions-page')->with('error', 'Invalid file upload.');
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            array_shift($data);

            if (empty($data)) {
                return redirect()->to('members/import-transactions-page')->with('error', 'The uploaded file is empty or improperly formatted.');
            }

            $transactionsModel = new TransactionsModel();
            $membersModel = new MembersModel();
            $savingsAccountModel = new SavingsAccountModel();
            $sharesAccountModel = new SharesAccountModel();
            $journalModel = new JournalEntryModel();
            $journalDetailsModel = new JournalDetailsModel();
            $loanService = new LoanService();

            $imported = 0;
            $skipped = 0;
            $errors = [];

            $db = \Config\Database::connect();
            $db->transStart();

            foreach ($data as $index => $row) {
                $memberNo = $row['A'] ?? null;
                $loanId = isset($row['B']) && is_numeric($row['B']) ? $row['B'] : null;
                $offset = $loanId ? 1 : 0;
                $transactionType = $row[chr(66 + $offset)] ?? null;
                $amount = floatval($row[chr(67 + $offset)] ?? 0);
                $method = $row[chr(68 + $offset)] ?? null;
                $date = $row[chr(69 + $offset)] ?? null;
                $desc = $row[chr(70 + $offset)] ?? null;
                $service = $row[chr(71 + $offset)] ?? null;

                if (!$memberNo || !$amount || !$date || !$method || !$service) {
                    $errors[] = "Row " . ($index + 2) . " has missing fields.";
                    continue;
                }

                $member = $membersModel->where('member_number', $memberNo)->first();
                if (!$member) {
                    $errors[] = "Row " . ($index + 2) . " has unknown member number: $memberNo";
                    continue;
                }

                $ref = md5($memberNo . $date . $amount . $service);
                $exists = $transactionsModel->where('reference', $ref)->first();
                if ($exists) {
                    $skipped++;
                    continue;
                }

                if ($service === 'loans' && $loanId) {
                    $loanService->handleRepayment([
                        'loan_id' => $loanId,
                        'amount' => $amount,
                        'payment_date' => $date,
                        'payment_method' => $method,
                        'description' => $desc
                    ]);
                }

                $transactionData = [
                    'member_number' => $memberNo,
                    'service_transaction' => $service,
                    'transaction_type' => $transactionType,
                    'amount' => $amount,
                    'payment_method' => $method,
                    'transaction_date' => $date,
                    'description' => $desc,
                    'reference' => $ref
                ];

                $transactionId = $transactionsModel->insert($transactionData);

                $memberId = $member['id'];

                // Update balances
                if ($service === 'savings') {
                    $account = $savingsAccountModel->where('member_id', $memberId)->first();
                    if ($account) {
                        $savingsAccountModel->update($account['id'], [
                            'balance' => $account['balance'] + $amount
                        ]);
                    }
                } elseif ($service === 'share_deposits') {
                    $account = $sharesAccountModel->where('member_id', $memberId)->first();
                    if ($account) {
                        $sharesAccountModel->update($account['id'], [
                            'shares_owned' => $account['shares_owned'] + $amount
                        ]);
                    }
                }

                // Journal Entry
                $journalId = $journalModel->insert([
                    'date' => $date,
                    'description' => $desc,
                    'reference' => $ref,
                    'created_by' => session()->get('loggedInUser'),
                    'posted' => 0
                ]);

                $debitAccount = $this->getDebitAccount($service, $memberId);
                $creditAccount = $this->getCreditAccount($service);

                $journalDetailsModel->insert([
                    'journal_entry_id' => $journalId,
                    'account_id' => $debitAccount,
                    'debit' => $amount,
                    'credit' => 0.00,
                    'transaction_id' => $transactionId
                ]);

                $journalDetailsModel->insert([
                    'journal_entry_id' => $journalId,
                    'account_id' => $creditAccount,
                    'debit' => 0.00,
                    'credit' => $amount,
                    'transaction_id' => $transactionId
                ]);

                $imported++;
            }

            $db->transComplete();
            @unlink($filePath);

            $msg = "$imported transactions imported.";
            if ($skipped > 0) $msg .= " $skipped duplicates skipped.";
            if (!empty($errors)) $msg .= " Errors: " . implode(' ', $errors);

            return redirect()->to('members/import-transactions-page')->with('message', $msg);
        } catch (\Throwable $e) {
            return redirect()->to('members/import-transactions-page')->with('error', 'Processing failed: ' . $e->getMessage());
        }
    }

    private function getDebitAccount($serviceTransaction, $memberId)
    {
        $accounts = [
            'savings' => 3,
            'loans' => 3,
            'entrance_fee' => 3,
            'share_deposits' => 3,
        ];
        return $accounts[$serviceTransaction] ?? 5;
    }

    private function getCreditAccount($serviceTransaction)
    {
        $accounts = [
            'savings' => 74,
            'share_deposits' => 73,
            'loans' => 2,
            'entrance_fee' => 75,
        ];
        return $accounts[$serviceTransaction] ?? 5;
    }
}
