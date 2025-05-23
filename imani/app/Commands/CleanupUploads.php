<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CleanupUploads extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'cleanup:uploads';
    protected $description = 'Delete old Excel files from /writable/uploads folder.';

    public function run(array $params)
    {
        $uploadDir = WRITEPATH . 'uploads/';
        $files = glob($uploadDir . 'transactions_*.xlsx');

        $now = time();
        $expiredCount = 0;

        foreach ($files as $file) {
            $lastModified = filemtime($file);

            // Delete if older than 1 hour (3600 seconds)
            if ($lastModified < $now - 3600) {
                if (unlink($file)) {
                    $expiredCount++;
                    CLI::write("Deleted: " . basename($file), 'yellow');
                } else {
                    CLI::error("Failed to delete: " . basename($file));
                }
            }
        }

        if ($expiredCount === 0) {
            CLI::write("No expired files found.", 'cyan');
        } else {
            CLI::write("Total deleted: $expiredCount", 'green');
        }
    }
}
