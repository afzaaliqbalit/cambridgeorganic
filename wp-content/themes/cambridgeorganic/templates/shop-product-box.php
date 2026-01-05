<div class="shop-product-box">
    <div class="box-image">
        <?php echo get_the_post_thumbnail() ?>
    </div>
    <?php 
    $product = wc_get_product( get_the_ID() );
    ?>
    <div class="box-content">
        <h3><?php echo get_the_title() ?></h3>
        <div><?php 
        if(!empty($product)) { echo $product->get_weight();}
        ?></div>
        <div class="box-location"><?php echo get_field('product_location') ?></div>
        <div class="box-price"><?php if(!empty($product)) { echo $product->get_price_html();} ?></div>
    </div>
</div>