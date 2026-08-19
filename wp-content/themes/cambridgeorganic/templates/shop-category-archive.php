<div id="shop-category-archive-wrap">
<div id="shop-category-sidebar-filter">
    <?php if(!empty($args['products'])) {
        $item_products = [];
        foreach($args['products'] as $product) {
            if(!empty($product['associated_products'])) {
                foreach($product['associated_products'] as $associated_product) {
                    $item_products[$associated_product['id']] = $associated_product['name'];
                }
            }
        }
        ?>
    <div class="content-open">
        <div class="filter-button">
            <p>Filter These Options</p>
        </div>
        <div class="filter-content">
            <div class="filter-head">
                <h3>Filter</h3>
                <a href="#" class="button filter-close" onclick="this.closest('#shop-category-sidebar-filter').classList.toggle('open');return false;">Minimize</a>
            </div>

            <form method="get" class="form">
                <div class="filter-section">
                    <h5>Type of Produce <span class="info-icon">i</span></h5>
                    <div class="radio-group">
                        <label class="filter-option">
                            <input type="radio" name="box_type" value="fruit" class="styled" <?php echo !empty($_GET['box_type']) && $_GET['box_type'] == 'fruit' ? 'checked' : ''; ?>>
                            Fruit
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="box_type" value="vegetable" class="styled"  <?php echo !empty($_GET['box_type']) && $_GET['box_type'] == 'vegetable' ? 'checked' : ''; ?>>
                            Veg
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="box_type" value="Fruit & Vegetable" class="styled"  <?php echo !empty($_GET['box_type']) && $_GET['box_type'] == 'Fruit & Vegetable' ? 'checked' : ''; ?>>
                            Fruit & Veg
                        </label>
                    </div>
                </div>

                <?php if(!empty($item_products)) { ?>
                <div class="filter-section">
                    <h5>Classic Varieties <span class="info-icon">i</span></h5>
                    <div class="radio-list">
                        <label class="filter-option">
                            <input type="radio" name="associated_product" value="all" class="styled" checked>
                            Everything
                        </label>

                        <?php foreach($item_products as $id=>$name) { ?>
                            <label class="filter-option">
                                <input type="radio" name="associated_product" value="<?php echo $id ?>" class="styled">
                                <?php echo $name; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <div class="filter-section">
                    <h5>Sort by... <span class="info-icon">i</span></h5>
                    <div class="radio-group">
                        <label class="filter-option">
                            <input type="radio" name="sort_by" class="styled" value="special_offer">
                            Special Offer
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="sort_by" class="styled" value="best_sellers">
                            Best Sellers
                        </label>
                    </div>
                </div>

                <div class="filter-section">
                    <a href="#" class="button filter-reset">Reset Selection</a>
                </div>
            </form>
        </div>
    </div>

    <div class="content-close">
        <div class="filter-button" onclick="this.closest('#shop-category-sidebar-filter').classList.toggle('open');return false;">
            <p>Filter These Options</p>
        </div>
    </div>
    <?php } ?>
</div>
<div id="shop-category-archieve">
    <div class="container">
        <?php if(!empty($args['products'])) { ?>
        <div class="catalog-boxes">
            <?php
            $cart = new Cart();


                if($args['type'] === 'single') {
                    foreach ($args['products'] as $product) {
                        get_template_part('templates/product', 'single-box', ['product' => $product, 'cart' => $cart]);
                    }
                }
                if($args['type'] === 'hyper') {
                    foreach ($args['products'] as $product) {
                        get_template_part('templates/product', 'hyper-box', ['product' => $product, 'cart' => $cart]);
                    }
                }
            ?>
        </div>
        <?php } else {
                ?>
                <div class="nothing-found">
                    <h3>No product found</h3>
                </div>
                <?php
            } ?>
    </div>
</div>
</div>