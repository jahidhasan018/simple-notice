<?php
/**
 * Plugin Name: Simple Notice
 * Plugin URI:  https://curetheme.com/plugins/simple-notice
 * Description: This plugin will allow you to show notice on front of your site.
 * Version:     1.0
 * Author:      CureTheme
 * Author URI:  https://curetheme.com.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: smn_notice
 * Domain Path: /languages
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'SMN_NOTICE_VERSION', '1.1.0' );
define( 'SMN_NOTICE_PATH', plugin_dir_path( __FILE__ ) );
define( 'SMN_NOTICE_URL', plugin_dir_url( __FILE__ ) );

/***************************
* Includes
***************************/
include SMN_NOTICE_PATH . 'inc/script.php';
include SMN_NOTICE_PATH . 'inc/admin-options.php';
include SMN_NOTICE_PATH . 'inc/shortcode.php';

/**
 * Load plugin textdomain for translations.
 */
function smn_notice_load_textdomain() {
	load_plugin_textdomain( 'smn_notice', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'smn_notice_load_textdomain' );


// Add settigns page link to plugin page
function smn_plugin_action_links( $links ) {
	$links = array_merge(
		array(
			'<a href="' . esc_url( admin_url( 'options-general.php?page=smn_notice' ) ) . '">' . esc_html__( 'Settings', 'smn_notice' ) . '</a>',
		),
		$links
	);

	return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'smn_plugin_action_links' );
