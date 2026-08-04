
<?php
    $post = !empty( $_POST ) ? $_POST : null;
    $cart = new Cart();
    $cart_data = $cart->getCart();
?>

<!-- MAIN FORM WRAPPER (Can be formatted/printed) -->
<div id="mandateForm">

    <div style="max-width: 1024px">
        <!-- SECTION 1: YOUR DETAILS -->
        <div class="mandate-card">
            <h3 class="mandate-card-title">Your Details</h3>

            <div class="row g-4">
                <!-- Col 1: Company Address -->
                <div class="col-12 col-md-4 mandate-col-divider">
                    <h4 class="mandate-section-header">Full Name</h4>
                    <div class="mandate-text">
                        <div class="editable-field" data-field="full_name"><?php echo $post['title'] ?? '' ?> <?php echo $post['firstname'] ?? '' ?> <?php echo $post['lastname'] ?? '' ?></div>
                    </div>
                </div>

                <!-- Col 2: Contact Details -->
                <div class="col-12 col-md-4 mandate-col-divider mandate-col-spacing">
                    <h4 class="mandate-section-header">Contact Details</h4>
                    <div class="mandate-text">
                        <div class="editable-field" data-field="contact_telephone"><?php echo $post['telephone'] ?? '' ?></div>
                        <div class="editable-field" data-field="contact_secondary_telephone"><?php echo $post['secondary_telephone'] ?? '' ?></div>
                        <div class="editable-field" data-field="contact_email"><?php echo $post['email'] ?? '' ?></div>
                        <div class="editable-field" data-field="contact_email"><?php echo $post['secondary_email'] ?? '' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 mandate-col-divider">
                <!-- SECTION 2: BANKING DETAILS 1 -->
                <div class="mandate-card">
                    <h3 class="mandate-card-title">Delivery Details</h3>

                    <div class="row g-4">
                        <!-- Col 1: Bank / Building Society -->
                        <div class="col-12 col-md-6 mandate-col-divider">
                            <h4 class="mandate-section-header">Address</h4>
                            <div class="mandate-text">
                                <div class="editable-field" data-field="contact_address"><?php echo $post['address_line_1'] ?? '' ?> <?php echo $post['address_line_2'] ?? '' ?></div>
                                <div class="editable-field" data-field="contact_city"><?php echo $post['city'] ?? '' ?></div>
                                <div class="editable-field" data-field="contact_postcode"><?php echo $post['postcode'] ?? '' ?></div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mandate-col-divider">
                            <h4 class="mandate-section-header">Route Information</h4>
                            <div class="mandate-text">
                                <div class="editable-field"><?php echo $cart_data['RouteName'] ?? '' ?></div>
                                <div class="editable-field">Delivery day: <?php echo $cart_data['routeDay'] ?? '' ?></div>
                                <div class="editable-field">Next delivery date: <?php echo !empty($cart_data['next_delivery_date']) ? date('d/m/Y',strtotime($cart_data['next_delivery_date'])) : '' ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mandate-col-divider">
                <div class="mandate-card">
                    <h3 class="mandate-card-title">Billing Details</h3>

                    <div class="row g-4">
                        <!-- Col 1: Bank / Building Society -->
                        <div class="col-12 col-md-6 mandate-col-divider">
                            <h4 class="mandate-section-header">Address</h4>
                            <div class="mandate-text">
                                <div class="editable-field" data-field="contact_address"><?php echo $post['address_line_1'] ?? '' ?> <?php echo $post['address_line_2'] ?? '' ?></div>
                                <div class="editable-field" data-field="contact_city"><?php echo $post['city'] ?? '' ?></div>
                                <div class="editable-field" data-field="contact_postcode"><?php echo $post['postcode'] ?? '' ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mandate-card">
            <h3 class="mandate-card-title">Payment Details</h3>

            <div class="row g-4">
                <div class="col-12 col-md-4 mandate-col-divider">
                    <h4 class="mandate-section-header">Payment Method</h4>
                    <div class="mandate-text">
                        <?php echo $post['PaymentMethod'] ?? '-' ?>
                    </div>
                </div>

                <div class="col-12 col-md-4 mandate-col-divider">
                    <h4 class="mandate-section-header">Preferred Communication</h4>
                    <div class="mandate-text">
                        <?php echo $post['preferredCommunication'] ?? '-' ?>
                    </div>
                </div>

                <div class="col-12 col-md-4 mandate-col-divider">
                    <h4 class="mandate-section-header">Notes</h4>
                    <div class="mandate-text">
                        <?php echo $post['notes'] ?? '-' ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- UNDERLYING REGULATORY TEXT -->
        <div class="my-4 px-1">
            <p class="small text-secondary mb-4 fs-14" style="line-height: 1.6; text-align: justify;">
                Please pay L&Z Re Cambridge Organic. Direct Debits from the account detailed in this instruction subject to the safeguards assured by the Direct Debit Guarantee. I understand that this instruction may remain with L&Z Re Cambridge Organic and, if so, details will be passed electronically to my Bank / Building Society.
            </p>

            <!-- DIRECT DEBIT GUARANTEE BLOCK -->
            <div class="bg-white">
                <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom">
                    <h5>The Direct Debit Guarantee</h5>
                </div>

                <ul class="list-unstyled d-flex flex-column gap-3 mb-0" id="guaranteeList">
                    <!-- Bullet Items -->
                    <li class="d-flex align-items-start gap-2 text-sm mandate-text">
                        <span class="fw-bold fs-5 mt-n1">&mdash;</span>
                        <span>This guarantee is offered by all banks and building societies that accept instructions to pay Direct Debits.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2 text-sm mandate-text">
                        <span class="fw-bold fs-5 mt-n1">&mdash;</span>
                        <span id="textItem2">If there are any changes to the amount, date or frequency of your Direct Debit L&Z re <strong class="text-dark">Cambirdge Organic</strong> will notify you 3 working days in advance of your account being debited or as otherwise agreed. If you request L&Z re <strong class="text-dark">Cambridge Organic</strong> to collect payment, confirmation of the amount and date will be given to <span id="typoYouAt">youat</span> the time of the request.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2 text-sm mandate-text">
                        <span class="fw-bold fs-5 mt-n1">&mdash;</span>
                        <span id="textItem3">If an error is made in the payment of your Direct Debit, by L&Z re <strong class="text-dark">Cambirdge Organic</strong> or your bank or building society you are entitled to a full and immediate refund of the amount paid from your bank or building society - if you receive a refund you are not entitled to, you must pay it back when L&Z re <strong class="text-dark">Cambridge Organic</strong> asks you to.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2 text-sm mandate-text">
                        <span class="fw-bold fs-5 mt-n1">&mdash;</span>
                        <span>You can cancel a Direct Debit at any time by simply contacting your bank or building society. Written confirmation may be required. Please also notify us.</span>
                    </li>
                </ul>
            </div>
        </div>

        <p class="small text-secondary mb-4 fs-14" style="line-height: 1.6; text-align: justify;">
            A statement confirming the DDI will be set up within 3 working days i.e. You Direct Debit instruction will be confimred to you by email within 3 working days. We will also notify you of the amount being collected at least X working days prior to the first collection. Any changes to the frequency or amount of your collections will be advised to you XX working days in advance.
        </p>
    </div>

    <hr>

    <div class="step-form pt-3">
        <?php //echo progress_dots(['count'=>6, 'active'=>5]); ?>

        <div class="d-flex gap-3 justify-content-center mt-5">
            <input type="hidden" name="action" value="create_user_account">
            <?php wp_nonce_field('create_user_account', 'contact_nonce'); ?>

            <?php
                foreach($post as $k=>$v) {
                    ?>
                    <input type="hidden" name="<?php echo $k ?>" value="<?php echo $v ?>">
                    <?php
                }
            ?>

            <button type="button" onclick="history.back()" data-action="prev" class="button btn-secondary">Back</button>
            <button type="button" class="button btn-secondary">Print Details</button>
            <button type="submit" value="1" name="create_account" data-action="next" class="button btn-primary">Confirm Details & First Order</button>
        </div>
    </div>

</div>