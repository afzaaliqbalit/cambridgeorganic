// Constant configuration
const COST_PER_EXTRA_POINT = 0.50; // £0.50 per point excess
const DEFAULT_POINTS_LIMIT = 18;
let orderItemsData = [];
/**
 * Origin badge helper renderer
 */
function getOriginBadge(iconType, originText) {
    let iconHtml = '';
    if (iconType === 'heart') {
        iconHtml = `<i class="fa-solid fa-heart text-danger me-1 small"></i>`;
    } else if (iconType === 'flag-eu') {
        iconHtml = `<span class="badge bg-primary text-warning font-monospace me-1 p-1" style="font-size: 9px;">EU</span>`;
    } else if (iconType === 'flag-uk') {
        iconHtml = `<span class="badge bg-dark text-danger font-monospace me-1 p-1" style="font-size: 9px;">UK</span>`;
    } else {
        iconHtml = `<i class="fa-solid fa-globe text-emerald-700 me-1 small"></i>`;
    }
    return `<div class="d-flex align-items-center text-secondary small mt-1">
                            ${iconHtml}
                            <span>${originText}</span>
                        </div>`;
}

/**
 * Stepper Template Part Helper
 *
 * PHP Equivalent requested:
 * get_template_part('templates/stepper-input', null, ['name' => 'quantity'])
 */
function renderStepperInput(item) {
    return `
                <!-- TEMPLATE PART: get_template_part('templates/stepper-input', null, ['name' => 'quantity', 'id' => '${item.id}']) -->
                <div class="d-flex align-items-center gap-2 user-select-none">
                    <button type="button"
                            onclick="updateQuantity('${item.id}', -1)"
                            class="stepper-btn-minus"
                            aria-label="Decrease quantity">
                        –
                    </button>
                    <span class="fw-bold px-1 text-dark" id="qty-val-${item.id}">
                        ${item.quantity}
                    </span>
                    <button type="button"
                            onclick="updateQuantity('${item.id}', 1)"
                            class="stepper-btn-plus"
                            aria-label="Increase quantity">
                        +
                    </button>
                </div>`;
}

/* ==========================================================================
   STREAMING_CHUNK:Rendering items list with Bootstrap components...
   ========================================================================== */

/**
 * Render availability list on left column
 */
function renderItems(filterQuery = "") {
    const container = document.getElementById("items-container");
    if (!container) return;

    const query = filterQuery.toLowerCase().trim();

    const filteredItems = orderItemsData.filter(item =>
        item.name.toLowerCase().includes(query) ||
        item.origin.toLowerCase().includes(query)
    );

    if (filteredItems.length === 0) {
        container.innerHTML = `
                        <div class="p-4 text-center text-muted">
                            No available items match your search "${filterQuery}".
                        </div>`;
        return;
    }

    container.innerHTML = filteredItems.map(item => {
        const bgClass = item.isHighPoints ? "bg-high-points" : "bg-white";

        // Option dropdown or single label
        let optionSelectorHtml = `<span class="fw-bold text-dark small">${item.weight}</span>`;
        if (item.options) {
            optionSelectorHtml = `
                            <div class="d-inline-flex align-items-center gap-1">
                                <span class="text-secondary small">Option</span>
                                <select onchange="changeItemOption('${item.id}', this.value)"
                                        class="form-select form-select-sm py-0 px-2 fw-semibold border-secondary-subtle" style="width: auto; font-size: 12px;">
                                    ${item.options.map(opt => `
                                        <option value="${opt.label}" ${opt.label === item.weight ? 'selected' : ''}>
                                            ${opt.label}
                                        </option>
                                    `).join('')}
                                </select>
                            </div>`;
        }

        return `
                    <div class="item-card ${bgClass} p-3 mb-2 d-flex align-items-center justify-content-between gap-2">
                        <!-- Left Image Thumbnail -->
                        <div class="flex-shrink-0">
                            <img src="${item.image}" alt="${item.name}"
                                 onerror="this.src='https://placehold.co/70x70/e2e8f0/475569?text=Veg';"
                                 class="rounded border border-secondary-subtle object-fit-cover"
                                 style="width: 64px; height: 64px;">
                        </div>

                        <!-- Middle Description -->
                        <div class="flex-grow-1 min-width-0 px-2">
                            <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.95rem;">
                                ${item.name}
                            </h6>

                            <div class="d-flex align-items-center gap-2 small text-secondary">
                                ${optionSelectorHtml}
                                <span class="text-muted">Points</span>
                                <span class="fw-bold text-dark" id="item-pts-${item.id}">${item.points}</span>
                            </div>

                            ${getOriginBadge(item.iconType, item.origin)}
                        </div>

                        <!-- Right Stepper -->
                        <div class="flex-shrink-0">
                            ${renderStepperInput(item)}
                        </div>
                    </div>`;
    }).join('');
}

/* ==========================================================================
   STREAMING_CHUNK:Updating quantity state, points totals and serialized hidden input...
   ========================================================================== */

/**
 * Update Item Quantity & trigger recalculation
 */
function updateQuantity(itemId, delta) {
    const item = orderItemsData.find(i => i.id === itemId);
    if (!item) return;

    const newQty = Math.max(0, item.quantity + delta);

    if(item.stock_status && newQty > item.maxStock) {
        return;
    }

    item.quantity = newQty;

    // Sync card stepper UI element if present
    const qtyEl = document.getElementById(`qty-val-${itemId}`);
    if (qtyEl) {
        qtyEl.innerText = newQty;
    }

    // Recalculate summary sidebar & hidden input
    updateSummaryAndTotals();
}

/**
 * Option Selector Dropdown Change Handler
 */
function changeItemOption(itemId, selectedOptionLabel) {
    const item = orderItemsData.find(i => i.id === itemId);
    if (!item || !item.options) return;

    const selectedOpt = item.options.find(o => o.label === selectedOptionLabel);
    if (selectedOpt) {
        item.weight = selectedOpt.label;
        item.points = selectedOpt.points;

        const ptsEl = document.getElementById(`item-pts-${itemId}`);
        if (ptsEl) ptsEl.innerText = selectedOpt.points;

        updateSummaryAndTotals();
    }
}

/**
 * Recalculates points, renders right-side summary list, red cross removal, and updates hidden form input
 */
function updateSummaryAndTotals() {
    const selectedItems = orderItemsData.filter(i => i.quantity > 0);

    const summaryContainer = document.getElementById("summary-items-list");
    const emptyMsg = document.getElementById("empty-summary-message");

    if (!summaryContainer) return;

    if (selectedItems.length === 0) {
        summaryContainer.innerHTML = "";
        if (emptyMsg) emptyMsg.classList.remove("d-none");
    } else {
        if (emptyMsg) emptyMsg.classList.add("d-none");
        summaryContainer.innerHTML = selectedItems.map(item => {
            const totalItemPoints = item.quantity * item.points;
            return `
                        <div class="d-flex align-items-center justify-content-between py-1 px-2 rounded hover-bg-light">
                            <div class="text-truncate pe-2 font-medium text-dark">
                                <span class="fw-semibold">${item.name}</span>
                                <span class="text-secondary small">${item.weight}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <span class="fw-bold text-dark">x${item.quantity}</span>
                                <span class="text-secondary fw-semibold text-end" style="width: 45px;">${totalItemPoints} pts</span>
                                <!-- Click red cross to remove item from list -->
                                <button type="button"
                                        onclick="updateQuantity('${item.id}', -${item.quantity})"
                                        title="Remove item"
                                        class="remove-btn">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                            </div>
                        </div>`;
        }).join('');
    }

    // Calculate total points used
    const totalPointsUsed = orderItemsData.reduce((sum, item) => sum + (item.quantity * item.points), 0);
    const ptsCounter = document.getElementById("points-used-counter");
    if (ptsCounter) ptsCounter.innerText = totalPointsUsed;

    // Calculate points over limit & extra cost
    const overPoints = Math.max(0, totalPointsUsed - DEFAULT_POINTS_LIMIT);
    const extraCost = (overPoints * COST_PER_EXTRA_POINT).toFixed(2);

    const overCountEl = document.getElementById("points-over-count");
    const overCostEl = document.getElementById("points-over-cost");
    if (overCountEl) overCountEl.innerText = overPoints;
    if (overCostEl) overCostEl.innerText = `£${extraCost}`;

    // Create hidden input field to collect all selected items
    const hiddenInputPayload = selectedItems.map(item => ({
        id: item.id,
        name: item.name,
        option_weight: item.weight,
        unit_points: item.points,
        quantity: item.quantity,
        total_points: item.quantity * item.points
    }));

    const inputEl = document.getElementById("selected-items-input");
    if (inputEl) inputEl.value = JSON.stringify(hiddenInputPayload);
}

function init_hyperproduct_selector() {
    // Unpack HTML <template> into the DOM container
    // const template = document.getElementById("hyperproduct-order-builder-popup");
    // const targetWrapper = document.getElementById("hyperproduct-order-builder-wrapper");
    //
    // if (template && targetWrapper) {
    //     targetWrapper.appendChild(template.content.cloneNode(true));
    // }

    // Format current date display
    // const today = new Date();
    // const day = String(today.getDate()).padStart(2, '0');
    // const month = String(today.getMonth() + 1).padStart(2, '0');
    // const year = today.getFullYear();
    // const dateEl = document.getElementById("current-date-display");
    // if (dateEl) dateEl.innerText = `${day}/${month}/${year}`;

    // Initial render
    renderItems();

    // Calculate summary state
    updateSummaryAndTotals();

    // Real-time search filter
    const searchInput = document.getElementById("search-input");
    if (searchInput) {
        searchInput.addEventListener("input", function (e) {
            renderItems(e.target.value);
        });
    }
}

window.build_order_selector = (input)=> {
    if(input) {
        const ele = document.querySelector('#hyperproduct-order-builder-popup');

        if(ele) {
            const pid = input.product_id;

            fetch(`${site_url}cart_action/getproducts`).then(res=>res.json()).then(data=>{
                const ele_html = ele.content.firstElementChild.cloneNode(true);
                orderItemsData = [];

                const products = data.product_info;

                if(!products) {
                    alert('Unable to fetch products');
                    return;
                }

                if(products.length) {

                    products.forEach((product)=>{
                        orderItemsData.push({
                            id: product.slug,
                            name: product.name,
                            weight: "150g",
                            points: product.point_systems_id,
                            isHighPoints: false,
                            iconType: "heart",
                            origin: product.place_origin_description,
                            image: product.image,
                            quantity: 0,
                            options: null,
                            maxStock: product.stock,
                            stock_status: product.stock_status
                        });
                    });

                    Swal.fire({
                        customClass: {
                            popup: 'hyperproduct-order-builder'
                        },
                        showCloseButton: true,
                        showConfirmButton: false,
                        html: ele_html,
                        didOpen: ()=>{
                            init_hyperproduct_selector(orderItemsData);
                            if(typeof input.onOpen !== "undefined") {
                                input.onOpen();
                            }
                        }
                    });

                    document.querySelector('#hyperproduct-order-builder-confirm').addEventListener('click', ()=>{
                        if(document.querySelector('#hyperproduct-order-builder')) {
                            document.querySelector('#hyperproduct-order-builder').classList.add('loading')
                        }

                        php_session.get('ordle-cart').then(data => {

                            const cart_products = Array.isArray(data.products) ? data.products : [];

                            const selected_items = JSON.parse(
                                document.querySelector('#selected-items-input').value || '[]'
                            );

                            if (!selected_items.length) {
                                return;
                            }

                            fetch(`${site_url}cart_action/product_info`, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json"
                                },
                                body: JSON.stringify({
                                    product_id: pid
                                })
                            })
                                .then(res => res.json())
                                .then(prod => {

                                    const product = prod.product_info;

                                    // Find product in cart
                                    const index = cart_products.findIndex(item => item.id == product.id);

                                    if (index === -1) {

                                        // Product doesn't exist in cart
                                        cart_products.push({
                                            ...product,
                                            cart_quantity: 1,
                                            selected_items: [...selected_items]
                                        });

                                    } else {

                                        // Product exists - append selected items
                                        if (!Array.isArray(cart_products[index].selected_items)) {
                                            cart_products[index].selected_items = [];
                                        }

                                        selected_items.forEach(item => {
                                            if (!cart_products[index].selected_items.some(i => i.id == item.id)) {
                                                cart_products[index].selected_items.push(item);
                                            }
                                        });
                                    }

                                    php_session.update('ordle-cart', {
                                        products: cart_products
                                    }).then(() => {
                                        window.location = 'checkout';
                                    });

                                });

                        });
                    });
                }else {
                    init_add_to_cart({
                        product_id: pid,
                        qty: 1,
                        attrs: {},
                        product_price: product_info.net_selling_price
                    }).then(()=>{
                        window.location = 'checkout';
                    });
                }

            });
        }
    }
}