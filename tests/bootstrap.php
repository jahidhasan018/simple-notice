<?php

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

if ( ! defined( 'SMN_NOTICE_URL' ) ) {
	define( 'SMN_NOTICE_URL', 'http://example.com/' );
}

if ( ! defined( 'SMN_NOTICE_VERSION' ) ) {
	define( 'SMN_NOTICE_VERSION', '1.1.0' );
}

if ( ! function_exists( 'add_action' ) ) {
	function add_action() {
		return null;
	}
}

if ( ! function_exists( 'sanitize_text_field' ) ) {
	function sanitize_text_field( $value ) {
		if ( is_scalar( $value ) ) {
			return trim( strip_tags( (string) $value ) );
		}

		return '';
	}
}

if ( ! function_exists( 'absint' ) ) {
	function absint( $value ) {
		return abs( (int) $value );
	}
}

require_once __DIR__ . '/../inc/script.php';
require_once __DIR__ . '/../inc/admin-options.php';
