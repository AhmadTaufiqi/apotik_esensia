<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doku_payment
{
    private $ci;
    private $api_url;
    private $client_id;
    private $secret_key;
    private $merchant_id;

    public function __construct()
    {
        $this->ci =& get_instance();
        // Doku sandbox credentials - replace with actual values
        $this->api_url = 'https://api-sandbox.doku.com';
        $this->client_id = 'your_client_id'; // Replace with actual client ID
        $this->secret_key = 'your_secret_key'; // Replace with actual secret key
        $this->merchant_id = 'your_merchant_id'; // Replace with actual merchant ID
    }

    /**
     * Generate VA payment
     */
    public function generateVA($order_data)
    {
        $endpoint = '/dokuwallet-emoney/v1/payment';

        // Prepare request data
        $request_data = [
            'client' => [
                'id' => $this->client_id
            ],
            'order' => [
                'invoice_number' => $order_data['invoice_number'],
                'amount' => $order_data['amount']
            ],
            'virtual_account_info' => [
                'virtual_account_type' => $this->getVAType($order_data['payment_method']),
                'expired_time' => 24 // 24 hours
            ],
            'customer' => [
                'name' => $order_data['customer_name'],
                'email' => $order_data['customer_email']
            ]
        ];

        // Generate signature
        $signature = $this->generateSignature($request_data);

        // Set headers
        $headers = [
            'Content-Type: application/json',
            'Client-Id: ' . $this->client_id,
            'Request-Id: ' . uniqid(),
            'Request-Timestamp: ' . gmdate('Y-m-d\TH:i:s\Z'),
            'Signature: ' . $signature
        ];

        // Make API call
        $response = $this->makeRequest('POST', $this->api_url . $endpoint, $request_data, $headers);

        return $response;
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus($invoice_number)
    {
        $endpoint = '/orders/v1/status/' . $invoice_number;

        $request_data = [
            'client' => [
                'id' => $this->client_id
            ],
            'order' => [
                'invoice_number' => $invoice_number
            ]
        ];

        // Generate signature
        $signature = $this->generateSignature($request_data);

        $headers = [
            'Content-Type: application/json',
            'Client-Id: ' . $this->client_id,
            'Request-Id: ' . uniqid(),
            'Request-Timestamp: ' . gmdate('Y-m-d\TH:i:s\Z'),
            'Signature: ' . $signature
        ];

        $response = $this->makeRequest('POST', $this->api_url . $endpoint, $request_data, $headers);

        return $response;
    }

    /**
     * Generate signature for API authentication
     */
    private function generateSignature($data)
    {
        $string_to_sign = $this->client_id . '|' . gmdate('Y-m-d\TH:i:s\Z') . '|' . json_encode($data);
        return hash_hmac('sha256', $string_to_sign, $this->secret_key);
    }

    /**
     * Get VA type based on payment method
     */
    private function getVAType($payment_method)
    {
        $va_types = [
            'BCA Virtual Account' => 'BCA_VA',
            'BRI Virtual Account' => 'BRI_VA',
            'BNI Virtual Account' => 'BNI_VA',
            'Mandiri Virtual Account' => 'MANDIRI_VA',
            'Bank BCA' => 'BCA_VA',
            'Bank BRI' => 'BRI_VA',
            'Bank BNI' => 'BNI_VA',
            'Bank Mandiri' => 'MANDIRI_VA'
        ];

        return isset($va_types[$payment_method]) ? $va_types[$payment_method] : 'BCA_VA';
    }

    /**
     * Make HTTP request to Doku API
     */
    private function makeRequest($method, $url, $data = null, $headers = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For sandbox only
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            return [
                'success' => false,
                'error' => $error,
                'http_code' => $http_code
            ];
        }

        $decoded_response = json_decode($response, true);

        return [
            'success' => $http_code == 200,
            'http_code' => $http_code,
            'data' => $decoded_response,
            'raw_response' => $response
        ];
    }
}
