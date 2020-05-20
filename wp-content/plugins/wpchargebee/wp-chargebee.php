<?php
/**
 * @package WPCB
 * 
 * Plugin Name: WP Chargebee
 * Plugin URI: http://thinkun.net
 * Description: Connect your site to Chargebee with WPCB.
 * Version: 1.1
 * Author: Thinkun
 * Author URI: http://thinkun.net
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * 
 * ----------------------------------------------------------------------
 * WP Chargebee - Connect your site to Chargebee with WPCB
 * Copyright (C) 2019  Thinkun
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

if (! defined('ABSPATH') ) {
    wp_die();
}

if (! class_exists('WPCB') ) {
    class WPCB
    {
        static $api_config_file;
        
        public static function wpcb_register()
        {   
            add_action('init', array( 'WPCB', 'wpcb_require_all' )); // Get all required files and packages
            add_action('init', array( 'WPCB', 'wpcb_get_api_keys' )); // Connect to api-config.json and fetch API keys
            add_action('init', array( 'WPCB', 'wpcb_register_session' )); // Start a session if it hasn't been started already
            add_action('init', array( 'WPCB', 'wpcb_redirect_if_skipped' )); // Redirect user if plans or form pages have been skipped
            add_action('wp_ajax_wpcb_get_chosen_plan_handler', array( 'WPCB', 'wpcb_get_chosen_plan' )); // Get chosen plan and register it to a session in admin mode
            add_action('wp_ajax_nopriv_wpcb_get_chosen_plan_handler',  array( 'WPCB', 'wpcb_get_chosen_plan' )); // Get chosen plan and register it to a session in non-admin mode
            add_action('wp_ajax_wpcb_get_session_plan_handler', array( 'WPCB', 'wpcb_get_session_plan' )); // Get chosen plan and register it to a session in admin mode
            add_action('wp_ajax_nopriv_wpcb_get_session_plan_handler',  array( 'WPCB', 'wpcb_get_session_plan' )); // Get chosen plan and register it to a session in non-admin mode
            add_action('wp_ajax_wpcb_create_payment_from_url_handler',  array( 'WPCB', 'wpcb_create_payment_from_url' )); // Get payment method and register customer to subscription in admin mode
            add_action('wp_ajax_nopriv_wpcb_create_payment_from_url_handler',  array( 'WPCB', 'wpcb_create_payment_from_url' )); // Get payment method and register customer to subscription in non-admin mode
            add_action('wp_ajax_wpcb_create_payment_from_session_handler',  array( 'WPCB', 'wpcb_create_payment_from_session' )); // Get payment method and register customer to subscription in admin mode
            add_action('wp_ajax_nopriv_wpcb_create_payment_from_session_handler',  array( 'WPCB', 'wpcb_create_payment_from_session' )); // Get payment method and register customer to subscription in non-admin mode
            add_action('wp_ajax_wpcb_get_customer_detail_by_id_handler', array( 'WPCB', 'wpcb_get_customer_detail_by_id' )); // Get chosen plan and register it to a session in admin mode
            add_action('wp_ajax_nopriv_wpcb_get_customer_detail_by_id_handler',  array( 'WPCB', 'wpcb_get_customer_detail_by_id' )); // Get chosen plan and register it to a session in non-admin mode
            add_filter('gform_countries', array( 'WPCB', 'wpcb_use_country_codes' )); // Use country codes instead of country names on Gravity Forms
            add_action('gform_after_submission', array( 'WPCB', 'wpcb_create_new_chargebee_customer' ), 10, 2); // Create a new Chargebee customer after a Gravity Forms submission
            add_action('admin_init', array( 'WPCB', 'wpcb_apply_registration_hooks' )); // Hook up activate and deactivate hooks
            add_action('admin_menu', array( 'WPCB', 'wpcb_add_main_menu' )); // Add the main plugin menu on WP admin
            add_action('admin_menu', array( 'WPCB', 'wpcb_add_settings_menu' )); // Add the main plugin menu on WP admin
            add_action('wp_enqueue_scripts', array( 'WPCB', 'wpcb_enqueue_frontend' )); // Enqueue all frontend assets and configurations
        }
        
		
        static function activate()
        {
            flush_rewrite_rules();
        }
        
        static function deactivate()
        {
            flush_rewrite_rules();
        }
        
        static function wpcb_require_all()
        {
            include_once plugin_dir_path(__FILE__) . 'inc/shortcodes.php'; // Add all plugin shortcodes
            include_once plugin_dir_path(__FILE__) . 'vendor/autoload.php'; // Get the Chargebee PHP API package    
        }
        
        static function wpcb_get_api_keys()
        {
            WPCB::$api_config_file = json_decode(file_get_contents(plugin_dir_path(__FILE__) . 'inc/api-config.json'), true); // Set the API configuration file
            ChargeBee_Environment::configure(WPCB::$api_config_file[ 'chargeBeeSite' ], WPCB::$api_config_file[ 'chargeBeeApiKey' ]); // Configure the Chargebee PHP API package
        }
        
        static function wpcb_apply_registration_hooks()
        {
            // Activation and deactivation trigger hooks
            register_activation_hook(__FILE__, array( 'WPCB', 'activate' )); // Register activation and deactivation hooks
            register_deactivation_hook(__FILE__, array( 'WPCB', 'deactivate' ));
            
            // Check if Gravity Forms is installed as a dependency
            WPCB::wpcb_has_gravity_forms();
        }
        
        static function wpcb_has_gravity_forms()
        {
            if (is_admin() && current_user_can('activate_plugins') &&  ! is_plugin_active('gravityforms/gravityforms.php') ) {
                add_action('admin_notices', array( 'WPCB', 'wpcb_no_gravity_forms_notice' ));

                deactivate_plugins(plugin_basename(__FILE__)); 

                if (isset($_GET[ 'activate' ]) ) {
                    unset($_GET[ 'activate' ]);
                }
            }
        }
        
        static function wpcb_no_gravity_forms_notice()
        {
            ?><div class="error"><p>Sorry, but WPChargebee requires <a href="https://www.gravityforms.com/" target="_blank">Gravity Forms</a> to be installed and active.</p></div><?php
        }
        
        static function wpcb_enqueue_frontend()
        {
            // Bootstrap
            wp_enqueue_style('bootstrap_css', plugins_url('/assets/css/bootstrap.min.css', __FILE__));
            
            // Stylesheets
            wp_enqueue_style('frontend_css', plugins_url('/assets/css/frontend.css', __FILE__));
            
            
            // Scripts
            wp_enqueue_script('stripe_js', plugins_url('/assets/js/stripecheckout.js', __FILE__), array( 'jquery' ), null, true);
            wp_enqueue_script('plans_js', plugins_url('/assets/js/plans.js', __FILE__), array( 'jquery' ), null, true);
            wp_enqueue_script('checkout_js', plugins_url('/assets/js/checkout.js', __FILE__), array( 'jquery' ), null, true);
            
            // Additional Configurations
            WPCB::wpcb_allow_wp_ajax();
        }
        
        static function wpcb_register_session()
        {
            if (! session_id() ) {
                session_start();
            }
        }
        
        static function wpcb_redirect_if_skipped()
        {
            $plan_slug       = WPCB::$api_config_file[ 'loadPlanPageSlug' ];
            $form_slug       = WPCB::$api_config_file[ 'loadFormPageSlug' ];
            $confirm_slug = WPCB::$api_config_file[ 'loadStripePageSlug' ];
            $current_slug = str_replace('/', '', $_SERVER[ 'REQUEST_URI' ]);
            $planPath = '/' . $plan_slug . '/';
            
            if ($current_slug != $plan_slug ) {
                if ($current_slug == $form_slug ) {
                    echo '<script type="text/javascript">var value = sessionStorage.getItem("planId"); if(value == null) { window.location.href = ' . $planPath . '; }</script>';
                } else if (substr($current_slug, 0, strlen($confirm_slug)) === $confirm_slug ) {
                       $cusId = '';
                    if(array_key_exists('customerId', $_SESSION) ) {
                        $cusId = $_SESSION[ 'customerId' ];
                    }
                    if(! array_key_exists('v', $_GET) && $cusId == "" ) {
                        echo '<script type="text/javascript">window.location.href = '.$planPath.'</script>';
                    }
                }
            }
        }
        
        static function wpcb_allow_wp_ajax()
        {
            // Localize a generated nonce and the path to the admin-ajax.php file
            wp_localize_script(
                'plans_js', 'ajaxData', array( 
                'ajaxUrl'     => admin_url('admin-ajax.php'),
                'nonce'      => wp_create_nonce('site_nonce')
                )
            );
            
            // Localize the dynamic Stripe slug provided from the settings menu
            wp_localize_script(
                'checkout_js', 'stripeData', array( 
                'stripeKey'      => WPCB::$api_config_file[ 'stripeKey' ],
                'stripeSlug'  => WPCB::$api_config_file[ 'loadStripePageSlug' ],
                'formSlug'    => WPCB::$api_config_file[ 'loadFormPageSlug' ],
                'planSlug'    => WPCB::$api_config_file[ 'loadPlanPageSlug' ],
                'stripeEmail' => WPCB::$api_config_file[ 'stripeEmail' ],
                'stripeImg'   => WPCB::$api_config_file[ 'stripeImg' ],
                'successMsg'  => preg_replace('/\\\\/', '', WPCB::$api_config_file[ 'successMsg' ]),
                )
            );
        }
        
        static function wpcb_get_chosen_plan()
        {
            wp_verify_nonce( 'site_nonce', 'wpcb_get_chosen_plan' );
            
            $planId    = sanitize_text_field($_POST['planId']);
            $planName  = sanitize_text_field($_POST['planName']);
            $planPrice = sanitize_text_field($_POST['planPrice']);
            
            $_SESSION[ 'initPlanId' ]      = $planId;
            $_SESSION[ 'initPlanName' ]    = $planName;
            $_SESSION[ 'initPlanPrice' ]   = $planPrice;
            
            wp_die();
        }
        
        static function wpcb_get_session_plan()
        {
            wp_verify_nonce( 'site_nonce', 'wpcb_get_session_plan' );
			
            $result = json_encode(
                array(
                'initPlanId'    => $_SESSION[ 'initPlanId' ],
                'initPlanName'  => $_SESSION[ 'initPlanName' ],
                'initPlanPrice' => $_SESSION[ 'initPlanPrice' ]
                ) 
            );
            
            echo $result;
            wp_die();
        }
        
        static function wpcb_add_main_menu()
        {
            $page_title = 'WPCB';
            $menu_title = 'WPCB';
            $capability = 'manage_options';
            $menu_slug  = 'wpcb';
            $function     = array( 'WPCB', 'wpcb_add_main_menu_content' );
            $icon_url     = 'dashicons-groups';
            $position     = 99;
            
            add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
            
            return $menu_slug;
        }
        
        static function wpcb_add_main_menu_content()
        {
            // Get and return the HTML to render the plugin options
            ob_start();
            include_once plugin_dir_path(__FILE__) . 'content/content-main-menu.php';
            echo ob_get_clean();
        }
        
        static function wpcb_add_settings_menu()
        {
            $parent_slug = WPCB::wpcb_add_main_menu();
            $page_title  = 'Settings';
            $menu_title  = 'Settings';
            $capability  = 'manage_options';
            $menu_slug	 = 'wpcb-settings';
            $function	 = array( 'WPCB', 'wpcb_add_settings_menu_content' );
            
			add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
        }
        
        static function wpcb_add_settings_menu_content()
        {
            // Get and return the HTML to render the plugin options
            ob_start();
            include_once plugin_dir_path(__FILE__) . 'content/content-settings-menu.php';
            echo ob_get_clean();
        }
        
        static function wpcb_use_country_codes( $countries )
        {
            $new_countries = array();

            foreach ( $countries as $country ) {
                $code = GF_Fields::get('address')->get_country_code($country);
                $new_countries[ $code ] = $country;
            }

            return $new_countries;
        }
        
        static function wpcb_create_new_chargebee_customer( $entry ,$form )
        {
            $form_slug       = WPCB::$api_config_file[ 'loadFormPageSlug' ];
            $confirm_slug = WPCB::$api_config_file[ 'loadStripePageSlug' ];
			$fromPath = '/' . $form_slug . '/';
			$confirmPath = '/' . $confirm_slug . '/';
			if( array_key_exists('initPlanId', $_SESSION) ) {
				$init_plan_id = $_SESSION['initPlanId'];
				$init_plan_name = $_SESSION['initPlanName'];
				$init_plan_price = $_SESSION['initPlanPrice'];
			}
			
			try{
				if ($_SESSION[ 'cart' ][ 'id' ] == $form[ 'id' ] ) {
					$fieldValues = array(
					"firstName" => rgar($entry, $_SESSION[ 'cart' ][ 'first_name' ]),
					"lastName"  => rgar($entry, $_SESSION[ 'cart' ][ 'last_name' ]),
					"email"     => rgar($entry, $_SESSION[ 'cart' ][ 'email' ]),
					"phone"     => rgar($entry, $_SESSION[ 'cart' ][ 'phone' ]),
					"metaData"     => json_encode(
						array( 
						"initPlanId"    => $init_plan_id,
						"initPlanName"  => $init_plan_name,
						"initPlanPrice" => $init_plan_price
						)
					),
					"auto_collection" => 'off',
					"billingAddress" => array(
					"firstName" => rgar($entry, $_SESSION[ 'cart' ][ 'first_name' ]),
					"lastName"  => rgar($entry, $_SESSION[ 'cart' ][ 'last_name' ]),
					"line1"     => rgar($entry, $_SESSION[ 'cart' ][ 'line_one' ]),
					"city"      => rgar($entry, $_SESSION[ 'cart' ][ 'city' ]),
					"state"     => rgar($entry, $_SESSION[ 'cart' ][ 'state' ]),
					"zip"       => rgar($entry, $_SESSION[ 'cart' ][ 'zip' ]),
					"country"   => rgar($entry, $_SESSION[ 'cart' ][ 'country' ])
					)
					);

					foreach ( array_keys($_SESSION[ 'custFields' ]) as $attr ) {
						$fieldValues[ $attr ] = rgar($entry, $_SESSION[ 'custFields' ][ $attr ]);
					}
					foreach ( $form[ 'fields' ] as $field ) {
						if ($field->type === "checkbox" ) {
							if(sizeof($field->choices) === 1) {
								$field_value = $field->get_value_export($entry, $field->id, true);
								$stripped = str_replace(' ', '', $field_value);

								if(strlen($stripped) > 0 ) {
									$fieldValues[ $_SESSION[ 'custFields_reverse' ][ $field->id ] ] = "True";
								}
							}
						}
					}

					$result = ChargeBee_Customer::create($fieldValues);
					$customer = $result->customer();
					$card = $result->card();

					$_SESSION[ 'customerId' ] = $customer->id;
					$_SESSION[ 'formFilled' ] = true;
					$_SESSION[ 'isError' ] = "false";
					echo '<script type="text/javascript">window.location.href = '.$confirmPath.'</script>';
				}
			} catch (Exception $e){
				$_SESSION[ 'isError' ] = "true";
				echo '<script type="text/javascript">window.location.href = '.$fromPath.'</script>';
			}
        }
        
        // myCourse signup takes Stripe Token from client and creates a payment source
        static function wpcb_create_payment_from_url()
        {
            wp_verify_nonce( 'site_nonce', 'wpcb_create_payment_from_url' );
            
            $result = ChargeBee_PaymentSource::createUsingTempToken(
                array( 
                "gatewayAccountId" => WPCB::$api_config_file[ 'gatewayAccountId' ],
                "customerId"       => $_SESSION[ 'urlCustId' ],
                "type"             => "card",
                "tmpToken"         => sanitize_text_field($_POST[ 'tokenId' ])
                ) 
            );
            
            $customer = $result->customer();
            $paymentSource = $result->paymentSource();
            
            $subresult = ChargeBee_Subscription::createForCustomer(
                $_SESSION[ 'urlCustId' ], array( 
                "planId" => $_SESSION[ 'urlMetaData' ][ 'initPlanId' ],
                "auto_collection" => 'on'
                ) 
            );

            $subscription    = $subresult->subscription();
            $customer        = $subresult->customer();
            $card            = $subresult->card();
            $invoice         = $subresult->invoice();
            $unbilledCharges = $subresult->unbilledCharges();

            session_unset();
            wp_die();
        }
        
        static function wpcb_create_payment_from_session()
        {
			wp_verify_nonce( 'site_nonce', 'wpcb_create_payment_from_session' );
			
            $tokenId   = sanitize_text_field($_POST['tokenId']);
            $result = ChargeBee_PaymentSource::createUsingTempToken(
                array( 
                "gatewayAccountId" => WPCB::$api_config_file[ 'gatewayAccountId' ],
                "customerId"       => $_SESSION[ 'customerId' ],
                "type"             => "card",
                "tmpToken"         => $tokenId
                ) 
            );
            
            $customer = $result->customer();
            $paymentSource = $result->paymentSource();
            
            $subresult = ChargeBee_Subscription::createForCustomer(
                $_SESSION[ 'customerId' ], array( 
                "planId" => $_SESSION[ 'initPlanId' ],
                "auto_collection" => 'on'
                ) 
            );

            $subscription    = $subresult->subscription();
            $customer        = $subresult->customer();
            $card            = $subresult->card();
            $invoice         = $subresult->invoice();
            $unbilledCharges = $subresult->unbilledCharges();

            session_unset();
            wp_die();
        }
        
        static function wpcb_get_customer_detail_by_id()
        {
            wp_verify_nonce( 'site_nonce', 'wpcb_get_customer_detail_by_id' );
			
            $custId    = sanitize_text_field($_POST['custId']);
            $result = ChargeBee_Customer::retrieve($custId);
            
            $customer = $result->customer();
            $metadata = $customer->metaData;
            
            $_SESSION[ 'urlMetaData' ] = $metadata;
            $_SESSION[ 'urlCustId' ] = $custId;
            
            echo json_encode($metadata);
            wp_die();
        }
    }
    
    WPCB::wpcb_register();
}