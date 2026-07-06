<div id="signup-steps-form-container">
<?php
$datas = !empty($args['success']) ? $args['data'] : array();
    if(empty($datas)) {
        get_template_part('inc/popups/remote/guest-postcode-delivery-notfound', null, $args ?? []);
    }
    else {
        $delivery_routes = [];
        $next_delivery_day = false;
        $next_delivery_date = null;
        $next_delivery_day_num = null;
        $next_delivery_month = null;

        $curr_day = date('N'); // 1 (Mon) - 7 (Sun)
        $weekDays = weekDays();

        $today = new DateTime();
        $minDiff = 8;

        foreach ($datas as $data) {
            $delivery_days = array_map('trim', explode(',', $data['RouteDay']));

            foreach ($delivery_days as $day) {
                $dayIndex = array_search($day, $weekDays, true);

                if ($dayIndex === false) {
                    continue;
                }

                $dayNumber = $dayIndex + 1;
                $diff = ($dayNumber - $curr_day + 7) % 7;

                if ($diff < $minDiff) {
                    $minDiff = $diff;
                    $next_delivery_day = $day;
                    $delivery_routes = $data;

                    // Calculate actual next delivery date
                    $nextDate = clone $today;
                    if ($diff > 0) {
                        $nextDate->modify("+{$diff} days");
                    }

                    $next_delivery_date = $nextDate->format('Y-m-d');
                    $next_delivery_day_num = $nextDate->format('d'); // e.g. 07
                    $next_delivery_month = $nextDate->format('m');   // e.g. July
                }
            }
        }
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
                    <button type="button" id="btn-cancel" class="button btn-secondary">Cancel</button>
                    <a href="<?php echo site_url('fruit-veg-boxes') ?>" role="button" class="button btn-primary">Choose your Veg Box</a>
                </div>
            </div>
        </div>

        <div id="signup-organic-step-2" class="step-wrapper">
            <div class="text-center">
                <h2 class="text-heading-2">Select your Delivery Options</h2>

                <span class="d-block text-uppercase text-brand-muted fw-bold tracking-wider mb-2" style="font-size: 0.7rem;">How often would you like a Delivery?</span>

                <!-- Tab Buttons style built entirely on Bootstrap components -->
                <div class="row g-2 mx-auto mb-4" style="max-width: 380px;">
                    <div class="col-6">
                        <div class="text-checkbox">
                            <input type="radio" name="delivery_schedule" value="weekly">
                            <span>Every Week</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-checkbox">
                            <input type="radio" name="delivery_schedule" value="fortnightly">
                            <span>Every 2 Weeks</span>
                        </div>
                    </div>
                </div>

                <p class="small text-brand-muted fw-semibold mb-1 px-1">
                    Your first available delivery is <strong class="text-brand-dark text-decoration-underline target-first-monday-placeholder">Monday 23rd January</strong>.
                </p>
                <p class="small text-brand-muted mb-4">
                    You can edit this by using the calendar below:
                </p>

                <!-- Bootstrap UI Calendar Component - Re-styled Card & Table Layout -->
                <div class="card mx-auto mb-4">
                    <div class="inline-datepicker-wrap">
                        <input type="hidden" name="selectedDates">
                    </div>
                </div>

                <p class="small text-brand-muted fw-semibold mb-4 px-1">
                    Your first chosen delivery date is <strong class="text-brand-dark text-decoration-underline selected-monday-display">Monday 23rd January</strong>.
                </p>

                <hr class="my-4" style="opacity: 0.1;">

                <!-- Action options -->
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" data-action="prev" class="button btn-secondary">Back</button>
                    <button type="button" data-action="next" class="button btn-primary">Confirm Selection</button>
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