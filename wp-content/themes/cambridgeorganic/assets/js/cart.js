function init_add_to_cart(data={}) {
    return fetch(`${site_url}cart_action/add`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify(data)
    });
}

window.add_to_cart = async (product_id, product_price, qty = 1, attrs = {}) => {
    try {
        const product_info = await fetch(`${site_url}cart_action/product_info`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                product_id
            })
        }).then(res=>res.json()).then(data=>{
            init_add_to_cart({
                product_id,
                qty,
                attrs,
                product_price
            });
        });

        return await product_info;
    } catch (error) {
        console.error("Add to cart failed:", error);
        throw error;
    }
};

window.removeCartItem = async (product_id) => {
    const result = await Swal.fire({
        customClass: {
            popup: 'remove-item-prompt'
        },
        title: 'Are you sure you want to remove this item?',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes',
        width: 550
    });

    if (!result.isConfirmed) {
        return;
    }

    try {
        const response = await fetch(`${site_url}cart_action/remove`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                product_id: product_id
            })
        });

        const data = await response.json();


        if (response.ok) {
            reloadCart().then(()=>{
                // Refresh cart
                Swal.fire({
                    icon: 'success',
                    title: 'Item removed',
                    timer: 1500,
                    showConfirmButton: false
                });
            })

        } else {
            throw new Error(data.message || 'Unable to remove item.');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
        });
    }
};

window.reloadCart = async function() {
    return reloadElement('.head-user-info,.basket-badge-container, .basket-subtotal-price, #side-cart-wrapper,.product-checkout');
}

window.guest_add_to_cart = async (product_id, product_price, qty = 1, attrs = {}) => {
    try {

        await php_session.update('ordle-cart', {
            products: {}
        });

        const response = await fetch(`${site_url}cart_action/add`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                product_id,
                qty,
                attrs,
                product_price
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        response.then(data=>{
           console.log(data);
        });

       // await response.json();

    } catch (error) {
        console.error("Add to cart failed:", error);
        throw error;
    }
};

window.cart_toggle = (state = null) => {
    const cart = document.getElementById('side-cart-wrapper');

    if (!cart) {
        return;
    }

    if (state === true) {
        cart.classList.add('open');
    } else if (state === false) {
        cart.classList.remove('open');
    } else {
        cart.classList.toggle('open');
    }
};

// Close when clicking outside
document.addEventListener('click', (e) => {
    const cart = document.getElementById('side-cart-wrapper');

    if (!cart || !cart.classList.contains('open')) {
        return;
    }

    // Ignore clicks inside the cart
    if (cart.contains(e.target)) {
        return;
    }

    // Ignore clicks on toggle buttons
    if (e.target.closest('[onclick*="cart_toggle"], [data-cart-toggle]')) {
        return;
    }

    cart_toggle(false);
});

window.change_delivery_frequency = (value) => {
    php_session.update('ordle-cart', {
        delivery_frequency: value
    });

    const picker = document.querySelector('#delivery_frequency_calender');

    if (!picker || !picker._flatpickr) {
        return;
    }

    const fp = picker._flatpickr;

    const start = new Date(picker.dataset.selected);
    start.setHours(0, 0, 0, 0);

    // Generate dates for the next 12 months
    const dates = [];
    const current = new Date(start);

    switch (value.toLowerCase()) {

        case 'weekly':
            while (current <= new Date(start.getFullYear() + 1, start.getMonth(), start.getDate())) {
                dates.push(new Date(current));
                current.setDate(current.getDate() + 7);
            }
            break;

        case 'bi weekly':
        case 'bi-weekly':
        case 'biweekly':
            while (current <= new Date(start.getFullYear() + 1, start.getMonth(), start.getDate())) {
                dates.push(new Date(current));
                current.setDate(current.getDate() + 14);
            }
            break;

        case 'monthly':
            const startDay = start.getDay();       // 0=Sun ... 6=Sat
            const startDate = start.getDate();
            const weekNo = Math.ceil(startDate / 7);
            const isLastWeek = startDate + 7 > new Date(start.getFullYear(), start.getMonth() + 1, 0).getDate();

            for (let i = 0; i < 12; i++) {
                const year = start.getFullYear() + Math.floor((start.getMonth() + i) / 12);
                const month = (start.getMonth() + i) % 12;

                let date;

                if (isLastWeek) {
                    // Last occurrence of the weekday
                    date = new Date(year, month + 1, 0);

                    while (date.getDay() !== startDay) {
                        date.setDate(date.getDate() - 1);
                    }
                } else {
                    // 1st/2nd/3rd/4th occurrence
                    date = new Date(year, month, 1);

                    while (date.getDay() !== startDay) {
                        date.setDate(date.getDate() + 1);
                    }

                    date.setDate(date.getDate() + (weekNo - 1) * 7);

                    // If we've rolled into the next month, use the last occurrence instead
                    if (date.getMonth() !== month) {
                        date = new Date(year, month + 1, 0);

                        while (date.getDay() !== startDay) {
                            date.setDate(date.getDate() - 1);
                        }
                    }
                }

                dates.push(date);
            }
            break;
    }

    fp.set('enable', dates);

    // Select the first available date
    if (dates.length) {
        fp.setDate(dates[0], true);
    }

    fp.redraw();
};