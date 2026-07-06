<template id="guest-signup-popup-form"></template>

<style>
    #signup-steps-form-container:not(.init) #signup-steps-form {
        display: none;
    }
    #signup-steps-form-container.init #processing-signup-form {
        display: none;
    }
</style>

<script>
    const myFormConfig = {
        containerSelector: '#signup-steps-form-container',
        totalProgressDots: 3, // Custom length of the progress dot track
        initialData: {},
        initialStepIndex: 0,
        containerClass: 'guest-deliverydate-lookup',
        onCancel: () => console.log('User cancelled/exited!'),
        onComplete: (data) => console.log('Form complete! Submission data:', data),
        onStateChange: (state) => console.log('State updated:', state),
        steps: [
            // STEP 1: MONDAY DELIVERY DETAIL
            {
                id: 'monday_info',
                templateId: 'signup-organic-step-1',
                validate: () => true,
                populate: (clone, data, engine) => {
                    // Add hydration logic here if needed
                },
                bindEvents: (clone, data, engine) => {
                    // Use querySelector instead of getElementById for broad DocumentFragment support
                    const btnCancel = clone.querySelector('#btn-cancel');
                    const btnNext = clone.querySelector('#btn-next');

                    if (btnCancel) {
                        btnCancel.addEventListener('click', () => swal.close());
                    }
                    if (btnNext) {
                        btnNext.addEventListener('click', () => engine.next());
                    }
                }
            },

            // STEP 2: SELECT OPTIONS & CALENDAR
            {
                id: 'delivery_options',
                templateId: 'signup-organic-step-2',
                validate: (data) => true,
                populate: (clone, data, engine) => {
                    // Add calendar generation/population logic here
                },
                bindEvents: (clone, data, engine) => {
                    const btnCancel = clone.querySelector('#btn-cancel');
                    const btnNext = clone.querySelector('#btn-next');
                    const btnBack = clone.querySelector('#btn-back');

                    if (btnCancel) {
                        btnCancel.addEventListener('click', () => swal.close());
                    }
                    if (btnBack) {
                        btnBack.addEventListener('click', () => engine.prev());
                    }
                    if (btnNext) {
                        btnNext.addEventListener('click', () => engine.next());
                    }

                    setTimeout(()=>{
                        init_inline_datepicker();
                    },500);
                }
            },

            // STEP 3: BUILD YOUR FIRST ORDER
            {
                id: 'build_order',
                templateId: 'signup-organic-step-3',
                validate: () => true,
                populate: (clone, data, engine) => {
                    // Add final confirmation summaries here
                },
                bindEvents: (clone, data, engine) => {
                    const btnBack = clone.querySelector('#btn-back');
                    const btnNext = clone.querySelector('#btn-next');

                    if (btnBack) {
                        btnBack.addEventListener('click', () => engine.prev());
                    }
                    if (btnNext) {
                        btnNext.addEventListener('click', () => engine.next());
                    }
                }
            }
        ]
    };

    window.user_login_modal = function() {
        Swal.fire({
            customClass: {
                popup: 'user-login'
            },
            showCloseButton: true,
            showConfirmButton: false,
            html: document.querySelector('#user-login-popup-modal').innerHTML,
            didOpen: ()=>{
                form_validate_init();
            }
        });
    }

    window.guest_postcode_delivery_modal = (postcode_value='', signup_step=0)=>{

        if(postcode_value.length===0) {
            const guestPostcode = document.querySelector('#guest-signup-postcode');
            if(!validate_input_field(guestPostcode)) {
                return false;
            }
            postcode_value = guestPostcode.value;
            const wrapper = guestPostcode.closest('.panel-wrapper');
            wrapper.classList.add('loading');
        }

        const selectedProduct = null;

        let check_postcode = get_remote_request('get_postcode_routes', {
            postcode: postcode_value,
            selectedProduct: selectedProduct
        });

        check_postcode.then(function(data) {
            const modal_element = document.querySelector('#guest-signup-popup-form');
            if(!modal_element) {
                wrapper.classList.remove('loading');
                return;
            }

            modal_element.innerHTML = data.html;

            const modal_html = modal_element.innerHTML;

            Swal.fire({
                customClass: {
                    popup: 'postcode-delivery-lookup'
                },
                width: 540,
                showCloseButton: true,
                showConfirmButton: false,
                html: modal_html,
                willOpen: ()=>{
                    try {
                       if(data.success) {
                           SessionStorage.set('user_signup_form', {
                               postcode: postcode_value
                           });
                           if(signup_step) {
                               myFormConfig.initialStepIndex = signup_step;
                           }else {
                               myFormConfig.initialStepIndex = 0;
                           }
                           setTimeout(()=>{
                               const engine = new StepFormEngine(myFormConfig);
                           },500);
                       }
                    } catch (error) {

                    }
                }
            });
        });
    }

    window.init_signup_box_selection = ()=>{
        const signup_session = SessionStorage.get('user_signup_form');
        if(SessionStorage.get('user_signup_form') && signup_session && document.querySelector('.product-hyper-box')) {
            const postcode_value = signup_session.postcode;

            document.querySelectorAll('.product-box-wrapper').forEach((box)=>{
                const footer = box.querySelector('.box-footer');
                const pid = box.dataset.pid;
                footer.querySelector('.btn').removeAttribute('data-tooltip');
                footer.querySelector('.btn').addEventListener('click', ()=>{
                    guest_postcode_delivery_modal(postcode_value,1);
                });
            });
        }
    }
</script>