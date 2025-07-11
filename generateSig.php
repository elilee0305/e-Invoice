<?php
/* For Debugging Purposes */
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo OPENSSL_VERSION_TEXT;

/* Overall Process : 
-- This file is mainly for generating and signing the document digest and certificate hash. --

1.4 LOAD THE PRIVATE CERTIFICATE > EXTRACT THE PRIVATE KEY > CREATE RSA SIGNATURE FORMATTER > SIGN THE HASH >CONVERT HASH TO BASE64
1.5. LOAD THE PRIVATE CERTIFICATE > COMPUTE THE HASH OF THE CERTIFICATE > CONVERT THE HASH TO BASE64
*/

// Get the current script path
$currentPath = dirname(__FILE__);

// Output the current script path
echo 'Current script path: ' . $currentPath . PHP_EOL;
echo "\n";

// Path to the .p12 file
$p12FilePath = $currentPath . DIRECTORY_SEPARATOR . "certificate" . DIRECTORY_SEPARATOR . "HYBRID_INFINITY_TECH_SDN._BHD..p12";
$p12Password = "Fl8+vyWP"; //softcert pin
echo $p12FilePath ;
echo "\n";

// Check if the file exists and is readable
if (!file_exists($p12FilePath)) {
    die('The .p12 file does  not exist: ' . $p12FilePath);
}
if (!is_readable($p12FilePath)) {
    die('The .p12 file is not readable: ' . $p12FilePath);
}

// Load the .p12 file
try {
       $p12Content = file_get_contents($p12FilePath);
       if ($p12Content === false) {
              die('Failed to read the .p12 file');
       }
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}

// Function to load the certificate and private key
function loadCertificate($p12Content, $p12Password) {
    $certs = [];
    if (!openssl_pkcs12_read($p12Content, $certs, $p12Password)) {
        // Detailed error message
        while ($error = openssl_error_string()) {
            echo "OpenSSL Error: $error\n";
        }
        die('Failed to parse the .p12 file');
    }

    // Validate keys and certificate
    if (!isset($certs['pkey']) || !isset($certs['cert'])) {
        die('The .p12 file does not contain the expected keys or certificate.');
    }

    return $certs;
}

// Load the certificate and private key
$certs = loadCertificate($p12Content, $p12Password);
if (!$certs) {
    die('Failed to load the certificate and private key.');
}

/*
// Extract the certificate and private key from the .p12 file
$certs = [];
if (!openssl_pkcs12_read($p12Content, $certs, $p12Password)) {
    // Detailed error message
    while ($error = openssl_error_string()) {
        echo "OpenSSL Error: $error\n";
    }
    die('Failed to parse the .p12 file');
}

// Validate keys and certificate
if (!isset($certs['pkey']) || !isset($certs['cert'])) {
    die('The .p12 file does not contain the expected keys or certificate.');
}
*/

// The private key
$privateKey = openssl_pkey_get_private($certs['pkey']);

// Validate the private key
if (!$privateKey) {
    while ($error = openssl_error_string()) {
        echo "OpenSSL Error: $error\n";
    }
    die('Failed to get the private key from the .p12 file.');
}

// 1.4 Step 4: Sign the document digest

// Function to sign the SHA-256 hash data using the private key
function signData($data, $privateKey) {
    $signature = '';
    if (!openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
        die('Failed to sign the data');
    }
    return base64_encode($signature);
}

//1.5 Step 5: Generate the certificate hash
// Function to compute the hash of the certificate
function computeCertHash($cert) {

    // Convert certificate to binary format [! important]
    $certBin = base64_decode(preg_replace('/\-{5}.*?\-{5}/', '', $cert));

    // Compute SHA-256 hash
    $certHash = hash('sha256', $certBin, true);
    return base64_encode($certHash);
}

// Output certificate details
echo "\n";
echo 'Certificate: ' . $certs['cert'] . PHP_EOL;

// Print certificate details
$certDetails = openssl_x509_parse($certs['cert']);
if ($certDetails) {
    print_r($certDetails);
} else {
    echo "Failed to parse certificate details.\n";
}
?>
