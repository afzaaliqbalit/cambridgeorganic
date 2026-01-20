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
}

add_action('init', 'wp_register_styles');

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