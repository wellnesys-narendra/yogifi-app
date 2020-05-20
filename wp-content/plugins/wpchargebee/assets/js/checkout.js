($ => {
    $(document).ready(() => {
		const urlParams  = new URLSearchParams(location.search);

		const stripePath = '/' + stripeData.stripeSlug + '/';
		const planPath 	 = '/' + stripeData.planSlug + '/';
		const formPath 	 = '/' + stripeData.formSlug + '/';

		if(window.location.pathname == stripePath) { 
			if(urlParams.has('v')) {
				const urlCustId = urlParams.get('v');

				$.ajax({
					type: 'post',
					url: ajaxData.ajaxUrl,
					data: {
						custId: urlCustId,
						action: 'wpcb_get_customer_detail_by_id_handler',
						_ajax_nonce: ajaxData.nonce
					},
					success: response => {
						validateResponse(response);
					},
					error: error => {
						console.log(error);
					}
				});
			} else {
				$.ajax({
					type: 'get',
					url: ajaxData.ajaxUrl,
					data: {
						action: 'wpcb_get_session_plan_handler',
						_ajax_nonce: ajaxData.nonce
					},
					success: response => {
						validateResponse(response);
					},
					error: error => {
						console.log(error);
					}
                });
			}

			let paymentSuccessful = false; // State tracker for payments
			let handler = null;

			try {
				handler = StripeCheckout.configure({
					key: stripeData.stripeKey,
					image: stripeData.stripeImg,
					allowRememberMe: false,
					token: token => {
						if(urlParams.has('v')) {
							addPaymentHandlerForUrls(token.id);
						} else {
							addPaymentHandlerForSessions(token.id);
						}
					},
					closed: () => {
						if(paymentSuccessful) {
							$('.confirm-message').html(stripeData.successMsg);
						} else {
							$('.confirm-message').html('<p>Unfortunately, the payment did not succeed. Click <a href="javascript: location.reload(true); ">here</a> to try again. Please ensure your credit card details are correct.</p>');
						}

						$('.spinner-container').hide();
					}
				});
			} catch(e) {
				window.location.href = planPath;
			}

			const validateResponse = resp => {
				var SCRIPT_REGEX = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi;
				while (SCRIPT_REGEX.test(resp)) {
    				resp = resp.replace(SCRIPT_REGEX, "");
				}
				
				const data = JSON.parse(resp);
				if(!data.initPlanName) {
					window.location.href = planPath;
				} else {
					openHandler(handler, data.initPlanName, data.initPlanPrice);
				}
			};
			
			const openHandler = (stripeHandler, plName, plPrice) => {
				stripeHandler.open({
		    		name: plName,
		    		amount: parseInt(plPrice),
		    		email: stripeData.stripeEmail
				});
			};
	
			const addPaymentHandlerForUrls = tokId => {
				$.ajax({
		    		type: 'post',
		    		dataType: 'json',
		    		url: ajaxData.ajaxUrl,
		    		data: {
		        		tokenId: tokId,
		        		action: 'wpcb_create_payment_from_url_handler',
		        		_ajax_nonce: ajaxData.nonce
		    		},
		    		error: error => {
		        		console.log(error);
		    		}
				});
			
				paymentSuccessful = true;
			};

			const addPaymentHandlerForSessions = tokId => {
				$.ajax({
		    		type: 'post',
		    		url: ajaxData.ajaxUrl,
		    		data: {
		        		tokenId: tokId,
		        		action: 'wpcb_create_payment_from_session_handler',
		        		_ajax_nonce: ajaxData.nonce
		    		},
		    		error: error => {
		        		console.log(error);
		    		}
				});
			
				paymentSuccessful = true;
			};
		}
	});

})(jQuery);