($ => {
    $(document).ready(() => {
		
		
		const planPath = '/' + stripeData.planSlug + '/';
		const formPath = '/' + stripeData.formSlug + '/';
        if(window.location.pathname == planPath) {
			sessionStorage.removeItem('planId');
			const planBox = $('.plan-box'); // jQuery objects
            
            const events = () => {
                planBox.click(event => handleFormLoad(event));
            };
            
            const handleFormLoad = e => {
                const planButtonId    = $(e.currentTarget).attr('data-plan-id');
                const planButtonName  = $(e.currentTarget).attr('data-plan-name');
                const planButtonPrice = $(e.currentTarget).attr('data-plan-price');
				const initPlan = {'planId' : planButtonId, 'planName' : planButtonName , 'planPrice' : planButtonPrice};
				sessionStorage.setItem('planId', planButtonId);
				//sessionStorage.setItem('initPlan',initPlan);
				window.location.href = formPath
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: ajaxData.ajaxUrl,
                    data: {
                        planId: planButtonId,
                        planName: planButtonName,
                        planPrice: planButtonPrice,
                        action: 'wpcb_get_chosen_plan_handler',
                        _ajax_nonce: ajaxData.nonce
                    },
					success: window.location.href = formPath
                });
            }

            events(); // Load jQuery event listeners
        } 
    });
})(jQuery);