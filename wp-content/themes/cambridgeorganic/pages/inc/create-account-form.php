<div class="create-account">

    <div style="max-width: 820px">
        <!-- Profile Section -->
        <div class="form-body inline-labels">
            <div class="form-head">
                <h3 class="d-flex align-items-center gap-3">
                    <i class="icon-user" style="--size: 40px"></i> Profile
                </h3>
            </div>

            <!-- Name Row (Title, First Name, Last Name) -->
            <div class="form-group">
                <label>Name</label>
                <div>
                    <div class="d-flex gap-3 w-100 flex-wrap flex-md-nowrap" style="max-width: 820px">
                        <!-- Title -->
                        <div style="width: 112px;">
                            <label>Title</label>
                            <select name="title" class="form-control">
                                <option value="">Select...</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>

                        <!-- First Name -->
                        <div class="w-100">
                            <div>
                                <label>First Name <span>*</span></label>
                                <input type="text" placeholder="Enter first name" name="firstname" class="form-control" required>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="w-100">
                            <div>
                                <label>Last Name <span>*</span></label>
                                <input type="text" placeholder="Enter last name" name="lastname" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Telephone -->
            <div class="form-group">
                <label>Telephone:</label>
                <div class="w-100">
                    <input type="tel" placeholder="Enter Tel" name="telephone" class="form-control">
                </div>
            </div>

            <!-- Secondary Telephone -->
            <div class="form-group">
                <label>Secondary Telephone:</label>
                <div class="w-100">
                    <input type="tel" placeholder="Enter Secondary Tel" name="secondary_telephone" class="form-control">
                </div>
            </div>

            <!-- Mobile -->
            <div class="form-group">
                <label>Mobile: <span>*</span></label>
                <div class="w-100">
                    <input type="tel" placeholder="" name="mobile" class="form-control" value="07823 134238" required>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email: <span>*</span></label>
                <div class="w-100">
                    <input type="email" placeholder="" name="email" class="form-control" value="testuser1@cambition.co.uk" required>
                </div>
            </div>

            <!-- Secondary Email -->
            <div class="form-group">
                <label>Secondary Email (optional):</label>
                <div class="w-100">
                    <input type="email" placeholder="Enter Secondary Email" name="secondary_email" class="form-control">
                </div>
            </div>

            <!-- Account Password -->
            <div class="form-group">
                <label>Account Password:</label>
                <div class="w-100">
                    <input type="password" placeholder="******" name="password" class="form-control">
                </div>
            </div>

        </div>

        <hr class="my-5">

        <!-- Deliveries Section -->
        <div class="form-body inline-labels mb-5">
            <div class="form-head mt-4">
                <h3 class="d-flex align-items-center gap-3">
                    <i class="icon-truck" style="width: 40px;height: 40px; background-color: var(--red)"></i> Delivery Address
                </h3>
            </div>

            <!-- House # -->
            <div class="form-group">
                <label>House # <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="house_number" class="form-control" required>
                </div>
            </div>

            <!-- Address Line 1 -->
            <div class="form-group">
                <label>Address Line 1 <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="address_line_1" class="form-control" required>
                </div>
            </div>

            <!-- Address Line 2 -->
            <div class="form-group">
                <label>Address Line 2 (Optional)</label>
                <div class="w-100">
                    <input type="text" placeholder="" name="address_line_2" class="form-control">
                </div>
            </div>

            <!-- Village / Town / City Name -->
            <div class="form-group">
                <label>Village / Town / City Name <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="city" class="form-control" required>
                </div>
            </div>

            <!-- Postcode -->
            <div class="form-group">
                <label>Postcode <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="postcode" class="form-control" required>
                </div>
            </div>

            <!-- Postcode -->
            <div class="form-group">
                <label>What3Words Location: <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="ww3_location" class="form-control" required>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <div class="form-body inline-labels mb-5">
            <div class="form-head mt-4">
                <h3 class="d-flex align-items-center gap-3">
                    <i class="icon-truck" style="width: 40px;height: 40px; background-color: var(--red)"></i> Billing Address
                </h3>
            </div>

            <!-- House # -->
            <div class="form-group">
                <label>House #: <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="billing_house_number" class="form-control" value="1" required>
                </div>
            </div>

            <!-- Address Line 1 -->
            <div class="form-group">
                <label>Address Line 1: <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="billing_address_line_1" class="form-control" value="Guthrie Courtt" required>
                </div>
            </div>

            <!-- Address Line 2 -->
            <div class="form-group">
                <label>Address Line 2 (Optional):</label>
                <div class="w-100">
                    <input type="text" placeholder="" name="billing_address_line_2" class="form-control" value="Paradise Street">
                </div>
            </div>

            <!-- Village / Town / City Name -->
            <div class="form-group">
                <label>Village / Town / City Name: <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="billing_city" class="form-control" value="Cambridge" required>
                </div>
            </div>

            <!-- Postcode -->
            <div class="form-group">
                <label>Postcode: <span>*</span></label>
                <div class="w-100">
                    <input type="text" placeholder="" name="billing_postcode" class="form-control" value="CB1 1" required>
                </div>
            </div>


        </div>

        <?php
        /*<hr class="my-5">

        <div class="form-body inline-labels mb-5">
            <div class="form-head">
                <div>
                    <h3 class="d-flex align-items-center gap-3">
                        <i class="icon-money" style="width: 40px;height: 40px; background-color: var(--red)"></i> Set Up your Payment: Direct Debit
                    </h3>
                    <p class="fs-14">Currently, our customers use only direct debit to pay for deliveries. You will only ever be charged AFTER an order has been delivered. We will be changing soon to also allow card payments.</p>
                </div>
            </div>

            <div class="mt-5">
                <div class="form-group">
                    <label>Contact Name <span>*</span></label>
                    <div class="w-100">

                        <input type="text" placeholder="" class="form-control" name="payment_contact_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Address Line 1 <span>*</span></label>
                    <div class="w-100">
                        <input type="text" placeholder="" class="form-control" name="payment_address_1" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Address Line 2 <span>*</span></label>
                    <div class="w-100">

                        <input type="text" placeholder="" class="form-control" name="payment_address_2" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Town / City <span>*</span></label>
                    <div class="w-100">
                        <input type="text" placeholder="" class="form-control" name="payment_city" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Postcode <span>*</span></label>
                    <div class="w-100" class="w-100">
                        <input type="text" placeholder="" class="form-control" name="payment_postcode" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Email Address  <span>*</span></label>
                    <div class="w-100">
                        <input type="text" placeholder="" class="form-control" name="payment_email_address" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Telephone <span>*</span></label>
                    <div class="w-100">
                        <input type="text" placeholder="" class="form-control" name="payment_telephone" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Account Holder Name <span>*</span></label>
                    <div class="w-100">
                        <input type="text" placeholder="" class="form-control" name="payment_account_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Sort Code <span>*</span></label>
                    <div class="w-100">
                        <input type="text" placeholder="" class="form-control" name="payment_sort_code" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Account Number <span>*</span></label>
                    <div class="w-100">
                        <input type="text" placeholder="" class="form-control" name="payment_account_number" required>
                    </div>
                </div>
            </div>

        </div>*/
        ?>

        <hr>

        <div class="form-body inline-labels pt-3">
            <div class="form-head">
                <h3 class="d-flex align-items-center gap-3">
                    Terms & Conditions
                </h3>
            </div>

            <div class="form-group">
                <div>
                    <label class="d-flex gap-2"><input type="checkbox" name="terms_conditions" value="1" required> Agree to Cambridge Organic Terms & Conditions <span class="red">*</span></label>
                    <p class="fs-14 pt-2">Please confirm you have read, agreed and consent to the Terms & Conditions and Privacy Policy</p>
                </div>
            </div>

        </div>
    </div>

</div>

<hr>

<div class="step-form pt-3">
    <?php //echo progress_dots(['count'=>6, 'active'=>5]); ?>

    <div class="d-flex gap-3 justify-content-center mt-5">
        <input type="hidden" name="route_id" value="" id="user_route_id">
        <button type="button" onclick="history.back()" data-action="prev" class="button btn-secondary">Back</button>
        <button type="submit" value="1" name="confirm_create_account" data-action="next" class="button btn-primary">Proceed & Checkout</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        const user_form = SessionStorage.get('user_signup_form');
        const get_route_id = user_form ? user_form.delivery_route : '';
        if(document.querySelector('#user_postcode')) {
            document.querySelector('#user_postcode').value = user_form ? user_form.postcode : '';;
        }
        if(document.querySelector('#user_route_id')) {
            document.querySelector('#user_route_id').value = get_route_id;
        }
    });
</script>