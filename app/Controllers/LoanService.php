<?php

namespace App\Controllers;

use App\Controllers\Accounting\JournalService;
use App\Controllers\BaseController;
use App\Controllers\Auth;
use App\Models\LoanGuarantorModel;
use App\Models\LoansModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use App\Libraries\Pdf;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\Accounting\JournalEntryModel;
use App\Models\InterestTypeModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanTypeModel;
use App\Models\LoanRepaymentModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;


class LoanService extends BaseController
{
    /**
     * Generate loan installments based on the loan details
     *
     * @param int $loanId
     * @return bool|array Returns false if loan is not found or not approved, otherwise returns an array of installments
     */
    public function generateInstallments($loanId)
    {
        $loanModel = new LoanApplicationModel();
        $repaymentModel = new LoanRepaymentModel();

        $loan = $loanModel->find($loanId);

        if (!$loan || $loan['loan_status'] !== 'approved') {
            return false;
        }

        $installments = [];

        $P = (float) $loan['principal'];
        $annualRate = (float) $loan['interest_rate'] / 100;
        $monthlyRate = $annualRate / 12;
        $n = (int) $loan['repayment_period'];
        $startDate = new DateTime($loan['request_date']);

        // Monthly EMI formula (reducing balance)
        $EMI = ($P * $monthlyRate * pow(1 + $monthlyRate, $n)) / (pow(1 + $monthlyRate, $n) - 1);
        $EMI = round($EMI, 2);

        $balance = $P;

        $totalInterest = 0;
        for ($i = 1; $i <= $n; $i++) {
            $dueDate = clone $startDate;
            $dueDate->modify("+{$i} months");

            $interest = round($balance * $monthlyRate, 2);
            $principalComponent = round($EMI - $interest, 2);
            $balance = round($balance - $principalComponent, 2);

            // Adjust the last installment
            if ($i === $n && $balance !== 0.00) {
                $principalComponent += $balance;
                $EMI = $principalComponent + $interest;
                $balance = 0.00;
            }

            $installments[] = [
                'loan_id' => $loanId,
                'installment_number' => $i,
                'due_date' => $dueDate->format('Y-m-d'),
                'amount_due' => $EMI,
                'principal_due' => $principalComponent,
                'interest_due' => $interest,
                'principal_paid' => 0.00,
                'interest_paid' => 0.00,
                'amount_paid' => 0.00,
                'status' => 'pending',
                'payment_method' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $totalInterest += $interest;
        }

        // Optionally, you can round the total interest and adjust the last installment's interest_due to match
        $roundedTotalInterest = round($totalInterest);
        $interestDiff = $roundedTotalInterest - $totalInterest;
        if ($n > 0 && abs($interestDiff) > 0.01) {
            // Adjust the last installment's interest_due so the sum matches the rounded value
            $installments[$n-1]['interest_due'] = round($installments[$n-1]['interest_due'] + $interestDiff, 2);
        }

        return $repaymentModel->insertBatch($installments);
    }


    /**
     * Apply advance payment to loan installments
     *
     * @param int $loanId
     * @param float $amount
     */
    public function applyAdvancePayment($loanId, $amount)
    {
        $repaymentModel = new LoanRepaymentModel();
        $loanModel = new LoanApplicationModel();

        $remaining = floatval($amount);
        $loan = $loanModel->find($loanId);

        if (!$loan) {
            log_message('error', "Loan ID $loanId not found");
            return;
        }

        $loanAmount = floatval($loan['principal']);

        $installments = $repaymentModel
            ->where('loan_id', $loanId)
            ->orderBy('due_date', 'ASC')
            ->findAll();

        if (!$installments) {
            log_message('error', "No installments found for Loan ID $loanId");
            return;
        }

        // Step 1: Track remaining principal
        $remainingPrincipal = $loanAmount;
        foreach ($installments as $i => $installment) {
            $remainingPrincipal -= floatval($installment['principal_paid']);
            $installments[$i]['_remaining_principal'] = $remainingPrincipal;
        }

        // Totals to return
        $totalInterestPaid = 0;
        $totalPrincipalPaid = 0;

        // Step 2: Apply advance
        foreach ($installments as $installment) {
            $id = $installment['id'];
            $status = $installment['status'];

            if (!in_array($status, ['pending', 'overdue'])) {
                log_message('debug', "Skipping installment ID $id with status '$status'");
                continue;
            }

            if ($remaining <= 0) {
                log_message('debug', "Advance exhausted.");
                break;
            }

            $alreadyPaid = floatval($installment['amount_paid']);
            $due = floatval($installment['amount_due']) - $alreadyPaid;
            if ($due <= 0) {
                log_message('debug', "Installment ID $id already fully paid");
                continue;
            }

            $interestDue = floatval($installment['interest_due']);
            $interestPaid = floatval($installment['interest_paid']);
            $principalDue = floatval($installment['principal_due']);
            $principalPaid = floatval($installment['principal_paid']);

            $interestRemaining = $interestDue - $interestPaid;
            $principalRemaining = $principalDue - $principalPaid;

            $interestPayment = 0;
            $principalPayment = 0;

            // Always pay all remaining interest for this period first
            if ($remaining > 0 && $interestRemaining > 0) {
                $interestPayment = min($remaining, $interestRemaining);
                $remaining -= $interestPayment;
            }

            // Then pay principal for this period if any money left
            if ($remaining > 0 && $principalRemaining > 0) {
                $principalPayment = min($remaining, $principalRemaining);
                $remaining -= $principalPayment;
            }

            $newInterestPaid = round($interestPaid + $interestPayment, 2);
            $newPrincipalPaid = round($principalPaid + $principalPayment, 2);
            $newAmountPaid = round($alreadyPaid + $interestPayment + $principalPayment, 2);

            $updateData = [
                'amount_paid' => $newAmountPaid,
                'interest_paid' => $newInterestPaid,
                'principal_paid' => $newPrincipalPaid,
                'payment_date' => date('Y-m-d'),
                'payment_method' => 'advance_payment',
                'status' => ($newAmountPaid >= floatval($installment['amount_due'])) ? 'paid' : 'pending',
            ];

            $success = $repaymentModel->update($id, $updateData);

            if (!$success) {
                log_message('error', "Failed to update installment ID $id");
            } else {
                log_message('debug', "Updated installment ID $id: " . json_encode($updateData));
                $totalInterestPaid += $interestPayment;
                $totalPrincipalPaid += $principalPayment;
            }
        }

        log_message('debug', "Advance payment complete. Remaining unallocated: $remaining");
        if ($remaining <= 0) {
            // Check if all installments are now paid
            $allPaid = $repaymentModel
                ->where('loan_id', $loanId)
                ->where('status !=', 'paid')
                ->countAllResults() === 0;

            if ($allPaid) {
                $loanModel->update($loanId, ['loan_status' => 'paid']);
                log_message('debug', "Loan ID $loanId status updated to 'paid'");
            }
        }
        return [
            'principal_paid' => $totalPrincipalPaid,
            'interest_paid' => $totalInterestPaid
        ];

    }


    public function handleRepayment($data)
    {
        $loanId = $data['loan_id'];
        $amountPaid = floatval($data['amount']);
        $paymentDate = $data['payment_date'] ?? date('Y-m-d');
        $paymentMethod = $data['payment_method'] ?? 'unknown';
        $description = $data['description'] ?? '';
        $user = session()->get('loggedInUser');

        // Apply repayment logic
        $breakdown = $this->applyAdvancePayment($loanId, $amountPaid);

        // Post journal entry
        $journalService = new JournalService();
        $journalService->createLoanRepaymentEntry([
            'loan_id' => $loanId,
            'amount_paid' => $amountPaid,
            'payment_date' => $paymentDate,
            'description' => $description,
            'payment_method' => $paymentMethod,
            'interest_paid' => $breakdown['interest_paid'],
            'principal_paid' => $breakdown['principal_paid'],
        ], $user);
    }
}
