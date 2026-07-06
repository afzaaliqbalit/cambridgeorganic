<template id="report-delivery-item-form-template">
    <div>
        <h2 class="heading">Report a Problem</h2>

        <div class="content-body text-center">
            <p>We are sorry that you have encountered a problem with the following item:</p>
            <h4 class="fs-20">Parsnips 100g</h4>

            <div style="max-width: 450px;" class="m-auto pt-2">
                <div class="mt-2 pb-4">
                    <p class="fs-14">Please make a selection from the following list that best describes your complaint:</p>
                    <select>
                        <option>This item was missing</option>
                    </select>
                </div>
                <div class="mt-2">
                    <p class="fs-14">Please can you clarify the quantity affected?</p>
                    <select>
                        <option>0</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <div class="mt-2 pt-4 pb-4">
                    <p class="fs-14">You can also use the comments box below to describe your complaint:</p>
                    <textarea rows="6" placeholder="Please use this box to explain in detail the problem that you have encountered..."></textarea>
                </div>

                <div class="mt-2 pt-1 pb-5">
                    <p class="fs-14">Please make a selection from the following list that outlines your preferred remedy:</p>
                    <select>
                        <option>Replace next week</option>
                    </select>
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