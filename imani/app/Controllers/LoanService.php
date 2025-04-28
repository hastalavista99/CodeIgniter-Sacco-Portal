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
    public function generateInstallments($loanId)
    {
        $loanModel = new LoanApplicationModel();
        $repaymentModel = new LoanRepaymentModel();

        $loan = $loanModel->find($loanId);

        if (!$loan || $loan['loan_status'] !== 'approved') {
            return false;
        }

        $installments = [];
        $startDate = new DateTime($loan['request_date']);
        $monthlyAmount = $loan['monthly_repayment'];
        $period = (int) $loan['repayment_period'];

        for ($i = 1; $i <= $period; $i++) {
            $dueDate = clone $startDate;
            $dueDate->modify("+{$i} months");

            $installments[] = [
                'loan_id'           => $loanId,
                'installment_number' => $i,
                'due_date'          => $dueDate->format('Y-m-d'),
                'amount_due'        => $monthlyAmount,
                'amount_paid'       => 0.00,
                'status'            => 'pending',
            ];
        }

        return $repaymentModel->insertBatch($installments);
    }

    public function applyAdvancePayment($loanId, $amount)
    {
        $repaymentModel = new \App\Models\LoanRepaymentModel();
        $remaining = floatval($amount);

        // Get all installments (pending or partially paid)
        $installments = $repaymentModel
            ->where('loan_id', $loanId)
            ->whereIn('status', ['pending', 'overdue'])
            ->orderBy('due_date', 'ASC')
            ->findAll();

        foreach ($installments as $installment) {
            if ($remaining <= 0) {
                break;
            }

            $due = $installment['amount_due'] - $installment['amount_paid'];
            $payNow = min($due, $remaining);

            $newAmountPaid = $installment['amount_paid'] + $payNow;

            // Calculate new status
            $newStatus = ($newAmountPaid >= $installment['amount_due']) ? 'paid' : 'pending';

            // Update this installment
            $repaymentModel->update($installment['id'], [
                'amount_paid' => $newAmountPaid,
                'payment_date' => date('Y-m-d'),
                'payment_method' => 'advance_payment', // optional
                'status' => $newStatus,
            ]);

            $remaining -= $payNow;
        }

        if ($remaining > 0) {
            // If still remaining (member has overpaid beyond all current installments)
            // Create a new future installment or handle manually (optional)
        }
    }


    public function handleRepayment($data)
    {
        $loanId = $data['loan_id'];
        $amountPaid = floatval($data['amount']);
        $paymentDate = $data['payment_date'] ?? date('Y-m-d');
        $paymentMethod = $data['payment_method'] ?? 'unknown';
        $description = $data['description'] ?? '';
        $user = session()->get('loggedInUser');

        // Apply repayment + advance
        $this->applyAdvancePayment($loanId, $amountPaid);

        // Then create journal entry
        $journalService = new JournalService();
        $journalService->createLoanRepaymentEntry([
            'loan_id' => $loanId,
            'amount_paid' => $amountPaid,
            'payment_date' => $paymentDate,
            'description' => $description,
            'payment_method' => $paymentMethod,
        ], $user);
    }
}
