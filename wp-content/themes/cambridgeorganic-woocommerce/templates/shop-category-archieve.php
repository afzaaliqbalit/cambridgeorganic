<?php

?>
<div id="shop-category-archieve">

    <?php
        $args = [
            'status'  => 'publish',
            'limit'   => -1,           // or your desired number, e.g. 12
            'orderby' => 'date',
            'order'   => 'DESC',
        ];

        // Keep existing category filter if you still need it
        if (!empty($cat)) {
            $args['category'] = $cat;   // or $args['tax_query'][] for more control
        }

        // Get values from GET request (sanitize properly)
        $type_of_produce = isset($_GET['type_of_produce']) ? sanitize_text_field(wp_unslash($_GET['type_of_produce'])) : '';
        $prod_variety    = isset($_GET['prod_variety'])    ? sanitize_text_field(wp_unslash($_GET['prod_variety']))    : '';

        // Build tax_query only if we have at least one taxonomy filter
        $tax_query = [];

        if (!empty($type_of_produce)) {
            $tax_query[] = [
                'taxonomy' => 'type_of_produce',
                'field'    => 'slug',           // or 'term_id' / 'name' if preferred
                'terms'    => $type_of_produce, // can be single slug or array of slugs
                'operator' => 'IN',
            ];
        }

        if (!empty($prod_variety)) {
            $tax_query[] = [
                'taxonomy' => 'prod_variety',
                'field'    => 'slug',
                'terms'    => $prod_variety,
                'operator' => 'IN',
            ];
        }

        // If we have any taxonomy filters, add tax_query with proper relation
        if (!empty($tax_query)) {
            $tax_query['relation'] = 'AND';     // Change to 'OR' if you prefer OR logic
            $args['tax_query'] = $tax_query;
        }

        // Get the products
        //$products = wc_get_products($args);
    ?>

    <div class="catalog-boxes">
        <?php
//            foreach ($products as $product) {
//                set_query_var('product', $product);
//                get_template_part('templates/product', 'selection-box',[ 'product' => $product ]);
//            }
        get_template_part('templates/product', 'selection-box',[ 'product' => [] ]);
        ?>
    </div>
</div>