<?php
namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Models\Accounting\JournalEntryModel;

class ReportsController extends BaseController
{
    public function trialBalance()
    {
        $model = new JournalEntryModel();
        $data['entries'] = $model->findAll();
        return view('Modules\Accounting\Views\trial_balance', $data);
    }

    public function balanceSheet()
    {
        $model = new JournalEntryModel();
        $data['entries'] = $model->findAll();
        return view('Modules\Accounting\Views\trial_balance', $data);
    }
}
