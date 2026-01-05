<?php
/**
 * Plugin Name: Weight Based Pricing for WooCommerce
 * Plugin URI: https://www.themeparrot.com/
 * Description: Weight Based Product Pricing for WooCommerce helps you to set product price based on the weight.
 * Version: 1.1.6
 * Author: Themeparrot
 * Author URI: https://themeparrot.com/
 * Text Domain: weight-based-pricing-woocommerce
 * Domain Path: /i18n/languages
 * Requires at least: 4.9.0
 * Requires PHP: 5.6
 * WC requires at least: 3.0.0
 * WC tested up to: 9.2.3
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * 
 * WC HPOS Compatibility: yes
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// This plugin constants
defined('WWBP_PLUGIN_NAME') or define('WWBP_PLUGIN_NAME', 'Weight Based Pricing for WooCommerce');
defined('WWBP_PLUGIN_VERSION') or define('WWBP_PLUGIN_VERSION', '1.1.6');

defined('WWBP_PLUGIN_FILE') or define('WWBP_PLUGIN_FILE', __FILE__);
defined('WWBP_PLUGIN_PATH') or define('WWBP_PLUGIN_PATH', plugin_dir_path(__FILE__));

defined('WWBP_PLUGIN_URL') or define('WWBP_PLUGIN_URL', plugin_dir_url(__FILE__));
defined('WWBP_WP_ADMIN_URL') or define('WWBP_WP_ADMIN_URL', admin_url('admin.php'));
defined('WWBP_WP_ADMIN_AJAX_URL') or define('WWBP_WP_ADMIN_AJAX_URL', admin_url('admin-ajax.php'));

defined('WWBP_PLUGIN_SLUG') or define('WWBP_PLUGIN_SLUG', 'weight-based-pricing-woocommerce');
defined('WWBP_PLUGIN_TEXT_DOMAIN') or define('WWBP_PLUGIN_TEXT_DOMAIN', 'weight-based-pricing-woocommerce');

// Required dependencies version
defined('WWBP_REQUIRED_PHP_VERSION') or define('WWBP_REQUIRED_PHP_VERSION', 5.6);
defined('WWBP_REQUIRED_WC_VERSION') or define('WWBP_REQUIRED_WC_VERSION', '3.0.0');

// Initialize MVC Framework
require_once WWBP_PLUGIN_PATH . '/vendor/autoload.php';
new WWBP\App\Boot(); // Start Plugin

add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );