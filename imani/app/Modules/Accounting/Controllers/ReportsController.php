<?php
namespace Modules\Accounting\Controllers;

use App\Controllers\BaseController;
use Modules\Accounting\Models\JournalEntryModel;

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
