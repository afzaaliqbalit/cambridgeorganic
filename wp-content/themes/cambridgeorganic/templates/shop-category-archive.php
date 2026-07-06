<div id="shop-category-archieve">
    <div class="catalog-boxes">
        <?php
            if(!empty($args['products'])) {
                if($args['type'] === 'single') {
                    foreach ($args['products'] as $product) {
                        get_template_part('templates/product', 'single-box', ['product' => $product]);
                    }
                }
                if($args['type'] === 'hyper') {
                    foreach ($args['products'] as $product) {
                        get_template_part('templates/product', 'hyper-box', ['product' => $product]);
                    }
                }
            }
        ?>
    </div>
</div>