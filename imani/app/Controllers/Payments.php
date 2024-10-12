<?php

namespace App\Controllers;

use App\Models\PaymentsModel;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Payments extends BaseController
{
    public function index()
    {
        helper('number');
        $model = model(PaymentsModel::class);
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $totalAmount = $model->selectSum('TransAmount')->first()['TransAmount'];

        $total = number_to_currency($totalAmount, 'KES', 'en_US', 2);

        $data = [
            'payments'  => $model->getPayments(),
            'title' => 'Payments',
            'userInfo' => $userInfo,
            'total' => $total,
            'selectedMonth' => NULL,
            'selectedYear' => NULL
        ];

        return view('payments/index', $data);
    }

    public function filter()
    {

        $paymentModel = new PaymentsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        // Get the start and end dates from the request
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');

        // Fetch payments based on the selected date range
        $payments = [];
        if ($startDate && $endDate) {
            $payments = $paymentModel
                ->where('mp_date >=', $startDate)
                ->where('mp_date <=', $endDate)
                ->findAll();
        }

        // Calculate total amount
        $total = array_sum(array_column($payments, 'TransAmount'));

        return view('payments/index', [
            'payments' => $payments,
            'userInfo' => $userInfo,
            'title' => 'Payments',
            'total' => $total,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function show()
    {
        $model = model(PaymentsModel::class);

        $data['payments'] = $model->getPayments();

        if (empty($data['payments'])) {
            throw new PageNotFoundException('Cannot find any payments: ');
        }

        $data['title'] = $data['payments'];

        return view('payments/index', $data);
    }

    public function myPayments()
    {
        helper('number');
        $model = model(PaymentsModel::class);
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $phone = $userInfo['mobile'];

        $payments = $model->where('SUBSTRING(BillRefNumber, -10) =', $phone)->findAll();
        $totalAmount = $model->selectSum('TransAmount')->where('SUBSTRING(BillRefNumber, -10) =', $phone)->first()['TransAmount'];

        $total = number_to_currency($totalAmount, 'KES', 'en_US', 2);

        $data = [
            'payments' => $payments,
            'total' => $total,
            'title' => 'My Payments',
            'userInfo' => $userInfo,
        ];

        return view('payments/individual', $data);
    }

    public function editPage()
    {
        helper(['form', 'url']);
        $pay_id = $this->request->getGet('id');
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $payModel = new PaymentsModel();
        $query = $payModel->find($pay_id);

        $data = [
            'title' => 'Edit Name',
            'userInfo' => $userInfo,
            'payment' => $query,
            'id' => $pay_id
        ];

        return view('payments/edit', $data);
    }

    public function updatePay()
    {
        helper(['form', 'url']);
        $pay_id = $this->request->getGet('id');
        $name = $this->request->getPost('name');
        $addName = $this->request->getPost('addname');
        $member = $this->request->getPost('memberNumber');

        $model = new PaymentsModel();
        $data = [
            'mp_name' => $name . " " . $addName,
            'member_no' => $member
        ];

        $query = $model->update($pay_id, $data);
        if ($query) {
            return redirect()->to('payments')->with('success', 'Successfully updated name');
        } else {
            return redirect()->back()->with('fail', 'Something went wrong, try again later');
        }
    }

    public function export()
{
    if ($this->request->isAJAX()) {
        // Parse JSON data from the request body
        $postData = $this->request->getJSON();
        $paymentIds = $postData->payment_ids ?? [];
        $title = $postData->title ?? '';

        $account_number = match ($title) {
            'Share Capital' => '510100',
            'Saving Deposits' => '380800',
            'Loan Repayments' => '110100',
            default => '211',
        };

        if (!empty($paymentIds)) {
            $paymentsModel = new PaymentsModel();
            $payments = $paymentsModel->whereIn('mp_id', $paymentIds)->findAll();

            // Create Excel spreadsheet using PhpSpreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set the header row
            $sheet->fromArray(['account_number', 'ledger_number', 'transaction_date', 'document_number', 'document_type', 'amount', 'charge_amount', 'loan_number', 'description', 'reference_number', 'reference_type'], null, 'A1'); 

            // Populate the spreadsheet with payment data
            $row = 2;
            foreach ($payments as $payment) {
                $formattedDate = date('d/m/Y', strtotime($payment['mp_date']));
                $sheet->fromArray([
                    $account_number,
                    $payment['member_no'],
                    $formattedDate,
                    '',
                    'VCH',
                    $payment['TransAmount'],
                    '0',
                    '0',
                    $title,
                    '',
                    ''
                ], null, 'A' . $row);
                $row++;
            }

            // Save the file
            $writer = new Xlsx($spreadsheet);
            $fileName = 'payments_export_' . date('Y-m-d_H-i-s') . '.xlsx';
            $filePath = WRITEPATH . 'exports/' . $fileName;
            $writer->save($filePath);

            // Update payments as exported
            $paymentsModel->whereIn('mp_id', $paymentIds)->set(['exported' => 1])->update();

            // Trigger file download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit;

            // Respond with JSON success message (file will download)
            return $this->response->setJSON(['success' => true, 'file' => base_url('exports/' . $fileName)]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No payments selected.']);
        }
    }
    return redirect()->to(site_url('payments'));
}


    public function shares()
    {
        helper(['form', 'url']);
        $paymentModel = new PaymentsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $shares = ['SHA', 'Sha', 'sha'];

        $payments = $paymentModel
            ->groupStart()
            ->like('BillRefNumber', 'SHA%', 'after')
            ->orLike('BillRefNumber', 'Sha%', 'after')
            ->orLike('BillRefNumber', 'sha%', 'after')
            ->groupEnd()
            ->findAll();
            
        $total = (!empty($payments)) ? number_format(array_sum(array_column($payments, 'TransAmount')), 2, '.', ',') : '0.00';
        $data = [
            'payments' => $payments,
            'userInfo' => $userInfo,
            'title'    => 'Share Capital',
            'total'    => $total
        ];

        return view('payments/index', $data);
    }

    public function deposits()
    {
        helper(['form', 'url']);
        $paymentModel = new PaymentsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $deposits = ['DEP', 'Dep', 'dep'];

        $payments = $paymentModel
            ->groupStart()
            ->like('BillRefNumber', 'DEP%', 'after')
            ->orLike('BillRefNumber', 'Dep%', 'after')
            ->orLike('BillRefNumber', 'dep%', 'after')
            ->groupEnd()
            ->findAll();

        $total = (!empty($payments)) ? number_format(array_sum(array_column($payments, 'TransAmount')), 2, '.', ',') : '0.00';
        $data = [
            'payments' => $payments,
            'userInfo' => $userInfo,
            'title'    => 'Saving Deposits',
            'total'    => $total
        ];

        return view('payments/index', $data);
    }

    public function repayments()
    {
        helper(['form', 'url']);
        $paymentModel = new PaymentsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $repayments = ['LON', 'Lon', 'lon'];

        $payments = $paymentModel
            ->groupStart()
            ->like('BillRefNumber', 'LON%', 'after')
            ->orLike('BillRefNumber', 'Lon%', 'after')
            ->orLike('BillRefNumber', 'lon%', 'after')
            ->groupEnd()
            ->findAll();
        $total = (!empty($payments)) ? number_format(array_sum(array_column($payments, 'TransAmount')), 2, '.', ',') : '0.00';
        $data = [
            'payments' => $payments,
            'userInfo' => $userInfo,
            'title'    => 'Loan Repayments',
            'total'    => $total
        ];

        return view('payments/index', $data);
    }
    public function group()
    {
        helper(['form', 'url']);
        $paymentModel = new PaymentsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $repayments = ['G'];

        $payments = $paymentModel
            ->groupStart()
            ->like('BillRefNumber', 'G%', 'after')
            ->orLike('BillRefNumber', 'g%', 'after')
            ->groupEnd()
            ->findAll();
        $total = (!empty($payments)) ? number_format(array_sum(array_column($payments, 'TransAmount')), 2, '.', ',') : '0.00';
        $data = [
            'payments' => $payments,
            'userInfo' => $userInfo,
            'title'    => 'Group Payments',
            'total'    => $total
        ];

        return view('payments/individual', $data);
    }

    public function payDetails($billReff)
    {
        helper(['form', 'url']);

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $model = new PaymentsModel();

        $payments = $model->where('SUBSTRING(BillRefNumber, -10) =', $billReff)->findAll();
        $totalAmount = $model->selectSum('TransAmount')->where('SUBSTRING(BillRefNumber, -10) =', $billReff)->first()['TransAmount'];

        $total = (!empty($payments)) ? number_format(array_sum(array_column($payments, 'TransAmount')), 2, '.', ',') : '0.00';

        $data = [
            'payments' => $payments,
            'total' => $total,
            'title' => 'Group Payments',
            'userInfo' => $userInfo,
        ];

        return view('payments/individual', $data);
    }
}
