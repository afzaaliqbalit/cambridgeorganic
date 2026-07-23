<?php
add_action('admin_post_create_user_account', 'create_user_account');
add_action('admin_post_nopriv_create_user_account', 'create_user_account');

function create_user_account() {

    // Verify nonce
    if (
        !isset($_POST['contact_nonce']) ||
        !wp_verify_nonce($_POST['contact_nonce'], 'create_user_account')
    ) {
        wp_die('Invalid request.');
    }

    if(!empty($_POST['route_id'])) {
        $route_id = $_POST['route_id'];
        $cart_sess = $_SESSION['ordle-cart'];
        $cart_sess['delivery_route'] = $route_id;
        $_SESSION['cart'] = $cart_sess;
    }
    
    if(!is_user() && !empty($_POST['create_account'])) {
        $post = $_POST;
        $_SESSION['customer-info'] = $post;
        wp_redirect(home_url('/checkout'));
    }
    else {
        wp_redirect(home_url('/thank-you'));
    }
    exit;
}

function shortcode_product_create_account_actions() {
    ob_start();
    ?>
    <div class="pt-3">
        <hr>

        <div class="d-flex gap-3 justify-content-center mt-5">
            <a href="<?php echo site_url('create-account') ?>" class="button btn-primary">Confirm & Create Account</a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('cambi_product_create_account_actions', 'shortcode_product_create_account_actions');