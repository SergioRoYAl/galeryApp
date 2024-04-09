<?php

namespace App\Services;

use App\Models\Settings;
use Exception;

class APIService
{

    private $settings;
    public $storeID;

    public function __construct()
    {
        $this->settings = new Settings();
        $this->storeID = 1703841945006;
    }

    public function getToken()
    {

        if ($this->settings->getToken() == '' || !$this->isTokenValid($this->settings->getToken())) {

            $loginData = $this->loginCloud();
            return $loginData['token'];

        } else { return $this->settings->getToken(); }
    }

    public function loginCloud()
    {

        try {
            $publicKey = $this->getErpPublicKey();
            $passwd = config('app.cloud_password');
            $encryptedPasswd = $this->encryptTextWithPublicKey($this->addHeaderAndFooterToPublicKey($publicKey), $passwd);
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        $body = [
            'account' => config('app.cloud_account'),
            'password' => $encryptedPasswd,
            'loginType' => config('app.cloud_login_type')
        ];

        $loginData = json_decode($this->makeRequest('POST', '/user/login', json_encode($body)), true);

        $token = $loginData['data']['token'];
        $merchantId = $loginData['data']['currentUser']['merchantId'];
        $agencyId = $loginData['data']['currentUser']['agencyId'];

        $this->updateCloudInfo($token, $merchantId, $agencyId, $encryptedPasswd);

        return [
            'token' => $token,
            'merchantId' => $merchantId,
            'agencyId' => $agencyId,
        ];
    }

    /**
     * Updates cloud info in DB
     */
    private function updateCloudInfo($token, $merchantId, $agencyId, $encryptedPasswd)
    {
        $this->settings->updateCloudPassword($encryptedPasswd);
        $this->settings->updateToken($token);
        $this->settings->updateCloudMerchantId($merchantId);
        $this->settings->updateCloudAgencyId($agencyId);
    }

    public function isTokenValid($token)
    {

        $itemList = [
            'attrCategory'  => 'default',
            'attrName'      => 'default',
            'barCode'       => 'validate-token',
            'itemTitle'     => 'validate-token'
        ];

        $data = [
            'agencyId' => $this->settings->getCloudAgencyId(),
            'merchantId' => $this->settings->getCloudMerchantId(),
            'storeId' => '',
            'itemList' => [$itemList]
        ];

        $response = $this->makeRequest('POST', '/item/batchImportItem', json_encode($data), $token);
        $response = json_decode($response, true);
        return $response['success'];
    }

    /**
     * Makes an HTTP request using cURL.
     *
     * @param string $method The HTTP method (e.g., "GET", "POST", "PUT").
     * @param string $uri
     * @param mixed $data The data to be included in the request body.
     * @param string|null $token The authorization token (if applicable).
     * @return mixed The response from the HTTP request.
     */
    public function makeRequest($method, $uri, $data = false, $token = null)
    {

        $url = config('app.api_base_url') . $uri;

        // Initialize cURL session
        $curl = curl_init();

        // Set common options for cURL
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        ]);

        // Set method-specific options
        switch ($method) {
            case "POST":
                // Set cURL option for POST method
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                $headers = ['Content-Type: application/json'];
                break;
            case "IMAGE":
                // Set cURL option for IMAGE method
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                $headers = [];
                break;
            case "PUT":
                // Set cURL option for PUT method
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                $headers = ['Content-Type: application/json'];
                break;
            case "DELETE":
                // Set cURL option for DELETE method
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                $headers = ['Content-Type: application/json'];
                break;
            default:
                // If method is not POST, IMAGE, PUT, or DELETE, handle data for other methods
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
                $headers = [];
        }

        // Add authorization header if token is provided
        if ($token !== null) {
            $headers[] = 'Authorization: ' . $token;
        }

        // Set cURL options for HTTP headers and URL
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);

        // Execute the cURL session and get the result
        $result = curl_exec($curl);

        // Handle cURL errors
        if ($result === false) {
            $log = $this->construct_log_message("CallAPI", "ERROR ", "CURL ERROR IN '" . $url . "'", curl_error($curl));
            // wh_log($log);
            die($log);
        }

        // Close the cURL session
        curl_close($curl);

        // Return the result of the HTTP request
        return $result;
    }

    private function construct_log_message(string $conection, string $status, string $action, string $message, array $data = []): string
    {
        $log = "CONNECTION: " . $conection . ' - ' . date("Y-m-d H:i:s") . PHP_EOL .
            "STATUS:  $status" . PHP_EOL .
            "ACTION:  $action" . PHP_EOL .
            "MESSAGE: $message" . PHP_EOL;
        if (!empty($data)) {
            $log .= "DATA:" . PHP_EOL . json_encode($data) . PHP_EOL;
        }
        $log .= "-------------------------" . PHP_EOL;
        return $log;
    }

    private function getErpPublicKey()
    {
        $response = json_decode($this->makeRequest('GET', '/user/getErpPublicKey'), true);

        return $response['data'];
    }

    private function encryptTextWithPublicKey($public_key, $plaintext)
    {
        // Transform public key from PEM format to OpenSSL resource
        $publicKeyResource = openssl_get_publickey($public_key);

        if (!$publicKeyResource) {
            throw new Exception('Error al cargar la clave pública.');
        }

        // Encrypt the plaintext using the RSA public key
        $encryptedData = '';
        $encryptionSuccessful = openssl_public_encrypt($plaintext, $encryptedData, $publicKeyResource);

        // Unlocking the public key resource
        unset($publicKeyResource);

        if (!$encryptionSuccessful) {
            throw new Exception('Error encrypting data.');
        }

        // Return the encrypted text as a base64-encoded string for easy storage or transmission
        return base64_encode($encryptedData);
    }

    private function addHeaderAndFooterToPublicKey($public_key)
    {
        // Create the header.
        $header = "-----BEGIN PUBLIC KEY-----\n";

        // Add the public key to the header.
        $header .= $public_key;

        // Create the footer.
        $footer = "\n-----END PUBLIC KEY-----\n";

        // Return the public key with the header and footer.
        return $header . $footer;
    }

    /***********************************************************************************************************************/



    public function batchImportItem($item) {

        $data = [
            'agencyId' => intval($this->settings->getCloudAgencyId()),
            'merchantId' => intval($this->settings->getCloudMerchantId()),
            'storeId' => 1703841945006,
            'unitName' => 1,
            'itemList' => [$item]
        ];

        $response = $this->makeRequest('POST', '/item/batchImportItem', json_encode($data), $this->getToken());
        return $response = json_decode($response, true);
    }

    public function batchBind($mac, $itemBarCode) {
        
        $data = [
            'storeId' => 1703841945006,
            "tagItemBinds" => [
                [
                    "eslBarcode" => $mac,
                    "itemBarcode" => $itemBarCode
                ]
            ]
        ];

        $response = $this->makeRequest('POST', '/bind/batchBind', json_encode($data), $this->getToken());
        $response = json_decode($response, true);
        return $response;
    }


}
