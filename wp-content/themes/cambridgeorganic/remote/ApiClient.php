<?php

class ApiClient
{
    private $baseUrl = 'https://dev.zeeteck.com/projects/ordle-dev/api/v1';

    protected function request($method, $endpoint, array $data = [], $json_encode=false)
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'Accept: application/json'
        ];

        // Add authorization header if token exists
        if (!empty($_SESSION['api_token'])) {
            $headers[] = 'Authorization: ' . $_SESSION['api_token_type'] . ' ' . $_SESSION['api_token'];
        }

        $ch = curl_init();

        if ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
        ]);

        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $headers[] = 'Content-Type: application/json';

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $result = json_decode($response, true);

        if (empty($result['success'])) {
            $errors = [
                'success' => 0,
                'message' => $result['message']
            ];
            if(!empty($result['errors'])) {
                foreach ($result['errors'] as $key => $error) {
                    $errors['errors'][$key] = $error[0] ?? '';
                }
            }
            $result = $errors;
        }else {
            if(!empty($data['redirect'])) {
                $result['redirect'] = $data['redirect'];
            }
        }

        return $json_encode ? json_encode($result) : $result;
    }

}