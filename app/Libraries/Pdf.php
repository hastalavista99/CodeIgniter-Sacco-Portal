<?php
namespace App\Libraries;

use TCPDF;

class Pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();

        // Customize TCPDF settings here (optional)
        $this->SetAuthor('Your App');
        $this->SetTitle('Document Title');
        $this->SetMargins(10, 10, 10);
        $this->SetAutoPageBreak(TRUE, 10);
    }
}
