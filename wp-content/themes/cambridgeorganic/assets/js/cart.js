/** * Send a JSON POST request. */
const post_json = async (url, data = {}) => {
    const response = await fetch(url, {
        method: "POST",
        headers: {"Content-Type": "application/json", "Accept": "application/json"},
        body: JSON.stringify(data)
    });
    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }
    return response.json();
};

/** * Add product to cart. */
const add_cart_item = async (product_id, product_price, qty = 1, attrs = {}) => {
    return post_json(`${site_url}cart_action/add`, {product_id, qty, attrs, product_price});
};
/** * Initialize/add item to cart. */
window.init_add_to_cart = async (data = {}) => {
    try {
        return await post_json(`${site_url}cart_action/add`, data);
    } catch (error) {
        console.error("Add to cart failed:", error);
        throw error;
    }
};

/** * Add product to cart. * * Fetches product information first, then adds the product. */
window.add_to_cart = async (product_id, product_price, qty = 1, attrs = {}) => {
    try {
        if(document.querySelector('.catalog-boxes')) {
            document.querySelector('.catalog-boxes').classList.add('loading');
        }
        const product_info = await post_json(`${site_url}cart_action/product_info`, {product_id});
        await add_cart_item(product_id, product_price, qty, attrs);
        reloadCart();
        return product_info;
    } catch (error) {
        console.error("Add to cart failed:", error);
        throw error;
    }
};
/** * Add product to cart for a guest user. */
window.guest_add_to_cart = async (product_id, product_price, qty = 1, attrs = {}) => {
    try {
        await php_session.update("ordle-cart", {products: {}});
        return await add_cart_item(product_id, product_price, qty, attrs);
    } catch (error) {
        console.error("Guest add to cart failed:", error);
        throw error;
    }
};

window.updateCart = async (product_id, qty, attrs={})=>{
    return post_json(`${site_url}cart_action/update`, {product_id, qty, attrs});

}

window.updateCartItem = (ele, product_id, qty, attrs={}) => {
    document.querySelectorAll('.product-box-wrapper.loading').forEach((b)=>{
        b.classList.remove('loading');
    });
    const parent = ele.closest('.catalog-boxes');
    parent.classList.add('loading');

    if(parseInt(qty) === 0) {
        removeCartItem(product_id, false);
        ele.value =1;
        return;
    }

    updateCart(product_id, qty, attrs).then(res=>{
        parent.classList.remove('loading');
    });
}

window.addToCartItem = (box) => {
        document.querySelectorAll('.product-box-wrapper.loading').forEach((b)=>{
            b.classList.remove('loading');
        });

        const parent = box.closest('.product-box-wrapper');

        const footer = parent.querySelector('.box-footer');
        const pid = box.dataset.pid;

        const p_choicebox = box.dataset.choicebox;
        const price = box.dataset.price;

        box.closest('.catalog-boxes').classList.add('loading');

        if(is_login) {
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
                    add_to_cart(pid, price, 1);
                }
            });
        }
        else {
            if(p_choicebox === "choice") {
                build_order_selector({
                    product_id: pid,
                    onOpen: ()=>{
                         box.closest('.catalog-boxes').classList.remove('loading');
                    }
                });
            }else {
                add_to_cart(pid, price, 1).then(()=>{
                    location.href = 'create-account';
                });
            }
        }
}

window.removeCartItem = async (product_id, prompt_confirm = true) => {

    if(prompt_confirm) {
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
            reloadCart();
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
    reloadElement('.head-user-info,.basket-badge-container, .basket-subtotal-price, #side-cart-wrapper,.product-checkout,#shop-category-archieve');
}

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

    if (isNaN(start.getTime())) {
        return;
    }

    start.setHours(0, 0, 0, 0);

    // Generate dates for the next 12 months
    const end = new Date(start);
    end.setFullYear(end.getFullYear() + 1);

    const dates = [];
    const current = new Date(start);

    switch (value.toLowerCase()) {

        case 'daily':
            // Every day from the selected date for the next 12 months
            while (current <= end) {
                dates.push(new Date(current));
                current.setDate(current.getDate() + 1);
            }
            break;

        case 'weekly':
            while (current <= end) {
                dates.push(new Date(current));
                current.setDate(current.getDate() + 7);
            }
            break;

        case 'bi weekly':
        case 'bi-weekly':
        case 'biweekly':
            while (current <= end) {
                dates.push(new Date(current));
                current.setDate(current.getDate() + 14);
            }
            break;

        case 'monthly': {
            const startDay = start.getDay(); // 0 = Sun ... 6 = Sat
            const startDate = start.getDate();
            const weekNo = Math.ceil(startDate / 7);

            const lastDayOfStartMonth = new Date(
                start.getFullYear(),
                start.getMonth() + 1,
                0
            ).getDate();

            const isLastWeek = startDate + 7 > lastDayOfStartMonth;

            for (let i = 0; i < 12; i++) {
                const date = new Date(
                    start.getFullYear(),
                    start.getMonth() + i,
                    1
                );

                const year = date.getFullYear();
                const month = date.getMonth();

                let deliveryDate;

                if (isLastWeek) {
                    // Last occurrence of the weekday in the month
                    deliveryDate = new Date(year, month + 1, 0);

                    while (deliveryDate.getDay() !== startDay) {
                        deliveryDate.setDate(deliveryDate.getDate() - 1);
                    }
                } else {
                    // Same weekday occurrence (1st, 2nd, 3rd, 4th)
                    deliveryDate = new Date(year, month, 1);

                    while (deliveryDate.getDay() !== startDay) {
                        deliveryDate.setDate(deliveryDate.getDate() + 1);
                    }

                    deliveryDate.setDate(
                        deliveryDate.getDate() + (weekNo - 1) * 7
                    );

                    // If occurrence doesn't exist in this month,
                    // use the last occurrence instead.
                    if (deliveryDate.getMonth() !== month) {
                        deliveryDate = new Date(year, month + 1, 0);

                        while (deliveryDate.getDay() !== startDay) {
                            deliveryDate.setDate(deliveryDate.getDate() - 1);
                        }
                    }
                }

                if (deliveryDate >= start && deliveryDate <= end) {
                    dates.push(deliveryDate);
                }
            }

            break;
        }
    }

    fp.set('enable', dates);

    // Select the first available date
    if (dates.length) {
        fp.setDate(dates[0], true);
    }

    fp.redraw();
};