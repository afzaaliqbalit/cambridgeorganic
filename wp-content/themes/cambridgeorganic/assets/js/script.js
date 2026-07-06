function validate_input_field(field, e = null, report_validity = true) {
    let error = field.dataset.error;
    let is_valid = true;

    // Remove any previous error messages
    const parent = field.parentElement;

    const existingErrors = parent.querySelectorAll('.error_message:not(.prevent-remove)');
    existingErrors.forEach((el)=>{
       el.innerHTML = '';
    });

    field.classList.remove('is-invalid');

    if (typeof error === 'undefined') {
        error = field.validationMessage;
    }

    if (field.disabled) {
        return is_valid;
    }

    if (!field.checkValidity()) {
        try {
            if (e && typeof e === 'object' && typeof e.preventDefault === 'function') {
                e.preventDefault();
            }
        } catch (err) {
            console.warn(err);
        }

        field.classList.add('is-invalid');
        is_valid = false;


        if (report_validity) {
            if(!parent.querySelector('.error_message')) {
                parent.insertAdjacentHTML('beforeend',`<div class="error_message">${error}</div>`);
            }
            else {
                parent.querySelector('.error_message').innerHTML = error;
            }
        }
        field.focus(); // optional
    }

    // Custom text validation
    if (field.value && field.classList.contains('text-input') && !isTextString(field.value)) {
        field.classList.add('is-invalid');
        is_valid = false;

        if (report_validity) {
            if(!parent.querySelector('.error_message')) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error_message';
            errorDiv.textContent = 'Invalid characters';
            parent.appendChild(errorDiv);
            }
            else {
                parent.querySelector('.error_message').innerHTML = 'Invalid characters';
            }
        }
    }



    return is_valid;
}


window.validate_input_live = function(input) {
    // Remove any existing change event listener before adding a new one
    input.removeEventListener('change', input._validateChangeHandler);
    // Define and store the event handler on the element itself
    input._validateChangeHandler = function(e) {
        const validate = validate_input_field(input, e, true);
        if (validate) {
            input.classList.remove('is-invalid');
            const errorMessage = input.parentElement.querySelector('.error_message');
            if (errorMessage) {
                errorMessage.innerHTML = '';
            }
        }
    };
    // Add the new event listener
    input.addEventListener('change', input._validateChangeHandler);
};


window.validate_form_fields = function(form, e = null, report_validity = true, loading = true) {
    if(!form) {
        return;
    }
    if (loading) {
        form.classList.add('loading');
    }

    // Select all required & enabled inputs, selects, and textareas
    const fields = form.querySelectorAll('input[required]:not(:disabled), select[required]:not(:disabled), textarea[required]:not(:disabled)');

    fields.forEach(field => {
        const is_invalid = !validate_input_field(field, e, report_validity);
        form.classList.remove('loading');
        validate_input_live(field);;
    });

    return fields;
};

window.init_placeholders = ()=>{
    document.querySelectorAll('img[data-placeholder], .product-image').forEach(img => {
        const setPlaceholder = () => {
            img.removeEventListener('error', setPlaceholder);
            img.src = img.dataset.placeholder || theme_url+'/assets/images/placeholder.png';
        };

        img.addEventListener('error', setPlaceholder);

        // Handle cached broken images
        if (img.complete && img.naturalWidth === 0) {
            setPlaceholder();
        }
    });
}

function form_validate_init() {
    // Disable all submit buttons initially
    document.querySelectorAll('form.validate button[type="submit"]').forEach(button => {
        button.disabled = false;

        // Remove any previously attached click listeners
        button.removeEventListener('click', button._validateClickHandler);
        const form = button.closest('form');

        // Define and attach the new click handler
        button._validateClickHandler = function(e) {
            const validation = validate_form_fields(form, e);

            button.disabled = true;

            if(form.classList.contains('prevent-submit')) {
                e.preventDefault();
            }

            // Simulate jQuery .promise().done() since validation is synchronous
            Promise.resolve(validation).then(() => {
                form.classList.remove('loading');
                const errorMessages = form.querySelectorAll('.is-invalid');
                if (errorMessages.length > 0) {
                    const cartDiv = document.querySelector('#woocommerce-cart-form-div');

                    // Trigger custom "validation_failed" event
                    button.disabled = false;
                    const event = new CustomEvent('validation_failed', { bubbles: true });
                    form.dispatchEvent(event);
                }else {
                    button.disabled = false;
                    form.classList.remove('validate');
                    if(!form.classList.contains('ajax-submit') && !form.classList.contains('prevent-submit')) {
                        form.submit();
                    }
                }
            }).finally(()=>{
                form.classList.remove('loading');
            });
        };

        // Attach the event listener
        button.addEventListener('click', button._validateClickHandler);
    });
}

function nav_switcher() {
    const primaryMenu = document.querySelector('.nav-primary-menu');
    const secondaryMenu = document.querySelector('.nav-secondary-menu');
    const primaryItems = primaryMenu?.querySelectorAll('a[data-id]');
    const secondaryItems = document.querySelectorAll('.nav-secondary-menu > [id^="menu-"]');

    if (!primaryItems.length) return;

    let revertTimeout = null;

    function getActivePrimary() {
        return primaryMenu.querySelector('a.active[data-id]');
    }

    function showSecondary(id) {
        secondaryItems.forEach(item => item.classList.remove('active'));

        const target = document.getElementById(`menu-${id}`);
        if (target) {
            target.classList.add('active');
        }
    }

    function revertToActive() {
        clearTimeout(revertTimeout);

        revertTimeout = setTimeout(() => {
            const activePrimary = getActivePrimary();
            if (activePrimary) {
                showSecondary(activePrimary.dataset.id);
            }
        }, 1000);
    }

    function cancelRevert() {
        clearTimeout(revertTimeout);
    }

    primaryItems.forEach(item => {
        const id = item.dataset.id;

        item.addEventListener('mouseenter', () => {
            cancelRevert();
            showSecondary(id);
        });

        item.addEventListener('mouseleave', () => {
            revertToActive();
        });

        // Initial active menu
        if (item.classList.contains('active')) {
            showSecondary(id);
        }
    });

    // Keep current submenu open while hovering secondary menu
    if (secondaryMenu) {
        secondaryMenu.addEventListener('mouseenter', cancelRevert);
        secondaryMenu.addEventListener('mouseleave', revertToActive);
    }

    // Leaving primary menu entirely also starts timeout
    primaryMenu.addEventListener('mouseleave', revertToActive);
    primaryMenu.addEventListener('mouseenter', cancelRevert);
}


document.addEventListener("DOMContentLoaded", ()=>{
    new Accordion(".accordion-container",{
        duration: 400,
    });

    form_validate_init();

    // Initialize all stepper elements on the page
    const steppers = document.querySelectorAll('.stepper');

    steppers.forEach(stepper => {
        const decBtn = stepper.querySelector('.stepper__btn--decrement');
        const incBtn = stepper.querySelector('.stepper__btn--increment');
        const input = stepper.querySelector('.stepper__value');

        if (!input || !decBtn || !incBtn) return;

        // Retrieve constraints from input attributes (with sensible defaults)
        const getConstraints = () => {
            const min = input.hasAttribute('min') ? parseFloat(input.getAttribute('min')) : 1;
            const max = input.hasAttribute('max') ? parseFloat(input.getAttribute('max')) : Infinity;
            const step = input.hasAttribute('step') ? parseFloat(input.getAttribute('step')) : 1;
            return { min, max, step };
        };

        // Update disabled state of buttons based on the current value
        const updateButtonStates = (value) => {
            const { min, max } = getConstraints();

            if (decBtn) {
                decBtn.disabled = value <= min;
            }
            if (incBtn) {
                incBtn.disabled = value >= max;
            }
        };

        // Safely parse and sanitize the current input value
        const getSanitizedValue = () => {
            let value = parseFloat(input.value);
            if (isNaN(value)) {
                const { min } = getConstraints();
                return min;
            }
            return value;
        };

        // Set value and trigger any listening change events programmatically
        const setStepperValue = (newValue) => {
            const { min, max } = getConstraints();

            // Constrain value within boundaries
            let clampedValue = Math.max(min, Math.min(max, newValue));

            // Format to avoid floating point precision issues (e.g. 0.1 + 0.2 = 0.30000000000000004)
            const { step } = getConstraints();
            const decimalPlaces = (step.toString().split('.')[1] || '').length;
            if (decimalPlaces > 0) {
                clampedValue = parseFloat(clampedValue.toFixed(decimalPlaces));
            }

            input.value = clampedValue;
            updateButtonStates(clampedValue);

            // Dispatch change event so parent forms or external scripts can react
            input.dispatchEvent(new Event('change', { bubbles: true }));
        };

        // Event Listeners
        decBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const { step } = getConstraints();
            const currentValue = getSanitizedValue();
            setStepperValue(currentValue - step);
        });

        incBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const { step } = getConstraints();
            const currentValue = getSanitizedValue();
            setStepperValue(currentValue + step);
        });

        // Handle manual keyboard entries
        input.addEventListener('input', () => {
            const currentValue = parseFloat(input.value);
            if (!isNaN(currentValue)) {
                updateButtonStates(currentValue);
            }
        });

        // Sanitize and clamp values on blur (when user finishes typing)
        input.addEventListener('blur', () => {
            setStepperValue(getSanitizedValue());
        });

        // Initial run to ensure buttons match the starting markup value
        updateButtonStates(getSanitizedValue());
    });
});
window.addEventListener('load', () => {
    init_placeholders();
});
window.init_inline_datepicker = ()=>{
    $('.inline-datepicker-wrap:not(.init)').each(function(i) {
        const altInput = $(this).find('input');
        const parent = this;
        altInput.flatpickr({
            appendTo: parent,
            inline: true
        });
        $(this).addClass('init');
    });
}

jQuery(document).ready(function ($) {
    $('.product-scroller').owlCarousel({
        items: 4,
        margin: 15,
        nav: true,
        dots: false,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            }
        }
    });
    $('.schedule-scroller').owlCarousel({
        items: 4,
        margin: 15,
        nav: true,
        dots: false,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            }
        }
    });
    init_inline_datepicker();
    nav_switcher();
});