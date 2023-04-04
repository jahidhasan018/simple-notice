<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( "VERSION", time() );

// Load frontend assets
function smn_frontend_assets(){
	
    $smn_select_post =  get_option('smn_select_post');
    if( is_page( $smn_select_post ) || $smn_select_post == 'all' || is_single( $smn_select_post ) ) {
        
        wp_enqueue_style( 'smn-frontend-style', plugins_url( "../assets/frontend/notice.css", __FILE__ ) );
        wp_enqueue_script( 'smn-cookie-js', plugins_url( "../assets/frontend/jquery.cookie.js", __FILE__), array('jquery'), VERSION, true );
        wp_enqueue_script( 'smn-notify-js', plugins_url( "../assets/frontend/notify.min.js", __FILE__), array('jquery', 'smn-frontend-js'), VERSION, true );
        wp_enqueue_script( 'smn-frontend-js', plugins_url( "../assets/frontend/notice.js", __FILE__), array('jquery'), VERSION, true );
        
        // Pass to script
        $smn_pass_script = array( 
            'smn_text'              => get_option('smn_notice_text'),
            'smn_hide'              => get_option('smn_hide'),
            'smn_hide_delay'        => get_option('smn_hide_delay'),
            'smn_position'          => get_option('smn_position'),
            'smn_style'             => get_option('smn_style'),
            'smn_cookie_expire'     => get_option('smn_cookie_expire')
        );
        
        wp_localize_script('smn-frontend-js', 'smn_notice', $smn_pass_script );
        
    }
    
}
add_action( 'wp_enqueue_scripts', 'smn_frontend_assets' );


// Admin Assets

function smn_admin_assets($page_now){
    
    if( $page_now == "settings_page_smn_notice" ){
        wp_enqueue_style( 'smn-admin-style', plugins_url( "../assets/admin/admin.css", __FILE__ ) );
        wp_enqueue_script( 'smn-admin-js', plugins_url( "../assets/admin/admin.js", __FILE__), array( 'jquery' ), VERSION, true  );
    }
    
}
add_action( 'admin_enqueue_scripts', 'smn_admin_assets' );

