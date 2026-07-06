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
    wp_enqueue_style('main-style', get_stylesheet_uri());
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/assets/css/custom.css');
    wp_enqueue_style('camb_accordion', 'https://cdn.jsdelivr.net/npm/accordion-js@3.4.1/dist/accordion.min.css');
    wp_enqueue_script('camb_accordion', 'https://cdn.jsdelivr.net/npm/accordion-js@3.4.1/dist/accordion.min.js');
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/script.js');

    if (function_exists('is_product') && is_product()) {
        wp_enqueue_style('single-product-style', get_stylesheet_directory_uri() . '/assets/css/single-product.css', [], null);
        wp_enqueue_style('bootstrap-grid', get_stylesheet_directory_uri() . '/assets/css/bootstrap-grid.css');
    }
}
add_action('wp_enqueue_scripts', 'wp_register_styles');

add_action('init', 'wp_register_styles');

include "templates/wpb_wps_shortcode_function.php";

function primary_menu()
{
    $menu_items = wp_get_nav_menu_items('main-menu');
    $grouped_items = [];
    $children = [];
    $menu_html = '<div class="primary-menu">';
    if ($menu_items) {
        // Group items by parent ID
        foreach ($menu_items as $item) {
            if (empty($item->menu_item_parent)) {
                foreach ($menu_items as $child_item) {
                    if ($child_item->menu_item_parent == $item->ID) {
                        $slug = get_post_field('post_name',$child_item->object_id);
                        $classes = implode(' ', ($item->classes));
                        $children[] = array(
                            'ID' => $child_item->ID,
                            'slug' => $slug,
                            'title' => $child_item->title,
                            'classes' => $classes,
                            'url' => $child_item->url,
                            'menu_item_parent' => $child_item->menu_item_parent
                        );
                    }
                }
                $slug = get_post_field('post_name',$item->object_id);
                $classes = implode(' ', ($item->classes));
                $grouped_items[$item->ID] = array(
                    'ID' => $item->ID,
                    'title' => $item->title,
                    'url' => $item->url,
                    'classes' => $classes,
                    'slug' => $slug,
                    'menu_item_parent' => $item->menu_item_parent,
                    'menu_children' => $children
                );
            }

        }
    }

    $page_slug = get_queried_object()->post_name;

    foreach ($grouped_items as $item) {
        $is_active = $item['slug'] == $page_slug ? 'active' : '';
        $menu_html .= '<div class="menu-item">';
        $menu_html .= '<a class="button '.$is_active.' '.$item['classes'].'" href="' . $item['url'] . '">' . $item['title'] . '</a>';
        if (!empty($item['menu_children'])) {
            $menu_html .= '<div class="sub-menu"><div class="container">';
            foreach ($item['menu_children'] as $child) {
                $menu_html .= '<div class="sub-menu-item">';
                $menu_html .= '<a class="'.$is_active.' '.$child['classes'].'" href="' . $child['url'] . '">' . $child['title'] . '</a>';
                $menu_html .= '</div>';
            }
            $menu_html .= '</div></div>';
        }
        $menu_html .= '</div>';
    }

    $menu_html .= '</div>';

    return $menu_html;

}

add_shortcode('primary_menu_nav', 'primary_menu');


function store_products_shortcode($args = [])
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

function camb_postcode_search_form() {
    ob_start();
    ?>
    <form method="get" class="postcode-search">
        <div class="form-group">
            <input type="text" placeholder="Enter your postcode (e.g. CB2 VEG)" class="form-control" name="postcode" id="postcode">
        </div>
        <div class="form-group">
            <button type="submit" class="btn orange">Enter & Start Shopping</button>
        </div>
        <div class="form-group">
            <label>Or <a href="<?php echo site_url() ?>login">sign in</a> to your account</label>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

add_shortcode('camb_postcode_search_form','camb_postcode_search_form');

function camb_product_boxes($args=[]) {
    $atts = shortcode_atts([
        'limit' => ''
    ], $args);

    ob_start();
    ?>
    <div class="product-boxes">
        <?php
        for($i=1; $i<=$atts['limit']; $i++) {
            ?>
            <div class="product-box">
                <div class="thumbnail">
                    <img src="<?php echo site_url() ?>/wp-content/uploads/2025/10/Next_Box.png">
                </div>
                <div class="box-data">
                    <h3 class="prod-name">Vegetable Box · <span>Small</span></h3>
                    <div class="box-meta">
                        <div><i class="icon-people"></i> Serves 1-2</div>
                        <div><i class="icon-vegebox"></i> 8-10 Varieties</div>
                    </div>
                    <div class="box-footer">
                        <h5>Prices from</h5>
                        <h4 class="prod-price">£23</h4>
                        <a href="" class="btn orange">Select</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php

    return ob_get_clean();

}

add_shortcode('camb_product_boxes','camb_product_boxes');

function term_buttons_shortcode($atts) {
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

add_shortcode('term_buttons', 'term_buttons_shortcode');

function cambridge_products($args=[]) {
    $attr = shortcode_atts([
        'cat'=>''
    ],$args);

    ob_start();
    include "templates/shop-category-archieve.php";

    return ob_get_clean();
}

add_shortcode('cambridge_products', 'cambridge_products');

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