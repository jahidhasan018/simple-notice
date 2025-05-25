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
 
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Define plugin version constant
if ( ! defined( 'SMN_VERSION' ) ) {
    define( 'SMN_VERSION', '1.0' );
}

/***************************
* Includes
***************************/
include( plugin_dir_path( __FILE__ ) . '/inc/script.php' );
include( plugin_dir_path( __FILE__ ) . '/inc/admin-options.php' );
include( plugin_dir_path( __FILE__ ) . '/inc/shortcode.php' );


/**
 * Add settings page link to plugin actions.
 *
 * @param array $links An array of plugin action links.
 * @return array An array of plugin action links.
 */
function smn_plugin_action_links( $links ) {
    $settings_link = '<a href="' . esc_url( admin_url( '/options-general.php?page=smn_notice' ) ) . '">' . __( 'Settings', 'smn_notice' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'smn_plugin_action_links' );