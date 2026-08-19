<?php
/**
    Template Name: Product page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

$cart = new Cart();
?>

    <div class="container page-wrap product-box-wrapper">
        <div class="single-product-wrap catalog-boxes">
            <div class="row">
                <div class="col-5 product-image">
                    <img src="<?php echo thumbnail($args['image']) ?>">
                </div>
                <div class="col-7 product-info">
                    <!-- TITLE -->
                    <div class="product-title">
                        <h2 class="mb-0 fw-bold"><?php echo $args['name'] ?></h2>
                        <?php if(!empty($args['weight_kg'])) { ?>
                        <span class="text-muted"><?php echo product_weight($args)?></span>
                        <?php } ?>
                    </div>

                    <!-- TAGS -->

                    <?php
                    if($args['type'] !== 'single') {
                        $btnClass = 'btn orange';
                        $btnAction = 'add';
                        $onclick = 'addToCartItem(this)';
                        $btnText = 'Select';
                        $add_to_cart = '';
                    }else {
                        $btnClass = 'btn orange';
                        $btnAction = 'add';
                        $onclick = 'add_to_cart('.$args['id'].', '.$args['net_selling_price'].', 1, { item_frequency: this.closest(\'.product-select-box\').querySelector(\'.item_frequancy\').value })';
                        $btnText = 'Select';
                    }

                    if(!is_user() && !empty($_SESSION['ordle-cart']['routeDay'])) {
                        $add_to_cart = 'guest_add_to_cart';
                    }
                    if(!is_user() && empty($_SESSION['ordle-cart']['routeDay'])) {
                        $onclick = '';
                    }
                    if(is_user()) {
                        $add_to_cart = 'add_to_cart';
                    }
                    if(!empty($cart->getItem($args['id']))) {

                        ?>
                        <div class="box-message">
                            <div>
                                <i class="icon-basket"></i>
                                <p>This Item is in your Basket for next Delivery</p>
                            </div>
                        </div>
                        <?php

                        if($args['type'] !== 'single') {
                            $btnAction = 'remove';
                            $add_to_cart = 'remove_cart_item';
                            $onclick = 'removeCartItem(' . $args['id'] . ')';
                            $btnClass = 'btn bg-red color-white';
                            $btnText = 'Remove';
                            if ($args['hyper_product_type'] === 'choice') {
                                $btnAction = 'update';
                                $add_to_cart = 'update_cart_item';
                                $onclick = 'updateCartItem(this, ' . $args['id'] . ')';
                                $btnText = 'Update';
                            }
                        }else {
                            $btnAction = 'update';
                            $add_to_cart = 'update_cart_item';
                            $onclick = 'updateCartItem(this, '.$args['id'].', this.value, { item_frequency: this.closest(\'.product-select-box\').querySelector(\'.item_frequancy\').value })';
                            $btnText = 'Update';
                        }

                    }
                    ?>

                    <!-- PRICE + CONTROLS -->
                    <div>
                        <div class="price-info product-select-box box-footer">

                            <h3 class="product-price"><?php echo price($args['gross_selling_price']) ?></h3>

                            <?php if($args['type'] == 'single') {
                                $cart_item = $cart->getItem($args['id']);
                                ?>

                                <div class="var-selection">
                                    <label class="mb-2">How often?</label>
                                    <select class="form-select select2 text-center item_frequancy" name="item_frequancy" value="<?php echo $cart_item['item_frequency'] ?? '' ?>">
                                        <option value="add_once">Add Once</option>
                                        <option value="add_always">Add Always</option>
                                    </select>
                                </div>

                                <?php
                                    if(!empty($cart->getItem($args['id']))) {
                                        echo get_template_part('templates/stepper-input', null,
                                            [
                                                'name' => 'quantity',
                                                'onchange' => $onclick,
                                                'value' => $cart_item['cart_quantity'] ?? 1
                                            ]);
                                    }
                                ?>
                                <?php

                                ?>
                                <a href="#" role="button" data-quantity="1" class="btn button <?php echo $btnClass ?>" onclick="<?php echo $onclick ?>" data-pid="<?php echo $args['id'] ?>" aria-label="<?php echo $btnText ?>"><?php echo $btnText ?></a>
                                <?php

                            }else {
                                ?>
                                <div class="tooltip-wrapper">
                                    <button type="button" class="<?php echo $btnClass.' '.$add_to_cart ?>" data-slug="<?php echo $args['slug'] ?>" data-pid="<?php echo $args['id'] ?>" data-choicebox="<?php echo $args['hyper_product_type'] ?>" onclick="<?php echo $onclick ?>" data-price="<?php echo $args['net_selling_price'] ?>" <?php if(empty($add_to_cart)) {?> data-tooltip="login-tooltip-content" <?php } ?>><?php echo $btnText ?></button>
                                </div>
                                <?php
                            } ?>


                        </div>
                    </div>

                    <!-- Description -->

                    <?php if(!empty($args['description'])) {
                        ?>
                        <hr style="border-top: 1px solid #ffffff94; display: block; width: 100%; margin-top: 2em;">
                        <div class="product-description">
                            <h3 class="fs-5">Description:</h3>
                            <p><?php echo $args['description'] ?></p>
                        </div>
                        <?php
                    }; ?>

                    <!-- ACCORDION -->
                    <?php /*<div>
                        <div class="accordion" id="productAccordion">
                            <!-- Description -->
                            <div class="accordion-container">
                                <div class="ac js-enabled" id="ac-0">
                                    <h2 class="ac-header">
                                        <button type="button" class="ac-trigger" id="ac-trigger-0" role="button" aria-controls="ac-panel-0" aria-disabled="false" aria-expanded="false">Lorem ipsum dolor sit amet.</button>
                                    </h2>
                                    <div class="ac-panel" id="ac-panel-0" role="region" aria-labelledby="ac-trigger-0" style="transition-duration: 400ms; height: 0px;">
                                        <div class="ac-text">
                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                                laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam. Quis nostrud exerci tation
                                                ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in
                                                hendrerit in vulputate velit esse molestie consequat.</p>

                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                                laoreet dolore magna aliquam erat volutpat.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="ac js-enabled" id="ac-1">
                                    <h2 class="ac-header">
                                        <button type="button" class="ac-trigger" id="ac-trigger-1" role="button" aria-controls="ac-panel-1" aria-disabled="false" aria-expanded="false">Lorem ipsum dolor sit amet.</button>
                                    </h2>
                                    <div class="ac-panel" id="ac-panel-1" role="region" aria-labelledby="ac-trigger-1" style="transition-duration: 400ms; height: 0px;">
                                        <p class="ac-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </div>

                                <div class="ac js-enabled" id="ac-2">
                                    <h2 class="ac-header">
                                        <button type="button" class="ac-trigger" id="ac-trigger-2" role="button" aria-controls="ac-panel-2" aria-disabled="false" aria-expanded="false">Lorem ipsum dolor sit amet.</button>
                                    </h2>
                                    <div class="ac-panel" id="ac-panel-2" role="region" aria-labelledby="ac-trigger-2" style="transition-duration: 400ms; height: 0px;">
                                        <p class="ac-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>*/ ?>
                </div>
            </div>

        </div>
    </div>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
