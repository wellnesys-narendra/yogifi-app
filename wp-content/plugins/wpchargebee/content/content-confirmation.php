<?php
/**
 * @package WPCB
 */

if (! defined('ABSPATH') ) {
    wp_die();
}
$_SESSION[ 'isError' ] = "false";
function wpcb_write_response_message() {
	wp_verify_nonce( 'site_nonce', 'wpcb_write_response_message' );
	
	echo '<div class="spinner-container"><span class="spinner-loader"></span></div>';
	echo '<div class="confirm-message"></div>';
}

wpcb_write_response_message();
