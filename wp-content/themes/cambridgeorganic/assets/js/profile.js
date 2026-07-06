window.report_delivery_popup = function() {
    Swal.fire({
        customClass: {
            popup: 'customer-report-delivery'
        },
        showCloseButton: true,
        showConfirmButton: false,
        html: document.querySelector('#report-delivery-form-template').innerHTML,
        didOpen: ()=>{
            form_validate_init();
        }
    });
}

window.report_delivery_item_popup = function() {
    Swal.fire({
        customClass: {
            popup: 'customer-report-item-delivery'
        },
        showCloseButton: true,
        showConfirmButton: false,
        html: document.querySelector('#report-delivery-item-form-template').innerHTML,
        didOpen: ()=>{
            form_validate_init();
        }
    });
}

window.report_delivery_reported = function() {
    Swal.fire({
        customClass: {
            popup: 'customer-item-reported'
        },
        showCloseButton: true,
        showConfirmButton: false,
        html: document.querySelector('#report-delivery-success-template').innerHTML,
        didOpen: ()=>{
            form_validate_init();
        }
    });
}

window.report_view_delivery_item_popup = function() {
    Swal.fire({
        customClass: {
            popup: 'customer-item-report-view'
        },
        showCloseButton: true,
        showConfirmButton: false,
        html: document.querySelector('#report-delivery-view-template').innerHTML,
        didOpen: ()=>{
            form_validate_init();
        }
    });
}

window.edit_delivery_schedule = ()=>{
    Swal.fire({
        customClass: {
            popup: 'customer-edit-delivery-schedule'
        },
        showCloseButton: true,
        showConfirmButton: false,
        html: document.querySelector('#customer-edit-delivery-schedule').innerHTML,
        didOpen: ()=>{
            init_inline_datepicker();
        }
    });
}

window.edit_schedule_success = ()=>{
    Swal.fire({
        customClass: {
            popup: 'user-edit-schedule-success'
        },
        showCloseButton: true,
        showConfirmButton: false,
        html: document.querySelector('#user-edit-schedule-success').innerHTML,
        didOpen: ()=>{
            init_inline_datepicker();
        }
    });
}

window.cancel_schedule_form = ()=>{
    Swal.fire({
        customClass: {
            popup: 'user-cancel-membership'
        },
        showCloseButton: true,
        showConfirmButton: false,
        html: document.querySelector('#user-cancel-membership-popup').innerHTML,
        didOpen: ()=>{

        }
    });
}

window.confirm_member_cancellation_success = ()=>{
    Swal.fire({
        customClass: {
            popup: 'user-cancel-membership-success'
        },
        showCloseButton: true,
        showConfirmButton: false,
        html: document.querySelector('#user-cancel-membership-success').innerHTML,
        didOpen: ()=>{

        }
    });
}

window.confirm_member_cancellation = ()=>{
    if(document.querySelector('#cancel-membership') && document.querySelector('#cancel-membership').checked) {
        switch_js_form('user-cancel-membership-form', 1);
        document.querySelector('#cancel-membership').checked = false;
    }else {
        swal.close();
        confirm_member_cancellation_success();
    }
}