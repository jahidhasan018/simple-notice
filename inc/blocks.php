<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Render callback for the notice button block.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function smn_notice_render_block( $attributes ) {
	return smn_notice_button_shortcode( $attributes );
}

/**
 * Register Gutenberg blocks for Simple Notice.
 */
function smn_notice_register_blocks() {
	wp_register_script(
		'smn-notice-block',
		SMN_NOTICE_URL . 'assets/admin/block.js',
		array( 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-block-editor', 'wp-components', 'wp-server-side-render' ),
		SMN_NOTICE_VERSION,
		true
	);

	register_block_type(
		SMN_NOTICE_PATH . 'inc/blocks/notice-button',
		array(
			'editor_script'   => 'smn-notice-block',
			'render_callback' => 'smn_notice_render_block',
		)
	);
}
add_action( 'init', 'smn_notice_register_blocks' );
