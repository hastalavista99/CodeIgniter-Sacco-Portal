<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Accounting\TransactionsModel as AccountingTransactionsModel;
use App\Models\MembersModel;
use App\Models\OrganizationModel;
use App\Models\Accounting\TransactionsModel;
use App\Models\LoanApplicationModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class StatementsController extends BaseController
{
    public function downloadSavings($memberNumber)
    {

        $memberModel = new MembersModel();
        $orgModel = new OrganizationModel();
        $transactionsModel = new TransactionsModel();

        $member = $memberModel->where('member_number', $memberNumber)->first();
        if (!$member) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Member not found']);
        }

        $organization = $orgModel->first();
        if (!$organization) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Organization profile is missing']);
        }

        $transactions = $transactionsModel->getSavingsTransactions($memberNumber);

        $data = [
            'member' => $member,
            'organization' => $organization,
            'transactions' => $transactions,
        ];

        $html = view('members/savings_pdf', $data);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // todays date and current time
        $today = date('Y-m-d');
        $time = date('H-i-s');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="savings_' . $today . '_' . $time . '.pdf"')
            ->setBody($dompdf->output());
    }


    public function downloadShares($memberNo)
    {
        $memberModel = new MembersModel();
        $orgModel = new OrganizationModel();
        $transactionsModel = new TransactionsModel();

        $member = $memberModel->where('member_number', $memberNo)->first();
        if (!$member) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Member not found']);
        }

        $organization = $orgModel->first();
        if (!$organization) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Organization profile is missing']);
        }

        $transactions = $transactionsModel->getSharesTransactions($memberNo);

        $data = [
            'member' => $member,
            'organization' => $organization,
            'transactions' => $transactions,
        ];

        $html = view('members/shares_pdf', $data);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // todays date and current time
        $today = date('Y-m-d');
        $time = date('H-i-s');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="shares_' . $today . '_' . $time . '.pdf"')
            ->setBody($dompdf->output());
    }

    public function downloadLoans($memberNo)
    {
        $memberModel = new MembersModel();
        $orgModel = new OrganizationModel();
        $loanModel = new LoanApplicationModel();

        $member = $memberModel->where('member_number', $memberNo)->first();
        if (!$member) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Member not found']);
        }

        $organization = $orgModel->first();
        if (!$organization) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Organization profile is missing']);
        }

        $loans = $loanModel->getMemberLoanSummary($member['id']);

        $data = [
            'member' => $member,
            'organization' => $organization,
            'loans' => $loans,
        ];

        $html = view('members/loans_pdf', $data);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // todays date and current time
        $today = date('Y-m-d');
        $time = date('H-i-s');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="loans_' . $today . '_' . $time . '.pdf"')
            ->setBody($dompdf->output());
    }

    public function downloadTransactions($memberNo)
    {
        $memberModel = new MembersModel();
        $orgModel = new OrganizationModel();
        $transactionsModel = new TransactionsModel();

        $member = $memberModel->where('member_number', $memberNo)->first();
        if (!$member) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Member not found']);
        }

        $organization = $orgModel->first();
        if (!$organization) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Organization profile is missing']);
        }

        $transactions = $transactionsModel->getRecentTransactions($memberNo);

        $data = [
            'member' => $member,
            'organization' => $organization,
            'transactions' => $transactions,
        ];

        $html = view('members/transactions_pdf', $data);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // todays date and current time
        $today = date('Y-m-d');
        $time = date('H-i-s');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="transactions_' . $today . '_' . $time . '.pdf"')
            ->setBody($dompdf->output());
    }
}
