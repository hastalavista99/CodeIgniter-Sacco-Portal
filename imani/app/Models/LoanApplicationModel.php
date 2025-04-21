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

    // Get all loan IDs for the member
    $loanIds = $db->table('loan_applications')
        ->select('id')
        ->where('member_id', $memberId)
        ->get()
        ->getResultArray();

    if (empty($loanIds)) {
        return [
            'total_disbursed' => 0,
            'total_due' => 0,
            'total_paid' => 0,
            'balance' => 0,
        ];
    }

    $loanIds = array_column($loanIds, 'id');

    // Get total disbursed
    $totalDisbursed = $db->table('loan_applications')
        ->selectSum('disburse_amount', 'total_disbursed')
        ->where('member_id', $memberId)
        ->get()
        ->getRow()
        ->total_disbursed;

    // Sum up repayment data
    $repaymentQuery = $db->table('loan_repayments')
        ->select('SUM(amount_due) as total_due, SUM(amount_paid) as total_paid')
        ->whereIn('loan_id', $loanIds)
        ->get()
        ->getRow();

    $totalDue = $repaymentQuery->total_due ?? 0;
    $totalPaid = $repaymentQuery->total_paid ?? 0;
    $balance = $totalDue - $totalPaid;

    return [
        'total_disbursed' => $totalDisbursed,
        'total_due'       => $totalDue,
        'total_paid'      => $totalPaid,
        'balance'         => $balance,
    ];
}
}
