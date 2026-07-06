<?php
/**
    Template Name: Search page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

$term = get_search_query();
?>

    <div class="container page-wrap">
        <?php
            if(!empty($term)) {
        ?>
        <h1>Search Results for <?php echo get_search_query() ?></h1>
        <?php
            $results = $products->searchProduct($term);
            if(!empty($results)) {
                ?>
                <div class="catalog-boxes">
                    <?php
                    foreach($results as $product) {
                        get_template_part('templates/product', 'selection-box',[ 'product' => $product ]);
                    }
                    ?>
                </div>
                <?php
            }else {
                ?>
                <div>
                    <h3>No results found</h3>
                </div>
                <?php
            }
        ?>
        <?php } else {?>
                <div>
                    <h3>Please enter a search term</h3>
                </div>
                <?php } ?>
    </div>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
