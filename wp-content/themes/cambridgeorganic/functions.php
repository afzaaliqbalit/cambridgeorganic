<?php
include "inc/core_functions.php";
require_once "remote/remote.php";
require_once "inc/routes.php";
require_once "inc/Cart.php";
require_once "remote/php_session.php";
require_once "inc/user_functions.php";
require_once "inc/cart_functions.php";

function get_menu_nav(): array {
    $grouped_items = [];
    global $post;
    $parent_menu_id = 0;

    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations['primary']);
    $menu_items = wp_get_nav_menu_items($menu->term_id);

    $post_id = !empty($post->ID) ? $post->ID : 0;

    foreach ($menu_items as $item) {
        if ($item->object_id == $post_id) {
            $parent_menu_id = $item->menu_item_parent;
            break;
        }
    }


    // Group items by parent ID
    foreach ($menu_items as $item) {
        if (empty($item->menu_item_parent)) {
            $children = [];
            foreach ($menu_items as $child_item) {
                if ($child_item->menu_item_parent == $item->ID) {
                    $slug = get_post_field('post_name',$child_item->object_id);
                    $classes = implode(' ', ($item->classes));
                    $is_active = $post_id == $child_item->object_id ? 1 : 0;

                    $children[] = array(
                        'ID' => $child_item->ID,
                        'slug' => $slug,
                        'title' => $child_item->title,
                        'classes' => $classes,
                        'url' => $child_item->url,
                        'is_active' => $is_active,
                        'menu_item_parent' => $child_item->menu_item_parent
                    );
                }
            }

            $slug = get_post_field('post_name',$item->object_id);
            $classes = implode(' ', ($item->classes));

            $parent_active = $item->ID == $parent_menu_id;

            $grouped_items[$item->ID] = array(
                'ID' => $item->ID,
                'title' => $item->title,
                'url' => $item->url,
                'classes' => $classes,
                'is_active_parent' => $parent_active,
                'slug' => $slug,
                'menu_item_parent' => $item->menu_item_parent,
                'menu_children' => $children
            );
        }
    }

    return $grouped_items;
}

function primary_menu(): string
{
    $grouped_items = get_menu_nav();
    $menu_html = '<div class="nav-primary-menu">';
    $page_slug = get_queried_object()->post_name ?? '';

    foreach ($grouped_items as $item) {
        $is_active = $item['slug'] == $page_slug || $item['is_active_parent'] ? 'active' : '';
        $menu_html .= '<div class="menu-item">';
        $menu_html .= '<a data-id="'.$item['ID'].'" class="button '.$is_active.' '.$item['classes'].'" href="' . $item['url'] . '">' . $item['title'] . '</a>';

        $menu_html .= '</div>';
    }

    $menu_html .= '</div>';

    return $menu_html;
}

add_shortcode('cambi_primary_menu_nav', 'primary_menu');

function child_menu_nav() {
    $grouped_items = get_menu_nav();
    $menu_html = '<div class="nav-secondary-menu"><div>';

    foreach ($grouped_items as $item) {
        $is_active = $item['is_active_parent'] ? 'active' : '';
        if (!empty($item['menu_children'])) {
            $menu_html .= '<div id="menu-'.$item['ID'].'" class="menu-item '.$is_active.'">
            <div class="container">';
            foreach ($item['menu_children'] as $child) {

                $is_active = !empty($child['is_active']) ? 'active' : '';

                $menu_html .= '<div class="sub-menu-item">';
                $menu_html .= '<a class="'.$is_active.' '.$child['classes'].'" href="' . $child['url'] . '">' . $child['title'] . '</a>';
                $menu_html .= '</div>';
            }
            $menu_html .= '</div></div>';
        }
    }

    $menu_html .= '</div>';

    if(is_user()) {
        $menu_html .= '<div><a class="logout-btn" href="'.site_url('customer/logout').'"><i class="icon-logout"></i> Logout</a> </div>';
    }

    $menu_html .= '</div>';


    return $menu_html;
}

add_shortcode('cambi_secondary_menu_nav', 'child_menu_nav');

function store_products_shortcode($args = []): bool|string
{
    $atts = shortcode_atts([
        'cats' => ''
    ], $args);

    ob_start();
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );

    if (!empty($atts['cats'])) {
        $terms = $atts['cats'];
        if (!is_array($terms)) {
            $terms = explode(',', $terms);
        }
        $terms = array_filter(array_map('trim', $terms));
        $terms = array_map('sanitize_title', $terms);

        if (!empty($terms)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $terms,
                    'operator' => 'IN',
                ),
            );
        }
    }

    $loop = new WP_Query($args);

    if ($loop->have_posts()) {
        echo '<div class="product-grid">';
        while ($loop->have_posts()):
            $loop->the_post();
            get_template_part('templates/shop', 'product-box');
        endwhile;
        echo '</div>';
    } else {
        echo 'no product';
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('store_products', 'store_products_shortcode');

// Allow SVG upload
function allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Fix SVG preview in Media Library
function fix_svg_media_library_display() {
    echo '<style>
        .attachment-266x266, .thumbnail img {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action('admin_head', 'fix_svg_media_library_display');

function cart_basket_html() {
    $cart = new Cart();
    ?>
    <div class="basket-badge-container">
        <i class="icon-basket"></i>
        <span class="badge-total-items"><?php echo $cart->getCount() ?></span>
    </div>
    <?php
}

function camb_postcode_search_form() {
    ob_start();
    ?>
    <div class="panel-wrapper">
    <form id="validate-guest-postcode-form" class="validate w-100 prevent-enter">
        <div class="d-flex flex-column gap-3">
            <div class="form-group">
                <input type="text" class="ul-input-postcode guest-signup-postcode" placeholder="Enter your postcode (e.g. CB2 1FD)" required data-error="Your postcode is required.">
            </div>
            <div class="text-center">
                <button type="button" class="ul-btn button btn-primary" onclick="guest_postcode_delivery_modal(this)">Enter Postcode</button>
            </div>
        </div>
    </form>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('camb_postcode_search_form','camb_postcode_search_form');

function camb_product_boxes($args=[]) {
    $atts = shortcode_atts([
        'limit' => '',
    ], $args);

    ob_start();
    ?>
    <div class="catalog-boxes">
        <?php
        for($i=1; $i<=$atts['limit']; $i++) {
            get_template_part('templates/shop', 'product-box');
        }
        ?>
    </div>
    <?php

    return ob_get_clean();

}

add_shortcode('camb_product_boxes','camb_product_boxes');

function term_buttons_shortcode1($atts) {
    global $wp;

    $atts = shortcode_atts([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => '',
        'label' => '',
        'show_all_btn' => false,
        'first_active' => false,
    ], $atts);

    $current_page = get_queried_object();
    $current_term = get_queried_object();

    $args = [
        'taxonomy'   => $atts['taxonomy'],
        'hide_empty' => filter_var($atts['hide_empty'], FILTER_VALIDATE_BOOLEAN),
    ];

    // Optional parent filter
    if ($atts['parent'] !== '') {
        $args['parent'] = (int) $atts['parent'];
    }

    $terms = get_terms($args);

    if (empty($terms) || is_wp_error($terms)) {
        return '';
    }

    $output = '';
    $first = true;

    ob_start();
    ?>
    <div class="shop-head-group">
        <h3><?php echo $atts['label'] ?></h3>
        <div class="flex-inline-list">
    <?php

    if($atts['show_all_btn']) {
        $is_active = empty($_GET[$atts['taxonomy']]) ? 'active' : '';
        $output .= '<a href="'.site_url($current_page->post_name).'" class="button btn-large '.$is_active.'">Everything</a>';
    }

    foreach ($terms as $term) {

        $url = add_query_arg(
            $atts['taxonomy'],
            $term->slug,
            home_url( $wp->request . ( !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '' ) )
        );

        $active = '';
        // Determine active class
        if (isset($_GET[$atts['taxonomy']]) && $_GET[$atts['taxonomy']] === $term->slug) {
            $active = 'active'; // current selected term
        } elseif (($first && $atts['first_active'] && !empty($_GET[$atts['taxonomy']]) && $_GET[$atts['taxonomy']] === $term->slug) || (!isset($_GET[$atts['taxonomy']]) && $first && $atts['first_active'])) {
            $active = 'active'; // fallback: first term active
        } else {
            $active = '';
        }


        $output .= '<a href="'.$url.'" class="button btn-large ' . $active . '">';
        $output .= esc_html($term->name);
        $output .= '</a>';

        $first = false;
    }

    echo $output;

    ?>
        </div>
    </div>
     <?php

    return ob_get_clean();
}

function term_buttons_shortcode($atts) {
    $args = shortcode_atts([
        'type'   => '',
    ], $atts);
        ob_start();

    $filters = [
        'box_type' => [
            'title' => 'Type of Produce',
            'options' => [
                'fruit' => 'Fruit Box <i class="icon-info"></i>',
                'vegetable' => 'Veg Box <i class="icon-info"></i>',
                'Fruit & Vegetable' => 'Fruit &amp; Veg <i class="icon-info"></i>',
            ],
        ],

        'box_size' => [
            'title' => 'Size of Box',
            'options' => [
                'small'  => 'Small <i class="icon-info"></i>',
                'medium' => 'Medium <i class="icon-info"></i>',
                'large'  => 'Large <i class="icon-info"></i>',
                'giant'  => 'Giant <i class="icon-info"></i>',
            ],
        ],

        'hyper_product_type' => [
            'title' => 'Customisation',
            'options' => [
                'hyper'  => 'Build Your Own <i class="icon-info"></i>',
                'choice' => '3 Exclusions <i class="icon-info"></i>',
                'fixed'  => 'No Customisation <i class="icon-info"></i>',
            ],
        ],
    ];

    if($args['type'] === 'single') {
        unset($filters['type']);
        unset($filters['box_type']);
    }
    ?>
    <form id="shop-filter-form">
        <?php
        foreach ($filters as $name => $filter) {
            $selected = $_GET[$name] ?? '';
            ?>
            <div class="shop-head-group">
                <h3><?= htmlspecialchars($filter['title']) ?></h3>

                <?php foreach ($filter['options'] as $value => $label): ?>
                    <?php $active = ($selected === $value); ?>

                    <div class="flex-inline-list">
                        <label class="button btn-large">
                            <input
                                type="radio"
                                name="<?= htmlspecialchars($name) ?>"
                                value="<?= htmlspecialchars($value) ?>"
                                <?= $active ? 'checked' : '' ?>
                            >
                            <?= $label ?>
                        </label>
                    </div>

                <?php endforeach; ?>
            </div>
            <?php
        }
        ?>
        <script>
            document.querySelectorAll('#shop-filter-form input[type="radio"]').forEach((input) => {
                input.addEventListener('mousedown', (e) => {
                    e.currentTarget.dataset.wasChecked = e.currentTarget.checked;
                });

                input.addEventListener('click', (e) => {
                    const radio = e.currentTarget;
                    const wasChecked = radio.dataset.wasChecked === 'true';

                    if (wasChecked) {
                        // Browser has selected it, so undo that selection
                        setTimeout(() => {
                            radio.checked = false;
                            submitFilterForm(radio);
                        }, 0);
                    } else {
                        submitFilterForm(radio);
                    }
                });
            });

            function submitFilterForm(radio) {
                const form = radio.closest('form');
                const params = new URLSearchParams(new FormData(form));
                const url = new URL(window.location.href);

                ['box_type', 'box_size', 'type','hyper_product_type'].forEach((key) => {
                    url.searchParams.delete(key);
                });

                params.forEach((value, key) => {
                    url.searchParams.set(key, value);
                });

                reloadElement('#shop-category-archive-wrap', url, true).then(()=>{
                    init_sidebar_scroll();
                });
            }
        </script>
    </form>
    <?php
    return ob_get_clean();
}

add_shortcode('term_buttons', 'term_buttons_shortcode');

function image_button_box_html($args=[]) {
    $attr = shortcode_atts([
        'link'=>'',
        'label'=>'',
        'image'=>''
    ],$args);

    ob_start();
    include "templates/image_button_box.php";

    return ob_get_clean();
}

add_shortcode('image_button_box', 'image_button_box_html');

function cambridge_products_shortcode($atts=[]) {
    $atts = shortcode_atts([
        'theme' => 'default',
    ], $atts);
    ob_start();
    get_template_part('templates/products-slider', null, $atts);
    return ob_get_clean();
}

add_shortcode('camb-product-slider' , 'cambridge_products_shortcode');

function cambridge_signing_btn_shortcode() {
    if(!is_user()) {
    ?>
    <a href="#" onclick="user_login_modal(); return false;" class="button btn-orange">Sign In / Up</a>
    <?php
    }
}

add_shortcode('camb-signin-btn', 'cambridge_signing_btn_shortcode');

function cambridge_cart_icon_count_shortcode() {
    global $user;

    $cart = new Cart();
    ob_start();
    ?>
    <div class="head-user-info">
        <?php if(is_user()) {
            $profile = $user->getCustomer();
            $first_name = $profile['first_name'] ?? '';
            ?>
        <div class="user-info-wrapper">
            <a data-tooltip="customer-icon-menu" href="<?php echo site_url('customer') ?>"><span class="user-initial"><?php echo substr($first_name,0,1) ?></span><i class="icon-user"></i></a>
        </div>
        <?php }
        /*href="<?php
            $cart_link = '';
            if(is_login()) {
                $cart_link = site_url('checkout');
            }elseif(!is_login() && $cart->getCount() > 0) {
                $cart_link = site_url('create-account');
            }
            echo $cart->getCount() > 0 ? $cart_link:'#' ?>"*/
        $cart_count = $cart->getCount();
        ?>
            <a class="basket-badge-container" <?php echo $cart_count > 0 ? 'onclick="cart_toggle()"':'' ?>>
                <i class="icon-basket"></i>
                <span class="badge-total-items"><?php echo $cart_count ?></span>
            </a>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('camb-cart-counter', 'cambridge_cart_icon_count_shortcode');

function cambridge_cart_subtotalText_shortcode() {
    ob_start();
    $cart = new Cart();
    ?>
    <div class="basket-subtotal-price"><?php echo $cart ? price($cart->getTotal()) : 0 ?></div>
    <?php
    return ob_get_clean();
}

add_shortcode('camb-cart-subtotal-text', 'cambridge_cart_subtotalText_shortcode');

function cambridge_login_singup_form_shortcode() {
    ob_start();
    ?>
    <div id="user-login-signup-wrapper">
        <?php get_template_part('templates/user','login-signup-form'); ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('cambi_login_signup_form', 'cambridge_login_singup_form_shortcode');