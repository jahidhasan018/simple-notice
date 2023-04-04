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

/***************************
* Includes
***************************/
include( plugin_dir_path( __FILE__ ) . '/inc/script.php' );
include( plugin_dir_path( __FILE__ ) . '/inc/admin-options.php' );
include( plugin_dir_path( __FILE__ ) . '/inc/shortcode.php' );


// Add settigns page link to plugin page
function smn_plugin_action_links( $links ){
    
    $links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/options-general.php?page=smn_notice' ) ) . '">' . __( 'Settings', 'smn_notice' ) . '</a>'
	), $links );
    return $links;
    
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'smn_plugin_action_links' );