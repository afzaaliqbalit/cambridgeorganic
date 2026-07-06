<div <?php echo is_user() ? '':'data-tooltip="login-tooltip-content"' ?>>
    <div class="stepper <?php echo is_user() ? '':'theme-orange disabled' ?>">
        <button class="stepper__btn stepper__btn--decrement" aria-label="Decrease value">&minus;</button>
        <input type="number" step="1" name="<?php //echo $name ?? '' ?>" class="stepper__value" min="1" value="1">
        <button class="stepper__btn stepper__btn--increment" aria-label="Increase value">&plus;</button>
    </div>
</div>