<template id="report-delivery-success-template">
    <div>
        <h2 class="heading">Thank you</h2>

        <div class="content-body text-center">
            <div style="max-width: 450px;" class="m-auto pt-2">
            <p>We have received your Report & Comment.</p>
            <p>A Team Member will be in contact as soon as possible to reply to you and will work to resolve your problem.</p>
            <p>Please accept our apology for this undesired situation.</p>
            </div>
        </div>

        <!-- Action options -->
        <div class="d-flex gap-3 justify-content-center action-buttons pt-4">
            <button type="button" id="btn-next" class="button btn-primary" onclick="swal.close()">Confirm</button>
        </div>
    </div>
</template>