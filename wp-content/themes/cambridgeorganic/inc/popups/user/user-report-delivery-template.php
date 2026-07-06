<template id="report-delivery-form-template">
    <div>
        <h2 class="heading">Report a Problem (Whole Delivery)</h2>

        <div class="content-body text-center">
            <p>We are sorry that you have encountered a problem with :</p>
            <h4 class="fs-20">Delivery DD/MM/YYYY</h4>

            <div style="max-width: 450px;" class="m-auto pt-2">
                <div class="mt-2">
                    <p class="fs-14">Please make a selection from the following list that best describes your complaint:</p>
                    <select>
                        <option>I didn’t receive this Delivery</option>
                    </select>
                </div>
                <div class="mt-2 pt-4 pb-5">
                    <p class="fs-14">You can also use the comments box below to describe your complaint:</p>

                    <textarea rows="6" placeholder="Please use this box to explain in detail the problem that you have encountered..."></textarea>
                </div>
            </div>
        </div>

        <!-- Action options -->
        <div class="d-flex gap-3 justify-content-center action-buttons">
            <button type="button" id="btn-back" class="button btn-secondary">Back</button>
            <button type="button" id="btn-next" onclick="report_delivery_reported()" class="button btn-primary">Confirm & Submit</button>
        </div>
    </div>
</template>