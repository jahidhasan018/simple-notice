<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get allowed notice positions.
 *
 * @return string[]
 */
function smn_notice_positions() {
	return array(
		'left top',
		'top center',
		'top right',
		'left middle',
		'right middle',
		'left bottom',
		'bottom center',
		'right bottom',
	);
}

/**
 * Get allowed notice styles.
 *
 * @return string[]
 */
function smn_notice_styles() {
	return array(
		'bootstrap',
		'happyblue',
		'blackBg',
	);
}

// Load frontend assets
function smn_frontend_assets() {
	$smn_select_post = get_option( 'smn_select_post', 'all' );
	$smn_enable      = (int) get_option( 'smn_enable_notice', 1 );

	if ( ! $smn_enable ) {
		return;
	}

	if ( 'all' === $smn_select_post || is_page( (int) $smn_select_post ) || is_single( (int) $smn_select_post ) ) {
		wp_enqueue_style( 'smn-frontend-style', SMN_NOTICE_URL . 'assets/frontend/notice.css', array(), SMN_NOTICE_VERSION );
		wp_enqueue_script( 'smn-cookie-js', SMN_NOTICE_URL . 'assets/frontend/jquery.cookie.js', array( 'jquery' ), SMN_NOTICE_VERSION, true );
		wp_enqueue_script( 'smn-notify-js', SMN_NOTICE_URL . 'assets/frontend/notify.min.js', array( 'jquery' ), SMN_NOTICE_VERSION, true );
		wp_enqueue_script( 'smn-frontend-js', SMN_NOTICE_URL . 'assets/frontend/notice.js', array( 'jquery', 'smn-cookie-js', 'smn-notify-js' ), SMN_NOTICE_VERSION, true );

		$smn_position = get_option( 'smn_position', 'bottom center' );
		$smn_style    = get_option( 'smn_style', 'bootstrap' );

		// Pass to script.
		$smn_pass_script = array(
			'smn_text'          => wp_strip_all_tags( (string) get_option( 'smn_notice_text', '' ) ),
			'smn_hide'          => (int) get_option( 'smn_hide', 1 ),
			'smn_hide_delay'    => (int) get_option( 'smn_hide_delay', 5000 ),
			'smn_position'      => in_array( $smn_position, smn_notice_positions(), true ) ? $smn_position : 'bottom center',
			'smn_style'         => in_array( $smn_style, smn_notice_styles(), true ) ? $smn_style : 'bootstrap',
			'smn_cookie_expire' => (int) get_option( 'smn_cookie_expire', 0 ),
			'smn_hide_mobile'   => (int) get_option( 'smn_hide_mobile', 0 ),
		);

		wp_localize_script( 'smn-frontend-js', 'smn_notice', $smn_pass_script );
	}
}
add_action( 'wp_enqueue_scripts', 'smn_frontend_assets' );


// Admin Assets

function smn_admin_assets( $page_now ) {
	if ( 'settings_page_smn_notice' === $page_now ) {
		wp_enqueue_style( 'smn-admin-style', SMN_NOTICE_URL . 'assets/admin/admin.css', array(), SMN_NOTICE_VERSION );
		wp_enqueue_script( 'smn-admin-js', SMN_NOTICE_URL . 'assets/admin/admin.js', array( 'jquery' ), SMN_NOTICE_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'smn_admin_assets' );
