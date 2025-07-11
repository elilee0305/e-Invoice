<?php
session_start(); // Start the session to access session variables

/* Note :
   This file is created as a means to generate the access token to access protected LHDN APIs. The details are sent to the OAuth2.0 identity Service which handles the authentication for accessing the system. 
   Do refer to https://sdk.myinvois.hasil.gov.my/api/08-login-as-intermediary-system/, https://datatracker.ietf.org/doc/html/rfc6749#section-4.4 and https://sdk.myinvois.hasil.gov.my/faq/ for further details.
*/

function getOAuth2Token() {
    // Define the token endpoint URL for the OAuth2.0 identity service

    /* This is the URL for the production environment*/
    $token_url = 'https://api.myinvois.hasil.gov.my/connect/token';
    
    /* This is the API endpoint for the pre-production (sandbox) environment*/
    //$token_url = 'https://preprod-api.myinvois.hasil.gov.my/connect/token';

    // Validate and fetch client_id, client_secret1, and client_secret2 from the session
    $client_id = isset($_SESSION['client_id']) ? str_replace(' ', '', trim($_SESSION['client_id'])) : null;
    if (!$client_id) {
        die('Error: client_id is not defined or empty in the session.');
    }

    $client_secret1 = isset($_SESSION['client_secret1']) ? trim($_SESSION['client_secret1']) : null;
    if (!$client_secret1) {
        die('Error: client_secret1 is not defined or empty in the session.');
    }

    $client_secret2 = isset($_SESSION['client_secret2']) ? trim($_SESSION['client_secret2']) : null;
    if (!$client_secret2) {
        die('Error: client_secret2 is not defined or empty in the session.');
    }
    //$taxpayer_tin = trim($_SESSION['taxpayer_tin']); // Taxpayer TIN for intermediary login

    // Define the grant type and scope
    $grant_type = 'client_credentials';
    $scope = 'InvoicingAPI';

    // Define the cache file path
    $cache_file = 'token_cache.json';

    // Check if a valid token exists in the cache
    if (file_exists($cache_file)) {
        $cache_data = json_decode(file_get_contents($cache_file), true);
        // Check if the token is still valid 
        if ($cache_data && isset($cache_data['expires_at']) && $cache_data['expires_at'] > time()) {
            // Calculate the remaining time until expiration
            $expires_in = $cache_data['expires_at'] - time();
            // Return the cached token if it is still valid
            echo 'Access Token (from cache): ' . $cache_data['access_token'] . "\n";
            echo 'Expires In: ' . $expires_in . ' seconds' . "\n";
            echo 'Token Type: ' . $cache_data['token_type'] . "\n";
            echo 'Scope: ' . $cache_data['scope'] . "\n";
            return $cache_data['access_token'];
        }
    }

    $post_fields = [
        'client_id' => $client_id,
        'client_secret' => $client_secret1,
        'grant_type' => $grant_type,
        'scope' => $scope,
        //'taxpayer_tin' => $taxpayer_tin
    ];

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true); // Specify the POST method
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'Accept-Language: en',
        //'onBehalfOf: ' . $taxpayer_tin //Uncomment this if you are using the LoginAsintermediary 
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));

    // Disable SSL certificate verification (not recommended for production)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    // Decode the response
    $response_data = json_decode($response, true);

    // Check for errors and try the second client_secret if the first fails
    if (isset($response_data['error']) && $response_data['error']) {
        // Try with the second client_secret
        $post_fields['client_secret'] = $client_secret2;
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
        
        // Execute the request again
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }

        // Decode the response again
        $response_data = json_decode($response, true);
    }

    // Check for errors in the response
    if (isset($response_data['access_token'])) {
        // Cache the token based on expires_in response parameter
        $cache_data = [
            'access_token' => $response_data['access_token'],
            'expires_in' => $response_data['expires_in'],
            'token_type' => $response_data['token_type'],
            'scope' => $response_data['scope'],
            //'taxpayer_tin' => $taxpayer_tin
        ];
        file_put_contents($cache_file, json_encode($cache_data));

        // Display the access token -- FOR DEBUGGING PURPOSE
        
        echo 'Access Token: ' . $response_data['access_token'] . "\n";
        echo 'Expires In: ' . $response_data['expires_in'] . ' seconds' . "\n";
        echo 'Token Type: ' . $response_data['token_type'] . "\n";
        echo 'Scope: ' . $response_data['scope'] . "\n";
        

        return $response_data['access_token'];
    } else {
        //echo 'Error: Unable to obtain access token. Response: ';
        return null;
    }
        // Close the cURL session
        curl_close($ch);
}

// Call the function to get the access token
getOAuth2Token();
?>