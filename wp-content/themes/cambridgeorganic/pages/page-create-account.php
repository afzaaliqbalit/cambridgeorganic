<?php
/**
Template Name: Create Account
 */
?>
<?php get_header(); ?>

<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        if(!SessionStorage.get('user_signup_form')) {
            window.location = site_url
        }
    });
</script>

<?php
    if(empty($_SESSION['ordle-cart']['products']) || empty($_SESSION['ordle-cart']['routeDay'])) {
        wp_redirect(home_url());
        exit;
    }
    if(is_user()) {
        wp_redirect(home_url());
        exit;
    }
    //action="<?php echo esc_url(admin_url('admin-post.php'));
?>

<div class="container page-wrap">
    <form id="create_account_form" method="post" class="validate" autocomplete="off" action="<?php echo !empty($_POST['confirm_create_account']) ? esc_url(admin_url('admin-post.php')) : '' ?>">
        <div class="page-head pb-4">
            <div>
                <h1>Create Account</h1>
                <div class="caption-text">
                    <p>Please input the following information to activate your account. Fields highlighted with an asterisk (<span class="color-red">*</span>) are mandatory:</p>
                </div>
            </div>
        </div>

        <hr>

        <br>
        <br>
        <?php
            if(!empty($_POST['confirm_create_account'])) {
                echo get_template_part('pages/inc/confirm-account-form');
            }else {
                echo get_template_part('pages/inc/create-account-form');
            }
        ?>
    </form>
</div>

<?php get_footer(); ?>
