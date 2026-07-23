<div id="signup-steps-form-container">
<?php
$datas = !empty($args['success']) ? $args['data'] : array();
$data = $datas[0];
$routeID = !empty($data['id']) ? $data['id'] : 0;

    if(empty($datas) || empty($routeID)) {
        get_template_part('inc/popups/remote/guest-postcode-delivery-notfound', null, $args ?? []);
    }
    else {
        $cart = new Cart();
        $routeInfo = $cart->getRouteInfo($data);

        $delivery_routes = array();
        $next_delivery_day = $routeInfo['next_delivery_day'];
        $next_delivery_date = $routeInfo['next_delivery_date'];
        $next_delivery_day_num = $routeInfo['next_delivery_day_num'];
        $next_delivery_month = $routeInfo['next_delivery_month'];

//            if ($diff < $minDiff) {
//                $minDiff = $diff;
//                $next_delivery_day = $day;
//
//                // Calculate actual next delivery date
//                $nextDate = clone $today;
//                if ($diff > 0) {
//                    $nextDate->modify("+{$diff} days");
//                }
//
//                $next_delivery_date = $nextDate->format('Y-m-d');
//                $next_delivery_day_num = $nextDate->format('d');
//                $next_delivery_month = $nextDate->format('m');
//            }

//            foreach ($delivery_days as $day) {
//                $dayIndex = array_search($day, $weekDays, true);
//
//                if ($dayIndex === false) {
//                    continue;
//                }
//
//                $dayNumber = $dayIndex + 1;
//                $diff = ($dayNumber - $curr_day + 7) % 7;
//                $diff = $diff + 7;
//
//                if ($diff < $minDiff) {
//                    $minDiff = $diff;
//                    $next_delivery_day = $day;
//
//                    // Calculate actual next delivery date
//                    $nextDate = clone $today;
//                    if ($diff > 0) {
//                        $nextDate->modify("+{$diff} days");
//                    }
//
//                    $next_delivery_date = $nextDate->format('Y-m-d');
//                    $next_delivery_day_num = $nextDate->format('d');
//                    $next_delivery_month = $nextDate->format('m');
//                }
//            }
        //}
?>
        <div id="processing-signup-form" class="processing"></div>
<form id="signup-steps-form" action="" method="post">
    <div class="switch-js-form">
        <div id="signup-organic-step-1" class="step-wrapper active">
            <div class="text-center">
                <!-- Delivery Truck Graphic illustration as SVG -->
                <div class="mx-auto mb-2" style="max-width: 230px;">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-van.png">
                </div>

                <!-- Monday Heading text -->
                <h2 class="text-heading"><?php echo $next_delivery_day ?></h2>

                <p class="small text-brand-muted fw-semibold lh-base px-2">
                    The next time we can deliver to you is on <strong class="text-brand-dark next-delivery-placeholder"><?php echo $next_delivery_day_num ?> / <?php echo $next_delivery_month ?></strong>.
                </p>

                <?php /*<div class="small text-brand-muted fw-semibold lh-base px-2">
                    <div class="form-group">
                        <label>We have the following routes available for your delivery:</label>
                        <select id="delivery_route" name="delivery_route" required data-error="Please select a delivery route.">
                            <option value="" selected="selected">Select a route</option>
                            <?php foreach ($datas as $route) {
                                ?>
                            <option value="<?php echo $route['id'] ?>"><?php echo $route['RouteName'] ?></option>
                                <?php
                            } ?>
                        </select>
                    </div>
                </div>*/ ?>

                <hr class="my-4" style="opacity: 0.1;">

                <!-- Organic "How it works" information block -->
                <div class="info-panel-organic text-start shadow-sm mb-4">
                    <h3 class="h6 text-center border-bottom border-white border-opacity-25 pb-2 mb-3 mt-0">How it works:</h3>

                    <div class="row g-2 align-items-baseline" style="font-size: 0.82rem; line-height: 1.4;">
                        <div class="col-3 fw-medium text-light opacity-75">Step 1</div>
                        <div class="col-9 fw-medium">Choose your Fruit / Veg Box</div>

                        <div class="col-3 fw-medium text-light opacity-75">Step 2</div>
                        <div class="col-9 fw-medium">Customise your Fruit / Veg Box</div>

                        <div class="col-3 fw-medium text-light opacity-75">Step 3</div>
                        <div class="col-9 fw-medium">Create Account & Confirm</div>

                        <div class="col-3 fw-medium text-light opacity-75">Step 4</div>
                        <div class="col-9 fw-medium">Add on extras or sit back while we deliver!</div>
                    </div>
                </div>

                <hr class="my-4" style="opacity: 0.1;">

                <!-- Action options -->
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" data-action="cancel" class="button btn-secondary">Cancel</button>
                    <button type="button" data-action="next" class="button btn-primary">Choose your Veg Box</button>
                </div>
            </div>
        </div>

        <div id="signup-organic-step-3" class="step-wrapper">
            <div class="text-center py-2">
                <h2 class="text-heading-2">Build Your First Order</h2>

                <div class="d-flex flex-column gap-3 text-brand-muted fw-semibold small mx-auto mb-5" style="max-width: 380px;">
                    <p class="m-0">
                        Your next Delivery Date is too soon to process your first Order.
                    </p>
                    <p class="m-0">
                        You can build your first Order from <strong class="text-brand-dark text-decoration-underline build-start-placeholder">XX/XX/XXXX</strong> for the Delivery on Monday <strong class="text-brand-dark text-decoration-underline delivery-date-placeholder">XX/XX/XXXX</strong>.
                    </p>
                    <p class="m-0 text-brand-muted opacity-75" style="font-weight: 400; font-size: 0.82rem;">
                        Once your Account is activated, you will receive an email instructing you how to proceed.
                    </p>
                </div>

                <hr class="my-4" style="opacity: 0.1;">

                <!-- Action options -->
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" data-action="prev" class="button btn-secondary">Back</button>
                    <button type="button" data-action="next" class="button btn-primary">Proceed to activate Account</button>
                </div>
            </div>
        </div>
    </div>
</form>
    <?php } ?>
</div>

