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

    public function signup($data)
    {
        $response = $this->request('POST', '/customers/signup', $data);

        if (
            !empty($response['success'])
        )
        {
            set_session('api_token', $response['data']['token']);
            set_session('api_token_type', $response['data']['token_type']);
            set_session('customer', $response['data']['customer']);
        }

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

    function getPostCode($postcode='', $refresh = false) {

        $response = $this->request('GET', '/customers/postcode-info', [
            'postcode' => $postcode
        ]);

        $routeID = !empty($response['data'][0]['id']) ? $response['data'][0]['id'] : '';

        if($routeID) {
            $cart = new Cart();
            $routeInfo = $cart->getRouteInfo(['id' => $routeID]);

            $_SESSION['postcode_info'] = $routeInfo;
            $response['routeInfo'] = $routeInfo;
        }

        return $response;
    }

    public function profile() {
        $response = $this->request('GET', '/customers/me');
        return $response;
    }

    function getCustomerOrders() {
        $response = $this->request('GET', '/customers/orders', []);
        if(!empty($response['success'])) {
            $orders = $response['data'];

            if(!empty($orders['products'])) {

            }

            return $orders;
        }
        return [];
    }

    public function nextOrder() {
        $cart = new Cart();
        if(!is_user()) {
            $cart_data = $cart->getCart();
            return $cart_data;
        }
        else {
            $user = new User();
            $userOrders = $user->getCustomerOrders();
            $futureOrders = array_filter($userOrders, function ($order) {
                return !empty($order['deliveryDates'])
                    && $order['deliveryDates'][0] > date('Y-m-d');
            });
            $futureOrders = array_first($futureOrders);
            $futureOrders['next_delivery_date'] = $futureOrders['deliveryDates'][0];
            return $futureOrders;
        }
    }
}