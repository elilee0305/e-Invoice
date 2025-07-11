<?php
session_start();

/* For further details, do refer to the following links:
    1. https://sdk.myinvois.hasil.gov.my/signature/
    2. https://sdk.myinvois.hasil.gov.my/signature-creation-json/
    3. https://sdk.myinvois.hasil.gov.my/einvoicingapi/02-submit-documents/
    4. https://sdk.myinvois.hasil.gov.my/standard-header-parameters/

    *** Important resource to refer to :
    https://github.com/mokth/einvoice/blob/main/WinEInvoiceApp/
*/

// Include in the codes for generating the access token, extracting certificate, signing and hashing the DocDigest
include 'generateSig.php';
include 'oauth2_token.php';

// Certificate Path and Password
// Get the current script path
$currentPath = dirname(__FILE__);
    
// Output the current script path
echo 'Current script path: ' . $currentPath . PHP_EOL;

define('CERTIFICATE_PATH', $currentPath . DIRECTORY_SEPARATOR . 'certificate' . DIRECTORY_SEPARATOR . 'HYBRID_INFINITY_TECH_SDN._BHD..p12');
define('CERTIFICATE_PASSWORD', 'Fl8+vyWP');

// Define the json document without any signature
//$invoiceJson = json_decode(file_get_contents('JsonWithOutSignature.json'), true);
$invoiceJson = json_decode(file_get_contents('testLHDN.json'), true);

// Automatically generate IssueDate and IssueTime
$issueDate = gmdate('Y-m-d');
$issueTime = gmdate('H:i:s\Z');
$invoiceJson['Invoice'][0]['IssueDate'][0]['_'] = $issueDate;
$invoiceJson['Invoice'][0]['IssueTime'][0]['_'] = $issueTime;

// Function to get the access token from token_cache.json
function getAccessToken() {
    $tokenCachePath = __DIR__ . DIRECTORY_SEPARATOR . 'token_cache.json';
    if (file_exists($tokenCachePath)) {
        $tokenData = json_decode(file_get_contents($tokenCachePath), true);
        if (isset($tokenData['access_token']) && isset($tokenData['expires_at']) && $tokenData['expires_at'] > time()) {
            return $tokenData['access_token'];
        }
    }

    // If token is missing or expired, generate a new one
    include_once 'oauth2_token.php';
    return getOAuth2Token();
}

// Retrieve the access token
$accessToken = getAccessToken();
if (!$accessToken) {
    die('Access token not found or could not be generated.');
}

// API Endpoint to the SubmitDocuments API (Sandbox Environment)
//define('SUBMIT_DOCUMENTS_URL', 'https://preprod-api.myinvois.hasil.gov.my/api/v1.0/documentsubmissions');

/* This is the URL for the production environment*/
define('SUBMIT_DOCUMENTS_URL', 'https://api.myinvois.hasil.gov.my/api/v1.0/documentsubmissions');

/* 1. Prepare JSON document in canonical version, to be used for signing by performing these steps:
    - Minify the JSON document
    - Hash the canonicalized document invoice body using SHA-256    
*/

function prepareJsonDocument($invoiceJson) {
    // Minify the JSON
    $jsonString = json_encode($invoiceJson, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // Sign the docDigest 
    /*
    $signatureValid = openssl_sign($documentString, $signature, $privateKey, OPENSSL_ALGO_SHA256);
$signatureBase64 = base64_encode($signature);

openssl_free_key($privateKey);
return $signatureBase64;
*/

    // Hash the canonicalized document using SHA-256
    $hash = hash('sha256', $jsonString, true); // SHA-256 Hash    
    $docDigest = base64_encode($hash); // Base64 encode the hash    
    return [$jsonString, $hash, $docDigest];
}

// signing the actual data and submitting the signed data resolves the issues. 
/*
signing the docDigest that hadn't been hashed and converting it to Base64 which 
is a pure JSON object or document that doesn't contain the 'signature' or 'ublextension' elements.
*/
//DS333- Docdigest (raw format; no ubl extensions / signature -> convert to base 64) 

/* FOR DEBUGGING PURPOSES */
echo '<br>';
list($jsonMinified, $hash, $docDigest) = prepareJsonDocument($invoiceJson);

// Debugging output to verify minified JSON and hash
echo '<br>';
echo "Minified JSON: " . $jsonMinified . PHP_EOL;
echo "SHA-256 Hash (Base64): " . $docDigest . PHP_EOL;

echo "DocDigest: " . $docDigest . PHP_EOL;

// Load the certificate and private key
$p12Content = file_get_contents(CERTIFICATE_PATH);
$certs = loadCertificate($p12Content, CERTIFICATE_PASSWORD);
if (!$certs) {
    die('Failed to load the certificate and private key.');
}
$privateKey = openssl_pkey_get_private($certs['pkey']);
if (!$privateKey) {
    die('Failed to get the private key from the .p12 file.');
}

/* 2. Generate Digital Signature: Sign the generated invoice hash (DocDigest) with RSA-SHA256 using the signing certificate private key
   Please refer to the code in generateSig.php#id-xades-signed-props
*/
echo '<br>';
$sig = signData($docDigest, $privateKey);
echo "Signature (Sig): " . $sig . PHP_EOL;

// 3. Generate the certificate hash using the function from generateSig.php
echo '<br>';
$certHashBase64 = computeCertHash($certs['cert']);
echo 'SHA-256 cert Hash in Base64 (certHash): ' . $certHashBase64 . PHP_EOL;

/* 4. Populate the signed properties section by performing these:
    4.1 - Calculate the DigestValue(3), SigningTime, X509SerialNumber and X509IssuerName 
    4.2 - Obtain the qualifyingProperties properties in string format > minify the string > compute the hashed of the signed properties > covert to base64
    4.3 - Assign it to PropsDigest
*/

/* 
4.1a - Calculate the DigestValues
    1st DigestValue is referring to the DocDigest (SHA-256 hash of the canonicalized (minified) JSON document)
    2nd DigestValue is referring to the CertDigest (CertHash)
    3rd DigestValue is referring to the PropsDigest (SHA-256 hash of the minified string of the signed properties)
*/

//4.1b - Calculate the SigningTime (Note: make sure the SigningTime in the chunk is later than document submission time)

// Set the SigningTime to a time slightly later than the current time
echo '<br>';
$signingTime = gmdate('Y-m-d\TH:i:s\Z');
echo "Signing Time: " . $signingTime . PHP_EOL;

//4.1c - Calculate the X509SerialNumber
// Note: Use the SerialNumber of the private certificate (.p12), convert the hexadecimal string to a BigInteger
function getCertSerialNumber($cert) {
    $certDetails = openssl_x509_parse($cert);
    $serialNumberHex = $certDetails['serialNumberHex'];
    $serialNumber = hexdec($serialNumberHex); // Convert hex to decimal
    $serialNumberStr = (string)$serialNumber; // Convert to string to handle BigInteger
    echo "Serial Number (BigInteger): " . $serialNumberStr . PHP_EOL;
    return $serialNumberStr;
}

// Get the certificate serial number (BigInteger)
$serialNumber = getCertSerialNumber($certs['cert']);
echo $serialNumber . PHP_EOL;

// Function to get the certificate data in Base64 string
function getX509Certificate($cert) {
    return base64_encode($cert);
}

// Extract certificate data
$base64CertData = getX509Certificate($certs['cert']);
echo "Certificate Data (Base64): " . $base64CertData . PHP_EOL;

$certData = openssl_x509_parse($certs['cert']);

// Extract and format the X509IssuerName
$issuerArray = $certData['issuer'];
$issuerName = "CN={$issuerArray['CN']}, OU={$issuerArray['OU']}, O={$issuerArray['O']}, C={$issuerArray['C']}";
echo "X509IssuerName: " . $issuerName . PHP_EOL;

// Get the certificate issuer name
echo "Issuer Name: " . $issuerName . PHP_EOL;

//4.2 - Obtain the qualifyingProperties properties in json string format > minify the string > compute the hashed of the signed properties > covert to base64

// Create an array and populate the qualifying properties with the calculated values 
$qualifyingProperties = [
    "QualifyingProperties" => [
    [
    "Target" => "signature",
    "SignedProperties" => [
        [
            "Id" => "id-xades-signed-props",
            "SignedSignatureProperties" => [
                [
                    "SigningTime" => [
                        ["_" => $signingTime]
                    ],
                    "SigningCertificate" => [
                        [
                            "Cert" => [
                                [
                                    "CertDigest" => [
                                        [
                                            "DigestMethod" => [
                                                ["_" => "", "Algorithm" => "http://www.w3.org/2001/04/xmlenc#sha256"]
                                            ],
                                            "DigestValue" => [
                                                ["_" => $certHashBase64]
                                            ]
                                        ]
                                    ],
                                    "IssuerSerial" => [
                                        [
                                            "X509IssuerName" => [
                                                ["_" => $issuerName]
                                            ],
                                            "X509SerialNumber" => [
                                                ["_" => $serialNumber]
                                                ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

//Extract the SignedProperties Block Only
$signedProperties = $qualifyingProperties["QualifyingProperties"][0];
echo "Signed Properties: " . json_encode($signedProperties, JSON_PRETTY_PRINT) . PHP_EOL;
//Convert to Compact JSON (Linearization)
$linearizedJson = json_encode($signedProperties, JSON_UNESCAPED_SLASHES);
echo "Linearized JSON: " . $linearizedJson . PHP_EOL;
//Generate the sha256 hash
$hash = hash("sha256", $linearizedJson, true);  // Output in raw binary
echo "Hash: " . $hash . PHP_EOL;
//Encode the hash in base64
$propsDigest = base64_encode($hash);

// Debugging Output
echo "Signed Properties: " . json_encode($signedProperties, JSON_PRETTY_PRINT) . PHP_EOL;
echo "Linearized JSON: " . $linearizedJson . PHP_EOL;
echo "PropsDigest: " . $propsDigest . PHP_EOL;

// Function to create the signature chunk
function createSignatureChunk($signingTime, $docDigest, $sig, $certHashBase64, $serialNumber, $base64CertData, $propsDigest, $issuerName) {
    return [
        "UBLExtensions" => [
            [
                "UBLExtension" => [
                    [
                        "ExtensionURI" => [
                            [
                                "_" => "urn:oasis:names:specification:ubl:dsig:enveloped:xades"
                            ]
                        ],
                        "ExtensionContent" => [
                            [
                                "UBLDocumentSignatures" => [
                                    [
                                        "SignatureInformation" => [
                                            [
                                                "ID" => [
                                                    [
                                                        "_" => "urn:oasis:names:specification:ubl:signature:1"
                                                    ]
                                                ],
                                                "ReferencedSignatureID" => [
                                                    [
                                                        "_" => "urn:oasis:names:specification:ubl:signature:Invoice"
                                                    ]
                                                ],
                                                "Signature" => [
                                                    [
                                                        "Id" => "signature",
                                                        "Object" => [
                                                            [
                                                                "QualifyingProperties" => [
                                                                    [
                                                                        "Target" => "signature",
                                                                        "SignedProperties" => [
                                                                            [
                                                                                "Id" => "id-xades-signed-props",
                                                                                "SignedSignatureProperties" => [
                                                                                    [
                                                                                        "SigningTime" => [
                                                                                            [
                                                                                                "_" => $signingTime
                                                                                            ]
                                                                                        ],
                                                                                        "SigningCertificate" => [
                                                                                            [
                                                                                                "Cert" => [
                                                                                                    [
                                                                                                           "CertDigest" => [
                                                                                                            [
                                                                                                                "DigestMethod" => [
                                                                                                                    [
                                                                                                                        "_" => "",
                                                                                                                        "Algorithm" => "http://www.w3.org/2001/04/xmlenc#sha256"
                                                                                                                    ]
                                                                                                                ],
                                                                                                                "DigestValue" => [
                                                                                                                    [
                                                                                                                        "_" => $certHashBase64 // Replace Value 3
                                                                                                                    ]
                                                                                                                ]
                                                                                                            ]
                                                                                                        ],
                                                                                                        "IssuerSerial" => [
                                                                                                            [
                                                                                                                "X509IssuerName" => [
                                                                                                                    [
                                                                                                                        "_" => $issuerName
                                                                                                                    ]
                                                                                                                ],
                                                                                                                "X509SerialNumber" => [
                                                                                                                    [
                                                                                                                        "_" => $serialNumber // Replace Value 4
                                                                                                                    ]
                                                                                                                ]
                                                                                                            ]
                                                                                                        ]
                                                                                                    ]
                                                                                                ]
                                                                                            ]
                                                                                        ]
                                                                                    ]
                                                                                ]
                                                                            ]
                                                                        ]
                                                                    ]
                                                                ]
                                                            ]
                                                        ],
                                                        "KeyInfo" => [
                                                            [
                                                                "X509Data" => [
                                                                    [
                                                                        "X509Certificate" => [
                                                                            [
                                                                                "_" => $base64CertData // Replace Value 5
                                                                            ]
                                                                        ],
                                                                        "X509SubjectName" => [
                                                                            [
                                                                                "_" => "E=devsugu@yahoo.com, SERIALNUMBER=201401007986, CN=HYBRID INFINITY TECH SDN. BHD., OID.2.5.4.97=C23194732010, O=HYBRID INFINITY TECH SDN. BHD., C=MY"
                                                                            ]
                                                                        ],
                                                                        "X509IssuerSerial" => [
                                                                            [
                                                                                "X509IssuerName" => [
                                                                                    [
                                                                                        "_" => $issuerName
                                                                                    ]
                                                                                ],
                                                                                "X509SerialNumber" => [
                                                                                    [
                                                                                        "_" => $serialNumber // Replace Value 4
                                                                                    ]
                                                                                ]
                                                                            ]
                                                                        ]
                                                                    ]
                                                                ]
                                                            ]
                                                        ],
                                                        "SignatureValue" => [
                                                            [
                                                                "_" => $sig // Replace Value 2
                                                            ]
                                                        ],
                                                        "SignedInfo" => [
                                                            [
                                                                "SignatureMethod" => [
                                                                    [
                                                                        "_" => "",
                                                                        "Algorithm" => "http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"
                                                                    ]
                                                                ],
                                                                "Reference" => [
                                                                    [
                                                                        "Id" => "id-xades-signed-props",
                                                                        "Type" => "http://uri.etsi.org/01903/v1.3.2#SignedProperties",
                                                                        "URI" => "#id-xades-signed-props",
                                                                        "DigestMethod" => [
                                                                            [
                                                                                "_" => "",
                                                                                "Algorithm" => "http://www.w3.org/2001/04/xmlenc#sha256"
                                                                            ]
                                                                        ],
                                                                        "DigestValue" => [
                                                                            [
                                                                                "_" => $propsDigest // Replace Value 6
                                                                            ]
                                                                        ]
                                                                    ],
                                                                    [
                                                                        "Id" => "id-doc-signed-data",
                                                                        "URI" => "",
                                                                        "DigestMethod" => [
                                                                            [
                                                                                "_" => "",
                                                                                "Algorithm" => "http://www.w3.org/2001/04/xmlenc#sha256"
                                                                            ]
                                                                        ],
                                                                        "DigestValue" => [
                                                                            [
                                                                                "_" => $docDigest // Replace Value 1
                                                                            ]
                                                                        ]
                                                                    ]
                                                                ]
                                                            ]
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        "Signature" => [
            [
                "ID" => [
                    [
                        "_" => "urn:oasis:names:specification:ubl:signature:Invoice"
                    ]
                ],
                "SignatureMethod" => [
                    [
                        "_" => "urn:oasis:names:specification:ubl:dsig:enveloped:xades"
                    ]
                ]
            ]
        ]
    ];
}

// Create the signature chunk
$signatureChunk = createSignatureChunk($signingTime, $docDigest, $sig, $certHashBase64, $serialNumber, $base64CertData, $propsDigest, $issuerName);

// Output the signature block JSON for DEBUGGING!!
$signatureBlockJson = json_encode($signatureChunk, JSON_UNESCAPED_SLASHES);
echo '<br>';
echo "Signature Block JSON: " . $signatureBlockJson . PHP_EOL;

echo '<br>';
echo "Invoice JSON: " . json_encode($invoiceJson, JSON_PRETTY_PRINT) . PHP_EOL;

// Check if 'Invoice' key exists and is an array
if (!isset($invoiceJson['Invoice']) || !is_array($invoiceJson['Invoice'])) {
    die('Error: $invoiceJson[\'Invoice\'] is not set or not an array.');
}

// Remove duplicate UBLExtensions and Signature at the root level if they exist
unset($invoiceJson['UBLExtensions']);
unset($invoiceJson['Signature']);

// Nest the signature and UBLExtensions within the invoice ( Ensure the signature block is nested within the Invoice element)
$invoiceJson['Invoice'][0]['UBLExtensions'] = $signatureChunk['UBLExtensions'];
$invoiceJson['Invoice'][0]['Signature'] = $signatureChunk['Signature'];

// Merge the signature chunk with the original JSON document
$signedJson = json_encode($invoiceJson, JSON_UNESCAPED_SLASHES);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error encoding JSON: ' . json_last_error_msg());
}

// Output the signed JSON for debugging
echo '<br><br><br><br><br><br><br>';
echo "Signed JSON: " . $signedJson . PHP_EOL;
echo '<br><br><br><br><br><br><br>';

// Hash the document (documentHash)
$docHash = hash('sha256', $signedJson);

// Output the hash of the signed JSON for debugging
echo '<br>';
echo "Document Hash: " . $docHash . PHP_EOL;

// Base64 encode the signed JSON document (document)
$base64SignedJson = base64_encode($signedJson);

// Output the base64 encoded signed JSON for debugging (without minification by using preetier-print)
echo '<br>';
echo "Base64 Signed JSON: " . $base64SignedJson . PHP_EOL;

// Create the submission payload
$payload = [
    "documents" => [
        [   
            "format" => "JSON",
            "documentHash" => $docHash,  //The hash value of the document being submitted.
            "codeNumber" => "JSON-INV12345", 
            "document" => $base64SignedJson // The base64 of the document JSON or XML	
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
echo '<br>';
$response = submitDocument($payload);

// Output Response
echo '<br>';
echo "API Response: " . $response;

// Store the uuid and submissionUID in the session
$responseData = json_decode($response, true);
if (isset($responseData['submissionUid']) && isset($responseData['acceptedDocuments'][0]['uuid'])) {
    $_SESSION['uuid'] = $responseData['acceptedDocuments'][0]['uuid'];
    $_SESSION['submissionUid'] = $responseData['submissionUid'];
    echo '<br>';
    echo "UUID: " . $responseData['acceptedDocuments'][0]['uuid'] . PHP_EOL;
    echo "SubmissionUID: " . $responseData['submissionUid'] . PHP_EOL;
} else {
    echo '<br>';
    die('UUID or SubmissionUID not found in the response.');
}
?>