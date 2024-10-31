<?php
/**
 * PHP version 7
 * Plugin Name: Pay Now Button with GiyaPay
 * Plugin URI: https://cynder.io
 * Description: Add Pay Now Button using GiyaPay
 * Author: CynderTech
 * Author URI: http://cynder.io
 * Version: 1.0.1
 * Requires at least: 5.3.2
 * Tested up to: 7.0
 */

/** Can't access this file directly */
if (!defined('ABSPATH')) {
    exit;
}

/** Register stylesheet for admin page */
function register_giyapay_styles() {
    wp_register_style('giyapay-now-admin', plugins_url('giyapay-admin.css', __FILE__));
    wp_enqueue_style('giyapay-now-admin');
}
add_action('admin_enqueue_scripts', 'register_giyapay_styles');

function register_giyapay_fe_styles() {
    wp_register_style('giyapay-now', plugins_url('giyapay.css', __FILE__));
    wp_enqueue_style('giyapay-now');
}
add_action('wp_enqueue_scripts', 'register_giyapay_fe_styles');

/** Define primary GiyaPay settings */
define('GIYAPAY_SETTINGS_KEY', 'giyapay_now_settings_options');

/** Activation/deactivation/uninstall hooks */
register_activation_hook(__FILE__, 'giyapay_now_activate');
register_deactivation_hook(__FILE__ , 'giyapay_now_deactivate');
register_uninstall_hook(__FILE__, 'giyapay_now_uninstall');

const GIYAPAY_PRODUCTION_URL = 'https://pay.giyapay.com';
const GIYAPAY_SANDBOX_URL = 'https://sandbox.giyapay.com';

const GIYAPAY_PLUGIN_MODE_SANDBOX = 'sandbox';
const GIYAPAY_PLUGIN_MODE_PRODUCTION = 'production';
const GIYAPAY_PLUGIN_MODES = [
    GIYAPAY_PLUGIN_MODE_SANDBOX,
    GIYAPAY_PLUGIN_MODE_PRODUCTION,
];

/** On activate, set configuration values */
function giyapay_now_activate() {
    $giyapay_now_settings_options = array(
        'merchant_id' => '',
        'api_key' => '',
        'success_callback' => '',
        'error_callback' => '',
        'cancel_callback' => '',
        'plugin_mode' => GIYAPAY_PLUGIN_MODE_PRODUCTION,
    );

    add_option(GIYAPAY_SETTINGS_KEY, $giyapay_now_settings_options);
}

/** On deactivate, delete existing configuration values */
function giyapay_now_deactivate() {
    delete_option(GIYAPAY_SETTINGS_KEY);
}

/** Nothing to do on uninstall for now */
function giyapay_now_uninstall() {}

add_action('admin_menu', 'giyapay_now_menu');

function giyapay_now_menu() {
    add_options_page('GiyaPay Button', 'GiyaPay Button', 'manage_options', 'wp-giyapay-settings', 'wp_giyapay_settings');
}

function wp_giyapay_settings() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    if (isset($_POST['update'])) {
        $nonce = $_REQUEST['_wpnonce'];

        if (!wp_verify_nonce($nonce, 'giyapay_settings_form_post')) {
            echo 'Nonce verification failed';
            exit;
        }

        if (!in_array($_POST['plugin_mode'], GIYAPAY_PLUGIN_MODES)) {
            echo 'Invalid plugin mode';
            exit;
        }

        validate_giyapay_callback_url($_POST['success_callback'], 'success');
        validate_giyapay_callback_url($_POST['error_callback'], 'error');
        validate_giyapay_callback_url($_POST['cancel_callback'], 'cancel');

        $options['merchant_id'] = sanitize_text_field($_POST['merchant_id']);
        $options['api_key'] = sanitize_text_field($_POST['api_key']);
        $options['success_callback'] = sanitize_text_field($_POST['success_callback']);
        $options['error_callback'] = sanitize_text_field($_POST['error_callback']);
        $options['cancel_callback'] = sanitize_text_field($_POST['cancel_callback']);
        $options['plugin_mode'] = sanitize_text_field($_POST['plugin_mode']);

        update_option(GIYAPAY_SETTINGS_KEY, $options);
    }

    $value = get_giyapay_settings();

    require_once 'giyapay-settings-form.php';
}

/** Actual GiyaPay Button/form */
function giyapay_now($atts) {
    $options = get_giyapay_settings();

    $final_attributes = shortcode_atts(array(
        'currency' => 'PHP',
        'amount' => '0',
        'description' => '',
    ), $atts);

    $final_amount = floatval($final_attributes['amount']);
    $final_amount = $final_amount * 100;

    $time_now = time();
    $nonce = wp_create_nonce(time());

    $signature_payload = $options['merchant_id'] . strval($final_amount) . $final_attributes['currency'] . $time_now . $nonce . $options['api_key'];

    $signature = hash("sha512", $signature_payload);

    $success_callback = get_final_giyapay_callback_url($options['success_callback']);
    $error_callback = get_final_giyapay_callback_url($options['error_callback']);
    $cancel_callback = get_final_giyapay_callback_url($options['cancel_callback']);
    $form_base_url = $options['plugin_mode'] === GIYAPAY_PLUGIN_MODE_PRODUCTION ? GIYAPAY_PRODUCTION_URL : GIYAPAY_SANDBOX_URL;
        
    ob_start();
    include 'giyapay-button.php';
    return ob_get_clean();
}

add_shortcode('giyapay', 'giyapay_now');

function get_giyapay_settings() {
    $options = get_option(GIYAPAY_SETTINGS_KEY);
    foreach ($options as $k => $v) { $value[$k] = $v; }

    return $value;
}

function get_final_giyapay_callback_url($url) {
    if (str_starts_with($url, '/')) {
        return get_bloginfo('url') . $url;
    }

    return $url;
}

function validate_giyapay_callback_url($url, $type) {
    if (!empty($url) && !str_starts_with($url, '/') && !str_starts_with($url, 'http')) {
        echo "Invalid $type callback URL";
        exit;
    }
}