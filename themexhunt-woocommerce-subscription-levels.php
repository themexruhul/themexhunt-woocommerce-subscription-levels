<?php
/*
Plugin Name: Themexhunt WooCommerce Subscription Levels
Description: Custom plugin to manage subscription levels based on points.
Version: 1.0
Author: Ruhul amin
Author URI: https://mramin.info/
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check if WooCommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // Include required files
    include_once(plugin_dir_path(__FILE__) . 'includes/themexhunt-points-system.php');
    include_once(plugin_dir_path(__FILE__) . 'includes/themexhunt-level-upgrade.php');
    include_once(plugin_dir_path(__FILE__) . 'includes/themexhunt-discounts.php');
    include_once(plugin_dir_path(__FILE__) . 'includes/class-themexhunt-settings.php');

    // Register settings
    add_filter('woocommerce_get_settings_pages', 'themexhunt_add_settings_page');
}

/**
 * Add a settings page to the WooCommerce settings.
 *
 * @param array $settings
 * @return array
 */
function themexhunt_add_settings_page($settings) {
    $settings[] = include('includes/class-themexhunt-settings.php');
    return $settings;
}