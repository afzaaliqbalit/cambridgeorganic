<?php
$_GLOBALS['cart'] = new Cart();

function endpoint_cart_actions($action=''): void
{
    $cart = new Cart();
    $product = new Products();

    $params = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (empty($params)) {
        $params = json_decode(file_get_contents('php://input'), true);
    }

    $pid = $params['product_id'] ?? 0;
    $pqty = !empty($params['qty']) ? intval($params['qty']) : 0;
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

            $cart->addProduct($item_id, [
                'cart_quantity' => $pqty
            ]);
            $res = ['success'=>1, 'message'=>'Item added to cart'];
        break;
        case 'remove':
            $item_id = intval($pid);
            $cart->deleteItem($item_id);
            $res = ['success'=>1, 'message'=>'Item removed from cart'];
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