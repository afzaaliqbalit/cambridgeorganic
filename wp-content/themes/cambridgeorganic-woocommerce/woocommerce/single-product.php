<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<div class="single-product-wrap">
				<div class="row">
					<div class="col-5 product-image">
                        <img src="http://localhost:8080/signum/cambridgeorganic/wp-content/uploads/2025/10/Hodmedods.png">
                    </div>
					<div class="col-7 product-info">
                            <!-- TITLE -->
                            <div class="product-title">
                                <h2 class="mb-0 fw-bold">Grapefruit (2x)</h2>
                                <span class="text-muted">150g</span>
                            </div>

                            <!-- TAGS -->
                            <div>
                                <div class="tag-wrap">
                                    <span><i class="icon-info"></i>Organic</span>
                                    <span><i class="icon-spain"></i></span>
                                    <span>Andalucia, Spain</span>
                                </div>
                            </div>

                            <!-- PRICE + CONTROLS -->
                            <div>
                                <div class="price-info">

                                    <h3 class="product-price">£1.25</h3>

                                    <div class="sub-freq selection">
                                        <label class="me-2">How often?</label>
                                        <select class="form-select">
                                            <option>Add Once</option>
                                            <option>Weekly</option>
                                        </select>
                                    </div>

                                    <!-- QUANTITY -->
                                    <div class="d-flex align-items-center qty-box">
                                        <button class="btn btn-dark btn-sm">−</button>
                                        <span class="px-3">3</span>
                                        <button class="btn btn-success btn-sm">+</button>
                                    </div>

                                </div>
                            </div>

                            <!-- ACCORDION -->
                            <div>
                                <div class="accordion" id="productAccordion">
                                    <!-- Description -->
                                    <div class="accordion-container">
                                        <div class="ac">
                                            <h2 class="ac-header">
                                                <button type="button" class="ac-trigger">Lorem ipsum dolor sit amet.</button>
                                            </h2>
                                            <div class="ac-panel">
                                                <p class="ac-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                            </div>
                                        </div>

                                        <div class="ac">
                                            <h2 class="ac-header">
                                                <button type="button" class="ac-trigger">Lorem ipsum dolor sit amet.</button>
                                            </h2>
                                            <div class="ac-panel">
                                                <p class="ac-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                            </div>
                                        </div>

                                        <div class="ac">
                                            <h2 class="ac-header">
                                                <button type="button" class="ac-trigger">Lorem ipsum dolor sit amet.</button>
                                            </h2>
                                            <div class="ac-panel">
                                                <p class="ac-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
				</div>
			</div>
		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
