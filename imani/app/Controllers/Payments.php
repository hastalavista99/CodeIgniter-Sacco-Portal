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
        // Get the selected month and year from the query parameters
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year') ?: date('Y'); // Default to the current year if no year is selected

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

        $model = new PaymentsModel();
        $data = [
            'mp_name' => $name . " " . $addName,
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
            $paymentIds = $this->request->getPost('payment_ids');

            // Ensure $postData is correctly parsed
            $postData = $this->request->getJSON();
            if (isset($postData->payment_ids) && is_array($postData->payment_ids)) {
                $paymentIds = $postData->payment_ids;
                // log_message('info', 'Received payment IDs: ' . implode(', ', $paymentIds));
                // Proceed with processing
            }



            if (!empty($paymentIds)) {
                $paymentsModel = new PaymentsModel();
                // log_message('info', 'Received payment IDs: ' . implode(', ', $paymentIds));
                $payments = $paymentsModel->whereIn('mp_id', $paymentIds)->findAll();

                // Logic to create Excel file using PhpSpreadsheet
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'ID');
                $sheet->setCellValue('B1', 'Name');
                $sheet->setCellValue('C1', 'Amount');
                $sheet->setCellValue('D1', 'Trans ID');
                $sheet->setCellValue('E1', 'BillRefNumber');
                $sheet->setCellValue('F1', 'Paybill');
                $sheet->setCellValue('G1', 'Time');

                $row = 2;
                foreach ($payments as $payment) {
                    $sheet->setCellValue('A' . $row, $payment['mp_id']);
                    $sheet->setCellValue('B' . $row, $payment['mp_name']);
                    $sheet->setCellValue('C' . $row, number_format($payment['TransAmount'], 2));
                    $sheet->setCellValue('D' . $row, $payment['TransID']);
                    $sheet->setCellValue('E' . $row, $payment['BillRefNumber']);
                    $sheet->setCellValue('F' . $row, $payment['ShortCode']);
                    $sheet->setCellValue('G' . $row, $payment['mp_date']);
                    $row++;
                }

                $writer = new Xlsx($spreadsheet);
                $fileName = 'payments_export_' . date('Y-m-d_H-i-s') . '.xlsx';
                $filePath = WRITEPATH . 'exports/' . $fileName;
                $writer->save($filePath);

                // Update payments as exported
                $paymentsModel->whereIn('mp_id', $paymentIds)->set(['exported' => 1])->update();

                // Set headers to trigger file download
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                exit; // End the script to prevent further output

                return $this->response->setJSON(['success' => true, 'file' => base_url('exports/' . $fileName)]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'No payments selected.']);
            }
        }
        return redirect()->to(site_url('payments'));
    }
}
