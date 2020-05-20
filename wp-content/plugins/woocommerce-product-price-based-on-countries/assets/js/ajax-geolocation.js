/* global wc_price_based_country_ajax_geo_params */
;( function( $ ) {

	// wc_price_based_country_ajax_geo_params is required to continue, ensure the object exists
	if ( typeof wc_price_based_country_ajax_geo_params === 'undefined' ) {
		return false;
	}

	var geolocation = {

		xhr: false,

		get_product_ids: function(){
			var ids                = [];
			var product_id         = null;

			$('span.wcpbc-price.loading').each(function(){

				product_id = $(this).data('productId');

				if ( typeof product_id === 'undefined' ) {
					// Get product_id from class because the data attr have been removed
					var product_id_class = $(this).attr('class').match(/wcpbc-price-\d+/);
					if ( typeof product_id_class !== 'undefined' && product_id_class !== null && product_id_class.length > 0 ) {
						product_id = parseInt( product_id_class[0].replace('wcpbc-price-', '') );
					}
				}
				if ( product_id && typeof product_id !== 'undefined' ) {
					// Add the product ID
					ids.push(product_id);
				}
			});

			// Add product variations
			if ( $( 'form.variations_form' ).length > 0 ) {

				$( 'form.variations_form' ).each( function() {

					var product_variations = $(this).data('product_variations');

					if ( null !== product_variations && typeof product_variations !== 'undefined' ) {

						$.each( product_variations, function(i, variation ){
							if ( typeof variation.variation_id !== 'undefined' ){
								ids.push( variation.variation_id );
							}
						});
					}
				});
			}

			$(document.body).trigger( 'wc_price_based_country_get_product_ids', [ids] );

			ids.sort();	// Sort before return.
			return ids;
		},

		get_areas: function(){
			var areas = {};

			$('.wc-price-based-country-refresh-area:not(.refreshed)').each( function(i, el){
				var area 	= $(el).data('area');
				var id 		= $(el).data('id');
				var options	= $(el).data('options');

				if ( typeof area !== 'undefined' && typeof id !== 'undefined' && typeof options !== 'undefined' ) {
					if ( typeof areas[area] == 'undefined' ) {
						areas[area] = {};
					}
					areas[area][id] = options;
				}
			});

			return areas;
		},

		refresh_product_price: function( products ) {
			var $price_html;

			$.each( products, function( i, product ) {

				$price_html = $('<div>'+ product.price_html+'</div>').find('.wcpbc-price.wcpbc-price-' + product.id + ':first');

				if ( typeof $price_html !== 'undefined') {
					$( '.wcpbc-price.wcpbc-price-' + product.id ).html($price_html.html()).removeClass('loading');
				}
			});

			// update product variation
			if ( $( 'form.variations_form' ).length > 0 ) {
				$( 'form.variations_form' ).each( function() {

					var product_variations = $( this ).data( 'product_variations' );

					if ( null !== product_variations && typeof product_variations !== 'undefined' ) {
						$.each( product_variations, function( i, variation ){

							var $price_html = $( variation.price_html );

							if (typeof products[ variation.variation_id ] !== 'undefined') {

								product_variations[i].display_price 		= products[variation.variation_id].display_price;
								product_variations[i].display_regular_price = products[variation.variation_id].display_regular_price;

								if ( $price_html.hasClass( 'price' ) ) {
									$price_html.first().html( products[ variation.variation_id ].price_html );
								}else {
									$price_html.html( products[ variation.variation_id ].price_html );
								}
							}

							// Set price html visible
							$price_html.find('.wcpbc-price').css('visibility', '');
							$price_html.find('.wcpbc-price').removeClass('loading');

							product_variations[i].price_html = $price_html.html();
						});

						$(this).data('product_variations', product_variations);
					}

				});
			}

			$(document.body).trigger( 'wc_price_based_country_set_product_price', [products] );

			// set visible all elements
			$('.wcpbc-price').css('visibility', '');
			$('.wcpbc-price').css('display', '');	//Fix issue with plugins that uses the class 'loading' to hide elements.
			$('.wcpbc-price').removeClass('loading');
		},

		refresh_areas: function( areas ) {
			$.each(areas, function(i, data){
				var selector 	 = '.wc-price-based-country-refresh-area[data-id="' + data.id + '"][data-area="' + data.area + '"]';
				var content_html = $(data.content).filter('.wc-price-based-country-refresh-area[data-area="' + data.area + '"]').html();

				$(selector).html(content_html).addClass('refreshed');
			});
		},

		refresh_currency_settings: function( currency_params ) {

			if ( typeof woocommerce_price_slider_params !== 'undefined' && typeof accounting !== 'undefined' ) {
				var min_price = $( '.price_slider_amount #min_price' ).data( 'min' ),
					max_price = $( '.price_slider_amount #max_price' ).data( 'max' );

				$( '.price_slider_amount span.from' ).html( accounting.formatMoney( min_price, {
					symbol:    currency_params.symbol,
					decimal:   currency_params.decimal_sep,
					thousand:  currency_params.thousand_sep,
					precision: woocommerce_price_slider_params.currency_format_num_decimals,
					format:    currency_params.format
				} ) );

				$( '.price_slider_amount span.to' ).html( accounting.formatMoney( max_price, {
					symbol:    currency_params.symbol,
					decimal:   currency_params.decimal_sep,
					thousand:  currency_params.thousand_sep,
					precision: woocommerce_price_slider_params.currency_format_num_decimals,
					format:    currency_params.format
				} ) );

				woocommerce_price_slider_params.currency_format_symbol       = currency_params.symbol;
				woocommerce_price_slider_params.currency_format_decimal_sep  = currency_params.decimal_sep;
				woocommerce_price_slider_params.currency_format_thousand_sep = currency_params.thousand_sep;
				woocommerce_price_slider_params.currency_format              = currency_params.format;
			}
			$(document.body).trigger( 'wc_price_based_country_set_currency_params', [currency_params] );
		},

		geolocate_customer: function(){

			if ( geolocation.xhr ) {
				geolocation.xhr.abort();
			}

			var xhr_data = {
				ids: 	   geolocation.get_product_ids(),
				areas:     geolocation.get_areas(),
				is_single: $('body').hasClass('single') ? '1' : '0'
			};

			if ( 0 === xhr_data.ids.length && $.isEmptyObject( xhr_data.areas ) ) {
				return;
			}

			geolocation.xhr = $.ajax({
				url: wc_price_based_country_ajax_geo_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'wcpbc_get_location' ),
				data: xhr_data,
				type: 'POST',
				success: function( response ) {
					geolocation.refresh_product_price(response.products);
					geolocation.refresh_areas(response.areas);
					geolocation.refresh_currency_settings(response.currency_params);

					$(document.body).trigger( 'wc_price_based_country_after_ajax_geolocation', [response.zone_id] );
				},
				error: function() {
					// set visible all elements
					$('.wcpbc-price').css('visibility', '');
					$('.wcpbc-price').css('display', '');	//Fix issue with plugins that uses the class 'loading' to hide elements.
					$('.wcpbc-price').removeClass('loading');
				},
				complete: function() {
					geolocation.xhr = false;
				}
			});
		},

		init: function(){
			// On page load
			this.geolocate_customer();

			// After AJAX call
			$(document).ajaxComplete(function( event, xhr, settings ) {
				if ( $('body').find('.wcpbc-price.loading').length == 0 || settings.url.indexOf( 'wcpbc_get_location' ) > 0 || settings.url.indexOf( 'get_refreshed_fragments' ) > 0 ) {
					return;
				}
				if ( typeof xhr.responseText !== 'undefined' && xhr.responseText.indexOf('wcpbc-price') > 0 ) {
					geolocation.geolocate_customer();
				}
			});

			// On event.
			$(document.body).on('wc_price_based_country_ajax_geolocation', geolocation.geolocate_customer );
		}
	};
	geolocation.init();
})( jQuery );