<div class="product-checkout">
    <div class="page-head">
        <h1>Shopping Basket</h1>
        <div class="caption-text">
            <p>By checking-out you are confirming your next Order and any</p>
            <p>Future additional items that are added which you can see below</p>
        </div>
    </div>

    <div class="container my-4">
        <!-- Header Section -->

        <div class="row align-items-center mb-4">
            <div class="col-md-8 col-12 d-flex align-items-end gap-3 mb-3 mb-md-0">
                <?php cart_basket_html() ?>
                <div class="fs-5 fw-semibold mt-1">
                    Your Shopping Basket for Delivery on <span class="text-accent-red fw-bold" id="delivery-date">DD/MM/YYYY</span>
                </div>
            </div>
            <div class="col-md-4 col-12 justify-content-end d-flex">
                <button onclick="confirm_order()" class="btn btn-orange text-uppercase shadow-sm d-inline-flex align-items-center gap-2 order-confirm">
                    <i class="icon-basket white"></i> Confirm Order
                </button>
            </div>
        </div>

        <!-- Main Outer Gray Container Box -->
        <div class="basket-outer-box">

            <!-- CARD 1: Customizable Veg Box -->
            <div class="basket-item-card" id="card-vegbox">
                <div class="row g-4">
                    <!-- Product Image -->
                    <div class="col-lg-3 col-md-4 col-12 text-center text-md-start">
                        <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&q=80&w=400" alt="Veg Box Build Your Own" class="product-image">
                    </div>

                    <div class="col-lg-7 col-md-6 col-12">
                        <div class="row">
                            <!-- Product Details -->
                            <div class="col-lg-7 col-md-9 col-12">
                                <div class="d-flex align-items-start gap-2 mb-1">
                                    <i class="bi bi-box-seam-fill text-primary-green fs-5"></i>
                                    <h4 class="text-primary-green m-0 fw-bold fs-5">Veg Box : Build Your Own (Choice) : Small</h4>
                                </div>
                                <p class="text-muted mb-2" style="font-size: 0.85rem;">
                                    Delivery Option &nbsp;&bull;&nbsp; 1 Vegetable Box Every Week
                                </p>

                                <div class="box-summary-text" style="font-size: 0.85rem;">
                                    <div>
                                        <span class="fw-semibold">Summary of your Box</span>
                                    </div>
                                    <div class="text-points">
                                        <span class="text-success"><i class="bi icon-check-circle-fill"></i> Points Used</span>
                                        <span class="fw-bold">
                                                    <span class="text-accent-red">&mdash;&nbsp; 25</span> <span>/ 18</span></span>
                                    </div>
                                </div>

                                <!-- Inner veg list -->
                                <div class="veg-list">
                                    <div class="veg-list-row"><span>Carrots 150g</span> <span class="fw-medium">3x</span></div>
                                    <div class="veg-list-row"><span>Potatoes (Red Carra) 100g Sack</span> <span class="fw-medium">1x</span></div>
                                    <div class="veg-list-row"><span>Parsnips 100g</span> <span class="fw-medium">1x</span></div>
                                    <div class="veg-list-row"><span>Cucumbers (x3) 250g</span> <span class="fw-medium">1x</span></div>
                                    <div class="veg-list-row"><span>Turmeric Root 60g</span> <span class="fw-medium">1x</span></div>
                                    <div class="veg-list-row"><span>Vine Tomatoes 250g</span> <span class="fw-medium">1x</span></div>
                                    <div class="veg-list-row"><span>Onions 150g</span> <span class="fw-medium">3x</span></div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-6 col-12">
                                <div class="text-end mb-3 mb-md-0 text-right price-text">
                                    <!-- Simulated Pricing based on points setup -->
                                    <span class="fs-4 fw-bold text-dark" id="vegbox-price">£19.25</span>
                                    <span class="text-accent-red fw-semibold additional">(Additional £3.75 included)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12 d-flex flex-column justify-content-between">
                        <!-- Action Buttons -->
                        <div class="d-flex flex-column gap-2 w-100 align-items-md-end align-items-start action-buttons">
                            <button class="btn btn-outline-custom d-flex align-items-center gap-2 w-75 justify-content-center justify-content-md-start" onclick="notifyAction('Edit Schedule')">
                                <i class="bi icon-truck"></i> Edit Schedule
                            </button>
                            <button class="btn btn-outline-custom d-flex align-items-center gap-2 w-75 justify-content-center justify-content-md-start" onclick="notifyAction('Edit Choices')">
                                <i class="bi icon-vegebox"></i> Edit Your Choices
                            </button>
                            <button class="btn btn-outline-custom d-flex align-items-center gap-2 w-75 justify-content-center justify-content-md-start" onclick="notifyAction('Change Box')">
                                <i class="bi icon-vegebox"></i> Change Your Box
                            </button>
                        </div>

                        <div>
                            <button class="btn-remove" onclick="removeItem('bananas')">X</button>
                        </div>
                    </div>
                </div>
            </div>


        </div> <!-- End Main Outer Container Box -->

        <!-- Promo Code Redeem Section -->
        <section class="voucher-section py-4">
            <div class="row align-items-center">
                <div class="col-md-6 col-12 mb-3 mb-md-0 d-flex gap-2 align-items-start">
                    <i class="bi bi-info-circle-fill text-primary-green fs-5 mt-1"></i>
                    <div>
                        <h5 class="m-0 fw-bold text-primary-green" style="font-size: 1.05rem;">Redeem Voucher or Offer Code?</h5>
                        <p class="text-muted m-0" style="font-size: 0.85rem;">
                            If you have a Voucher or Offer Code, then please enter the code in the space opposite to redeem.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-12 text-md-end text-start d-flex align-items-center justify-content-md-end gap-3 flex-wrap">
                    <input type="text" id="voucher-input" class="voucher-input" placeholder="Enter code here">
                    <button class="btn-apply-code" onclick="applyPromoCode()">
                        <i class="bi bi-bag-check-fill"></i> Apply Code
                    </button>
                </div>
            </div>
        </section>

        <!-- Small Terms Info above the Bottom Bar -->
        <div class="text-center py-4">
                    <span class="text-muted" style="font-size: 0.8rem; font-style: italic;">
                        By checking-out you are confirming your next Order and any future Additional items that are added which you can see above
                    </span>
        </div>
    </div>

    <!-- Sticky Bottom Totals & Confirmation Bar -->
    <footer class="sticky-footer-bar sticky-bottom">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <!-- Left Side Details -->
                <div class="col-lg-7 col-md-6 col-12 d-flex align-items-center gap-3 justify-content-md-start justify-content-center mb-3 mb-md-0">
                    <div class="text-muted" style="font-size: 0.9rem;">
                        Subtotal <span class="ms-1 text-dark fw-bold" id="footer-subtotal">£24.25</span>
                    </div>
                    <div class="divider-vertical d-none d-sm-inline-block"></div>
                    <div class="text-muted" style="font-size: 0.9rem;">
                        Delivery <span class="ms-1 text-primary-green fw-bold">FREE EV</span>
                    </div>
                    <div class="divider-vertical d-none d-sm-inline-block"></div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-primary-green fw-semibold">Next Delivery Total</span>
                        <span class="fs-4 fw-bold text-primary-green" id="footer-grand-total">£24.25</span>
                    </div>
                </div>
                <!-- Right Side Confirmation Button -->
                <div class="col-lg-5 col-md-6 col-12 text-md-end text-center">
                    <button class="btn btn-orange text-uppercase shadow-sm px-5 py-2 d-inline-flex align-items-center gap-2" onclick="confirm_order()">
                        <i class="bi bi-basket2"></i> Confirm Order
                    </button>
                </div>
            </div>
        </div>
    </footer>



    <script>
        function confirm_order() {
            Swal.fire({
                customClass: {
                    popup: 'confirm-order' // Connects to the CSS class we defined above
                },
                showCloseButton: true,
                showConfirmButton: false, // Hide default SweetAlert buttons
                html: `
                            <div class="modal-content">
                              <h1 class="modal-title">Thank you for your purchase</h1>
                              <p class="modal-subtitle">Thank you too for chosing Cambridge Organic.</p>
                              <p class="modal-note">The payment will only be taken after the delivery of your items.</p>

                              <div class="button-group">
                                <button class="custom-btn btn-outline" onclick="handleSignOut()">
                                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                  </svg>
                                  Sign Out
                                </button>

                                <button class="custom-btn btn-outline" onclick="handleContinueShopping()">
                                  Continue Shopping
                                </button>

                                <button class="custom-btn btn-solid" onclick="handleManageAccount()">
                                  Manage Account
                                </button>
                              </div>
                            </div>
                          `
            });

// Example functions to handle the custom button clicks
            function handleSignOut() {
                console.log("Signing out...");
                Swal.close();
            }

            function handleContinueShopping() {
                console.log("Continuing shopping...");
                Swal.close();
            }

            function handleManageAccount() {
                console.log("Managing account...");
                Swal.close();
            }
        }
    </script>

</div>