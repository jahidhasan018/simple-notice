<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Button shortcode
function smn_notice_button_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'text'     => __( 'Your button text', 'smn_notice' ),
			'url'      => '#',
			'class'    => 'smn-notice-btn',
			'hide'     => 'auto',
			'position' => 'top center',
			'style'    => 'bootstrap',
		),
		$atts
	);

	$class    = sanitize_html_class( $atts['class'] );
	$position = smn_notice_sanitize_position( $atts['position'] );
	$style    = smn_notice_sanitize_style( $atts['style'] );
	$hide     = 'click' === $atts['hide'] ? 'click' : 'auto';
	$text     = sanitize_text_field( $atts['text'] );
	$url      = esc_url( $atts['url'] );

	wp_enqueue_style( 'smn-frontend-style', SMN_NOTICE_URL . 'assets/frontend/notice.css', array(), SMN_NOTICE_VERSION );
	wp_enqueue_script( 'smn-cookie-js', SMN_NOTICE_URL . 'assets/frontend/jquery.cookie.js', array( 'jquery' ), SMN_NOTICE_VERSION, true );
	wp_enqueue_script( 'smn-notify-js', SMN_NOTICE_URL . 'assets/frontend/notify.min.js', array( 'jquery' ), SMN_NOTICE_VERSION, true );

	$auto_hide   = 'auto' === $hide;
	$notify_args = array(
		'position'      => $position,
		'clickToHide'   => ! $auto_hide,
		'autoHide'      => $auto_hide,
		'autoHideDelay' => 3000,
		'style'         => $style,
	);

	$script = sprintf(
		'jQuery(function($){$(".%1$s").notify(%2$s, %3$s);});',
		esc_js( $class ),
		wp_json_encode( $text ),
		wp_json_encode( $notify_args )
	);
	wp_add_inline_script( 'smn-notify-js', $script );

	return sprintf(
		'<a class="%1$s" href="%2$s">%3$s</a>',
		esc_attr( $class ),
		esc_url( $url ),
		esc_html( $text )
	);
}
add_shortcode( 'smn_notice_btn', 'smn_notice_button_shortcode' );
