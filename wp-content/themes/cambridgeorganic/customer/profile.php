<?php get_header( 'shop' ); ?>

    <div id="customer-profile" class="container page-wrap">
        <?php echo get_template_part('customer/inc/header') ?>

        <?php
        $user = new User();
        $customer = $user->getCustomer();
        ?>

        <div class="body-content">
            <div>
                <div class="row mt-4">
                    <div>
                        <div class="mandate-card">
                            <h3 class="mandate-card-title">Profile</h3>

                            <div class="row g-4">
                                <div class="col-12 col-md-6 mandate-col-divider">
                                    <div class="mandate-text">
                                        <div class="editable-field">
                                            <strong>Name:</strong>
                                            <?php
                                            echo trim(
                                                ($customer['title'] ?? '') . ' ' .
                                                ($customer['first_name'] ?? '') . ' ' .
                                                ($customer['last_name'] ?? '')
                                            );
                                            ?>
                                        </div>

                                        <div class="editable-field">
                                            <strong>Account Reference:</strong>
                                            <?php echo $customer['account_reference'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            <strong>Status:</strong>
                                            <?php echo $customer['status'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            <strong>Preferred Communication:</strong>
                                            <?php echo $customer['preferred_communication'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            <strong>Payment Method:</strong>
                                            <?php echo $customer['payment_method'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            <strong>Remaining Points:</strong>
                                            <?php echo $customer['remaining_points'] ?? '0'; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="mandate-text">
                                        <div class="editable-field">
                                            <strong>Email:</strong>
                                            <?php echo $customer['email'] ?? ''; ?>
                                        </div>

                                        <?php if (!empty($customer['secondary_email'])) { ?>
                                            <div class="editable-field">
                                                <strong>Secondary Email:</strong>
                                                <?php echo $customer['secondary_email']; ?>
                                            </div>
                                        <?php } ?>

                                        <div class="editable-field">
                                            <strong>Telephone:</strong>
                                            <?php echo $customer['telephone'] ?? ''; ?>
                                        </div>

                                        <?php if (!empty($customer['secondary_telephone'])) { ?>
                                            <div class="editable-field">
                                                <strong>Secondary Telephone:</strong>
                                                <?php echo $customer['secondary_telephone']; ?>
                                            </div>
                                        <?php } ?>

                                        <?php if (!empty($customer['mobile'])) { ?>
                                            <div class="editable-field">
                                                <strong>Mobile:</strong>
                                                <?php echo $customer['mobile']; ?>
                                            </div>
                                        <?php } ?>

                                        <?php if (!empty($customer['what_three_words'])) { ?>
                                            <div class="editable-field">
                                                <strong>What3Words:</strong>
                                                <?php echo $customer['what_three_words']; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <?php if (!empty($customer['notes'])) { ?>
                                    <div class="col-12">
                                        <h4 class="mandate-section-header">Notes</h4>

                                        <div class="mandate-text">
                                            <div class="editable-field">
                                                <?php echo nl2br(htmlspecialchars($customer['notes'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Delivery Details -->
                    <div class="col-12 col-md-6 mandate-col-divider">
                        <div class="mandate-card">
                            <h3 class="mandate-card-title">Delivery Details</h3>

                            <div class="row g-4">
                                <div class="col-12 col-md-6 mandate-col-divider">
                                    <h4 class="mandate-section-header">Address</h4>

                                    <div class="mandate-text">
                                        <div class="editable-field" data-field="delivery_address">
                                            <?php echo trim(
                                                ($customer['delivery_address']['housenumber'] ?? '') . ' ' .
                                                ($customer['delivery_address']['housename'] ?? '') . ' ' .
                                                ($customer['delivery_address']['streetname'] ?? '')
                                            ); ?>
                                        </div>

                                        <div class="editable-field" data-field="delivery_city">
                                            <?php echo $customer['delivery_address']['cityname'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field" data-field="delivery_postcode">
                                            <?php echo $customer['delivery_address']['postcode'] ?? ''; ?>
                                        </div>

                                        <?php if (!empty($customer['what_three_words'])) { ?>
                                            <div class="editable-field" data-field="delivery_w3w">
                                                What3Words: <?php echo $customer['what_three_words']; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mandate-col-divider">
                                    <h4 class="mandate-section-header">Route Information</h4>

                                    <div class="mandate-text">
                                        <div class="editable-field">
                                            <?php echo $customer['route']['name'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            Delivery day:
                                            <?php echo $customer['route']['day'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            Route ID:
                                            <?php echo $customer['route_id'] ?? ''; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Details -->
                    <div class="col-12 col-md-6 mandate-col-divider">
                        <div class="mandate-card">
                            <h3 class="mandate-card-title">Billing Details</h3>

                            <div class="row g-4">
                                <div class="col-12 col-md-6 mandate-col-divider">
                                    <h4 class="mandate-section-header">Address</h4>

                                    <div class="mandate-text">
                                        <div class="editable-field" data-field="billing_address">
                                            <?php echo trim(
                                                ($customer['billing_address']['housenumber'] ?? '') . ' ' .
                                                ($customer['billing_address']['housename'] ?? '') . ' ' .
                                                ($customer['billing_address']['streetname'] ?? '')
                                            ); ?>
                                        </div>

                                        <div class="editable-field" data-field="billing_city">
                                            <?php echo $customer['billing_address']['cityname'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field" data-field="billing_postcode">
                                            <?php echo $customer['billing_address']['postcode'] ?? ''; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mandate-col-divider">
                                    <h4 class="mandate-section-header">Customer Details</h4>

                                    <div class="mandate-text">
                                        <div class="editable-field">
                                            <?php
                                            echo trim(
                                                ($customer['title'] ?? '') . ' ' .
                                                ($customer['first_name'] ?? '') . ' ' .
                                                ($customer['last_name'] ?? '')
                                            );
                                            ?>
                                        </div>

                                        <div class="editable-field">
                                            <?php echo $customer['email'] ?? ''; ?>
                                        </div>

                                        <?php if (!empty($customer['secondary_email'])) { ?>
                                            <div class="editable-field">
                                                <?php echo $customer['secondary_email']; ?>
                                            </div>
                                        <?php } ?>

                                        <div class="editable-field">
                                            <?php echo $customer['telephone'] ?? ''; ?>
                                        </div>

                                        <?php if (!empty($customer['mobile'])) { ?>
                                            <div class="editable-field">
                                                Mobile: <?php echo $customer['mobile']; ?>
                                            </div>
                                        <?php } ?>

                                        <div class="editable-field">
                                            Account Ref:
                                            <?php echo $customer['account_reference'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            Status:
                                            <?php echo $customer['status'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            Payment Method:
                                            <?php echo $customer['payment_method'] ?? ''; ?>
                                        </div>

                                        <div class="editable-field">
                                            Preferred Communication:
                                            <?php echo $customer['preferred_communication'] ?? ''; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer( 'shop' ); ?>