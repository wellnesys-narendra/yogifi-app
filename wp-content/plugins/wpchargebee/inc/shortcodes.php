<?php
/**
 * @package WPCB
 */

if (! defined('ABSPATH') ) {
    wp_die();
}

// Get and return the HTML to render the plans
function wpcb_render_chargebee_plans($atts)
{
    ob_start();
    include_once plugin_dir_path(__DIR__) . 'content/content-plans.php';
    return ob_get_clean();
}

add_shortcode('wpcb_plans', 'wpcb_render_chargebee_plans');

// Get the Gravity Form and field values by shortcode attributes
function wpcb_render_gravity_form($atts)
{
    ob_start();
    include_once plugin_dir_path(__DIR__) . 'content/content-form.php';
    return ob_get_clean();
}

add_shortcode('wpcb_form', 'wpcb_render_gravity_form');

// Get the Stripe checkout confirmation message HTML and return it onto the page
function wpcb_render_stripe_confirmation()
{
    ob_start();
    include_once plugin_dir_path(__DIR__) . 'content/content-confirmation.php';
    return ob_get_clean();
}

add_shortcode('wpcb_confirmation', 'wpcb_render_stripe_confirmation');
