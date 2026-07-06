<?php
if(!empty($args['product'])) {
$product = $args['product'];
?>
<div class="product-box-wrapper product-hyper-box" data-pid="<?php echo $product['id'] ?>">
    <div class="thumbnail">
        <img decoding="async" loading="lazy" class="product-image" src="<?php echo thumbnail($product['image']) ?>">
    </div>
    <div class="box-data">
        <h3 class="prod-name"><?php echo $product['name'] ?><span><?php echo $product['box_size'] ? ' · '.$product['box_size'] : '' ?></span></h3>
        <div class="box-meta">
            <div><i class="icon-people"></i> Serves <?php echo box_servings($product['box_size']) ?></div>
            <div><i class="icon-vegebox"></i> 8-10 Varieties</div>
        </div>
        <div class="box-footer">
            <h5>Prices from</h5>
            <h4 class="prod-price"><?php echo price($product['net_selling_price']) ?></h4>

            <div class="tooltip-wrapper">
                <button type="button" class="btn orange" data-tooltip="login-tooltip-content">Select</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>