<?php
/**
 * @package WPCB
 */

if (! defined('ABSPATH') ) {
    wp_die();
}
$all = ChargeBee_Customer::all(
    array( 
      "auto_collection[is]" => "off"
    ) 
);

if (count($all) != 0 ) :
    echo '<h1 style="margin-top: 40px;">WP Chargebee - Pending Chargebee Customers</h1>';
    
    echo 
       '<table style="width:100%; position: relative; top: 40px;">
        <tr>
            <th style="text-align: left;"><h2>Name</h2></th>
            <th style="text-align: left;"><h2>Email</h2></th>
            <th style="text-align: left;"><h2>Plan</h2></th>
            <th style="text-align: left;"><h2>Payment URL</h2></th>
        </tr>';

    foreach( $all as $entry ) : $customer = $entry->customer(); $plan = json_encode($customer->metaData); $initPlan = json_decode($plan);
        echo'<tr>
             <td>' . esc_html($customer->firstName) . ' ' . esc_html($customer->lastName) . '</td>' .
        '<td>' . esc_html($customer->email) . '</td>' .
        '<td>' . esc_html(trim($initPlan->initPlanName, "Inspire 2020 ")) . '</td>' .
        '<td>' . esc_html(site_url()) .'/'. esc_html(WPCB::$api_config_file[ 'loadStripePageSlug' ]) . '/?v='. esc_html($customer->id) . '</td>' .
        '</tr>';
    endforeach;
    echo '</table>';
    else:
        echo '<h1 style="margin-top: 40px;">WP Chargebee - No Pending Chargebee Customers</h1>';
    endif;