<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Load frontend assets (styles and scripts).
 *
 * @since 1.0
 */
function smn_frontend_assets() {
    // Register all frontend scripts
    wp_register_script( 'smn-cookie-js', plugins_url( "../assets/frontend/jquery.cookie.js", __FILE__ ), array( 'jquery' ), SMN_VERSION, true );
    wp_register_script( 'smn-notify-js', plugins_url( "../assets/frontend/notify.min.js", __FILE__ ), array( 'jquery', 'smn-cookie-js' ), SMN_VERSION, true );
    wp_register_script( 'smn-frontend-js', plugins_url( "../assets/frontend/notice.js", __FILE__ ), array( 'jquery', 'smn-notify-js' ), SMN_VERSION, true );
    wp_register_script( 'smn-shortcode-js', plugins_url( "../assets/frontend/shortcode-notice.js", __FILE__ ), array( 'jquery', 'smn-notify-js' ), SMN_VERSION, true );

    // Conditionally enqueue scripts for the main notice display
    $smn_select_post = get_option( 'smn_select_post' );
    if ( is_page( $smn_select_post ) || 'all' === $smn_select_post || is_single( $smn_select_post ) ) {
        wp_enqueue_style( 'dashicons' );
        wp_enqueue_style( 'smn-frontend-style', plugins_url( "../assets/frontend/notice.css", __FILE__ ), array(), SMN_VERSION );
        wp_enqueue_script( 'smn-frontend-js' ); // This will pull its dependencies: smn-notify-js, smn-cookie-js
        
        // Pass to script for the main notice
        $smn_pass_script = array(
            'smn_text'              => sanitize_text_field( get_option('smn_notice_text') ),
            'smn_hide'              => absint( get_option('smn_hide') ),
            'smn_hide_delay'        => absint( get_option('smn_hide_delay') ),
            'smn_position'          => sanitize_text_field( get_option('smn_position') ),
            'smn_style'             => sanitize_key( get_option('smn_style') ),
            'smn_cookie_expire'     => absint( get_option('smn_cookie_expire') ),
            'smn_notice_type'       => sanitize_key( get_option('smn_notice_type', 'info') ),
            'smn_notice_bg_color'   => sanitize_hex_color( get_option('smn_notice_bg_color', '') ),
            'smn_notice_text_color' => sanitize_hex_color( get_option('smn_notice_text_color', '') ),
            'smn_notice_icon'       => sanitize_html_class( get_option('smn_notice_icon', 'dashicons-info-outline') ),
            'smn_show_once_per_session' => absint( get_option('smn_show_once_per_session', '0') ) // Display Rule
        );
        wp_localize_script( 'smn-frontend-js', 'smn_notice', $smn_pass_script );
    }
}
add_action( 'wp_enqueue_scripts', 'smn_frontend_assets' );

/**
 * Load admin assets (styles and scripts).
 *
 * @since 1.0
 * @param string $page_now The current admin page hook.
 */
function smn_admin_assets( $page_now ) {
    if ( 'settings_page_smn_notice' === $page_now ) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'smn-admin-style', plugins_url( '../assets/admin/admin.css', __FILE__ ), array(), SMN_VERSION );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'smn-admin-js', plugins_url( '../assets/admin/admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), SMN_VERSION, true );
    }
}
add_action( 'admin_enqueue_scripts', 'smn_admin_assets' );

