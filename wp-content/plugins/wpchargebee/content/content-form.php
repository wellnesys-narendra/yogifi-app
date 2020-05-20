<?php
/**
 * @package WPCB
 */

if (! defined('ABSPATH') ) {
    wp_die();
}

$_SESSION[ 'cart' ] = array(
    'id' => $atts[ 'id' ],
    'first_name' => $atts[ 'first_name' ],
    'last_name' => $atts[ 'last_name' ],
    'email' => $atts[ 'email' ],
    'phone' => $atts[ 'phone' ],
    'line_one' => $atts[ 'line_one' ],
    'city' => $atts[ 'city' ],
    'state' => $atts[ 'state' ],
    'zip' => $atts[ 'zip' ],
    'country' => $atts[ 'country' ]
);

// Add custom_fields to an array within the $_SESSION if there are any
$custom_fields = array();
$custom_fields_reverse = array();

foreach ( array_keys($atts) as $attr ) {
    if (strpos($attr, 'cf_') === 0 ) {
        $custom_fields[ $attr ] = $atts[ $attr ];
        $custom_fields_reverse[ $atts[ $attr ] ] = $attr;
    }
}

$_SESSION[ 'custFields' ] = $custom_fields;
$_SESSION[ 'custFields_reverse' ] = $custom_fields_reverse;
// Get the attributes for rendering the Gravity Form
$id = $atts[ 'id' ];
$title = $atts[ 'title' ];
$description  = $atts[ 'description' ];
$plan_slug       = WPCB::$api_config_file[ 'loadPlanPageSlug' ];

if($plan_slug != "") {
	if($_SESSION[ 'isError' ] === "true"){
		echo '<div class="form-api-error">Sorry, there was a technical issue with your registration. Please try again.</div>';
	}
    echo do_shortcode("[gravityforms id=$id title=$title description=$description ajax=false]");
	
}
