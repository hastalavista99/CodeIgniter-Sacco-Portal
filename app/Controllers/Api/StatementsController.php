<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Accounting\TransactionsModel as AccountingTransactionsModel;
use App\Models\MembersModel;
use App\Models\OrganizationModel;
use App\Models\Accounting\TransactionsModel;
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

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="savings_statement.pdf"')
            ->setBody($dompdf->output());
    }
}


