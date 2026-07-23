<style>
    /* Direct Debit Mandate Card Styling */
    .mandate-card {
        background-color: var(--gray);
        border: 1px solid #e1e6e3;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .mandate-card-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .mandate-section-header {
        font-size: 1rem;
        font-weight: 700;
        color: #2D3D36;
        margin-bottom: 0.75rem;
    }

    .mandate-text {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #3d4f46;
    }
</style>

<?php
    $post = !empty( $_POST ) ? $_POST : null;
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
                    <h4 class="mandate-section-header">Delivery Address</h4>
                    <div class="mandate-text">
                        <div class="editable-field" data-field="company_name"><?php echo $post['house_number'] ?? '' ?></div>
                        <div class="editable-field" data-field="address_1"><?php echo $post['address_line1'] ?? '' ?></div>
                        <div class="editable-field" data-field="address_2"><?php echo $post['address_line2'] ?? '' ?></div>
                        <div class="editable-field" data-field="postcode"><?php echo $post['postcode'] ?? '' ?></div>
                        <div class="editable-field mt-2" data-field="phone"><?php echo $post['phone'] ?? '' ?></div>
                        <div class="editable-field" data-field="email"><?php echo $post['email'] ?? '' ?></div>
                    </div>
                </div>

                <!-- Col 2: Contact Details -->
                <div class="col-12 col-md-4 mandate-col-divider mandate-col-spacing">
                    <h4 class="mandate-section-header">Contact Details</h4>
                    <div class="mandate-text">
                        <div class="editable-field" data-field="contact_title_name"><?php echo $post['firstname'] ?? '' ?> <?php echo $post['lastname'] ?? '' ?></div>
                        <div class="editable-field" data-field="contact_address_1"><?php echo $post['address_line1'] ?? '' ?> <?php echo $post['address_line2'] ?? '' ?></div>
                        <div class="editable-field" data-field="contact_postcode"><?php echo $post['postcode'] ?? '' ?></div>
                    </div>
                </div>

                <!-- Col 3: Name of Account Holder -->
                <div class="col-12 col-md-4 mandate-col-spacing">
                    <h4 class="mandate-section-header">Name of Account Holder</h4>
                    <div class="mandate-text">
                        <div class="editable-field font-monospace fw-semibold" data-field="account_holder_name"><?php echo $post['payment_account_name'] ?? '' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: BANKING DETAILS 1 -->
        <div class="mandate-card">
            <h3 class="mandate-card-title">Banking Details</h3>

            <div class="row g-4">
                <!-- Col 1: Bank / Building Society -->
                <div class="col-12 col-md-4 mandate-col-divider">
                    <h4 class="mandate-section-header">Bank / Building Society</h4>
                    <div class="mandate-text">
                        <div class="editable-field" data-field="bank_name"><?php echo $post['payment_address_1'] ?? '' ?> <?php echo $post['payment_address_2'] ?? '' ?></div>
                    </div>
                </div>

                <!-- Col 2: Name on Statement -->
                <div class="col-12 col-md-4 mandate-col-divider mandate-col-spacing">
                    <h4 class="mandate-section-header">Name on Statement</h4>
                    <div class="mandate-text">
                        <div class="editable-field font-monospace" data-field="statement_name"><?php echo $post['payment_contact_name'] ?></div>
                    </div>
                </div>

                <!-- Col 3: Bank Account & Sort Code -->
                <div class="col-12 col-md-4 mandate-col-spacing">
                    <!-- Row block inside column -->
                    <div class="mb-4">
                        <h4 class="mandate-section-header">Bank Account Number</h4>
                        <div class="mandate-text">
                            <div class="editable-field font-monospace" data-field="account_number"><?php echo $post['payment_account_number'] ?></div>
                        </div>
                    </div>

                    <div>
                        <h4 class="mandate-section-header">Sort Code</h4>
                        <div class="mandate-text">
                            <div class="editable-field font-monospace" data-field="sort_code"><?php echo $post['payment_sort_code'] ?></div>
                        </div>
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