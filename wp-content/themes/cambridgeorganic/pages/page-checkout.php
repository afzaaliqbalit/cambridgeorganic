<?php
/**
Template Name: Checkout
 */
?>

<?php get_header( 'shop' );

if(empty($_SESSION['ordle-cart']['products']) || empty($_SESSION['ordle-cart']['routeDay'])) {
    wp_redirect(home_url());
    exit;
}

if(empty($_SESSION['customer-info']) && !is_user()) {
    wp_redirect('create-account');
}

$cart = new Cart();
$api = new APIClient();
$cart_data = $cart->getCart();
$cart_products = $cart_data['products'];

$next_delivery_date = $cart_data['next_delivery_date'];
$delivery_frequency = !empty($cart_data['delivery_frequency']) ? $cart_data['delivery_frequency'] : 'Weekly';
$delivery_frequency_name = '';
switch ($delivery_frequency) {
    case 'Weekly':
        $delivery_frequency_name = 'Week';
        break;
    case 'Monthly':
        $delivery_frequency_name = 'Month';
        break;
    case 'BiWeekly':
        $delivery_frequency_name = '2 Weeks';
        break;
}
?>

    <div class="container page-wrap">
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
                            Your Shopping Basket for Delivery on <span class="text-accent-red fw-bold" id="delivery-date"><?php echo date('d/m/Y',strtotime($next_delivery_date)) ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 justify-content-end d-flex gap-3">
                        <button class="btn btn-outline-custom d-flex align-items-center gap-2 w-75 justify-content-center justify-content-md-start" onclick="notifyAction('edit_schedule')">
                            <i class="bi icon-truck"></i> Edit Schedule
                        </button>

                        <button onclick="confirm_order()" class="btn btn-orange text-uppercase shadow-sm d-inline-flex align-items-center gap-2 order-confirm">
                            <i class="icon-basket white"></i> Confirm Order
                        </button>
                    </div>
                </div>

                <!-- Main Outer Gray Container Box -->
                <div class="basket-outer-box">

            <?php

            foreach ($cart_products as $product) {
                ?>
                    <!-- CARD 1: Customizable Veg Box -->
                    <div class="basket-item-card" id="card-vegbox">
                        <div class="row g-4">
                            <!-- Product Image -->
                            <div class="col-lg-3 col-md-4 col-12 text-center text-md-start">
                                <img src="<?php echo thumbnail($product['image']) ?>" alt="<?php echo $product['name'] ?>" class="product-image">
                            </div>

                            <div class="col-lg-7 col-md-6 col-12">

                                        <div class="row">
                                            <!-- Product Details -->
                                            <div class="col-lg-7 col-md-9 col-12">
                                                <div class="d-flex align-items-start gap-2 mb-1">
                                                    <i class="bi bi-box-seam-fill text-primary-green fs-5"></i>
                                                    <h4 class="text-primary-green m-0 fw-bold fs-5"><?php echo $product['name'] ?> <?php echo !empty($product['box_size']) ? ' : '.$product['box_size'] : '' ?></h4>
                                                </div>
                                                <p class="text-muted mb-2" style="font-size: 0.85rem;">
                                                    Delivery Option &nbsp;&bull;&nbsp; <?php echo $product['cart_quantity'] ?> <?php echo $product['name'] ?> Every <?php echo $delivery_frequency_name ?>
                                                </p>

                                                <?php
                                                if($product['type'] !== 'single') {
                                                ?>
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
                                                    <?php
                                                    $box_items = [];
                                                    if($product['type'] !== 'single' && !empty($product['hyper_product_type'])) {
                                                        if($product['hyper_product_type'] === 'choice') {
                                                            $box_items = $product['selected_items'];
                                                        }
                                                        if($product['hyper_product_type'] === 'fixed') {
                                                            $box_items = $product['associated_products'];
                                                        }
                                                        if($product['hyper_product_type'] === 'hybrid') {
                                                            $box_items = $product['associated_products'];
                                                        }
                                                    }
                                                    foreach($box_items as $a_product) {
                                                        $weight = !empty($a_product['option_weight']) ? $a_product['option_weight'] : $a_product['weight'].' '.$a_product['per_unit'];
                                                    ?>
                                                    <div class="veg-list-row"><span><?php echo $a_product['name'] ?> <?php echo $weight ?></span> <?php if(!empty($a_product['quantity'])) { ?> <span class="fw-medium"><?php echo $a_product['quantity'] ?>x</span> <?php } ?></div>
                                                    <?php }
                                                    ?>
                                                </div>
                                                <?php } ?>

                                            </div>

                                            <div class="col-lg-5 col-md-6 col-12">
                                                <div class="text-end mb-3 mb-md-0 text-right price-text">
                                                    <span class="fs-4 fw-bold text-dark" id="vegbox-price"><?php echo price($product['net_selling_price']) ?></span>
                                                </div>
                                            </div>
                                        </div>


                            </div>

                            <div class="col-lg-2 col-md-6 col-12 d-flex flex-column justify-content-between">
                                <!-- Action Buttons -->
                                <div class="d-flex flex-column gap-2 w-100 align-items-md-end align-items-start action-buttons">
                                    <button class="btn btn-outline-custom d-flex align-items-center gap-2 w-75 justify-content-center justify-content-md-start" onclick="notifyAction('Edit Choices')">
                                        <i class="bi icon-vegebox"></i> Edit Your Choices
                                    </button>
                                    <button class="btn btn-outline-custom d-flex align-items-center gap-2 w-75 justify-content-center justify-content-md-start" onclick="notifyAction('Change Box')">
                                        <i class="bi icon-vegebox"></i> Change Your Box
                                    </button>
                                </div>

                                <div>
                                    <button class="btn-remove" onclick="removeCartItem(<?php echo $product['id'] ?>)">X</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>


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
                                Subtotal <span class="ms-1 text-dark fw-bold" id="footer-subtotal"><?php echo price($cart->getSubTotal()) ?></span>
                            </div>
                            <div class="divider-vertical d-none d-sm-inline-block"></div>
                            <div class="text-muted" style="font-size: 0.9rem;">
                                Delivery <span class="ms-1 text-primary-green fw-bold"><?php echo price($cart->deliveryCost()) ?></span>
                            </div>
                            <div class="divider-vertical d-none d-sm-inline-block"></div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-primary-green fw-semibold">Next Delivery Total</span>
                                <span class="fs-4 fw-bold text-primary-green" id="footer-grand-total"><?php echo price($cart->getTotal()) ?></span>
                            </div>
                        </div>
                        <!-- Right Side Confirmation Button -->
                        <div class="col-lg-5 col-md-6 col-12 text-md-end text-center">
                            <button class="btn btn-orange text-uppercase shadow-sm px-5 py-2 d-inline-flex align-items-center gap-2" onclick="confirmOrder()">
                                <i class="bi bi-basket2"></i> Confirm Order
                            </button>
                        </div>
                    </div>
                </div>
            </footer>

            <?php
            echo get_template_part('inc/popups/user/user-edit-delivery-schedule');
            ?>

            <script>
                function notifyAction(action) {
                    if(action === 'edit_schedule') {
                        edit_delivery_schedule();
                    }
                }

                function prompt_checkout_successs() {
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
                }

               function confirm_order() {
                    const checkout_wrapper = document.querySelector('.product-checkout');
                    checkout_wrapper.classList.add('loading');
                    <?php
                   if(!is_user()) {
                       $data = $_SESSION['customer-info'];

                       $title = $data['title'] ?? '';
                       $firstname = $data['firstname'] ?? '';
                       $lastname = $data['lastname'] ?? '';
                       $email = $data['email'] ?? '';
                       $secondary_email = $data['secondary_email'] ?? '';

                       $phone = $data['telephone'] ?? '';
                       $secondary_phone = $data['secondary_telephone'] ?? '';
                       $mobile = $data['mobile'] ?? '';

                       $password = $data['password'] ?? '';
                       $confirm_password = $data['confirm_password'] ?? '';

                       $house_number = $data['house_number'] ?? '';
                       $house_name = $data['house_name'] ?? '';
                       $address_line_1 = $data['address_line_1'] ?? '';
                       $address_line_2 = $data['address_line_2'] ?? '';
                       $city = $data['city'] ?? '';
                       $postcode = $data['postcode'] ?? '';
                       $gps = $data['gps'] ?? '';
                       $what_three_words = $data['ww3_location'] ?? '';

                       $billing_house_number = $data['billing_house_number'] ?? '';
                       $billing_house_name = $data['billing_house_name'] ?? '';
                       $billing_address_line_1 = $data['billing_address_line_1'] ?? '';
                       $billing_address_line_2 = $data['billing_address_line_2'] ?? '';
                       $billing_city = $data['billing_city'] ?? '';
                       $billing_postcode = $data['billing_postcode'] ?? '';
                       $billing_gps = $data['billing_gps'] ?? '';

                       $route_id = $data['route_id'] ?? '';
                       $account_reference = $data['account_reference'] ?? '';

                       $payment_method = $data['PaymentMethod'] ?? '';
                       $preferred_communication = $data['preferredCommunication'] ?? '';
                       $notes = $data['notes'] ?? '';

                       $confirm_create_account = !empty($data['terms_conditions']) ? 1 : 0;

                       $apiData = [
                           'Password' => $password,
                           'Title' => $title,
                           'FirstName' => $firstname,
                           'LastName' => $lastname,
                           'Email' => $email,
                           'EmailSecondary' => $secondary_email,
                           'Tel' => $phone,
                           'TelSecondary' => $secondary_phone,
                           'Mobile' => $mobile,

                           'PaymentMethod' => $payment_method,
                           'PreferedCommunication' => $preferred_communication,
                           'Notes' => $notes,

                           'accountreference' => $account_reference,
                           'route' => $route_id,

                           'housenumber' => $house_number,
                           'housename' => $house_name,
                           'streetname' => $address_line_1,
                           'streetname2' => $address_line_2,
                           'cityname' => $city,
                           'postcode' => $postcode,
                           'gps' => $gps,
                           'what_three_words' => $what_three_words,

                           'billing_housenumber' => $billing_house_number,
                           'billing_housename' => $billing_house_name,
                           'billing_streetname' => $billing_address_line_1,
                           'billing_streetname2' => $billing_address_line_2,
                           'billing_cityname' => $billing_city,
                           'billing_postcode' => $billing_postcode,
                           'billing_gps' => $billing_gps,
                       ];

                       //print_r($apiData);


                   }else {
                       ?>

                       <?php
                     }
                   ?>

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
    </div>

<?php get_footer( 'shop' ); ?>