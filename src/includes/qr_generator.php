<?php
// qr_generator.php
// This file contains the logic for generating QR codes for student registration.

require_once 'vendor/autoload.php'; // Include the Composer autoload file

use Endroid\QrCode\QrCode; // Use the QrCode class from the Endroid library

/**
 * Generates a QR code for a given student ID.
 *
 * @param string $studentId The ID of the student for whom the QR code is generated.
 * @return string The file path of the generated QR code image.
 */
function generateQrCode($studentId) {
    // Create a new QR code instance
    $qrCode = new QrCode($studentId);
    
    // Set the size and error correction level
    $qrCode->setSize(300);
    $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
    
    // Define the file path to save the QR code image
    $filePath = __DIR__ . '/../assets/images/qrcodes/' . $studentId . '.png';
    
    // Save the QR code image to the specified file path
    $qrCode->writeFile($filePath);
    
    return $filePath; // Return the file path of the generated QR code
}
?>