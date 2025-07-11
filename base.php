<?php
session_start(); // Start the session

/* For further details, do refer to the following links:
    1. https://sdk.myinvois.hasil.gov.my/signature/
    2. https://sdk.myinvois.hasil.gov.my/signature-creation-json/
    3. https://sdk.myinvois.hasil.gov.my/einvoicingapi/02-submit-documents/
    4. https://sdk.myinvois.hasil.gov.my/standard-header-parameters/

    *** Important and helpful Resource to refer to :
    https://github.com/mokth/einvoice/blob/main/WinEInvoiceApp/
*/

// Include in the codes for extracting certificate and signing and hashing the DocDigest
include 'generateSig.php';

// Certificate Path and Password
// Get the current script path
$currentPath = dirname(__FILE__);

// Output the current script pa th
echo 'Current script path: ' . $currentPath . PHP_EOL;

define('CERTIFICATE_PATH', $currentPath . DIRECTORY_SEPARATOR . 'certificate' . DIRECTORY_SEPARATOR . 'HYBRID_INFINITY_TECH_SDN._BHD..p12');
define('CERTIFICATE_PASSWORD', 'On7@e*ki');

// Define the json document without any signature
$invoiceJson = file_get_contents('JsonWithOutSignature.json');

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

/* FOR DEBUGGING PURPOSES */
echo '<br>';
$invoiceJson = json_decode(file_get_contents('JsonWithOutSignature.json'), true);
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
   Please refer to the code in generateSig.php
*/
echo '<br>';
$sig = signData($docDigest, $privateKey);
echo "Signature (Sig): " . $sig . PHP_EOL;

// 3. Generate the certificate hash using the function from generateSig.php
echo '<br>';
$certHashBase64 = computeCertHash($certs['cert']);
echo 'SHA-256 cert Hash in Base64: ' . $certHashBase64 . PHP_EOL;

/* 4. Populate the signed properties section by performing these:
    4.1 - Calculate the DigestValue, SigningTime, X509SerialNumber and X509IssuerName 
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
echo '<br>';
echo $serialNumber . PHP_EOL;

// Function to get the certificate data in Base64 string
function getX509Certificate($cert) {
    return base64_encode($cert);
}

$certData = getX509Certificate($certs['cert']);
echo '<br>';
echo "Certificate Data (Base64): " . $certData . PHP_EOL;

//4.1d - Calculate the X509IssuerName
$issuerArray = openssl_x509_parse($certs['cert'])['issuer'];
$issuerName = "CN={$issuerArray['CN']}, OU={$issuerArray['OU']}, O={$issuerArray['O']}, C={$issuerArray['C']}";
echo "Issuer Name: " . $issuerName . PHP_EOL;

// Get the certificate issuer name
/*
$issuerName = getCertIssuerName($certs['cert']);
echo "Issuer Name: " . $issuerName . PHP_EOL;
*/

//4.2 - Obtain the qualifyingProperties properties in string format > minify the string > compute the hashed of the signed properties > covert to base64

$qualifyingProperties = [
    "Target" => "signature",
    "SignedProperties" => [
        [
            "Id" => "id-xades-signed-props",
            "SignedSignatureProperties" => [
                [
                    "SigningTime" => [
                        ["_" => gmdate('Y-m-d\TH:i:s\Z')] // Current time in UTC
                    ],
                    "SigningCertificate" => [
                        [
                            "Cert" => [
                                [
                                    "CertDigest" => [
                                        "DigestMethod" => [
                                            ["_" => "", "Algorithm" => "http://www.w3.org/2001/04/xmlenc#sha256"]
                                        ],
                                        "DigestValue" => [
                                            ["_" => $certHashBase64]
                                        ]
                                    ],
                                    "IssuerSerial" => [
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
];

echo '<br>';
$propsDigest = getQualifyingPropertiesDigest($qualifyingProperties);
echo "Qualifying Properties Digest (Base64): " . $propsDigest . PHP_EOL;

// Function to compute the hash of the signed properties
function getQualifyingPropertiesDigest($qualifyingProperties) {
    $jsonSignedProperties = json_encode($qualifyingProperties, JSON_UNESCAPED_SLASHES);
    $jsonMinified = preg_replace('/\s+/', '', $jsonSignedProperties); // Minify JSON
    $hash = hash('sha256', $jsonMinified, true);
    return base64_encode($hash);
}

// Function to create the signature chunk
function createSignatureChunk($base64Hash, $signature, $certHashBase64, $serialNumber, $certData, $propsDigest, $issuerName) {
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
                                                                                                "_" => gmdate('Y-m-d\TH:i:s\Z') // Current time in UTC
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
                                                                                "_" => $certData // Replace Value 5
                                                                            ]
                                                                        ],
                                                                        "X509SubjectName" => [
                                                                            [
                                                                                "_" => $issuerName
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
                                                                "_" => $signature // Replace Value 2
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
                                                                        "Type" => "",
                                                                        "URI" => "",
                                                                        "DigestMethod" => [
                                                                            [
                                                                                "_" => "",
                                                                                "Algorithm" => "http://www.w3.org/2001/04/xmlenc#sha256"
                                                                            ]
                                                                        ],
                                                                        "DigestValue" => [
                                                                            [
                                                                                "_" => $base64Hash // Replace Value 1
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
echo '<br>';
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

// Function to submit the document
function submitDocument($payload) {

    $accessToken = getAccessToken();
    if (!$accessToken) {
        die('Access token not found.');
    }


    $ch = curl_init(SUBMIT_DOCUMENTS_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Request Error: ' . curl_error($ch));
    }

    curl_close($ch);

    return $response;
}

// Prepare the signed JSON document for submission
// Base64 encode the signed JSON document
$base64SignedJson = base64_encode($signedJson);

// Create the submission 1payload
$payload = [
    "documents" => [
        [
            "format" => "JSON",
            "documentHash" => $docDigest,
            "codeNumber" => "INV12345",
            "document" => $base64SignedJson
        ]
    ]
];

// Echo the payload for debugging
echo '<br>';
echo "Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . PHP_EOL;

// Submit the signed document to the API endpoint
echo '<br>';
$response = submitDocument($payload);

// Output Response
echo '<br>';
echo "API Response: " . $response;
?>

