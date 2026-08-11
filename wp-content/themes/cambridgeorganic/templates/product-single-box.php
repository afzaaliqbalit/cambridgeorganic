<?php
if(!empty($args['product'])) {
    $product = $args['product'];
    $cart = $args['cart'];
    $cart_item = $cart->getItem($product['id']);
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
            <label class="mb-2">How often?</label>
            <select class="form-select select2 text-center item_frequancy" name="item_frequancy" style=" min-width: 210px;" value="<?php echo $cart_item['item_frequency'] ?? '' ?>">
                <option value="add_once">Add Once</option>
                <option value="add_always">Add Always</option>
            </select>
        </div>

        <?php
        $btnClass = 'btn orange';
        $btnAction = 'add';
        $onclick = 'add_to_cart('.$product['id'].', '.$product['net_selling_price'].', 1, { item_frequency: this.closest(\'.product-select-box\').querySelector(\'.item_frequancy\').value })';
        $btnText = 'Select';
        if(!empty($cart->getItem($product['id']))) {
            ?>
            <div class="box-message mb-4">
                <div>
                    <i class="icon-basket"></i>
                    <p>This Item is in your Basket for next Delivery</p>
                </div>
            </div>
            <?php
            $btnAction = 'update';
            $add_to_cart = 'update_cart_item';
            $onclick = 'updateCartItem(this, '.$product['id'].', this.value, { item_frequency: this.closest(\'.product-select-box\').querySelector(\'.item_frequancy\').value })';
            $btnText = 'Update';
        } ?>

        <div class="prod_buttons">
            <?php
            if(is_user()) { ?>
                <?php
                if($btnAction == 'add') {
                    ?>
                    <a href="#" role="button" data-quantity="1" class="button <?php echo $btnClass ?>" onclick="<?php echo $onclick ?>" data-product_id="<?php echo $product['id'] ?>" aria-label="<?php echo $btnText ?>"><?php echo $btnText ?></a>
                    <?php
                }else {
                    ?>
                    <?php echo get_template_part('templates/stepper-input', null,
                        [
                            'name' => 'quantity',
                            'onchange' => $onclick,
                            'value' => $cart_item['cart_quantity'] ?? 1
                        ]); ?>
                    <?php
                }
                ?>
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