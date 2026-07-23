<div class="user-login-wrapper">
    <!-- LEFT PANEL -->
    <div class="ul-left-panel rel">
        <div class="panel-wrapper">
            <h2 class="ul-heading-left">New Customer? Find out your delivery day:</h2>

            <div class="ul-van-wrapper">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-van.png">
            </div>

            <p class="ul-text">Enter your Postcode below and discover when<br>our delivery team are in your area:</p>

            <form id="validate-guest-postcode-form" class="validate w-100 prevent-enter">
                <div class="form-group">
                    <input type="text" class="ul-input-postcode guest-signup-postcode" placeholder="Enter your postcode (e.g. CB2 1FD)" required data-error="Your postcode is required.">
                </div>
                <button type="button" class="ul-btn button btn-primary" onclick="guest_postcode_delivery_modal(this)">Enter Postcode</button>
            </form>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="ul-right-panel">
        <form method="post" class="form validate ajax-submit" action="<?php echo remote_endpoint('customer-login') ?>">
            <h2 class="ul-heading-right">Existing Customer?</h2>

            <div class="ul-sign-in-box">
                <!-- Custom SVG User Icon from the image -->
                <h3 class="ul-subheading">Customers Sign In</h3>
            </div>

            <div class="ul-form-group">
                <label class="ul-label" style="width: 100px;">Email</label>
                <div class="input-group">
                    <input type="email" class="ul-input" placeholder="Email Address..." required data-error="Email address is required" name="user_email">
                </div>
            </div>

            <div class="ul-form-group">
                <label class="ul-label" style="width: 100px;">Password</label>
                <div class="input-group">
                    <input type="password" class="ul-input" placeholder="Password..." required data-error="Password is required" name="user_password">
                    <div id="default-error-message" class="error_message"></div>
                </div>
            </div>

            <div class="ul-btn-container">
                <button type="submit" class="ul-btn button btn-primary">  <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right: 4px; font-size: 18px;"></i>  Sign In </button>
            </div>
        </form>

        <p class="ul-forgot-pwd">
            <i class="fa-solid fa-circle-info"></i>
            <span><i class="icon-info"></i> If you have forgotten your Password,<br>please <a href="#">click here for help.</a></span>
        </p>
    </div>
</div>