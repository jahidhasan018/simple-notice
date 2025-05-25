<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Register plugin settings.
 *
 * @since 1.0
 */
function smn_notice_register_settings() {
    register_setting( 'smn_options_group', 'smn_notice_text' );
    register_setting( 'smn_options_group', 'smn_select_post' );
    register_setting( 'smn_options_group', 'smn_hide' );
    register_setting( 'smn_options_group', 'smn_hide_delay' );
    register_setting( 'smn_options_group', 'smn_position' );
    register_setting( 'smn_options_group', 'smn_style' );
    register_setting( 'smn_options_group', 'smn_cookie_expire' );
    register_setting( 'smn_options_group', 'smn_notice_type' );
    register_setting( 'smn_options_group', 'smn_notice_bg_color' );
    register_setting( 'smn_options_group', 'smn_notice_text_color' );
    register_setting( 'smn_options_group', 'smn_notice_icon' ); // Icon support
    add_option( 'smn_hide_delay', '5000' );
    add_option( 'smn_cookie_expire', '0' );
    add_option( 'smn_notice_type', 'info' );
    add_option( 'smn_notice_bg_color', '' );
    add_option( 'smn_notice_text_color', '' );
    add_option( 'smn_notice_icon', 'dashicons-info-outline' );
    add_option( 'smn_show_once_per_session', '0' ); // Display Rule: Default to 'No' (every page load)
}
add_action( 'admin_init', 'smn_notice_register_settings' );

/**
 * Add options page.
 *
 * @since 1.0
 */
function smn_options_page() {
    add_options_page(
        __( 'Simple Notice Settings', 'smn_notice' ),
        __( 'Simple Notice', 'smn_notice' ),
        'manage_options',
        'smn_notice',
        'smn_notice_display'
    );
}
add_action( 'admin_menu', 'smn_options_page' );

/**
 * Display the plugin options page.
 *
 * @since 1.0
 */
function smn_notice_display() {
    ?>
    <div class="wrap simple-notice">
        <h1><?php _e( 'Simple Notice Settings', 'smn_notice' ); ?></h1>
            
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
                    $smn_notice_type    = get_option('smn_notice_type', 'info');
                    $smn_notice_bg_color       = get_option( 'smn_notice_bg_color', '' );
                    $smn_notice_text_color     = get_option( 'smn_notice_text_color', '' );
                    $smn_notice_icon           = get_option( 'smn_notice_icon', 'dashicons-info-outline' );
                    $smn_show_once_per_session = get_option( 'smn_show_once_per_session', '0' ); // Retrieve display rule
                ?>
                
                <!-- Smn Options Area -->
                <div class="smn_fields">

                    <div class="smn-admin-section">
                        <h3><?php _e( 'Content & Behavior', 'smn_notice' ); ?></h3>

                        <!-- Notice Text Field -->
                        <div class="smn_group">
                            <label for="smn_notice_text"><?php _e( 'Notice Text', 'smn_notice' ); ?></label>
                            <input type="text" id="smn_notice_text" name="smn_notice_text" value="<?php echo esc_attr( $smn_notice_text ); ?>" placeholder="<?php esc_attr_e( 'Enter your text...', 'smn_notice' ); ?>" />
                        </div>

                        <!-- Notice Icon Field -->
                        <div class="smn_group">
                            <label for="smn_notice_icon"><?php _e( 'Notice Icon', 'smn_notice' ); ?></label>
                            <select id="smn_notice_icon" name="smn_notice_icon">
                                <option value="none" <?php selected( $smn_notice_icon, 'none' ); ?>><?php _e( 'None', 'smn_notice' ); ?></option>
                                <option value="dashicons-info-outline" <?php selected( $smn_notice_icon, 'dashicons-info-outline' ); ?>><?php _e( 'Info (Outline)', 'smn_notice' ); ?></option>
                                <option value="dashicons-info" <?php selected( $smn_notice_icon, 'dashicons-info' ); ?>><?php _e( 'Info (Solid)', 'smn_notice' ); ?></option>
                                <option value="dashicons-yes-alt" <?php selected( $smn_notice_icon, 'dashicons-yes-alt' ); ?>><?php _e( 'Success (Tick)', 'smn_notice' ); ?></option>
                                <option value="dashicons-warning" <?php selected( $smn_notice_icon, 'dashicons-warning' ); ?>><?php _e( 'Warning', 'smn_notice' ); ?></option>
                                <option value="dashicons-dismiss" <?php selected( $smn_notice_icon, 'dashicons-dismiss' ); ?>><?php _e( 'Error (Dismiss)', 'smn_notice' ); ?></option>
                                <option value="dashicons-lightbulb" <?php selected( $smn_notice_icon, 'dashicons-lightbulb' ); ?>><?php _e( 'Lightbulb', 'smn_notice' ); ?></option>
                                <option value="dashicons-megaphone" <?php selected( $smn_notice_icon, 'dashicons-megaphone' ); ?>><?php _e( 'Megaphone', 'smn_notice' ); ?></option>
                                <option value="dashicons-admin-generic" <?php selected( $smn_notice_icon, 'dashicons-admin-generic' ); ?>><?php _e( 'Settings Cog', 'smn_notice' ); ?></option>
                                <option value="dashicons-star-filled" <?php selected( $smn_notice_icon, 'dashicons-star-filled' ); ?>><?php _e( 'Star', 'smn_notice' ); ?></option>
                            </select>
                            <p class="description"><?php _e( 'Select a Dashicon to display before the notice text.', 'smn_notice' ); ?></p>
                        </div>

                        <!-- Notification Page Field -->
                        <div class="smn_group">
                            <label for="smn_select_post"><?php _e( 'Display on Pages/Posts', 'smn_notice' ); ?></label>
                        <select id="smn_select_post" name="smn_select_post">
                            <option value="all" <?php selected( $smn_select_post, 'all' ); ?>><?php _e( 'All', 'smn_notice' ); ?></option>
                            
                            <!-- Pages -->
                            <optgroup label="<?php _e( 'Pages', 'smn_notice' ); ?>">
                            <?php 
                                $smn_pages = get_pages(); 
                                foreach ( $smn_pages as $page ) : ?>
                                    <option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $smn_select_post, $page->ID ); ?>>
                                        <?php echo esc_html( $page->post_title ); ?>
                                    </option>
                            <?php endforeach; ?>
                            </optgroup>
                            
                            <!-- Posts -->
                            <optgroup label="<?php _e( 'Posts', 'smn_notice' ); ?>">
                            <?php 
                                global $post;
                                $args = array( 
                                    'posts_per_page' => -1,
                                    'post_status'    => 'publish',
                                );
                                $posts_array = get_posts( $args ); // Renamed to avoid conflict with global $post
                                foreach ( $posts_array as $custom_post ) : // Changed $post to $custom_post
                                    ?>
                                    <option value="<?php echo esc_attr( $custom_post->ID ); ?>" <?php selected( $smn_select_post, $custom_post->ID ); ?>>
                                        <?php echo esc_html( $custom_post->post_title ); ?>
                                    </option>
                            <?php endforeach; wp_reset_postdata(); ?>
                            </optgroup>
                        </select>
                        <p class="description"><?php _e( 'Select where the notice should be displayed.', 'smn_notice' ); ?></p>
                    </div>
                    </div> <!-- .smn-admin-section (Content & Behavior) -->

                    <div class="smn-admin-section">
                        <h3><?php _e( 'Appearance', 'smn_notice' ); ?></h3>

                        <!-- Notice Type Field -->
                        <div class="smn_group">
                            <label for="smn_notice_type"><?php _e( 'Notice Type', 'smn_notice' ); ?></label>
                            <select id="smn_notice_type" name="smn_notice_type">
                              <option value="info" <?php selected( $smn_notice_type, 'info' ); ?> ><?php _e( 'Info', 'smn_notice' ); ?></option>
                              <option value="success" <?php selected( $smn_notice_type, 'success' ); ?> ><?php _e( 'Success', 'smn_notice' ); ?></option>
                              <option value="warning" <?php selected( $smn_notice_type, 'warning' ); ?> ><?php _e( 'Warning', 'smn_notice' ); ?></option>
                              <option value="error" <?php selected( $smn_notice_type, 'error' ); ?> ><?php _e( 'Error', 'smn_notice' ); ?></option>
                            </select>
                        </div>
                        
                        <!-- Notice Style Field -->
                        <div class="smn_group">
                            <label for="smn_style"><?php _e( 'Notice Style (Base Theme)', 'smn_notice' ); ?></label>
                            <select id="smn_style" name="smn_style">
                              <option value="bootstrap" <?php selected( $smn_style, 'bootstrap' ); ?>><?php _e( 'Bootstrap', 'smn_notice' ); ?></option>
                              <option value="happyblue" <?php selected( $smn_style, 'happyblue' ); ?>><?php _e( 'Happy Blue', 'smn_notice' ); ?></option>
                              <option value="blackBg" <?php selected( $smn_style, 'blackBg' ); ?>><?php _e( 'Black BG', 'smn_notice' ); ?></option>
                            </select>
                             <p class="description"><?php _e( 'Base style from notify.js. The Notice Type (Info, Success etc.) will apply semantic colors on top.', 'smn_notice' ); ?></p>
                        </div>

                        <!-- Notice Background Color Field -->
                        <div class="smn_group">
                            <label for="smn_notice_bg_color"><?php _e( 'Notice Background Color (Overrides Type/Theme)', 'smn_notice' ); ?></label>
                            <input type="text" id="smn_notice_bg_color" name="smn_notice_bg_color" value="<?php echo esc_attr( $smn_notice_bg_color ); ?>" class="smn-color-picker" data-default-color="" />
                            <p class="description"><?php _e( 'Leave blank to use colors from the selected Notice Type or Base Theme.', 'smn_notice' ); ?></p>
                        </div>

                        <!-- Notice Text Color Field -->
                        <div class="smn_group">
                            <label for="smn_notice_text_color"><?php _e( 'Notice Text Color (Overrides Type/Theme)', 'smn_notice' ); ?></label>
                            <input type="text" id="smn_notice_text_color" name="smn_notice_text_color" value="<?php echo esc_attr( $smn_notice_text_color ); ?>" class="smn-color-picker" data-default-color="" />
                            <p class="description"><?php _e( 'Leave blank to use colors from the selected Notice Type or Base Theme.', 'smn_notice' ); ?></p>
                        </div>

                        <!-- Notice Position Field -->
                        <div class="smn_group">
                            <label for="smn_position"><?php _e( 'Notice Position', 'smn_notice' ); ?></label>
                            <p class="description"><?php _e( 'Select notice bar position. Default is: "bottom center".', 'smn_notice' ); ?></p>
                            <select id="smn_position" name="smn_position">
                              <option value="left top" <?php selected( $smn_position, 'left top' ); ?>><?php _e( 'Top Left', 'smn_notice' ); ?></option>
                              <option value="top center" <?php selected( $smn_position, 'top center' ); ?>><?php _e( 'Top Center', 'smn_notice' ); ?></option>
                              <option value="top right" <?php selected( $smn_position, 'top right' ); ?>><?php _e( 'Top Right', 'smn_notice' ); ?></option>
                              <option value="left middle" <?php selected( $smn_position, 'left middle' ); ?>><?php _e( 'Left Middle', 'smn_notice' ); ?></option>
                              <option value="right middle" <?php selected( $smn_position, 'right middle' ); ?>><?php _e( 'Right Middle', 'smn_notice' ); ?></option>
                              <option value="left bottom" <?php selected( $smn_position, 'left bottom' ); ?>><?php _e( 'Bottom Left', 'smn_notice' ); ?></option>
                              <option value="bottom center" <?php selected( $smn_position, 'bottom center' ); ?>><?php _e( 'Bottom Center', 'smn_notice' ); ?></option>
                              <option value="right bottom" <?php selected( $smn_position, 'right bottom' ); ?>><?php _e( 'Bottom Right', 'smn_notice' ); ?></option>
                            </select>
                        </div>
                    </div> <!-- .smn-admin-section (Appearance) -->

                    <div class="smn-admin-section">
                        <h3><?php _e( 'Hiding & Display Rules', 'smn_notice' ); ?></h3>
                        <!-- Set how to hide the notice Field -->
                        <div class="smn_group">
                            <label for="smn_hide"><?php _e( 'Hiding Behavior', 'smn_notice' ); ?></label>
                            <select id="smn_hide" name="smn_hide">
                              <option value="1" <?php selected( $smn_hide_val, '1' ); ?>><?php _e( 'Auto Hide', 'smn_notice' ); ?></option>
                              <option value="2" <?php selected( $smn_hide_val, '2' ); ?>><?php _e( 'Click to Hide', 'smn_notice' ); ?></option>
                            </select>
                        </div>
                        
                        <!-- Auto Hide Delay Field (conditionally shown) -->
                        <div class="smn_group" id="smn_delay_field"> <!-- ID kept for JS targeting -->
                            <label for="smn_hide_delay"><?php _e( 'Auto Hide Delay (ms)', 'smn_notice' ); ?></label>
                            <input type="text" id="smn_hide_delay" name="smn_hide_delay" value="<?php echo esc_attr( $smn_hide_delay ); ?>" />
                            <p class="description"><?php _e( 'Enter a number in milliseconds. Default is: "5000".', 'smn_notice' ); ?></p>
                        </div>

                        <!-- Display Rule Field -->
                        <div class="smn_group">
                            <label for="smn_show_once_per_session"><?php _e( 'Display Frequency', 'smn_notice' ); ?></label>
                            <select id="smn_show_once_per_session" name="smn_show_once_per_session">
                                <option value="0" <?php selected( $smn_show_once_per_session, '0' ); ?>><?php _e( 'Show on every page load (default)', 'smn_notice' ); ?></option>
                                <option value="1" <?php selected( $smn_show_once_per_session, '1' ); ?>><?php _e( 'Show only once per browser session', 'smn_notice' ); ?></option>
                            </select>
                            <p class="description"><?php _e( 'Controls how often the notice is shown to a user initially.', 'smn_notice' ); ?></p>
                        </div>

                        <!-- Notice Time Field (Persistent Cookie) -->
                        <div class="smn_group">
                            <label for="smn_cookie_expire"><?php _e( 'Re-show After Hiding (Days)', 'smn_notice' ); ?></label>
                            <p class="description">
                                <?php _e( 'If the notice was hidden (by click/auto-hide), show it again after this many days. <strong>"0" means no persistent cookie (it will re-appear next session/page load based on Display Frequency).</strong>', 'smn_notice' ); ?><br/>
                            </p>
                            <input type="number" id="smn_cookie_expire" name="smn_cookie_expire" value="<?php echo esc_attr( $smn_cookie_expire ); ?>" />
                        </div>
                    </div> <!-- .smn-admin-section (Hiding & Display Rules) -->
                </div> <!-- .smn_fields -->
                
                <div class="smn-admin-section">
                    <h3><?php _e( 'Shortcode Information', 'smn_notice' ); ?></h3>
                    <p class="description"><?php _e( 'You can use the following shortcode to display the notice as a button or link tooltip within your content:', 'smn_notice' ); ?></p>
                    <code>
                        [smn_notice_btn text="<?php esc_attr_e( 'My Button Text', 'smn_notice' ); ?>" url="#" class="my-custom-class" hide_behavior="auto" position="top center" style="bootstrap" auto_hide_delay="5000"]
                    </code>
                    <p class="description">
                        <?php _e( 'Available attributes:', 'smn_notice' ); ?><br>
                        - `text`: <?php _e( 'The text for the button/link.', 'smn_notice' ); ?><br>
                        - `url`: <?php _e( 'The URL the button/link points to (use # for just triggering notice).', 'smn_notice' ); ?><br>
                        - `class`: <?php _e( 'Custom CSS class for the button/link.', 'smn_notice' ); ?><br>
                        - `hide_behavior`: `click` <?php _e( '(notice hides on click) or', 'smn_notice' ); ?> `auto` <?php _e( '(notice auto-hides). Default: `click`.', 'smn_notice' ); ?><br>
                        - `position`: <?php _e( 'Position of the notice (e.g., `top center`, `bottom left`). Default: `top center`.', 'smn_notice' ); ?><br>
                        - `style`: <?php _e( 'Base theme for the notice (e.g., `bootstrap`, `happyblue`, `blackBg`). Default: `bootstrap`.', 'smn_notice' ); ?><br>
                        - `auto_hide_delay`: <?php _e( 'Delay in milliseconds if `hide_behavior="auto"`. Default: `3000`.', 'smn_notice' ); ?>
                    </p>
                </div>
                
                <?php submit_button(); ?>       
            </form>
        </div><!-- .wrap -->
    <?php
}