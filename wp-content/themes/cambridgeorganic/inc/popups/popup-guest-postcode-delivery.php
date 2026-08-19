<template id="guest-signup-popup-form"></template>
<template id="signup-organic-delivery-options">
    <div id="signup-organic-step-2" class="step-wrapper">
        <div class="text-center">
            <h2 class="text-heading-2">Select your Delivery Options</h2>

            <span class="d-block text-uppercase text-brand-muted fw-bold tracking-wider mb-2" style="font-size: 0.7rem;">How often would you like a Delivery?</span>

            <!-- Tab Buttons style built entirely on Bootstrap components -->
            <div class="row g-2 mx-auto mb-4" style="max-width: 380px;">
                <div class="col-6">
                    <div class="text-checkbox">
                        <input type="radio" name="delivery_schedule" value="weekly">
                        <span>Every Week</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-checkbox">
                        <input type="radio" name="delivery_schedule" value="fortnightly">
                        <span>Every 2 Weeks</span>
                    </div>
                </div>
            </div>

<!--            <p class="small text-brand-muted fw-semibold mb-1 px-1">-->
<!--                Your first available delivery is <strong class="text-brand-dark text-decoration-underline target-first-monday-placeholder">Monday 23rd January</strong>.-->
<!--            </p>-->
<!--            <p class="small text-brand-muted mb-4">-->
<!--                You can edit this by using the calendar below:-->
<!--            </p>-->

            <!-- Bootstrap UI Calendar Component - Re-styled Card & Table Layout -->
            <div class="card mx-auto mb-4">
                <div class="inline-datepicker-wrap">
                    <input type="hidden" name="selectedDates">
                </div>
            </div>

<!--            <p class="small text-brand-muted fw-semibold mb-4 px-1">-->
<!--                Your first chosen delivery date is <strong class="text-brand-dark text-decoration-underline selected-monday-display">Monday 23rd January</strong>.-->
<!--            </p>-->

            <hr class="my-4" style="opacity: 0.1;">

            <!-- Action options -->
            <div class="d-flex gap-3 justify-content-center">
                <button type="button" data-action="prev" class="button btn-secondary">Back</button>
                <button type="button" data-action="next" class="button btn-primary">Confirm Selection</button>
            </div>
        </div>
    </div>
</template>

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
        onStateChange: (state) => {
            console.log('State updated:', state);

        },
        steps: [
            // STEP 1: DELIVERY DETAIL
            {
                id: 'delivery_info',
                templateId: 'signup-organic-step-1',
                validate: () => {
                    const validate_route = validate_input_field(document.querySelector('#delivery_route'));
                    if(validate_route) {
                        return true;
                    }
                },
                populate: (clone, data, engine) => {
                    // Add hydration logic here if needed
                },
                bindEvents: (clone, data, engine) => {
                    // Use querySelector instead of getElementById for broad DocumentFragment support
                    const btnCancel = clone.querySelector('[data-action="cancel"]');
                    const btnNext = clone.querySelector('[data-action="next"]');

                    if (btnCancel) {
                        btnCancel.addEventListener('click', () => swal.close());
                    }
                    if (btnNext) {
                        btnNext.addEventListener('click', () => {
                            //const route_input = document.querySelector('#delivery_route');
                            //const validate_route = validate_input_field(route_input);
                            //console.log(validate_route.value);

                            // Storage.update('user_signup_form', {
                            //     'delivery_route': route_input.value
                            // });
                            window.location = site_url+'fruit-veg-boxes/';
                            return false;
                            //engine.next()
                        });
                    }
                }
            },

            /*// STEP 2: SELECT OPTIONS & CALENDAR
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
            }*/
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

    window.guest_postcode_delivery_modal = async (postcode_input='', signup_step=0)=>{

        const guestPostcode = postcode_input.closest('form').querySelector('.guest-signup-postcode');
        const wrapper = guestPostcode.closest('.panel-wrapper');

        let postcode_value = '';
        if(postcode_input.value.length===0) {
            if(!validate_input_field(guestPostcode)) {
                return false;
            }
            postcode_value = guestPostcode.value;
            wrapper.classList.add('loading');
        }

        guestPostcode.classList.remove('is-invalid');

        const validate_postcode = await validateUKPostcode(postcode_value);

        if(!validate_postcode.valid) {
            const parent = guestPostcode.parentElement;
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error_message';
            errorDiv.textContent = 'Postcode is invalid';
            parent.appendChild(errorDiv);
            guestPostcode.classList.add('is-invalid');

            wrapper.classList.remove('loading');
            return false;
        }else {
            postcode_value = validate_postcode.postcode;
        }

        SessionStorage.remove('user_signup_form');
        php_session.remove('ordle-cart');

        const selectedProduct = null;

        let check_postcode = get_remote_request('get_postcode_routes', {
            postcode: postcode_value,
        });

        check_postcode.then(function(data) {
            const modal_element = document.querySelector('#guest-signup-popup-form');

            if(!modal_element) {
                wrapper.classList.remove('loading');
                return;
            }

            modal_element.innerHTML = data.html;

            const modal_html = modal_element.innerHTML;

            wrapper.classList.remove('loading');

            let routeID = 0;
            let delivery_info = {};
            if(data.success) {
                routeID = data.data[0].id || 0;
                delivery_info = data.routeInfo || {};
            }else {
                routeID = 0;
            }

            // if(!delivery_info.success) {
            //     alert(delivery_info.message);
            //     return;
            // }

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
                           const del_info = {
                               ...delivery_info,
                               postcode: postcode_value,
                               delivery_route: routeID
                           };

                           SessionStorage.set('user_signup_form', del_info);

                           php_session.update('ordle-cart', del_info);

                           if(signup_step) {
                               myFormConfig.initialStepIndex = signup_step;
                           }else {
                               myFormConfig.initialStepIndex = 0;
                           }
                           setTimeout(()=>{
                               new StepFormEngine(myFormConfig);
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

        if(signup_session && document.querySelector('.product-hyper-box') || is_login) {
           // const postcode_value = signup_session.postcode;

            document.querySelectorAll('.product-box-wrapper').forEach((box)=>{
                const footer = box.querySelector('.box-footer');
                const pid = box.dataset.pid;

                const p_choicebox = footer.querySelector('.btn').dataset.choicebox;
                //const slug = footer.querySelector('.btn').dataset.slug;
                const price = footer.querySelector('.btn').dataset.price;

                if(!footer.querySelector('.btn.add_to_cart')) {
                    return;
                }
                footer.querySelector('.btn.add_to_cart').addEventListener('click', ()=>{
                    document.querySelectorAll('.product-box-wrapper.loading').forEach((b)=>{
                        b.classList.remove('loading');
                    });
                    box.closest('.catalog-boxes').classList.add('loading');

                    <?php
                    if(!is_user()) {
                        ?>
                    php_session.update('ordle-cart', {
                        products: {}
                    }).then(()=>{
                        if(p_choicebox === "choice") {
                            build_order_selector({
                                product_id: pid,
                                onOpen: ()=>{
                                    box.closest('.catalog-boxes').classList.remove('loading');
                                }
                            });
                        }else {
                            add_to_cart(pid, price, 1).then(()=>{
                                reloadCart().then(function() {
                                    box.classList.remove('loading');
                                });
                                location.href = site_url+'create-account';
                            });
                        }
                    });
                        <?php
                    }else {
                        ?>

                        if(p_choicebox === "choice") {
                            build_order_selector({
                                product_id: pid,
                                onOpen: ()=>{
                                    box.closest('.catalog-boxes').classList.remove('loading');
                                }
                            });
                        }else {
                            add_to_cart(pid, price, 1).then(()=>{
                                reloadCart().then(function() {
                                    box.closest('.catalog-boxes').classList.remove('loading');
                                });
                                location.href = site_url+'create-account';
                            });
                        }
                    <?php
                    }
                    ?>

                    // get_remote_request('getproduct', {
                    //     product_slug: slug
                    // }).then((data)=>{
                    //     if(data.success) {
                    //
                    //     }else {
                    //         alert(data.message);
                    //         box.classList.remove('loading');
                    //     }
                    // });
                });
            });
        }
    }

    document.addEventListener("DOMContentLoaded", ()=>{
        init_signup_box_selection();
        /*document.querySelector('.basket-badge-container').addEventListener('click', (e)=>{
            //console.log(Storage.get('user_signup_form'), is_login);
            if(Storage.get('user_signup_form') && !is_login) {
                e.preventDefault();

                const modal_element = document.querySelector('#signup-organic-delivery-options');
                const modal_html = modal_element.innerHTML;
                Swal.showLoading();

                const postcode_value = Storage.get('user_signup_form').postcode;
                const route_id = Storage.get('user_signup_form').delivery_route;

                let check_postcode = get_remote_request('get_postcode_routes', {
                    postcode: postcode_value
                });

                check_postcode.then(function(res) {
                    let curr_route = 0;

                    if(res.data) {
                        for(let i in res.data) {
                            const curr_data = res.data[i];
                            if(curr_data.id === parseInt(route_id)) {
                                curr_route = curr_data;
                                break;
                            }
                        }
                    }

                    const dayMap = {
                        Sunday: 0,
                        Monday: 1,
                        Tuesday: 2,
                        Wednesday: 3,
                        Thursday: 4,
                        Friday: 5,
                        Saturday: 6
                    };

                    Swal.fire({
                        customClass: {
                            popup: 'signup-deliver-options'
                        },
                        width: 540,
                        showCloseButton: true,
                        showConfirmButton: false,
                        html: modal_html,
                        willOpen: ()=>{
                            //const routeDays = curr_route.RouteDay.split(',');

                            //const allowedIndexes = routeDays.map(day => dayMap[day]);

                            // init_inline_datepicker({
                            //     element: '#signup-organic-step-2 .inline-datepicker-wrap',
                            //     enable: [
                            //         function (date) {
                            //             return allowedIndexes.includes(date.getDay());
                            //         }
                            //     ]
                            // });
                        }
                    });
                });

            }
        });*/
    });
</script>