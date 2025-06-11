<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanRepaymentModel extends Model
{
    protected $table            = 'loan_repayments';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'loan_id',
        'installment_number',
        'due_date',
        'principal_due',
        'interest_due',
        'principal_paid',
        'interest_paid',
        'amount_due',
        'amount_paid',
        'payment_date',
        'status',
        'payment_method',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules (optional)
    protected $validationRules = [
        'loan_id'           => 'required|is_natural_no_zero',
        'installment_number'=> 'required|integer',
        'due_date'          => 'required|valid_date',
        'amount_due'        => 'required|decimal',
        'amount_paid'       => 'permit_empty|decimal',
        'status'            => 'in_list[pending,paid,overdue]',
    ];

    /**
     * Get all installments for a specific loan
     */
    public function getInstallments($loanId)
    {
        return $this->where('loan_id', $loanId)
                    ->orderBy('installment_number', 'ASC')
                    ->findAll();
    }

    /**
     * Get total balance for a loan
     */
    public function getLoanBalance($loanId)
    {
        return $this->select('SUM(amount_due) as total_due, SUM(amount_paid) as total_paid')
                    ->where('loan_id', $loanId)
                    ->groupBy('loan_id')
                    ->first();
    }

    /**
     * Get total loan balance for a member (cross-loan)
     */
    public function getMemberLoanBalance($memberId)
    {
        return $this->db->table('loan_repayments lr')
                        ->select('SUM(lr.amount_due) as total_due, SUM(lr.amount_paid) as total_paid')
                        ->join('loan_applications la', 'la.id = lr.loan_id')
                        ->where('la.member_id', $memberId)
                        ->get()
                        ->getRow();
    }

    /**
     * Get next due installment for a loan
     */
    public function getNextDueInstallment($loanId)
    {
        return $this->where('loan_id', $loanId)
                    ->where('status', 'pending')
                    ->orderBy('due_date', 'ASC')
                    ->first();
    }

    /**
     * Update payment for an installment
     */
    public function recordPayment($repaymentId, $amountPaid, $paymentDate = null, $paymentMethod = null)
    {
        $data = [
            'amount_paid'   => $amountPaid,
            'payment_date'  => $paymentDate ?? date('Y-m-d'),
            'status'        => 'paid',
            'payment_method'=> $paymentMethod,
        ];

        return $this->update($repaymentId, $data);
    }


    public function getRepaymentsByLoan($loanId)
    {
        return $this->where('loan_id', $loanId)->orderBy('installment_number')->findAll();
    }

    public function getOutstandingBalance($loanId)
    {
        return $this->selectSum('amount_due - amount_paid', 'balance')
                    ->where('loan_id', $loanId)
                    ->where('status !=', 'paid')
                    ->first();
    }

    public function getTotalPaid($loanId)
    {
        return $this->selectSum('amount_paid', 'total_paid')
                    ->where('loan_id', $loanId)
                    ->first();
    }

    

}
