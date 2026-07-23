<div id="side-cart-wrapper">
    <div id="side-cart-toggle" data-cart-toggle onclick="cart_toggle()"><?php cart_basket_html() ?></div>

    <?php
        $cart = new Cart();
        $items = $cart->getCart();
        $items = !empty($items['products']) ? $items['products'] : array();
    ?>
    <div id="sidecart">
        <h3>Your Shopping Basket</h3>
        <div class="cart-items">
            <?php
                foreach ($items as $item) {
            ?>
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="<?php echo thumbnail($item['image']); ?>" loading="lazy">
                    </div>
                    <div class="cart-item-details">
                        <table width="100%">
                            <tr>
                                <th>Name</th>
                                <td><?php echo $item['name'] ?> x <?php echo $item['cart_quantity'] ?></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td><?php echo price($item['net_selling_price']) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="cart-actions">

                    </div>
                </div>
            <?php } ?>

        </div>
        <div class="cart-total">
            <div class="cart-subtotal-price">
                <label>Subtotal</label>
                <p><?php echo price($cart->getSubTotal()) ?></p>
            </div>
            <div class="cart-delivery-price">
                <label>Delivery</label>
                <p><?php echo price($cart->deliveryCost()) ?></p>
            </div>
            <div class="cart-total-price">
                <label><h6>Total</h6></label>
                <h5><?php echo price($cart->getTotal()) ?></h5>
            </div>
        </div>

        <div class="cart-actions pt-4">
            <?php if(is_user() && get_current_page() !== 'checkout') { ?>
            <a href="<?php echo site_url('checkout') ?>" class="button btn-primary w-100">Checkout</a>
            <?php }else {
                if(get_current_page() !== 'create-account' && get_current_page() !== 'checkout') { ?>
                <a href="<?php echo site_url('create-account') ?>" class="button btn-primary w-100">Create Account</a>
                <?php
                }
            } ?>
        </div>
    </div>
</div>