<?php
register_nav_menus(array(
    'primary_menu' => __('Primary Menu', 'cambridgeorganic'),
));

function pr($array = [])
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function wp_register_styles()
{
    wp_enqueue_style('main-style', get_stylesheet_uri());
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0', 'all');
}

add_action('init', 'wp_register_styles');

function primary_menu()
{
    $menu_items = wp_get_nav_menu_items('main-menu');
    $grouped_items = [];
    $menu_html = '<div class="primary-menu">';
    if ($menu_items) {
        // Group items by parent ID
        foreach ($menu_items as $item) {
            if (empty($item->menu_item_parent)) {
                $children = [];
                foreach ($menu_items as $child_item) {
                    if ($child_item->menu_item_parent == $item->ID) {
                        $children[] = array(
                            'ID' => $child_item->ID,
                            'title' => $child_item->title,
                            'url' => $child_item->url,
                            'menu_item_parent' => $child_item->menu_item_parent
                        );
                    }
                }
                ;
                $grouped_items[$item->ID] = array(
                    'ID' => $item->ID,
                    'title' => $item->title,
                    'url' => $item->url,
                    'menu_item_parent' => $item->menu_item_parent,
                    'menu_children' => $children
                );
            }

        }
    }

    foreach ($grouped_items as $item) {
        $menu_html .= '<div class="menu-item">';
        $menu_html .= '<a href="' . $item['url'] . '">' . $item['title'] . '</a>';
        if (!empty($item['menu_children'])) {
            $menu_html .= '<div class="sub-menu"><div class="container">';
            foreach ($item['menu_children'] as $child) {
                $menu_html .= '<div class="sub-menu-item">';
                $menu_html .= '<a href="' . $child['url'] . '">' . $child['title'] . '</a>';
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