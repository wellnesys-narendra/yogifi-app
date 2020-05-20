<?php
/**
 * @package WPCB
 */

session_destroy(); // Destroy the session if this content is loaded
session_unset();

// Check whether 'limit' or 'specific' shortcode attribute was provided and get plans based on that
if (! array_key_exists('specific', $atts) && array_key_exists('limit', $atts) ) {
    $all = ChargeBee_Plan::all(
        array(
        "limit" => $atts[ 'limit' ],
        "status[is]" => "active"
        )
    );
} else if (array_key_exists('specific', $atts) && ! array_key_exists('limit', $atts) ) {
    $all = ChargeBee_Plan::all(
        array(
        "status[is]" => "active"
        )
    );
    
} else if (! array_key_exists('specific', $atts) && ! array_key_exists('limit', $atts) ) {
    $all = ChargeBee_Plan::all(
        array(
        "status[is]" => "active"
        )
    );
} else {
    echo '<p class="text-danger">UCBC: Error - You must either enter "limit" or "specific" as a shortcode attribute, not both.</p>';
}

// Set the plans array to only have provided plans if they were specified with the 'specific' attribute
if (array_key_exists('specific', $atts) ) {
    $allSpecified = array();
    
    $specific = explode('+', $atts[ 'specific' ]); // Get each plan separately by dividing them at '+' symbols
    
    foreach ( $all as $current ) {
        foreach ( $specific as $id ) {
            if ($id == $current->plan()->id ) {
                array_push($allSpecified, $current);
                $all = $allSpecified; // Set the main array to the specific array
            }
        }
    }
}

if (WPCB::$api_config_file[ 'planBox' ] != '' ) {
    $planBox = WPCB::$api_config_file[ 'planBox' ];
}
if (WPCB::$api_config_file[ 'planName' ] != '' ) {
    $planName = WPCB::$api_config_file[ 'planName' ];
}
if (WPCB::$api_config_file[ 'planType' ] != '' ) {
    $planType = WPCB::$api_config_file[ 'planType' ];
}
if (WPCB::$api_config_file[ 'planBody' ] != '' ) {
    $planBody = WPCB::$api_config_file[ 'planBody' ];
}
if (WPCB::$api_config_file[ 'planDescription' ] != '' ) {
    $planDescription = WPCB::$api_config_file[ 'planDescription' ];
}
if (WPCB::$api_config_file[ 'planButtonContainer' ] != '' ) {
    $planButtonContainer = WPCB::$api_config_file[ 'planButtonContainer' ];
}
if (WPCB::$api_config_file[ 'planButton' ] != '' ) {
    $planButton = WPCB::$api_config_file[ 'planButton' ];
}

?>

<div class="row">
    <?php foreach ( $all as $entry ) : $plan = $entry->plan(); ?>
    <div class="col-xs-12 col-sm-6 col-lg-4">
        <div class="plan-box" style="<?php echo esc_attr( $planBox ); ?>" data-plan-id="<?php echo esc_attr( $plan->id ); ?>" data-plan-name="<?php echo esc_attr( $plan->name ); ?>" data-plan-price="<?php echo esc_attr( $plan->price ); ?>">
            <span class="plan-name" style="<?php echo esc_attr( $planName ); ?>"><?php echo esc_html( $plan->name ); ?></span>
            <span class="plan-type" style="<?php echo esc_attr( $planType ); ?>"><?php echo esc_html( $plan->billingCycles ) . ' ' . esc_html( $plan->periodUnit ) . 'ly payments' . ' of $' . esc_html( $plan->price/100 ); ?></span>
            <div class="plan-body" style="<?php echo esc_attr( $planBody ); ?>">
                <span class="plan-description" style="<?php echo esc_attr( $planDescription ); ?>"><?php echo esc_html( $plan->description ); ?></span>
            </div>
            <div class="plan-button-container" style="<?php echo esc_attr( $planButtonContainer ); ?>">
                <span class="plan-button" style="<?php echo esc_attr( $planButton ); ?>">START PLAN</span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
