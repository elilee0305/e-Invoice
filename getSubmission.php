<?php

/*  This php file is created in order to validate the document details before proceeding in generating the QR code. 
    
    For further details, do refer to the following links:
    1. https://sdk.myinvois.hasil.gov.my/einvoicingapi/08-get-document-details/
    2. https://sdk.myinvois.hasil.gov.my/standard-header-parameters/
*/

session_start(); // start the session
include 'oauth2_token.php';

// Function to get the cached access token from token_cache.json
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

function getDocumentDetails($uuid) {
    $accessToken = getAccessToken();
    if (!$accessToken) {
        die('Access token not found.');
    }
    /* This is the URL for the production environment*/
    $url = "https://api.myinvois.hasil.gov.my/api/v1.0/documents/{$uuid}/details";

    /* This is the API endpoint for the pre-production (sandbox) environment*/
    //$url = "https://preprod-api.myinvois.hasil.gov.my/api/v1.0/documents/{$uuid}/details";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Request Error: ' . curl_error($ch));
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    // Check for JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('JSON decode error: ' . json_last_error_msg());
    }

    return $responseData;
}

// Example usage to get document details
if (isset($_SESSION['uuid'])) {
    $uuid = $_SESSION['uuid']; // Assuming the uuid is stored in the session
    echo "UUID: " . $uuid . "<br>";
    $documentDetails = getDocumentDetails($uuid);
    echo '<pre>';
    print_r($documentDetails);
    echo '</pre>';
} else {
    die('UUID not found in the session.');
}