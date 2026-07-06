<?php get_header( 'shop' ); ?>

    <div id="customer-profile" class="container page-wrap">
        <?php echo get_template_part('customer/inc/header') ?>

        <div id="profile-schedule" class="body-content">

            <div class="head-text">
                <h4>Your Delivery Schedule</h4>
                <p>View the calendar below to see your next and future scheduled deliveries.</p>
            </div>

            <div class="owl-carousel schedule-scroller camb-woo-products-slider">
                <div class="item">
                    <div class="inline-datepicker-wrap">
                        <input type="hidden" name="selectedDates" onchange="edit_delivery_schedule()">
                    </div>
                </div>

                <div class="item">
                    <div class="inline-datepicker-wrap">
                        <input type="hidden" name="selectedDates" onchange="edit_delivery_schedule()">
                    </div>
                </div>

                <div class="item">
                    <div class="inline-datepicker-wrap">
                        <input type="hidden" name="selectedDates" onchange="edit_delivery_schedule()">
                    </div>
                </div>

                <div class="item">
                    <div class="inline-datepicker-wrap">
                        <input type="hidden" name="selectedDates" onchange="edit_delivery_schedule()">
                    </div>
                </div>

                <div class="item">
                    <div class="inline-datepicker-wrap">
                        <input type="hidden" name="selectedDates" onchange="edit_delivery_schedule()">
                    </div>
                </div>

                <div class="item">
                    <div class="inline-datepicker-wrap">
                        <input type="hidden" name="selectedDates" onchange="edit_delivery_schedule()">
                    </div>
                </div>
            </div>

            <div class="pt-3">
                <div class="d-flex justify-content-end">
                    <div class="d-flex gap-3">
                        <button class="button btn-secondary button-icon"><i class="icon-truck"></i> Take / Edit a Break</button>
                        <button class="button btn-secondary button-icon" onclick="cancel_schedule_form()"><i class="icon-cog"></i> Cancel Membership</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer( 'shop' ); ?>