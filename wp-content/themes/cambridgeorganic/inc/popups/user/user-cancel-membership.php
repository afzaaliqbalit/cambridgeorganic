<template id="user-cancel-membership-popup">
    <div>
        <div id="user-cancel-membership-form" class="switch-js-form">
            <div class="active">
                <h2 class="heading">Cancel Membership / Stop Deliveries</h2>
                <div class="content-body text-center">
                    <p>Please select from the following options:</p>
                    <div class="pt-2">
                        <div style="max-width: 450px" class="m-auto text-left">
                            <div class="d-flex flex-column gap-3 pt-3">
                                <?php /*<div class="d-flex gap-3">
                                    <div class="text-checkbox" style="min-width: max-content;">
                                        <input type="checkbox" value="">
                                        <span class="fs-14" style="min-width: 180px">Pause</span>
                                    </div>
                                    <div>
                                        <p class="fs-14">Do you just want to take a break from your next scheduled deliveries? If so, then click Pause.</p>
                                    </div>
                                </div>*/ ?>

                                <div class="d-flex gap-3">
                                    <div class="text-checkbox" style="min-width: max-content;">
                                        <input type="checkbox" id="cancel-membership" value="">
                                        <span class="fs-14">Cancel Membership</span>
                                    </div>
                                    <div>
                                        <p class="fs-14">Do you wish to stop and cancel your membership and all of your future scheduled deliveries? If so, then click Cancel Membership</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action options -->
                <div class="d-flex gap-3 justify-content-center action-buttons pt-5">
                    <button type="button" id="btn-back" class="button btn-secondary" onclick="swal.close()">Back</button>
                    <button type="button" id="btn-next" onclick="confirm_member_cancellation()" class="button btn-primary">Confirm Selection</button>
                </div>
            </div>

            <div>
                <h2 class="heading">No More Deliveries?</h2>

                <div class="content-body text-center">
                    <h2 class="heading">Cancel Membership / Stop Deliveries</h2>
                    <div class="content-body text-center">
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <div class="text-checkbox" style="min-width: max-content;">
                                <input type="checkbox" value="">
                                <span class="fs-14" style="min-width: 180px">Yes</span>
                            </div>

                            <div class="text-checkbox" style="min-width: max-content;">
                                <input type="checkbox" value="">
                                <span class="fs-14" style="min-width: 180px">No</span>
                            </div>

                            <div class="text-checkbox" style="min-width: max-content;">
                                <input type="checkbox" value="">
                                <span class="fs-14" style="min-width: 180px">Perhaps</span>
                            </div>
                        </div>

                        <p class="fw-bold">We are sorry that you want to leave our Veg Box Delivery Scheme.</p>
                        <p>Please can you tell us why you are leaving (you can select more than one option):</p>

                        <div class="container my-4" style="max-width: 800px;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="text-checkbox w-100" style="min-width: max-content;">
                                        <input type="checkbox" value="">
                                        <span class="fs-14 w-100" style="min-width: 180px">I no longer want to recieve Veg Boxes</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-checkbox w-100" style="min-width: max-content;">
                                        <input type="checkbox" value="">
                                        <span class="fs-14 w-100" style="min-width: 180px">I am not happy with the quality of Produce</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-checkbox w-100" style="min-width: max-content;">
                                        <input type="checkbox" value="">
                                        <span class="fs-14 w-100" style="min-width: 180px">I am not happy with the quality of Service</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-checkbox w-100" style="min-width: max-content;">
                                        <input type="checkbox" value="">
                                        <span class="fs-14 w-100" style="min-width: 180px">I find the prices too expensive</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-checkbox w-100" style="min-width: max-content;">
                                        <input type="checkbox" value="">
                                        <span class="fs-14 w-100" style="min-width: 180px">I have decied to proceed with a competitor</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-checkbox w-100" style="min-width: max-content;">
                                        <input type="checkbox" value="">
                                        <span class="fs-14 w-100" style="min-width: 180px">I never managed to eat all of the Produce</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-4 mx-auto" style="max-width: 600px;">
                            <textarea class="form-control p-3" rows="4" placeholder="Please use this box to elaberate further, if you wish to, as to why you have decided to leave the Veg Box Delivery Scheme..."></textarea>
                        </div>

                        <div class="my-4 mx-auto" style="max-width: 600px;">
                            <p class="fs-14 fw-bold mb-3">
                                Payment for your last delivery is taken 5 to 7 days after delivery, therefore please do not cancel your direct debit until this payment has cleared. Tick here to confirm you have understood.
                            </p>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <input type="checkbox" id="understand-chk" style="width: 20px; height: 20px;">
                                <label for="understand-chk" class="fs-14 m-0 cursor-pointer">I understand</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action options -->
                <div class="d-flex gap-3 justify-content-center action-buttons pt-5">
                    <button type="button" id="btn-back" class="button btn-secondary" onclick="swal.close()">Back</button>
                    <button type="button" id="btn-next" onclick="confirm_member_cancellation_success()" class="button btn-primary">Confirm Selection</button>
                </div>
            </div>

        </div>
    </div>
</template>

<template id="user-cancel-membership-success">
    <h2 class="heading">Thank you for confirming</h2>

    <div>
        <p>We can confirm that you have cancelled your Veg Box Delivery subscription and will not recieve any future deliveries from us.</p>
        <p>If you do wish to return to the Veg Box Delivery Scheme, then simply re-log into your account, add any desired items to your cart, then checkout.</p>
    </div>

    <!-- Action options -->
    <div class="d-flex gap-3 justify-content-center action-buttons pt-5">
        <button type="button" id="btn-back" class="button btn-primary" onclick="swal.close()">Continue</button>
    </div>
</template>