<?php
$current_page = $args['current_page'] ?? '';

if($current_page === 'logout') {
    $user = new User();
    $user->logout();
    wp_redirect(site_url());
    exit;
}

$account_pages_map = [
    'home' => 'customer/home',
    'schedule' => 'customer/schedule',
    'orders' => 'customer/orders',
    'deliveries' => 'customer/deliveries',
    'profile' => 'customer/profile',
    'payments' => 'customer/payments',
    'contact' => 'customer/contact',
];

get_template_part($account_pages_map[$current_page], null, ['current_page' => $current_page]);

get_template_part('customer/inc/report-delivery-template');