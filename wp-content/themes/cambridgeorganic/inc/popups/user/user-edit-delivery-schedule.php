<template id="customer-edit-delivery-schedule">
    <div>
        <?php
        $cart = new Cart();
        $getCart = $cart->getCart();
        if(!empty($getCart['next_delivery_date'])) {
        $weekday = date('N',strtotime($getCart['next_delivery_date']));
        $deliveryDate = date('Y-m-d',strtotime($getCart['next_delivery_date']));
        $frequencies = getDeliveryFrequencies();

        $delivery_frequency = !empty($getCart['delivery_frequency']) ? $getCart['delivery_frequency'] : $frequencies[0];
        ?>
            <form method="post" action="#">
        <h2 class="heading">Edit Delivery Schedule</h2>

        <div class="content-body text-center">
            <p>How often would you like a Delivery?</p>


                <div class="pt-2">
                    <div style="max-width: 450px" class="m-auto text-left">
                        <?php
                        if(!empty($frequencies)) {
                            ?>
                            <div class="d-flex gap-3 pb-4">
                                <?php foreach($frequencies as $frequency) {
                                    $checked = $frequency == $delivery_frequency ? 'checked' : '';
                                    ?>
                                    <div class="text-checkbox">
                                        <input type="radio" name="delivery_frequency" <?=$checked?> value="<?php echo $frequency ?>" onchange="change_delivery_frequency(this.value)">
                                        <span><?php echo $frequency ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="m-auto text-center">
                            <p class="fs-14">You can edit this by using the calendar below:</p>
                        </div>

                        <div style="max-width: 310px" class="m-auto text-left">

                            <div class="pt-2">
                                <div class="inline-datepicker-wrap">
                                    <input id="delivery_frequency_calender" type="hidden" name="selectedDates" data-weekdays="<?php echo $weekday ?>" data-from="today" data-selected="<?php echo $deliveryDate ?>" onchange="">
                                </div>
                            </div>
                        </div>

                        <div class="pt-5 text-center">
                            <p class="dim fs-14">You can change this at any time up to 48 hours before a Delivery</p>
                        </div>

                    </div>
                </div>

        </div>

        <!-- Action options -->
        <div class="d-flex gap-3 justify-content-center action-buttons pt-5">
            <button type="button" id="btn-back" class="button btn-secondary">Back</button>
            <input type="hidden" name="action" value="edit_delivery_schedule">
            <button type="submit" id="btn-next" class="button btn-primary">Confirm Edits to Schedule</button>
        </div>
            </form>

        <?php } else {
            ?>
            <h4>Unable to change delivery date</h4>
            <?php
        } ?>
    </div>
</template>