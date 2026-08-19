<?php
$_GLOBALS['cart'] = new Cart();


function endpoint_cart_actions($action='')
{
    $cart = new Cart();
    $product = new Products();

    $params = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (empty($params)) {
        $params = json_decode(file_get_contents('php://input'), true);
    }

    $pid = $params['product_id'] ?? 0;
    $pqty = !empty($params['qty']) ? intval($params['qty']) : 0;
    $freq = !empty($params['attrs']['item_frequency']) ? $params['attrs']['item_frequency'] : '';
    $res = [];
    switch ($action) {
        case 'product_info':
            $product_info = $product->getProduct($pid);
            $res = ['success'=>1, 'product_info'=>$product_info];
            break;
        case 'getproducts':
            $product_info = $product->getProducts();
            $res = ['success'=>1, 'product_info'=>$product_info];
            break;
        case 'add':
            $item_id = intval($pid);
            $addprod = $cart->addProduct($item_id, [
                'cart_quantity' => $pqty,
                'item_frequency' => $freq
            ]);

            if($addprod !== false) {
                $res = ['success'=>1, 'message'=>'Item added to cart'];
            }else {
                $res = ['success'=>0, 'message'=>'Could not add item to cart'];
            }
        break;
        case 'update':
            $item_id = intval($pid);
            $cart->updateProduct($item_id, [
                'cart_quantity' => $pqty,
                'item_frequency' => $freq
            ]);
            $res = ['success'=>1, 'message'=>'Item update cart'];
            break;
        case 'remove':
            $item_id = intval($pid);
            $cart->deleteItem($item_id);
            $res = ['success'=>1, 'message'=>'Item removed from cart'];
        break;
        case 'validate_postcode':
            $postcode = $params['postcode'] ?? '';
            $getPostcode = $cart->checkPostcode($postcode);
            $res = ['success'=>$getPostcode['success'], 'data'=>$getPostcode];
            break;
        case 'checkout':
            $res = $cart->checkout($params);
            $success = $res['status'] === 'success';
            if($success) {
                $cart->clear();
            }
            $res = ['success'=>$success, 'data'=>$res];
            break;
    }

    echo json_encode($res);
    exit;
}

function endpoint_user_actions($action='') {
    $user = new User();

    $params = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (empty($params)) {
        $params = json_decode(file_get_contents('php://input'), true);
    }
    $res = [];
    switch ($action) {
        case 'user_signup':
            $signup = $user->signup($params);
            if(!empty($signup['success'])) {
                $res = ['success' => 1, 'user_info' => $signup];
            }else {
                $res = ['success' => 0, 'errors' => $signup['errors']];
            }
            break;
    }
    echo json_encode($res);
    exit;
}

add_action('init', function() {
    if(!empty($_POST['action'])) {
        if ($_POST['action'] == 'edit_delivery_schedule') {
            $delivery_frequency = $_POST["delivery_frequency"];
            $selectedDates = $_POST["selectedDates"];

            $cart = new Cart();
            $cart->setItem('delivery_frequency', $delivery_frequency);
            $cart->setItem('next_delivery_date', $selectedDates);

            wp_redirect($_SERVER['HTTP_REFERER']);
        }
    }
});

function product_weight($product=[]) {

    return trim(@$product['weight'] .' '. @$product['per_unit']);

}