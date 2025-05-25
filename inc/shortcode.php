<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Handle the [smn_notice_btn] shortcode.
 *
 * Outputs a link that, when clicked, triggers a JavaScript notification.
 * Note: The 'hide' and 'style' attributes are defined but not currently used
 * by the JavaScript `notify()` options, which are hardcoded for those aspects.
 *
 * @since 1.0
 * @param array  $atts    Shortcode attributes.
 * @param string $content Shortcode content (not used).
 * @return string HTML output for the shortcode.
 */
function smn_notice_button_shortcode( $atts, $content = null ) {
    $default_atts = array(
        'text'            => __( 'Your button text', 'smn_notice' ),
        'url'             => '#',
        'class'           => 'smn-notice-btn', // User-defined class
        'hide_behavior'   => 'click',          // 'click' or 'auto'
        'position'        => 'top center',
        'style'           => 'bootstrap',
        'auto_hide_delay' => 3000,
        // 'type'         => 'info', // Example for future: if shortcode can override global type
    );
    $atts = shortcode_atts( $default_atts, $atts, 'smn_notice_btn' );

    // Enqueue the dedicated script for shortcode notice buttons
    wp_enqueue_script( 'smn-shortcode-js' );

    // Determine boolean values for data attributes based on hide_behavior
    $auto_hide     = ( $atts['hide_behavior'] === 'auto' );
    $click_to_hide = ( $atts['hide_behavior'] === 'click' );

    // Prepare data attributes
    // All values passed to esc_attr() will be correctly escaped.
    // Boolean to string conversion ('true'/'false') is standard for data attributes.
    // jQuery's .data() method will automatically convert these back to booleans.
    $output = sprintf(
        '<a class="%s smn-notice-btn-shortcode" href="%s" data-notice-text="%s" data-position="%s" data-click-to-hide="%s" data-auto-hide="%s" data-auto-hide-delay="%s" data-style="%s">%s</a>',
        esc_attr( $atts['class'] ), // User-defined class
        esc_url( $atts['url'] ),
        esc_attr( $atts['text'] ),
        esc_attr( $atts['position'] ),
        $click_to_hide ? 'true' : 'false',
        $auto_hide ? 'true' : 'false',
        esc_attr( (int) $atts['auto_hide_delay'] ),
        esc_attr( $atts['style'] ),
        esc_html( $atts['text'] ) // Display text for the link
    );

    return $output;
}
add_shortcode( 'smn_notice_btn', 'smn_notice_button_shortcode' );