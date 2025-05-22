<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MembersModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;

class ImportController extends BaseController
{
    public function uploadPage()
    {
        $userModel = new \App\Models\UserModel();
        $loggeinUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggeinUserId);

        if (!$userInfo) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Import Members',
            'userInfo' => $userInfo,
        ];
        return view('members/import_page', $data);
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'member_number', 'first_name', 'last_name', 'dob', 'join_date', 'gender',
            'nationality', 'email', 'phone_number', 'street_address', 'city', 'county', 'zip_code'
        ];

        $sheet->fromArray($headers, NULL, 'A1');
        $sheet->fromArray([
            'M0001', 'Jane', 'Doe', '1990-01-01', '2024-01-01', 'female', 'Kenyan',
            'jane@example.com', '0722000000', '123 Main St', 'Nairobi', 'Nairobi', '00100'
        ], NULL, 'A2');

        $writer = new Xlsx($spreadsheet);
        $filename = 'members_import_template.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$filename}");
        $writer->save('php://output');
        exit;
    }

    public function import()
    {
        $file = $this->request->getFile('import_file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file upload.');
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            array_shift($data);

            if (empty($data)) {
                return redirect()->back()->with('error', 'The uploaded file is empty or improperly formatted.');
            }

            $membersModel = new MembersModel();
            $imported = 0;
            $skipped = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                if (empty($row['A']) || empty($row['B']) || empty($row['C']) || empty($row['D']) || empty($row['E']) || empty($row['F']) || empty($row['G']) || empty($row['H']) || empty($row['I']) || empty($row['J']) || empty($row['K']) || empty($row['L']) || empty($row['M'])) {
                    $errors[] = "Row " . ($index + 2) . " has missing required fields.";
                    continue;
                }

                $member = [
                    'member_number'    => $row['A'],
                    'first_name'       => $row['B'],
                    'last_name'        => $row['C'],
                    'dob'              => $row['D'],
                    'join_date'        => $row['E'],
                    'gender'           => $row['F'],
                    'nationality'      => $row['G'],
                    'email'            => $row['H'],
                    'phone_number'     => $row['I'],
                    'street_address'   => $row['J'],
                    'city'             => $row['K'],
                    'county'           => $row['L'],
                    'zip_code'         => $row['M'],
                    'is_active'        => 1,
                ];

                $existing = $membersModel->where('member_number', $member['member_number'])->first();
                if ($existing) {
                    $skipped++;
                    continue;
                }

                $memberId = $membersModel->insert($member);
                if (!$memberId) {
                    $errors[] = "Failed to import member on row " . ($index + 2);
                    continue;
                }

                $imported++;
            }

            $summary = "$imported members imported successfully.";
            if ($skipped > 0) $summary .= " $skipped duplicates skipped.";
            if (!empty($errors)) $summary .= " Errors: " . implode(' ', $errors);

            return redirect()->back()->with('message', $summary);

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    
}
