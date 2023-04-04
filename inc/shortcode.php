<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Button shortcode
function smn_notice_button_shortcode( $atts, $content = null ){

    extract(shortcode_atts( array(
        'text'      => __( 'Your button text', 'smn' ),
        'url'       => '#',
        'class'     => 'smn-notice-btn',
        'hide'      => 'auto',
        'position'  => 'top center',
        'style'     => 'bootstrap'
    ), $atts ));
    
    ob_start();
?>
    <a class="<?php echo esc_attr( $class ); ?>" href="<?php echo esc_attr( $url ); ?>"><?php echo esc_html( $text ); ?></a>
    <script>
        jQuery(document).ready(function(){
            jQuery(".<?php echo esc_attr( $class ); ?>").notify( "<?php echo esc_html( $text ); ?>", { 
                    position:'<?php echo esc_attr( $position ); ?>',
                    clickToHide: true,
                    autoHide: false,
                    autoHideDelay: 3000,
                    style: 'bootstrap',
                }
            );
        });
    </script>

<?php
    return ob_get_clean();

}
add_shortcode( 'smn_notice_btn', 'smn_notice_button_shortcode' );