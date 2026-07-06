<template id="customer-edit-delivery-schedule">
    <div>
        <h2 class="heading">Edit Delivery Schedule</h2>

        <div class="content-body text-center">
            <p>Please click on the Calendar below to edit your Delivery Schedule</p>

            <div class="pt-2">
                <div style="max-width: 450px" class="m-auto text-left">
                    <div style="max-width: 310px" class="m-auto text-left">
                        <p class="fs-14">You will receive your delivery.</p>
                        <p class="fs-14">You will not receive your delivery.</p>

                        <div class="pt-2">
                            <div class="inline-datepicker-wrap">
                                <input type="hidden" name="selectedDates">
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
            <button type="button" id="btn-next" onclick="edit_schedule_success()" class="button btn-primary">Confirm Edits to Schedule</button>
        </div>
    </div>
</template>