<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class StatementsController extends ResourceController
{
    public function download($type)
    {
        $memberNumber = $this->request->getGet('member_number');

        if (!$memberNumber || !in_array($type, ['loans', 'savings', 'shares'])) {
            return $this->failValidationErrors('Invalid request');
        }

        // Example: Call existing logic for PDF generation
        helper('pdf'); // if you're using dompdf or mpdf via helper

        $pdfPath = WRITEPATH . "statements/{$memberNumber}_{$type}_statement.pdf";

        // Call your existing service or model to generate the file
        // For now, fake it
        file_put_contents($pdfPath, "PDF content for {$type} - Member {$memberNumber}");

        return $this->response->download($pdfPath, null)->setFileName("statement_{$type}.pdf");
    }
}
