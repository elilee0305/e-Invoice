<?php
session_start(); // Start the session

include 'oauth2_token.php'; // Include oauth2_token.php directly

// Define the certificate password
define('CERTIFICATE_PASSWORD', 'On7@e*ki');

// Define the json document without any signature
$invoiceJson = json_decode(file_get_contents('JsonWithOutSignature.json'), true);

// Automatically generate IssueDate and IssueTime
$issueDate = gmdate('Y-m-d');
$issueTime = gmdate('H:i:s\Z');
$invoiceJson['Invoice'][0]['IssueDate'][0]['_'] = $issueDate;
$invoiceJson['Invoice'][0]['IssueTime'][0]['_'] = $issueTime;

// Function to extract TIN from the access token
function getTINFromToken($token) {
    $tokenParts = explode(".", $token);
    if (count($tokenParts) < 3) {
        die('Invalid JWT token structure.');
    }

    $tokenPayload = base64_decode($tokenParts[1]);
    if (!$tokenPayload) {
        die('Failed to decode JWT payload.');
    }

    $jwtPayload = json_decode($tokenPayload, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Failed to decode JSON payload: ' . json_last_error_msg());
    }

    echo "JWT Payload: " . json_encode($jwtPayload, JSON_PRETTY_PRINT) . PHP_EOL;

    return $jwtPayload['TaxpayerTIN'] ?? null; 
}

// Function to get the access token from token_cache.json
function getAccessToken() {
    $tokenCachePath = __DIR__ . DIRECTORY_SEPARATOR . 'token_cache.json';
    if (file_exists($tokenCachePath)) {
        $tokenData = json_decode(file_get_contents($tokenCachePath), true);
        if (isset($tokenData['access_token'])) {
            return $tokenData['access_token'];
        }
    }
    return null;
}

// Retrieve the access token
$accessToken = getAccessToken();
if (!$accessToken) {
    die('Access token not found.');
}
echo "Access Token: " . $accessToken . PHP_EOL;

// Extract the authenticated TIN from the access token
$authenticatedTIN = getTINFromToken($accessToken);
if (!$authenticatedTIN) {
    die('Authenticated TIN not found.');
}
echo "Authenticated TIN: " . $authenticatedTIN . PHP_EOL;

// Ensure the TIN in the JSON document matches the authenticated TIN
array_walk_recursive($invoiceJson, function (&$value, $key) use ($authenticatedTIN) {
    if ($key === 'ID' && isset($value['schemeID']) && $value['schemeID'] === 'TIN') {
        $value['_'] = $authenticatedTIN;
    }
});

// Save the updated JSON document back to the file
file_put_contents('JsonWithOutSignature.json', json_encode($invoiceJson, JSON_PRETTY_PRINT));

// Output the updated JSON for debugging
echo '<pre>' . json_encode($invoiceJson, JSON_PRETTY_PRINT) . '</pre>';

// API Endpoint to the SubmitDocuments API (Sandbox Environment)
define('SUBMIT_DOCUMENTS_URL', 'https://preprod-api.myinvois.hasil.gov.my/api/v1.0/documentsubmissions');

/* 1. Prepare JSON document in canonical version, to be used for signing by performing these steps:
    - Minify the JSON document
    - Hash the canonicalized document invoice body using SHA-256    
*/

function prepareJsonDocument($invoiceJson) {
    // Minify the JSON
    $jsonString = json_encode($invoiceJson, JSON_UNESCAPED_SLASHES);
    $jsonMinified = preg_replace('/\s+/', '', $jsonString); 
    
    // Remove escape sequences except for double quotes
    $jsonMinified = str_replace(['\\r', '\\n', '\\t'], '', $jsonMinified);

    // Hash the canonicalized document using SHA-256
    $hash = hash('sha256', $jsonMinified, true); // SHA-256 Hash
    $base64Hash = base64_encode($hash); // Base64 encode the hash
    return [$jsonMinified, $hash, $base64Hash];
}

// Prepare the JSON document
list($jsonMinified, $hash, $base64Hash) = prepareJsonDocument($invoiceJson);

// Debugging output to verify minified JSON and hash
echo '<br>';
echo "Minified JSON: " . $jsonMinified . PHP_EOL;
echo "SHA-256 Hash (Base64): " . $base64Hash . PHP_EOL;

// Set the DocDigest property by assigning the encoded hash to the Doc Digest
echo '<br>';
$docDigest = $base64Hash;
echo "DocDigest: " . $docDigest . PHP_EOL;

// Load the certificate and private key
$certs = loadCertificate();
$privateKey = openssl_pkey_get_private($certs['pkey']);
if (!$privateKey) {
    die('Failed to get the private key from the .p12 file.');
}

// Sign the document digest
$sig = signData($docDigest, $privateKey);
echo "Signature (Sig): " . $sig . PHP_EOL;

// Compute the certificate hash
$certHashBase64 = computeCertHash($certs['cert']);
echo 'SHA-256 cert Hash in Base64: ' . $certHashBase64 . PHP_EOL;

// Create the signature chunk
$signatureChunk = createSignatureChunk($base64Hash, $sig, $certHashBase64, $serialNumber, $certData, $propsDigest, $issuerName);

// Ensure $signatureChunk is an array before merging
if (!is_array($signatureChunk)) {
    die('Error: $signatureChunk is not an array.');
}

// Output the signature chunk for debugging
echo '<br>';
echo "Signature Chunk: " . json_encode($signatureChunk, JSON_PRETTY_PRINT) . PHP_EOL;

// Merge the signature chunk with the original JSON document
$signedJson = json_encode(array_merge($invoiceJson, $signatureChunk), JSON_UNESCAPED_SLASHES);

// Output the signed JSON for debugging
echo '<br>';
echo "Signed JSON: " . $signedJson . PHP_EOL;

// Save the signed JSON to a file
file_put_contents('testLHDN.json', $signedJson);

// Base64 encode the signed JSON document
$base64SignedJson = base64_encode($signedJson);

// Decode the base64 encoded signed JSON to pretty print it
$decodedSignedJson = base64_decode($base64SignedJson);
$prettyPrintedSignedJson = json_encode(json_decode($decodedSignedJson, true), JSON_PRETTY_PRINT);

// Output the base64 encoded signed JSON for debugging (without minification)
echo '<br>';
echo "Base64 Encoded Signed JSON (Pretty): " . base64_encode($prettyPrintedSignedJson) . PHP_EOL;

// Create the submission payload
$payload = [
    "documents" => [
        [
            "format" => "JSON",
            "documentHash" => $docDigest,
            "codeNumber" => $invoiceJson['Invoice'][0]['ID'][0]['_'], // Use the invoice ID
            "document" => base64_encode($prettyPrintedSignedJson)
        ]
    ]
];

// Echo the payload for debugging
echo '<br>';
echo "Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . PHP_EOL;

// Function to submit the document
function submitDocument($payload) {
    $accessToken = getOAuth2Token();
    if (!$accessToken) {
        die('Access token not found.');
    }

    $ch = curl_init(SUBMIT_DOCUMENTS_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken,
        'Accept-Language: en',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Request Error: ' . curl_error($ch));
    }

    curl_close($ch);

    return $response;
}

// Submit the signed document to the API endpoint
$response = submitDocument($payload);

// Output Response
echo '<br>';
echo "API Response: " . $response;
?>