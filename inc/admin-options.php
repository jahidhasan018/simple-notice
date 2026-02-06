<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Sanitize notice text.
 *
 * @param string $value Input value.
 * @return string
 */
function smn_notice_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}

/**
 * Sanitize enable/disable flags.
 *
 * @param mixed $value Input value.
 * @return int
 */
function smn_notice_sanitize_toggle( $value ) {
	return (int) (bool) $value;
}

/**
 * Sanitize select post option.
 *
 * @param mixed $value Input value.
 * @return string|int
 */
function smn_notice_sanitize_select_post( $value ) {
	if ( 'all' === $value ) {
		return 'all';
	}

	return absint( $value );
}

/**
 * Sanitize hide behavior.
 *
 * @param mixed $value Input value.
 * @return int
 */
function smn_notice_sanitize_hide_behavior( $value ) {
	$value = (int) $value;

	return in_array( $value, array( 1, 2 ), true ) ? $value : 1;
}

/**
 * Sanitize position.
 *
 * @param string $value Input value.
 * @return string
 */
function smn_notice_sanitize_position( $value ) {
	return in_array( $value, smn_notice_positions(), true ) ? $value : 'bottom center';
}

/**
 * Sanitize style.
 *
 * @param string $value Input value.
 * @return string
 */
function smn_notice_sanitize_style( $value ) {
	return in_array( $value, smn_notice_styles(), true ) ? $value : 'bootstrap';
}

/**
 * Sanitize hide delay.
 *
 * @param mixed $value Input value.
 * @return int
 */
function smn_notice_sanitize_hide_delay( $value ) {
	return max( 0, absint( $value ) );
}

/**
 * Sanitize cookie expiry in days.
 *
 * @param mixed $value Input value.
 * @return int
 */
function smn_notice_sanitize_cookie_expire( $value ) {
	return max( 0, absint( $value ) );
}

// Register plugin page settigns
function smn_notice_register_settings() {
	register_setting( 'smn_options_group', 'smn_enable_notice', array( 'sanitize_callback' => 'smn_notice_sanitize_toggle' ) );
	register_setting( 'smn_options_group', 'smn_notice_text', array( 'sanitize_callback' => 'smn_notice_sanitize_text' ) );
	register_setting( 'smn_options_group', 'smn_select_post', array( 'sanitize_callback' => 'smn_notice_sanitize_select_post' ) );
	register_setting( 'smn_options_group', 'smn_hide', array( 'sanitize_callback' => 'smn_notice_sanitize_hide_behavior' ) );
	register_setting( 'smn_options_group', 'smn_hide_delay', array( 'sanitize_callback' => 'smn_notice_sanitize_hide_delay' ) );
	register_setting( 'smn_options_group', 'smn_position', array( 'sanitize_callback' => 'smn_notice_sanitize_position' ) );
	register_setting( 'smn_options_group', 'smn_style', array( 'sanitize_callback' => 'smn_notice_sanitize_style' ) );
	register_setting( 'smn_options_group', 'smn_cookie_expire', array( 'sanitize_callback' => 'smn_notice_sanitize_cookie_expire' ) );
	register_setting( 'smn_options_group', 'smn_hide_mobile', array( 'sanitize_callback' => 'smn_notice_sanitize_toggle' ) );

	add_option( 'smn_enable_notice', 1 );
	add_option( 'smn_hide_delay', 5000 );
	add_option( 'smn_cookie_expire', 0 );
}
add_action( 'admin_init', 'smn_notice_register_settings' );

// Create Option Page
function smn_options_page() {
	add_options_page( 'Simple Notice Settings', 'Simple Notice', 'manage_options', 'smn_notice', 'smn_notice_display' );
}
add_action( 'admin_menu', 'smn_options_page' );

// Display options page
function smn_notice_display() {
	?>

		<div class="wrap simple-notice">
			<h1><?php esc_html_e( 'Simple Notice Settings', 'smn_notice' ); ?></h1>

			<form id="smn_notice_form" method="post" action="options.php">

				<?php
					settings_fields( 'smn_options_group' );
					$smn_enable        = (int) get_option( 'smn_enable_notice', 1 );
					$smn_notice_text   = (string) get_option( 'smn_notice_text', '' );
					$smn_select_post   = get_option( 'smn_select_post', 'all' );
					$smn_hide_val      = (int) get_option( 'smn_hide', 1 );
					$smn_hide_delay    = (int) get_option( 'smn_hide_delay', 5000 );
					$smn_position      = get_option( 'smn_position', 'bottom center' );
					$smn_style         = get_option( 'smn_style', 'bootstrap' );
					$smn_cookie_expire = (int) get_option( 'smn_cookie_expire', 0 );
					$smn_hide_mobile   = (int) get_option( 'smn_hide_mobile', 0 );

				?>

				<!-- Smn Options Area -->
				<div class="smn_fields">

					<!-- Enable notice -->
					<div class="smn_group">
						<label for="smn_enable_notice"><?php esc_html_e( 'Enable notice', 'smn_notice' ); ?></label>
						<input type="checkbox" id="smn_enable_notice" name="smn_enable_notice" value="1" <?php checked( 1, $smn_enable ); ?> />
						<p class="description"><?php esc_html_e( 'Turn the notice on or off across the site.', 'smn_notice' ); ?></p>
					</div>

					<!-- Notice Text Field -->
					<div class="smn_group">
						<label for="smn_notice_text"><?php esc_html_e( 'Notice Text', 'smn_notice' ); ?></label>
						<input type="text" id="smn_notice_text" name="smn_notice_text" value="<?php echo esc_attr( $smn_notice_text ); ?>" placeholder="<?php esc_attr_e( 'Enter your text...', 'smn_notice' ); ?>" />
					</div>

					<!-- Notification Page Field -->
					<div class="smn_group">
						<label for="smn_select_post"><?php esc_html_e( 'Select Page', 'smn_notice' ); ?></label>
						<select id="smn_select_post" name="smn_select_post">
							<option value="all" <?php selected( 'all', $smn_select_post ); ?> ><?php esc_html_e( 'All', 'smn_notice' ); ?></option>

							<!-- Pages -->
							<option class="option_posts" disabled><?php esc_html_e( 'Pages', 'smn_notice' ); ?></option>
							<?php
								$smn_pages = get_pages();
								foreach ( $smn_pages as $page ) :
									?>
									<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $smn_select_post, $page->ID ); ?> >
										<?php echo esc_html( $page->post_title ); ?>
									</option>
							<?php endforeach; ?>

							<!-- Posts -->
							<option class="option_posts" disabled><?php esc_html_e( 'Posts', 'smn_notice' ); ?></option>
							<?php
								global $post;
								$args  = array(
									'posts_per_page' => -1,
								);
								$posts = get_posts( $args );
								foreach ( $posts as $post ) :
									?>
									<option value="<?php echo esc_attr( $post->ID ); ?>" <?php selected( $smn_select_post, $post->ID ); ?> >
										<?php echo esc_html( $post->post_title ); ?>
									</option>
							<?php endforeach; wp_reset_postdata(); ?>

						</select>
					</div>

					<!-- Set how to hide the notice Field -->
					<div class="smn_group">
						<label for="smn_hide"><?php esc_html_e( 'Set how to hide the notice', 'smn_notice' ); ?></label>
						<select id="smn_hide" name="smn_hide">
							<option value="1" <?php selected( 1, $smn_hide_val ); ?> ><?php esc_html_e( 'Auto Hide', 'smn_notice' ); ?></option>
							<option value="2" <?php selected( 2, $smn_hide_val ); ?> ><?php esc_html_e( 'Click to Hide', 'smn_notice' ); ?></option>
						</select>

						<div id="smn_delay_field">
							<p class="description"><?php esc_html_e( 'Enter a number in milliseconds. Default is 5000.', 'smn_notice' ); ?></p>
							<input type="number" min="0" id="smn_hide_delay" name="smn_hide_delay" value="<?php echo esc_attr( $smn_hide_delay ); ?>" />
						</div>

					</div>

					<!-- Notice Position Field -->
					<div class="smn_group">
						<label for="smn_position"><?php esc_html_e( 'Notice Position', 'smn_notice' ); ?></label>
						<p class="description"><?php esc_html_e( 'Select notice bar position. Default is bottom center.', 'smn_notice' ); ?></p>
						<select id="smn_position" name="smn_position">
							<option value="left top" <?php selected( 'left top', $smn_position ); ?> ><?php esc_html_e( 'Top Left', 'smn_notice' ); ?></option>
							<option value="top center" <?php selected( 'top center', $smn_position ); ?> ><?php esc_html_e( 'Top Center', 'smn_notice' ); ?></option>
							<option value="top right" <?php selected( 'top right', $smn_position ); ?> ><?php esc_html_e( 'Top Right', 'smn_notice' ); ?></option>
							<option value="left middle" <?php selected( 'left middle', $smn_position ); ?> ><?php esc_html_e( 'Left Middle', 'smn_notice' ); ?></option>
							<option value="right middle" <?php selected( 'right middle', $smn_position ); ?> ><?php esc_html_e( 'Right Middle', 'smn_notice' ); ?></option>
							<option value="left bottom" <?php selected( 'left bottom', $smn_position ); ?> ><?php esc_html_e( 'Bottom Left', 'smn_notice' ); ?></option>
							<option value="bottom center" <?php selected( 'bottom center', $smn_position ); ?> ><?php esc_html_e( 'Bottom Center', 'smn_notice' ); ?></option>
							<option value="right bottom" <?php selected( 'right bottom', $smn_position ); ?> ><?php esc_html_e( 'Bottom Right', 'smn_notice' ); ?></option>
						</select>
					</div>

					<!-- Notice Style Field -->
					<div class="smn_group">
						<label for="smn_style"><?php esc_html_e( 'Notice Style', 'smn_notice' ); ?></label>
						<select id="smn_style" name="smn_style">
							<option value="bootstrap" <?php selected( 'bootstrap', $smn_style ); ?> ><?php esc_html_e( 'Bootstrap', 'smn_notice' ); ?></option>
							<option value="happyblue" <?php selected( 'happyblue', $smn_style ); ?> ><?php esc_html_e( 'Happy Blue', 'smn_notice' ); ?></option>
							<option value="blackBg" <?php selected( 'blackBg', $smn_style ); ?> ><?php esc_html_e( 'Black BG', 'smn_notice' ); ?></option>
						</select>
					</div>

					<!-- Hide on mobile -->
					<div class="smn_group">
						<label for="smn_hide_mobile"><?php esc_html_e( 'Hide on mobile', 'smn_notice' ); ?></label>
						<input type="checkbox" id="smn_hide_mobile" name="smn_hide_mobile" value="1" <?php checked( 1, $smn_hide_mobile ); ?> />
						<p class="description"><?php esc_html_e( 'Hide the notice on screens smaller than 768px wide.', 'smn_notice' ); ?></p>
					</div>

					<!-- Notice Time Field -->
					<div class="smn_group">
						<label for="smn_cookie_expire"><?php esc_html_e( 'Show notice after this many days', 'smn_notice' ); ?></label>
						<p class="description"><?php esc_html_e( 'How many days later do you want to show the notice again? Use 0 to show on every visit.', 'smn_notice' ); ?></p>
						<input type="number" min="0" id="smn_cookie_expire" name="smn_cookie_expire" value="<?php echo esc_attr( $smn_cookie_expire ); ?>" />
					</div>

				</div>

				<!-- Smn Shortcode area -->
				<div class="smn_shortcode">
					<h2><?php esc_html_e( 'You can use the shortcode', 'smn_notice' ); ?></h2>
					<p class="description"><?php esc_html_e( 'Use the shortcode to show a notification from a button or link tooltip.', 'smn_notice' ); ?></p>
					<code>
						[smn_notice_btn text="My button" hide="auto" position="top center" style="bootstrap"]
					</code>
				</div>

				<?php submit_button(); ?>
			</form>
		</div>

	<?php
}
