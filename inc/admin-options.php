<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register plugin page settigns
function smn_notice_register_settings(){

    register_setting( 'smn_options_group', 'smn_notice_text' );
    register_setting( 'smn_options_group', 'smn_select_post' );
    register_setting( 'smn_options_group', 'smn_hide' );
    register_setting( 'smn_options_group', 'smn_hide_delay' );
    register_setting( 'smn_options_group', 'smn_position' );
    register_setting( 'smn_options_group', 'smn_style' );
    register_setting( 'smn_options_group', 'smn_cookie_expire' );
    add_option( 'smn_hide_delay', '5000' );
    add_option( 'smn_cookie_expire', '0' );

    
}
add_action( 'admin_init', 'smn_notice_register_settings' );

// Create Option Page
function smn_options_page(){
    add_options_page( 'Simple Notice Settigns', 'Simple Notice', 'manage_options', 'smn_notice', 'smn_notice_display' );
}
add_action( 'admin_menu', 'smn_options_page' );

// Display options page
function smn_notice_display(){
    ?>
    
        <div class="wrap simple-notice">
            <h1>Simple Notice Settigns</h1>
            
            <form id="smn_notice_form" method="post" action="options.php">
                
                <?php 
                    settings_fields( 'smn_options_group' );
                    $smn_notice_text    = get_option('smn_notice_text');
                    $smn_select_post    = get_option('smn_select_post');
                    $smn_hide_val       = get_option('smn_hide');
                    $smn_hide_delay     = get_option('smn_hide_delay');
                    $smn_position       = get_option('smn_position');
                    $smn_style          = get_option('smn_style');
                    $smn_cookie_expire  = get_option('smn_cookie_expire');
                    
                ?>
                
                <!-- Smn Options Area -->
                <div class="smn_fields">
                    
                    <!-- Notice Text Field -->
                    <div class="smn_group">
                        <label for="smn_notice_text"><?php _e( 'Notice Text', 'smn_notice' ); ?></label>
                        <input type="text" id="smn_notice_text" name="smn_notice_text" value="<?php echo esc_attr( $smn_notice_text ); ?>" placeholder="Enter your text..." />
                    </div>
                    
                    <!-- Notification Page Field -->
                    <div class="smn_group">
                        <label for="smn_select_post"><?php _e( 'Select Page', 'smn_notice' ); ?></label>
                        <select id="smn_select_post" name="smn_select_post">
                            <option value="all" <?php echo ( $smn_select_post == 'all' ) ? "selected" : " "; ?> ><?php _e( 'All', 'smn_notice' ); ?></option>
                            
                            <!-- Pages -->
                            <option class="option_posts" disabled><?php _e( 'Pages', 'smn_notice' ); ?></option>
                            <?php 
                                $smn_pages = get_pages(); 
                                foreach ( $smn_pages as $page ) : ?>
                                    <option value="<?php echo esc_attr( $page->ID ); ?>" <?php echo ( $smn_select_post == $page->ID ) ? "selected" : " "; ?> >
                                        <?php echo esc_html( $page->post_title ); ?>
                                    </option>
                            <?php endforeach; ?>
                            
                            <!-- Posts -->
                            <option class="option_posts" disabled><?php _e( 'Posts', 'smn_notice' ); ?></option>
                            <?php 
                                global $post;
                                $args = array( 
                                        'posts_per_page' => -1
                                    );
                                $posts = get_posts( $args ); 
                                foreach ( $posts as $post ) : ?>
                                    <option value="<?php echo esc_attr( $post->ID ); ?>" <?php echo ( $smn_select_post == $post->ID ) ? "selected" : " "; ?> >
                                        <?php echo esc_html( $post->post_title ); ?>
                                    </option>
                            <?php endforeach; wp_reset_postdata();?>
                            
                        </select>
                    </div>
                    
                    <!-- Set how to hide the notice Field -->
                    <div class="smn_group">
                        <label for="smn_hide"><?php _e( 'Set how to hide the notice', 'smn_notice' ); ?></label>
                        <select id="smn_hide" name="smn_hide">
                          <option value="1" <?php echo ( $smn_hide_val == 1 ) ? "selected" : " "; ?> ><?php _e( 'Atuo Hide', 'smn_notice' ); ?></option>
                          <option value="2" <?php echo ( $smn_hide_val == 2 ) ? "selected" : " "; ?> ><?php _e( 'Click to Hide', 'smn_notice' ); ?></option>
                        </select>
                        
                        <div id="smn_delay_field">
                            <p class="description">Enter a number in milliseconds Defaut is: "5000"</p>
                            <input type="text" id="smn_hide_delay" name="smn_hide_delay" value="<?php echo esc_attr( $smn_hide_delay ); ?>" />
                        </div>
                        
                    </div>
                    
                    <!-- Notice Position Field -->
                    <div class="smn_group">
                        <label for="smn_position"><?php _e( 'Notice Position', 'smn_notice' ); ?></label>
                        <p class="description">Select notice bar position Defaut is: "bottom center"</p>
                        <select id="smn_position" name="smn_position">
                          <option value="left top" <?php echo ( $smn_position == 'left top' ) ? "selected" : " "; ?> ><?php _e( 'Top Left', 'smn_notice' ); ?></option>
                          <option value="top center" <?php echo ( $smn_position == 'top center' ) ? "selected" : " "; ?> ><?php _e( 'Top Center', 'smn_notice' ); ?></option>
                          <option value="top right" <?php echo ( $smn_position == 'top right' ) ? "selected" : " "; ?> ><?php _e( 'Top Right', 'smn_notice' ); ?></option>
                          <option value="left middle" <?php echo ( $smn_position == 'left middle' ) ? "selected" : " "; ?> ><?php _e( 'Left Middle', 'smn_notice' ); ?></option>
                          <option value="right middle" <?php echo ( $smn_position == 'right middle' ) ? "selected" : " "; ?> ><?php _e( 'Right Middle', 'smn_notice' ); ?></option>
                          <option value="left bottom" <?php echo ( $smn_position == 'left bottom' ) ? "selected" : " "; ?> ><?php _e( 'Bottom Left', 'smn_notice' ); ?></option>
                          <option value="bottom center" <?php echo ( $smn_position == 'bottom center' ) ? "selected" : " "; ?> ><?php _e( 'Bottom Center', 'smn_notice' ); ?></option>
                          <option value="right bottom" <?php echo ( $smn_position == 'right bottom' ) ? "selected" : " "; ?> ><?php _e( 'Bottom Right', 'smn_notice' ); ?></option>
                        </select>
                    </div>
                    
                    <!-- Notice Style Field -->
                    <div class="smn_group">
                        <label for="smn_style"><?php _e( 'Notice Style', 'smn_notice' ); ?></label>
                        <select id="smn_style" name="smn_style">
                          <option value="bootstrap" <?php echo ( $smn_style == 'bootstrap' ) ? "selected" : " "; ?> ><?php _e( 'Bootstrap', 'smn_notice' ); ?></option>
                          <option value="happyblue" <?php echo ( $smn_style == 'happyblue' ) ? "selected" : " "; ?> ><?php _e( 'Happy Blue', 'smn_notice' ); ?></option>
                          <option value="blackBg" <?php echo ( $smn_style == 'blackBg' ) ? "selected" : " "; ?> ><?php _e( 'Black BG', 'smn_notice' ); ?></option>
                        </select>
                    </div>
                    
                    <!-- Notice Time Field -->
                    <div class="smn_group">
                        <label for="smn_cookie_expire"><?php _e( 'Show notice after this days', 'smn_notice' ); ?></label>
                        <p class="description">How many days later you want to show the notice again? <strong>"0 for always"</strong></p>
                        <input type="number" id="smn_cookie_expire" name="smn_cookie_expire" value="<?php echo esc_attr( $smn_cookie_expire ); ?>" />
                    </div>
                    
                </div>
                
                <!-- Smn Shortcode area -->
                <div class="smn_shortcode">
                    <h2>You can use shortcode</h2>
                    <p class="description">You can use shortcode to show notification as button or link tooltip</p>
                    <code>
                        [smn_notice_btn text="My button" hide="auto" position="top" style="bootstrap"]
                    </code>
                </div>
                
                <?php submit_button(); ?>       
            </form>
        </div>
    
    <?php
}