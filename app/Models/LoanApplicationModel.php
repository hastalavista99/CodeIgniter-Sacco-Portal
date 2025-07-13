<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanApplicationModel extends Model
{
    protected $table = 'loan_applications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'member_id',
        'loan_type_id',
        'interest_method',
        'interest_rate',
        'insurance_premium',
        'crb_amount',
        'service_charge',
        'principal',
        'repayment_period',
        'request_date',
        'total_loan',
        'total_interest',
        'fees',
        'monthly_repayment',
        'disburse_amount',
        'loan_status',
        'created_at'
    ];

    public function getAllApplicationsWithDetails()
    {
        return $this->select('
            loan_applications.*,
            members.member_number,
            members.first_name AS member_first_name,
            members.last_name AS member_last_name,
            members.phone_number AS member_mobile,
            loan_types.loan_name
        ')
            ->join('members', 'members.id = loan_applications.member_id')
            ->join('loan_types', 'loan_types.id = loan_applications.loan_type_id')
            ->orderBy('loan_applications.created_at', 'DESC')
            ->findAll();
    }



    public function getApplicationWithDetails($loanAppId)
    {
        // Get the main loan application with member and loan type
        $application = $this->select('
            loan_applications.*,
            members.member_number,
            members.email,
            members.first_name AS member_first_name,
            members.last_name AS member_last_name,
            members.phone_number AS member_mobile,
            loan_types.loan_name
        ')
            ->join('members', 'members.id = loan_applications.member_id')
            ->join('loan_types', 'loan_types.id = loan_applications.loan_type_id')
            ->where('loan_applications.id', $loanAppId)
            ->first();

        if (!$application) {
            return null;
        }

        // Load guarantors from loan_guarantors table
        $db = \Config\Database::connect();

        $guarantors = $db->table('loan_guarantors')
            ->select('guarantor_member_no, name, mobile, amount')
            ->where('loan_application_id', $loanAppId)
            ->get()
            ->getResultArray();

        // Attach guarantors to the application
        $application['guarantors'] = $guarantors;

        return $application;

        // expected output
        /** {
        "id": 5,
        "member_id": 12,
        "loan_type_id": 3,
        "principal": "150000",
        "repayment_period": 18,
        "request_date": "2025-04-17",
        "member_number": "M0012",
        "member_name": "Alice Njeri",
        "member_mobile": "0722001122",
        "loan_name": "Emergency Loan",
        "guarantors": [
            {
            "guarantor_member_no": "M0045",
            "name": "Daniel Kipkoech",
            "mobile": "0711002200",
            "amount": "30000.00"
            },
            {
            "guarantor_member_no": "M0047",
            "name": "Linet Achieng",
            "mobile": "0700332211",
            "amount": "45000.00"
            }
        ]
        }
         */
    }

    public function getLoansByMember($memberId)
    {
        return $this->where('member_id', $memberId)->findAll();
    }

    public function getLoanDetails($loanId)
    {
        return $this->find($loanId);
    }

    public function getMemberLoanSummary($memberId)
    {
        $db = \Config\Database::connect();

        // Get loan applications for the member
        $loans = $db->table('loan_applications')
            ->select('id, disburse_amount')
            ->where('member_id', $memberId)
            ->where('loan_status', 'approved')
            ->orderBy('request_date', 'DESC')
            ->get()
            ->getResultArray();

        if (empty($loans)) {
            return [];
        }

        $loanSummaries = [];

        foreach ($loans as $loan) {
            $loanId = $loan['id'];
            $disbursed = $loan['disburse_amount'];

            // Get repayment summary for this loan
            $repayment = $this->select('loan_applications.*, loan_repayments.amount_due, SUM(loan_repayments.amount_paid) AS amount_paid')
                ->join('loan_repayments', 'loan_repayments.loan_id = loan_applications.id', 'left')
                ->where('loan_applications.id', $loanId)
                ->get()
                ->getRow();

            $totalDue  = $repayment->total_loan ?? 0;
            $totalPaid = $repayment->amount_paid ?? 0;
            $balance   = $totalDue - $totalPaid;

            $loanSummaries[] = [
                'loan_id'         => $loanId,
                'disbursed'       => $disbursed,
                'total_due'       => $totalDue,
                'total_paid'      => $totalPaid,
                'balance'         => $balance,
            ];
        }

        return $loanSummaries;
    }

    public function getMemberLoanBalance($memberId, $loanId)
    {
        $db = \Config\Database::connect();

        // Fetch the specific loan for the member
        $loan = $db->table('loan_applications')
            ->select('id, disburse_amount')
            ->where('id', $loanId)
            ->where('member_id', $memberId)
            ->where('loan_status', 'approved')
            ->get()
            ->getRow();

        if (!$loan) {
            return null; // or return []; depending on how you want to handle "not found"
        }

        $disbursed = $loan->disburse_amount;

        // Get repayment summary for this loan
        $repayment = $this->select('loan_applications.*, SUM(loan_repayments.amount_paid) AS amount_paid')
            ->join('loan_repayments', 'loan_repayments.loan_id = loan_applications.id', 'left')
            ->where('loan_applications.id', $loanId)
            ->get()
            ->getRow();

        $totalDue  = $repayment->total_loan ?? 0;
        $totalPaid = $repayment->amount_paid ?? 0;
        $balance   = $totalDue - $totalPaid;

        return [
            'loan_id'    => $loanId,
            'disbursed'  => $disbursed,
            'total_due'  => $totalDue,
            'total_paid' => $totalPaid,
            'balance'    => round($balance, 2),
        ];
    }


    // get total for all loans in the system
    public function getTotalLoans()
    {
        $db = \Config\Database::connect();

        $total = $db->table('loan_applications')
            ->selectSum('disburse_amount')
            ->where('loan_status', 'approved')
            ->get()
            ->getRow();

        return $total->disburse_amount ?? 0;
    }

    public function getMemberLoans(int $memberId): array
{
    return $this->builder()
        ->select([
            'l.id AS loanId',                    // 👈 unique per row
            'l.member_id',
            'lt.loan_name AS loanType',
            'l.principal',
            'l.loan_status AS loanStatus',
            'l.created_at AS requestDate',
        ])
        ->from("$this->table l")
        ->join('loan_types lt', 'lt.id = l.loan_type_id')
        ->where('l.member_id', $memberId)
        ->groupBy('l.id')                        // 👈 prevents 1-to-many blowup
        ->orderBy('l.created_at', 'DESC')
        ->get()
        ->getResultArray();
}
}
