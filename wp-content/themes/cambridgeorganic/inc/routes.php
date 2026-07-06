<?php
function endpoint_remote_request() {
    $params = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (empty($params)) {
        $params = json_decode(file_get_contents('php://input'), true);
    }
    $action_map = [
      'customer-login' => 'endpoint_customer_login',
      'get_postcode_routes' => 'get_postcode_routes'
    ];

    $current_action = get_query_var('remote_endpoint');

    if (array_key_exists($current_action, $action_map)) {
        $current_action = $action_map[$current_action];
        $current_action();
    }
    exit;
}

add_action('init', function () {
    add_rewrite_rule('^product/([^/]+)/?$', 'index.php?camb_product_slug=$matches[1]', 'top');
    add_rewrite_rule('^customer/?$', 'index.php?account_page=home', 'top');
    add_rewrite_rule('^customer/([^/]+)/?$', 'index.php?account_page=$matches[1]', 'top');
    add_rewrite_rule('^remote-request/([^/]+)/?$', 'index.php?remote_endpoint=$matches[1]', 'top');
});

add_filter('query_vars', function ($vars) {
    $vars[] = 'camb_product_slug';
    $vars[] = 'account_page';
    $vars[] = 'remote_endpoint';
    return $vars;
});

add_action('template_redirect', function () {
    if (get_query_var('remote_endpoint')) { endpoint_remote_request(); }
});

function load_custom_product_template($template)
{
    global $products;
    $product_slug = get_query_var('camb_product_slug');

    if ($product_slug) {
        $get_product = $products->getProduct($product_slug);
        return get_template_part('page-product', null, $get_product);
    }

    // Profile page
    $account_page = get_query_var('account_page');

    if($account_page) {
        if(!is_user()) {
            wp_redirect(home_url());
            exit;
        }
        $GLOBALS['profile_page'] = $account_page;
        return get_template_part('customer/common', null, ['current_page' => $account_page]);
    }

    return $template;
}
add_filter('template_include', 'load_custom_product_template');

