<?php

class Products extends ApiClient
{
    public function getProducts($options = [])
    {
        $options = array_filter($options);
        $response = $this->request('GET', '/getproducts', $options);

        if (
            !empty($response['success']) &&
            isset($response['data'])
        ) {
            return $response['data'];
        }

        return [];
    }

    public function gethyperproducts($options = [])
    {
        $response = $this->request('GET', '/gethyperproducts');

        if (
            !empty($response['success']) &&
            isset($response['data'])
        ) {
            return $response['data'];
        }

        return [];
    }

    public function getProduct($slug)
    {
        $response = $this->request(
            'GET',
            '/getproduct/' . urlencode($slug)
        );

        if (
            !empty($response['success']) &&
            isset($response['data'])
        ) {
            return $response['data'];
        }

        return [
            'success' => false,
            'message' => $response['message']
        ];
    }

    public function searchProduct($term)
    {
        $response = $this->request(
            'GET',
            '/search?search=' . filter_var($term, FILTER_SANITIZE_STRING)
        );

        if (
            !empty($response['success']) &&
            isset($response['data'])
        ) {
            return $response['data'];
        }

        return null;
    }
}