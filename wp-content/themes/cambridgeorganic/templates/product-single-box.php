<?php
if(!empty($args['product'])) {
    $product = $args['product'];
?>
<div class="product-select-box" data-pid="<?php echo $product['id'] ?>">
    <div class="image">
        <a href="<?php echo site_url() ?>/product/<?php echo $product['slug'] ?>">
            <img fetchpriority="high" decoding="async" width="300" height="189" src="<?php echo thumbnail($product['image']) ?>" class="product-image" alt="<?php echo $product['name'] ?>" loading="lazy">        </a>
    </div>


    <div class="actions">
        <!-- Product Name -->
        <h2 class="name"><?php echo $product['name'] ?></h2>

        <!-- Weight + Variety -->
        <h3 class="weight">
            <a href="<?php echo site_url() ?>/product/<?php echo $product['slug'] ?>"><?php echo $product['weight'] ?> <?php echo $product['per_unit'] ?></a>
        </h3>

        <!-- Location -->
<!--        <h4 class="location">Mucho Grande Andalucia, Spain</h4>-->

        <!-- Price -->
        <div class="prod_price">
            <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"></span><?php echo price($product['net_selling_price']) ?></bdi></span>        </div>

        <!-- How often? Selection -->
        <div class="var-selection">
            <p>How often?</p>
            <select name="variation[548]" class="select">
                <option value="once">Add Once</option>
                <option value="weekly">Weekly</option>
                <option value="biweekly">Every 2 Weeks</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>

        <div class="prod_buttons">
            <?php if(is_user()) { ?>
                <a href="#" role="button" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product['id'] ?>" aria-label="Add to cart">Add to Cart</a>
            <?php }else {
                ?>
                <a href="#" data-tooltip="login-tooltip-content" onclick="return false" class="button btn-orange" role="button">Add to cart</a>
                <?php
            } ?>

        </div>

        <!-- Taxonomies: Type of Produce & Variety -->
    </div>
</div>
<?php } ?>