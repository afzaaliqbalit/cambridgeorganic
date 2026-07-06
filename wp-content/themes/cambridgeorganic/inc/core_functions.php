<?php
register_nav_menus(array(
    'primary_menu' => __('Primary Menu', 'cambridgeorganic'),
));

function pr($array = [], $exit = true)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';

    if($exit){
        exit;
    }
}

function wp_register_styles()
{
    wp_enqueue_style('owl-style', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css');
    wp_enqueue_style('sweetalert-style', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.23.0/sweetalert2.css');

    wp_enqueue_style('main-style', get_stylesheet_uri());
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/assets/css/custom.css');
    wp_enqueue_style('animation-style', get_stylesheet_directory_uri() . '/assets/css/animations.css');
    wp_enqueue_style('camb_accordion', 'https://cdn.jsdelivr.net/npm/accordion-js@3.4.1/dist/accordion.min.css');
    wp_enqueue_script('camb_accordion', 'https://cdn.jsdelivr.net/npm/accordion-js@3.4.1/dist/accordion.min.js');
    wp_enqueue_script('jquery-script', 'https://code.jquery.com/jquery-3.7.1.min.js');
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/script.js');
    wp_enqueue_script('step-form-script', get_stylesheet_directory_uri() . '/assets/js/step-form.js');
    wp_enqueue_script('owl-script', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js');
    wp_enqueue_script('sweetalert-script', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.23.0/sweetalert2.min.js');
    wp_enqueue_script('datepicker-script', 'https://cdn.jsdelivr.net/npm/flatpickr');
    wp_enqueue_script('tooltip-script', get_stylesheet_directory_uri() . '/assets/js/tooltip.js');
    wp_enqueue_script('remote-script', get_stylesheet_directory_uri() . '/assets/js/remote.js');
    wp_enqueue_script('sessionstorage-script', get_stylesheet_directory_uri() . '/assets/js/sessionstorage.js');

    wp_enqueue_style('single-product-style', get_stylesheet_directory_uri() . '/assets/css/single-product.css', [], null);
    wp_enqueue_style('checkout-style', get_stylesheet_directory_uri() . '/assets/css/checkout.css', [], null);
    wp_enqueue_style('modals-style', get_stylesheet_directory_uri() . '/assets/css/modals.css', [], null);
    wp_enqueue_style('bootstrap-grid', get_stylesheet_directory_uri() . '/assets/css/bootstrap-grid.css');
    wp_enqueue_style('bootstrap-utilities', get_stylesheet_directory_uri() . '/assets/css/bootstrap-utilities.min.css');
    wp_enqueue_style('step-form-style', get_stylesheet_directory_uri() . '/assets/css/step-form.css');
    wp_enqueue_style('datepicker-style', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');

    if(is_user()) {
        wp_enqueue_style('profile-css', get_stylesheet_directory_uri() . '/assets/css/profile.css');
        wp_enqueue_script('profile-js', get_stylesheet_directory_uri() . '/assets/js/profile.js');
    }
    wp_enqueue_style('responsive-style', get_stylesheet_directory_uri() . '/assets/css/responsive.css');

}

add_action('wp_enqueue_scripts', 'wp_register_styles');

add_action('wp_head', function () {
    ?>
    <script>
        window.theme_url = '<?php echo esc_js(get_stylesheet_directory_uri()); ?>/';
        window.site_url = '<?php echo site_url(); ?>/';
    </script>
    <?php
});

function thumbnail($image_url='') {
    return $image_url;
}


add_action('wp_footer', function () {
    $template_files = glob(
        get_stylesheet_directory() . '/inc/popups/popup-*.php'
    );
    if(is_user()) {
        $template_files = array_merge($template_files, glob(
            get_stylesheet_directory() . '/inc/popups/user/*.php'
        ));
        ?>
        <template id="customer-icon-menu">
            <div class="tooltip-content" role="tooltip" style="margin: -28px -126px;">
                <div>
                    <p><a href="<?php echo site_url() ?>/customer/">View Profile</a></p>
                    <p><a href="<?php echo site_url() ?>/customer/logout">Logout</a></p>
                </div>
            </div>
        </template>
        <?php
    }
    foreach ($template_files ?: [] as $file) {
        require_once $file;
    }
    ?>
    <template id="login-tooltip-content">
        <div class="tooltip-content" role="tooltip">
            <p>You need an Account for this.</p>
            <button class="button btn-orange w-100" onclick="user_login_modal(); return false;">Sign In / Up</button>
        </div>
    </template>
    <?php
});

function weekDays() {
    return [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];
}

function price($price=0) {
    return '£'.number_format($price,2);
}

function is_user() {
    global $user;
    return (!empty($user) && $user->isLoggedIn());
}

function set_session($key, $value) {
    $_SESSION[$key] = $value;
}

function get_session($key, $default = null) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
}

function remove_session($key) {
    unset($_SESSION[$key]);
}

function box_servings($box_size='') {
    switch ($box_size) {
        case 'small':
        default:
            return '1-2';
        case 'medium':
            return '3-4';
        case 'large':
            return '5-6';
    }
}