<?php
/**
    Template Name: Product page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );
?>

    <div class="container page-wrap">
        <div class="single-product-wrap">
            <div class="row">
                <div class="col-5 product-image">
                    <img src="<?php echo thumbnail($args['image']) ?>">
                </div>
                <div class="col-7 product-info">
                    <!-- TITLE -->
                    <div class="product-title">
                        <h2 class="mb-0 fw-bold"><?php echo $args['name'] ?></h2>
                        <?php if(!empty($args['weight'])) { ?>
                        <span class="text-muted"><?php echo $args['weight'] ?> <?php echo $args['per_unit'] ?></span>
                        <?php } ?>
                    </div>

                    <!-- TAGS -->
                    <?php /*<div>
                        <div class="tag-wrap">
                            <span><i class="icon-info"></i>Organic</span>
                            <span><i class="icon-eu"></i></span>
                            <span>Andalucia, Spain</span>
                        </div>
                    </div>*/ ?>

                    <!-- PRICE + CONTROLS -->
                    <div>
                        <div class="price-info">

                            <h3 class="product-price"><?php echo price($args['selling_price']) ?></h3>

                            <div class="sub-freq selection">
                                <label class="me-2">How often?</label>
                                <select class="form-select select" style=" min-width: 210px;">
                                    <option>Add Once</option>
                                    <option>Weekly</option>
                                </select>
                            </div>

                            <!-- QUANTITY -->

                            <?php echo get_template_part('templates/stepper-input', null, ['name' => 'quantity']); ?>

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
