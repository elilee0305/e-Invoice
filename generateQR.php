<?php
session_start();
require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Get the values from the session
$envBaseUrl = ''; //  {envbaseurl} will need to be replaced with e-Invoice portal Base URL
$uuid = '';
$longId = '';   // {longId} will be retrieved from the getSubmissions.php

// Construct the validation link
$validationLink = "{$envBaseUrl}/{$uuid}/share/{$longId}";

// Generate the QR code
$qrCode = QrCode::create($validationLink)
    ->setSize(300)
    ->setMargin(10)
    ->setWriter(new PngWriter())
    ->setEncoding('UTF-8')
    ->setErrorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
    ->setLabel('Scan the code', 16, null, \Endroid\QrCode\LabelAlignment::CENTER);

// Write the QR code to a string
$qrCodeString = $qrCode->writeString();

// Encode the QR code string as base64
$base64QrCode = base64_encode($qrCodeString);

// Output the base64-encoded QR code image
echo '<img src="data:image/png;base64,' . $base64QrCode . '" alt="QR Code">';
?>