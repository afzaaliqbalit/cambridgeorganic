<template id="user-edit-schedule-success">
    <div>
        <h2 class="heading">Thank you for confirming</h2>

        <div class="content-body text-center">
            <div style="max-width: 450px;" class="m-auto pt-2">
                <p>We can confirm that you will not receive your future
                    Deliveries on the following dates:</p>
                <p>Monday 9/01/XXXX</p>
                <p>Monday 16/01/XXXX</p>

                <div class="pt-5">
                    <p class="dim">By clicking Continue, these changes will be saved and you will receive a confirmation email.</p>
                </div>
            </div>
        </div>

        <!-- Action options -->
        <div class="d-flex gap-3 justify-content-center action-buttons pt-4">
            <button type="button" id="btn-next" class="button btn-primary" onclick="swal.close()">Continue</button>
        </div>
    </div>
</template>