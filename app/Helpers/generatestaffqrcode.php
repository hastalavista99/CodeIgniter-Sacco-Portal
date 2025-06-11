<?php

// app/Helpers/qr_helper.php
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;

if (!function_exists('generateStaffQrCode')) {
    /**
     * Generate a QR code for staff member
     * 
     * @param string $text The text/data to encode in QR
     * @param string $filename The filename to save the QR code
     * @param array $options Additional options for QR code generation
     * @return string|bool The URL of generated QR code or false on failure
     */
    function generateStaffQrCode($text, $filename, array $options = [])
    {
        try {
            // Create QR code
            $qrCode = new QrCode($text);
            
            // Create writer
            $writer = new PngWriter();
            
            // Generate QR code
            $result = $writer->write($qrCode);

            // Ensure directory exists
            $directory = FCPATH . 'uploads/qrcodes';
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0777, true)) {
                    log_message('error', 'Failed to create QR code directory: ' . $directory);
                    return false;
                }
            }

            // Save QR code
            $path = $directory . '/' . $filename;
            if (!file_put_contents($path, $result->getString())) {
                log_message('error', 'Failed to save QR code to: ' . $path);
                return false;
            }

            return base_url('uploads/qrcodes/' . $filename);
        } catch (\Exception $e) {
            log_message('error', 'QR Code generation failed: ' . $e->getMessage());
            return false;
        }
    }
}
