<?php
$_GLOBALS['cart'] = new Cart();

function endpoint_cart_actions($action=''): void
{
    $cart = new Cart();

    $params = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (empty($params)) {
        $params = json_decode(file_get_contents('php://input'), true);
    }

    switch ($action) {
        case 'add':
            $item_id = intval($params['product_id']);
            $quantity = intval($params['qty']);

            $cart->addProduct($item_id, [
                'cart_quantity' => $quantity
            ]);
        break;
        case 'remove':
            $item_id = intval($params['product_id']);
            $cart->deleteItem($item_id);
        break;
    }

    echo json_encode(['success'=>1, 'message'=>'Item added to cart']);
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