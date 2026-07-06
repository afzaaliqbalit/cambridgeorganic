<?php
function start_wordpress_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_wordpress_session', 1);

require 'ApiClient.php';
require 'User.php';
require 'Products.php';
require 'remote-requests.php';

$user = new User();
$products = new Products();

function remote_endpoint($endpoint=''): string
{
    return site_url().'/remote-request/'.$endpoint;
}

