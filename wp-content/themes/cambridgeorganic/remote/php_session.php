<?php

// Register AJAX handlers.
add_action('wp_ajax_php_session', 'php_session_ajax');
add_action('wp_ajax_nopriv_php_session', 'php_session_ajax');

function php_session_ajax() {

    $action = isset($_POST['session_action']) ? sanitize_text_field($_POST['session_action']) : '';

    switch ($action) {

        case 'set':
            $key = sanitize_key($_POST['key']);

            $_SESSION[$key] = isset($_POST['value'])
                ? json_decode(stripslashes($_POST['value']), true)
                : null;

            wp_send_json_success($_SESSION[$key]);
            break;

        case 'get':
            $key = sanitize_key($_POST['key']);

            wp_send_json_success(isset($_SESSION[$key]) ? $_SESSION[$key] : null);
            break;

        case 'remove':
            $key = sanitize_key($_POST['key']);

            unset($_SESSION[$key]);

            wp_send_json_success(true);
            break;

        case 'has':
            $key = sanitize_key($_POST['key']);

            wp_send_json_success(isset($_SESSION[$key]));
            break;

        case 'clear':
            session_unset();

            wp_send_json_success(true);
            break;

        default:
            wp_send_json_error('Invalid session action.');
    }
}