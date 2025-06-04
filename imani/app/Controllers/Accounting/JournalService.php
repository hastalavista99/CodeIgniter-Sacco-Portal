<?php

namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Controllers\Loans;
use App\Controllers\LoanService;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\JournalEntryModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\Accounting\SavingsAccountModel;
use App\Models\Accounting\SharesAccountModel;
use App\Models\Accounting\TransactionsModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanTypeModel;
use App\Models\MembersModel;
use App\Models\UserModel;


class JournalService extends BaseController
{

    public function createLoanDisbursementEntry($loanData, $user)
    {
        $journalEntryModel = new JournalEntryModel();
        $journalDetailModel = new JournalDetailsModel();
        $accountModel = new AccountsModel();
        $loanTypeModel = new LoanTypeModel();

        // Create Journal Entry Header
        $entryData = [
            'date'        => date('Y-m-d'),
            'description' => 'Loan disbursement to Member ID ' . $loanData['member_id'],
            'reference'   => 'Loan #' . $loanData['id'],
            'created_by'  => $user,
        ];

        $entryId = $journalEntryModel->insert($entryData);

        // Get Accounts
        $loanTypeDetails = $loanTypeModel->find($loanData['loan_type_id']);
        $loanReceivableAccount = $accountModel->where('account_name', $loanTypeDetails['loan_name'])->first();

        $insuranceIncomeAccount = $accountModel->where('account_name', 'Loan Insurance Income')->first();
        $crbIncomeAccount       = $accountModel->where('account_name', 'CRB Charges')->first();
        $serviceChargeAccount   = $accountModel->where('account_name', 'Loan Application Fee')->first();

        $loanControlAccountId = 3; // Replace with your SACCO bank/cash account ID

        // Extract values
        $principal       = $loanData['principal'];         // Full loan amount
        $disbursed       = $loanData['disburse_amount'];   // Amount actually sent to member
        $insurance       = $loanData['insurance_premium'];
        $crb             = $loanData['crb_amount'];
        $serviceCharge   = $loanData['service_charge'];

        // 🎯 1. Debit: Loan Receivable (with full principal)
        $journalDetails[] = [
            'journal_entry_id' => $entryId,
            'account_id'       => $loanReceivableAccount['id'],
            'debit'            => $principal,
            'credit'           => 0,
        ];

        // 🎯 2. Credit: Bank (with actual disbursed amount)
        $journalDetails[] = [
            'journal_entry_id' => $entryId,
            'account_id'       => $loanControlAccountId,
            'debit'            => 0,
            'credit'           => $disbursed,
        ];

        // 🎯 3. Credit: Income accounts (for charges deducted)
        if ($insurance > 0) {
            $journalDetails[] = [
                'journal_entry_id' => $entryId,
                'account_id'       => $insuranceIncomeAccount['id'],
                'debit'            => 0,
                'credit'           => $insurance,
            ];
        }

        if ($crb > 0) {
            $journalDetails[] = [
                'journal_entry_id' => $entryId,
                'account_id'       => $crbIncomeAccount['id'],
                'debit'            => 0,
                'credit'           => $crb,
            ];
        }

        if ($serviceCharge > 0) {
            $journalDetails[] = [
                'journal_entry_id' => $entryId,
                'account_id'       => $serviceChargeAccount['id'],
                'debit'            => 0,
                'credit'           => $serviceCharge,
            ];
        }

        return $journalDetailModel->insertBatch($journalDetails);
    }

    public function createLoanRepaymentEntry($repaymentData, $user)
    {

        $journalEntryModel   = new JournalEntryModel();
        $journalDetailModel  = new JournalDetailsModel();
        $repaymentModel      = new \App\Models\LoanRepaymentModel();
        $accountModel        = new AccountsModel();
        $loanTypeModel       = new LoanTypeModel();
        $loanApplicationModel = new LoanApplicationModel();

        $loanId = $repaymentData['loan_id'];
        $paymentDate = $repaymentData['payment_date'] ?? date('Y-m-d');

        log_message('debug', 'Loan repayments data on ' . $paymentDate . ' for Loan ID ' . $loanId . ' data: ' . json_encode($repaymentData));

        // Create the journal entry
        $entryData = [
            'date'        => $paymentDate,
            'description' => 'Loan repayment for Loan ID ' . $loanId,
            'reference'   => 'Repayment #' . $loanId,
            'created_by'  => $user,
        ];

        $entryId = $journalEntryModel->insert($entryData);

        // Define accounts
        $cashAccountId = 3; // Bank
        $interestIncomeAccountId = 82; // actual ID for Interest Income

        // Find the loan and its receivable account
        $loan = $loanApplicationModel->find($loanId);
        $loanTypeDetails = $loanTypeModel->find($loan['loan_type_id']);
        $loanType = $loanTypeDetails['loan_name'];

        $loanReceivableAccount = $accountModel->where('account_name', $loanType)->first();
        $loanReceivableAccountId = $loanReceivableAccount['id'];


        $totalPrincipalPaid = 0;
        $totalInterestPaid = 0;

        $totalPrincipalPaid = floatval($repaymentData['principal_paid'] ?? 0);
        $totalInterestPaid = floatval($repaymentData['interest_paid'] ?? 0);
        $totalPaid = $totalPrincipalPaid + $totalInterestPaid;

        if ($totalPaid === 0) {
            log_message('error', 'No loan repayments found on ' . $paymentDate . ' for Loan ID ' . $loanId . ' data: ' . json_encode($repaymentData));
            return;
        }

        // Create journal details
        $entries = [
            [
                'journal_entry_id' => $entryId,
                'account_id'       => $cashAccountId,
                'debit'            => $totalPaid,
                'credit'           => 0,
            ],
            [
                'journal_entry_id' => $entryId,
                'account_id'       => $loanReceivableAccountId,
                'debit'            => 0,
                'credit'           => $totalPrincipalPaid,
            ],
            [
                'journal_entry_id' => $entryId,
                'account_id'       => $interestIncomeAccountId,
                'debit'            => 0,
                'credit'           => $totalInterestPaid,
            ],
        ];

        $journalDetailModel->insertBatch($entries);
    }
}
