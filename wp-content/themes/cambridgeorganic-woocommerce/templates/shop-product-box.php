<div class="shop-product-box">
    <div class="box-image">
        <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
    </div>

    <?php
    $product = wc_get_product(get_the_ID());
    ?>

    <div class="box-content">
        <!-- Product Name -->
        <h3><?php echo get_the_title(); ?></h3>

        <!-- Weight -->
        <div class="box-weight">
            <?php
            if (!empty($product) && $product->get_weight()) {
                echo esc_html($product->get_weight()) . 'g';
            } else {
                echo '150g'; // fallback
            }
            ?>
        </div>

        <!-- Location -->
        <div class="box-location">
            <?php
            $location = get_field('product_location');
            echo $location ? esc_html($location) : 'Andalucia, Spain';
            ?>
        </div>

        <!-- Price -->
        <div class="box-price">
            <?php
            if (!empty($product)) {
                echo $product->get_price_html();
            } else {
                echo '£1.25';
            }
            ?>
        </div>

        <!-- Type of Produce -->
        <div class="box-type-of-produce">
            <?php
            $produce_terms = wp_get_post_terms(get_the_ID(), 'type_of_produce', ['fields' => 'names']);
            if (!empty($produce_terms)) {
                echo '<strong>Type:</strong> ' . esc_html(implode(', ', $produce_terms));
            }
            ?>
        </div>

        <!-- Prod Variety -->
        <div class="box-prod-variety">
            <?php
            $variety_terms = wp_get_post_terms(get_the_ID(), 'prod_variety', ['fields' => 'names']);
            if (!empty($variety_terms)) {
                echo '<strong>Variety:</strong> ' . esc_html(implode(', ', $variety_terms));
            }
            ?>
        </div>

    </div>
</div>