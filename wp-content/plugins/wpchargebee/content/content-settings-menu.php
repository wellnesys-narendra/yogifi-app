<?php
 /*
  * @package WPCB
  */

if (! defined('ABSPATH') ) {
    wp_die();
} ?>

<div class="wrap">
    <h1>WP Chargebee - Settings</h1>
    
    <form method="post" id="formId">
        <h2>API Settings</h2>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Chargebee API Key</span>
            <input type="text" name="siteApiKey" required style="width: 65%;" id="siteApiKey"
                   value="<?php echo esc_attr(WPCB::$api_config_file[ 'chargeBeeApiKey' ]); ?>" /><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Chargebee Site</span>
            <input type="text" name="chargeBeeSite" required style="width: 65%;" id="chargeBeeSite"
                   value="<?php echo esc_attr(WPCB::$api_config_file[ 'chargeBeeSite' ]);  ?>" /><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Gateway Account ID</span>
            <input type="text" name="gatewayAccountId" required style="width: 65%;" id="gatewayAccountId"
                   value="<?php echo  esc_attr(WPCB::$api_config_file[ 'gatewayAccountId' ]); ?>" /><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Stripe Publishable Key</span>
            <input type="text" name="stripePublishKey" required style="width: 65%;" id="stripePublishKey"
                   value="<?php echo esc_attr(WPCB::$api_config_file[ 'stripeKey' ]); ?>" /><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Plan Page</span>
    			<?php wpcb_load_data_for_plan_page()?>
            <span> OR </span>
            <span>Page ID</span>
            <input type="text" name="planPgId" style="width: 25%;" id="planPgId" />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Form Page</span>
    			<?php wpcb_load_data_for_form_page()?>
            <span> OR </span>
            <span>Page ID</span>
            <input type="text" name="formPgId" style="width: 25%;" id="formPgId" />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Payment &amp; Confirmation Page</span>
    			<?php wpcb_load_data_for_confirm_page()?>
            <span> OR </span>
            <span>Page ID</span>
            <input type="text" name="loadStripePgId" style="width: 25%;" id="loadStripePgId" />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Stripe Email</span>
            <input type="text" name="stripeEmail" required style="width: 65%;" id="stripeEmail"
                   value="<?php echo  esc_attr(WPCB::$api_config_file[ 'stripeEmail' ]); ?>" /><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span>Stripe Image URL</span>
            <input type="text" name="stripeImg" style="width: 65%;" id="stripeImg"
                   value="<?php echo  esc_url(WPCB::$api_config_file[ 'stripeImg' ]); ?>" /><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span style="float:left;position:initial;">Success Message</span><br />
            <textarea cols="100" name= "successMessageId" style= "height: 416px;" form="formId"><?php 
                echo  esc_html(preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'successMsg' ])); ?> </textarea><br />
        </div>
        <h2>Custom CSS Settings</h2>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span style="float:left;position:initial;">Plan Box</span><br />
            <textarea cols="100" name= "planBox" style= "height: 150px;" form="formId">
                <?php echo  esc_html(preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'planBox' ])) ?> </textarea><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span style="float:left;position:initial;">Plan Name</span><br/>
            <textarea cols="100" name= "planName" style= "height: 150px;" form="formId">
                <?php echo esc_html(preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'planName' ])) ?> </textarea><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span style="float:left;position:initial;">Plan Type</span><br />
            <textarea cols="100" name= "planType" style= "height: 150px;" form="formId">
                <?php echo  esc_html(preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'planType' ])) ?> </textarea><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span style="float:left;position:initial;">Plan Body</span><br />
            <textarea cols="100" name= "planBody" style= "height: 150px;" form="formId">
                <?php echo  esc_html(preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'planBody' ])) ?> </textarea><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span style="float:left;position:initial;">Plan Description</span><br />
            <textarea cols="100" name= "planDescription" style= "height: 150px;" form="formId">
                <?php echo  esc_html(preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'planDescription' ])) ?> </textarea><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span style="float:left;position:initial;">Plan Button Container</span><br />
            <textarea cols="100" name= "planButtonContainer" style= "height: 150px;" form="formId">
                <?php echo  esc_html(preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'planButtonContainer' ])) ?> </textarea><br />
        </div>
        <div class="postbox" style="width: 80%; padding: 30px;">
            <span style="float:left;position:initial;">Plan Button</span><br />
            <textarea cols="100" name= "planButton" style= "height: 150px;" form="formId">
                <?php echo  esc_html(preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'planButton' ])) ?> </textarea><br />
        </div>
        <button type="submit" name="savechanges">Save Changes</button>
    </form>
</div>

<?php
    
function wpcb_load_data_for_confirm_page()
{
    $args = '';
    
    $defaults = array(
    'depth'                 => 0,
    'child_of'              => 0,
    'selected'              => 0,
    'echo'                  => 1,
    'name'                  => 'page_id1',
    'id'                    => '',
    'class'                 => '',
    'show_option_none'      => '',
    'show_option_no_change' => '',
    'option_none_value'     => '',
    'value_field'           => 'ID',
    );
    
    $r = wp_parse_args($args, $defaults);
    $pages  = get_pages($r);
    $output = '';
    
    if (empty($r[ 'id' ]) ) {
        $r[ 'id' ] = $r[ 'name' ];
        $r[ 'selected' ] = WPCB::$api_config_file[ 'loadStripePageId' ];
    }
    
    if (! empty($pages) ) {
        $class = '';
        if (! empty($r[ 'class' ]) ) {
            $class = " class='" . esc_attr($r[ 'class' ]) . "'";
        }
        
        $output = "<select name='" . esc_attr($r['name']) . "'" . $class . " id='" . esc_attr($r[ 'id' ]) . "'>\n";
        if ($r[ 'show_option_no_change' ] ) {
            $output .= "\t<option value=\"-1\">" . $r[ 'show_option_no_change' ] . "</option>\n";
        }
        if ($r[ 'show_option_none' ] ) {
            $output .= "\t<option value=\"" . esc_attr($r[ 'option_none_value' ]) . '">' . $r[ 'show_option_none' ] . "</option>\n";
        }
        $output .= walk_page_dropdown_tree($pages, $r[ 'depth' ], $r);
        $output .= "</select>\n";
    }
    
    $html = apply_filters('wp_dropdown_pages', $output, $r, $pages);
    
    if ($r[ 'echo' ] ) {
        echo $html;
    }
}

function wpcb_load_data_for_plan_page()
{
    $args = '';
    
    $defaults = array(
    'depth'                 => 0,
    'child_of'              => 0,
    'selected'              => 0,
    'echo'                  => 1,
    'name'                  => 'page_id2',
    'id'                    => '',
    'class'                 => '',
    'show_option_none'      => '',
    'show_option_no_change' => '',
    'option_none_value'     => '',
    'value_field'           => 'ID',
    );
    
    $r = wp_parse_args($args, $defaults);
    $pages  = get_pages($r);
    $output = '';
    
    if (empty($r[ 'id' ]) ) {
        $r[ 'id' ] = $r[ 'name' ];
        $r[ 'selected' ] = WPCB::$api_config_file[ 'loadPlanPageId' ];
    }
    
    if (! empty($pages) ) {
        $class = '';
        if (! empty($r[ 'class' ]) ) {
            $class = " class='" . esc_attr($r[ 'class' ]) . "'";
        }
        
        $output = "<select name='" . esc_attr($r['name']) . "'" . $class . " id='" . esc_attr($r[ 'id' ]) . "'>\n";
        if ($r[ 'show_option_no_change' ] ) {
            $output .= "\t<option value=\"-1\">" . $r[ 'show_option_no_change' ] . "</option>\n";
        }
        if ($r[ 'show_option_none' ] ) {
            $output .= "\t<option value=\"" . esc_attr($r[ 'option_none_value' ]) . '">' . $r[ 'show_option_none' ] . "</option>\n";
        }
        $output .= walk_page_dropdown_tree($pages, $r[ 'depth' ], $r);
        $output .= "</select>\n";
    }
    
    $html = apply_filters('wp_dropdown_pages', $output, $r, $pages);
    
    if ($r[ 'echo' ] ) {
        echo $html;
    }
}

function wpcb_load_data_for_form_page()
{
    $args = '';
    
    $defaults = array(
    'depth'                 => 0,
    'child_of'              => 0,
    'selected'              => 0,
    'echo'                  => 1,
    'name'                  => 'page_id3',
    'id'                    => '',
    'class'                 => '',
    'show_option_none'      => '',
    'show_option_no_change' => '',
    'option_none_value'     => '',
    'value_field'           => 'ID',
    );
    
    $r = wp_parse_args($args, $defaults);
    $pages  = get_pages($r);
    $output = '';
    
    if (empty($r[ 'id' ]) ) {
        $r[ 'id' ] = $r[ 'name' ];
        $r[ 'selected' ] = WPCB::$api_config_file[ 'loadFormPageId' ];
    }
    
    if (! empty($pages) ) {
        $class = '';
        if (! empty($r[ 'class' ]) ) {
            $class = " class='" . esc_attr($r[ 'class' ]) . "'";
        }
        
        $output = "<select name='" . esc_attr($r['name']) . "'" . $class . " id='" . esc_attr($r[ 'id' ]) . "'>\n";
        if ($r[ 'show_option_no_change' ] ) {
            $output .= "\t<option value=\"-1\">" . $r[ 'show_option_no_change' ] . "</option>\n";
        }
        if ($r[ 'show_option_none' ] ) {
            $output .= "\t<option value=\"" . esc_attr($r[ 'option_none_value' ]) . '">' . $r[ 'show_option_none' ] . "</option>\n";
        }
        $output .= walk_page_dropdown_tree($pages, $r[ 'depth' ], $r);
        $output .= "</select>\n";
    }
    
    $html = apply_filters('wp_dropdown_pages', $output, $r, $pages);
    
    if ($r[ 'echo' ] ) {
        echo $html;
    }
}

if($_SERVER[ 'REQUEST_METHOD' ] == "POST" and isset($_POST[ 'savechanges' ]) ) {
	wp_verify_nonce('site_nonce', 'wpcb_save_json_file');
    wpcb_save_json_file();
    echo "<meta http-equiv='refresh' content='0'>";
}

function wpcb_save_json_file()
{
    $myFile = plugin_dir_path(__FILE__) . '../inc/api-config.json';

    try
    {
        $stripePagePostId  = sanitize_option('page_id1', $_POST['page_id1']);
		$planPagePostId    = sanitize_option('page_id2', $_POST['page_id2']);
		$formPagePostId    = sanitize_option('page_id3', $_POST['page_id3']);

        if(sanitize_text_field($_POST[ 'loadStripePgId' ]) != "") {
            $stripePagePostId = intval( $_POST['loadStripePgId'] );
			if ( ! $stripePagePostId ) {
  				$stripePagePostId = '';
			}
        }
        if(sanitize_text_field($_POST[ 'formPgId' ]) != "") {
            $formPagePostId = intval( $_POST['formPgId'] );
			if ( ! $formPagePostId ) {
  				$formPagePostId = '';
			}
        }
        if(sanitize_text_field($_POST[ 'planPgId' ]) != "") {
            $planPagePostId = intval( $_POST['planPgId'] );
			if ( ! $planPagePostId ) {
  				$planPagePostId = '';
			}
        }
        $loadStripePost     = get_post($stripePagePostId); 
        $loadStripePostSlug = $loadStripePost->post_name;
        
        $loadFormPost      = get_post($formPagePostId); 
        $loadFormPostSlug = $loadFormPost->post_name;
        
        $loadPlanPost      = get_post($planPagePostId); 
        $loadPlanPostSlug = $loadPlanPost->post_name;
        
		$siteApiKey         = sanitize_text_field($_POST['siteApiKey']);
		$chargeBeeSite    = sanitize_text_field($_POST['chargeBeeSite']);
		$gatewayAccountId    = sanitize_text_field($_POST['gatewayAccountId']);
		$stripePublishKey   = sanitize_text_field($_POST['stripePublishKey']);
		$stripeEmail    = sanitize_email($_POST['stripeEmail']);
		$stripeImg    = sanitize_text_field($_POST['stripeImg']);
		$successMessageId    = sanitize_textarea_field($_POST['successMessageId']);
		$planBox    = sanitize_textarea_field($_POST['planBox']);
		$planName    = sanitize_textarea_field($_POST['planName']);
		$planType    = sanitize_textarea_field($_POST['planType']);
		$planBody    = sanitize_textarea_field($_POST['planBody']);
		$planDescription    = sanitize_textarea_field($_POST['planDescription']);
		$planButtonContainer    = sanitize_textarea_field($_POST['planButtonContainer']);
		$planButton   = sanitize_textarea_field($_POST['planButton']);

		
        // Get the form data
        $formdata = array(
        'chargeBeeApiKey'     => $siteApiKey,
        'chargeBeeSite'       => $chargeBeeSite,
        'gatewayAccountId'    => $gatewayAccountId,
        'stripeKey'           => $stripePublishKey,
        'loadStripePageId'    => $stripePagePostId,
        'loadStripePageSlug'  => $loadStripePostSlug,
        'loadFormPageId'      => $formPagePostId,
        'loadFormPageSlug'    => $loadFormPostSlug,
        'loadPlanPageId'      => $planPagePostId,
        'loadPlanPageSlug'    => $loadPlanPostSlug,
        'stripeEmail'         => $stripeEmail,
        'stripeImg'           => $stripeImg,
        'successMsg'          => $successMessageId,
        'planBox'             => $planBox,
        'planName'            => $planName,
        'planType'            => $planType,
        'planBody'            => $planBody,
        'planDescription'     => $planDescription,
        'planButtonContainer' => $planButtonContainer,
        'planButton'          => $planButton,
        );
        
        $jsondata = json_encode($formdata, JSON_PRETTY_PRINT);
        
        // Write json data into data.json file
        if (file_put_contents($myFile, $jsondata) ) {
            header('Location: ' . $_SERVER[ 'REQUEST_URI' ]);
        } else { 
            echo "error";
        }
        
    } catch ( Exception $e ) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
}