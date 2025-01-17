<?php
/**
 * Plugin Name: WP Video Popup
 * Plugin URI: https://wp-video-popup.com
 * Description: Add beautiful responsive YouTube & Vimeo Video lightbox popups to your WordPress website.
 * Version: 2.7
 * Author: David Vongries
 * Author URI: https://mapsteps.com
 *
 * @package WP_Video_Popup
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Plugin constants.
define( 'WP_VIDEO_POPUP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_VIDEO_POPUP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_VIDEO_POPUP_PLUGIN_VERSION', '2.7' );

// Clean up behind us.
if ( get_option( '_site_transient_disable-ryv-notice' ) ) {
	delete_option( '_site_transient_disable-ryv-notice' );
}

// Persist Admin notice Dismissals.
require_once WP_VIDEO_POPUP_PLUGIN_DIR . 'inc/persist-admin-notices-dismissal/persist-admin-notices-dismissal.php';

/**
 * PRO admin notice.
 */
function wp_video_popup_pro_ad() {

	if ( ! PAnD::is_admin_notice_active( 'wp-video-popup-pro-ad-forever' ) ) {
		return;
	}

	?>

	<div data-dismissible="wp-video-popup-pro-ad-forever" class="notice notice-info is-dismissible">
		<p>Get <a href="https://wp-video-popup.com/pricing/?utm_source=repository&utm_medium=admin_notice&utm_campaign=wp_video_popup" target="_blank"><strong>WP Video Popup PRO</strong></a> today for <strong>30% off</strong>.</p>
		<p><a href="https://wp-video-popup.com/pricing/?utm_source=repository&utm_medium=admin_notice&utm_campaign=wp_video_popup" target="_blank" class="button button-primary">Learn more</a></p>
	</div>

	<?php

}
add_action( 'admin_notices', 'wp_video_popup_pro_ad' );
add_action( 'admin_init', array( 'PAnD', 'init' ) );

/**
 * Enqueue scripts & styles.
 */
function wp_video_popup_styles() {

	wp_register_style( 'wp-video-popup', WP_VIDEO_POPUP_PLUGIN_URL . 'assets/css/wp-video-popup.css', [], WP_VIDEO_POPUP_PLUGIN_VERSION );
	wp_enqueue_style( 'wp-video-popup' );

	wp_register_script( 'wp-video-popup', WP_VIDEO_POPUP_PLUGIN_URL . 'assets/js/wp-video-popup.js', array( 'jquery' ), WP_VIDEO_POPUP_PLUGIN_VERSION, true );
	wp_enqueue_script( 'wp-video-popup' );

}
add_action( 'wp_enqueue_scripts', 'wp_video_popup_styles' );

/**
 * Popup shortcode.
 *
 * @param array $wp_video_popup_atts The shortcode attributes.
 *
 * @return string wp_video_popup_output The popup markup.
 */
function wp_video_popup_shortcode( $wp_video_popup_atts ) {

	$wp_video_popup_atts = shortcode_atts(
		array(
			'video'        => 'https://www.youtube.com/embed/YlUKcNNmywk',
			'mute'         => 0,
			'start'        => 0,
			'hide-related' => 0,
			'portrait'     => 0,
		),
		$wp_video_popup_atts,
		'wp-video-popup'
	);

	// Shortcode attributes.
	$video        = esc_url( $wp_video_popup_atts['video'] );
	$mute         = $wp_video_popup_atts['mute'] ? 1 : 0;
	$start        = $wp_video_popup_atts['start'];
	$hide_related = $wp_video_popup_atts['hide-related'] ? 1 : 0;
	$viewport     = $wp_video_popup_atts['portrait'] ? 'is-portrait' : 'is-landscape';

	// Parser data.
	$video_type = WP_Video_Popup_Parser::identify_service( $video );
	$video_url  = WP_Video_Popup_Parser::get_embed_url( $video );

	/* Construct Output */

	// Add class to landscape YouTube & Vimeos to dynamically resize them.
	if ( 'is-landscape' === $viewport ) {
		$viewport .= ' is-resizable';
	}

	if ( 'vimeo' === $video_type ) {

		// Mute Vimeo video.
		if ( $mute ) {
			$video_url .= '&amp;muted=1';
		}

	} else {

		// Remove YouTube related videos.
		if ( $hide_related ) {
			$video_url .= '&amp;rel=0';
		}

		// Mute YouTube video.
		if ( $mute ) {
			$video_url .= '&amp;mute=1';
		}

	}

	// Filter to let people add other URL parameters.
	$video_url = apply_filters( 'wp_video_popup', $video_url );

	if ( 'vimeo' === $video_type ) {

		// Start Vimeo video at specific time.
		if ( $start ) {
			$video_url .= '#t=' . $start;
		}

	} else {

		// Start YouTube video at specific time.
		if ( $start ) {
			$video_url .= '&amp;start=' . $start;
		}

	}

	return '
	<div class="wp-video-popup-wrapper">
		<div class="wp-video-popup-close"></div>
		<iframe class="wp-video-popup-video is-hosted ' . $viewport . '" src="" data-wp-video-popup-url="' . esc_url( $video_url ) . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay">
		</iframe>
	</div>
	';

}
add_shortcode( 'wp-video-popup', 'wp_video_popup_shortcode' );
add_shortcode( 'ryv-popup', 'wp_video_popup_shortcode' ); // Backwards compatibility.

/* Required files */

// Parser.
require_once WP_VIDEO_POPUP_PLUGIN_DIR . 'inc/class-wp-video-popup-parser.php';
