<div class="product-select-box">
    <div class="image">
        <a href="<?php echo $product->get_permalink(); ?>">
        <?php
        if ($product->get_image_id()) :
            echo $product->get_image('medium', ['class' => 'product-image']);
        else :
            ?>
            <img src="<?php echo site_url(); ?>/wp-content/uploads/2025/10/Next_Box.png"
                 alt="<?php echo esc_attr($product->get_name()); ?>"
                 class="product-image">
        <?php endif; ?>
        </a>
    </div>

    <?php
        $product_id = $product->get_id();
    ?>

    <div class="actions">
        <!-- Product Name -->
        <h2 class="name"><?php echo $product->get_name(); ?></h2>

        <!-- Weight + Variety -->
        <h3 class="weight">
            <a href="<?php echo $product->get_permalink(); ?>">
                <?php
                $weight = $product->get_weight();
                echo $weight ? esc_html($weight) . 'g' : '150g';
                ?>
                <?php
                // Show Prod Variety in the same line
                $variety_terms = wp_get_post_terms($product_id, 'prod_variety', ['fields' => 'names']);
                if (!empty($variety_terms)) {
                    echo ' | ' . esc_html(implode(', ', $variety_terms));
                }
                ?>
            </a>
        </h3>

        <!-- Location -->
        <h4 class="location">
            <?php
            $location = get_field('product_location', $product_id) ?:
                get_post_meta($product_id, 'location', true);
            echo $location ? esc_html($location) : 'Mucho Grande Andalucia, Spain';
            ?>
        </h4>

        <!-- Price -->
        <div class="prod_price">
            <?php echo $product->get_price_html(); ?>
        </div>

        <!-- How often? Selection -->
        <div class="var-selection">
            <p>How often?</p>
            <select name="variation[<?php echo esc_attr($product_id); ?>]" class="select">
                <option value="once">Add Once</option>
                <option value="weekly">Weekly</option>
                <option value="biweekly">Every 2 Weeks</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>

        <div class="prod_buttons">
            <a href="?add-to-cart=<?php echo $product_id ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="123" data-product_sku="" aria-label="Add to cart">Add to Cart</a>
        </div>

        <!-- Taxonomies: Type of Produce & Variety -->
        <?php /*<div class="product-taxonomies">
            <?php
                // Type of Produce
                $produce_terms = wp_get_post_terms($product_id, 'type_of_produce', ['fields' => 'names']);
                if (!empty($produce_terms)) {
                    echo '<span class="type-of-produce"><strong>Type:</strong> '
                        . esc_html(implode(', ', $produce_terms)) . '</span><br>';
                }

                // Prod Variety (optional extra display)
                $variety_terms = wp_get_post_terms($product->get_id(), 'prod_variety', ['fields' => 'names']);
                if (!empty($variety_terms)) {
                    echo '<span class="prod-variety"><strong>Variety:</strong> '
                        . esc_html(implode(', ', $variety_terms)) . '</span>';
                }
            ?>
        </div>*/ ?>
    </div>
</div>