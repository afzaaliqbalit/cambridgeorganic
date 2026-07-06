<template id="report-delivery-view-template">
    <div>
        <h2 class="heading">View Report</h2>

        <div class="content-body text-center">
            <p>Regarding the acknowledged complaint for the following item:</p>
            <h4 class="fs-20">Potatoes (Red Cara) 100g</h4>

            <div style="max-width: 450px;" class="m-auto pt-2">
                   <div class="mt-2">
                       <p class="fs-14">Description of your complaint:</p>
                       <div class="input-text-box m-auto">I didn’t receive this Delivery</div>
                   </div>
                   <div class="mt-2 pt-4 pb-3">
                       <p class="fs-14">Quantity affected:</p>
                       <div class="input-text-box m-auto">10</div>
                   </div>
                   <div class="mt-2 pt-4 pb-5">
                       <p class="fs-14">Further details of your complaint:</p>
                       <div class="input-text-box m-auto">This is the second time I’ve missed out on potatoes!</div>
                   </div>
            </div>
        </div>

        <!-- Action options -->
        <div class="d-flex gap-3 justify-content-center action-buttons">
            <button type="button" id="btn-back" class="button btn-secondary" onclick="swal.close()">Back</button>
            <button type="button" id="btn-next" onclick="report_delivery_reported()" class="button btn-primary">Confirm & Submit</button>
        </div>
    </div>
</template>