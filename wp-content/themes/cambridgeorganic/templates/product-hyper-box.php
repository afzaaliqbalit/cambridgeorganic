<?php
if(!empty($args['product'])) {
$product = $args['product'];
$cart = $args['cart'];
$associated_products = !empty($product['associated_products']) ? $product['associated_products'] : array();
$count_associated = count($associated_products);
$add_to_cart ='';
if(!is_user() && !empty($_SESSION['ordle-cart']['routeDay'])) {
    $add_to_cart = 'guest_add_to_cart';
}
if(is_user()) {
    $add_to_cart = 'add_to_cart';
}
?>
<div class="product-box-wrapper product-hyper-box" data-pid="<?php echo $product['id'] ?>">
    <div class="thumbnail">
        <a href="<?php echo site_url() ?>/product/<?php echo $product['id'] ?>"><img decoding="async" loading="lazy" class="product-image" src="<?php echo thumbnail($product['image']) ?>"></a>
    </div>
    <div class="box-data">
        <h3 class="prod-name"><?php echo $product['name'] ?><span><?php echo $product['box_size'] ? ' · '.$product['box_size'] : '' ?></span></h3>

        <div class="box-meta">
            <div><i class="icon-people"></i> Serves <?php echo box_servings($product['box_size']) ?></div>
            <?php if($count_associated) { ?>
            <div><i class="icon-vegebox"></i> <?php echo $count_associated ?> <?php echo $count_associated==1 ? 'Item':'Items' ?></div>
            <?php } ?>
        </div>

        <?php
        $btnClass = 'btn orange';
        $btnAction = 'add';
        $onclick = 'addToCartItem(this)';
        $btnText = 'Select';
        if(!empty($cart->getItem($product['id']))) {
            ?>
        <div class="box-message">
            <div>
                <i class="icon-basket"></i>
                <p>This Item is in your Basket for next Delivery</p>
            </div>
        </div>
            <?php
            $btnAction = 'remove';
            $add_to_cart = 'remove_cart_item';
            $onclick = 'removeCartItem('.$product['id'].')';
            $btnClass = 'btn bg-red color-white';
            $btnText = 'Remove';
            if($product['hyper_product_type'] === 'choice') {
                $btnAction = 'update';
                $add_to_cart = 'update_cart_item';
                $onclick = 'updateCartItem(this, '.$product['id'].')';
                $btnText = 'Update';
            }
        }

        if(!is_user() && empty($_SESSION['ordle-cart']['routeDay'])) {
            $onclick = '';
        }
        ?>

        <?php if(!empty($associated_products)) { ?>
        <div class="box-contents animated fadeInDown">
            <ul>
                <?php foreach($associated_products as $associated_product) { ?>
                <li><?php echo !empty($associated_product['origin_sticker']) ? '<img width="16" height="16" src="'.$associated_product['origin_sticker'].'" alt="'.$associated_product['product_origin_status'].'">' : '' ?>
                    <?php echo $associated_product['name'] ?> (<?php echo product_weight($associated_product)?>)</li>
                <?php } ?>
            </ul>
            <div class="box-bottom"><p>Approximate Weights For Guidance</p></div>
        </div>
        <?php } ?>

    <?php if(!empty($associated_products)) { ?>
        <div class="box-price text-center">
            <h5>Price </h5>
            <h4 class="prod-price"><?php echo price($product['net_selling_price']) ?></h4>
        </div>
        <?php } ?>

        <div class="box-footer">
    <?php if(!empty($associated_products)) { ?>
            <div class="prod-box-contents">
                <div class="prod-button" onclick="this.closest('.product-box-wrapper').classList.toggle('content-open')">Contents <i class="icon-arrow"></i></div>
            </div>
        <?php }else {
        ?>
        <div class="box-price text-center">
            <h5>Price </h5>
            <h4 class="prod-price"><?php echo price($product['net_selling_price']) ?></h4>
        </div>
        <?php
    }?>

            <div class="tooltip-wrapper">
                <button type="button" class="<?php echo $btnClass.' '.$add_to_cart ?>" data-slug="<?php echo $product['slug'] ?>" data-pid="<?php echo $product['id'] ?>" data-choicebox="<?php echo $product['hyper_product_type'] ?>" onclick="<?php echo $onclick ?>" data-price="<?php echo $product['net_selling_price'] ?>" <?php if(empty($add_to_cart)) {?> data-tooltip="login-tooltip-content" <?php } ?>><?php echo $btnText ?></button>
            </div>

        </div>
    </div>
</div>
<?php } ?>