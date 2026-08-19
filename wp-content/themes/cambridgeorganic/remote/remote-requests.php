<?php
//Get store products
function cambridge_products($args=[]) {
    $attr = shortcode_atts([
        'cat'=>'',
        'type' => 'single'
    ],$args);
    $products = new Products();

    $filter_arr = ['type','box_size','box_type','hyper_product_type'];
    $get_filter = array_combine(
        $filter_arr,
        array_map(
            fn($key) => $_GET[$key] ?? '',
            $filter_arr
        )
    );

    $get_filter['type'] = $attr['type'];

    $getProducts = $products->getProducts($get_filter);

    if(!empty($attr['limit'])) {
        $getProducts = array_splice($getProducts,0,$attr['limit']);
    }

   ob_start();

    get_template_part(
        'templates/shop-category-archive',
        null,
        [
            'products' => $getProducts,
            'cat'      => $attr['cat'],
            'type'      => $attr['type'],
            //'limit'      => $attr['limit'],
        ]
    );

    return ob_get_clean();
}
add_shortcode('cambridge_products', 'cambridge_products');

function endpoint_customer_login()
{
    global $user;
    $params = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (empty($params)) {
        $params = json_decode(file_get_contents('php://input'), true);
    }
    $user_email = !empty($params['user_password']) ? filter_var($params['user_email'], FILTER_VALIDATE_EMAIL) ?? '' : '';
    $user_password  = !empty($params['user_password']) ? filter_var($params['user_password'], FILTER_SANITIZE_STRING) ?? "" : '';
    $send_req = $user->login($user_email, $user_password);
    echo $send_req;
    exit;
}

function get_postcode_routes($reload = false) {
    global $user;

    $params = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (empty($params)) {
        $params = json_decode(file_get_contents('php://input'), true);
    }
    $postcode = $params['postcode'] ?? '';

    if(empty($postcode)){
        echo json_encode(['success'=>0, 'message' => 'Postcode is required.']);
        exit;
    }

    $send_req = $user->getPostcode($postcode, true);

    ob_start();

    if(!empty($send_req['success'])) {
        get_template_part('inc/popups/remote/signup-popup-steps', null, $send_req);
    }else {
        get_template_part('inc/popups/remote/guest-postcode-delivery-notfound', null, $send_req);
    }

    $send_req['html'] = ob_get_clean();

    echo json_encode($send_req);

    exit;
}

function get_remote_product() {
    $product = new Products();
    $params = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (empty($params)) {
        $params = json_decode(file_get_contents('php://input'), true);
    }
    if(!empty($params['product_slug'])) {
        $data = $product->getProduct($params['product_slug']);

        echo json_encode($data);
    }
    exit;
}

function getDeliveryFrequencies() {
    if(!empty($_SESSION['delivery_frequencies'])) {
        return $_SESSION['delivery_frequencies'];
    }else {
        $apiClient = new APIClient();
        $fetchRec = $apiClient->request('GET', '/settings/fetchFrequency');

        if(!empty($fetchRec['data']['frequencyschedules'])) {
            $_SESSION['delivery_frequencies'] = $fetchRec['data']['frequencyschedules'];
            return $fetchRec['data']['frequencyschedules'];
        }
    }

    return [];
}