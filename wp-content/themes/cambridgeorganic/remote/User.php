<?php

class User extends ApiClient
{
    public function login($email, $password)
    {
        $response = $this->request('POST', '/customers/login', [
            'Email' => $email,
            'Password' => $password,
            'redirect' => site_url('/customer')
        ]);

        if (
            !empty($response['success']) &&
            !empty($response['data']['token'])
        ) {
            set_session('api_token', $response['data']['token']);
            set_session('api_token_type', $response['data']['token_type']);
            set_session('customer', $response['data']['customer']);
        }

        $response = json_encode($response);

        return $response;
    }

    public function isLoggedIn()
    {
        return !empty(get_session('api_token'));
    }

    public function getCustomer()
    {
        return get_session('customer');
    }

    public function logout()
    {
        unset(
            $_SESSION['api_token'],
            $_SESSION['api_token_type'],
            $_SESSION['customer']
        );
    }

    public function getToken()
    {
        if (empty($_SESSION['api_token'])) {
            return null;
        }

        return $_SESSION['api_token_type'] . ' ' . $_SESSION['api_token'];
    }

    function getPostCode($postcode='') {
        $response = $this->request('GET', '/customers/postcode-info', [
            'postcode' => $postcode
        ]);

        return $response;
    }
}