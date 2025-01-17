"use strict";
jQuery(function ($) {
    $('#woocs_auto_switcher_skin').on("change", function () {
        var woocs_side_switcher_skin = $(this).val();
        if (woocs_side_switcher_skin == 'roll_blocks') {
            $('.woocs_roll_blocks_width').show(200);
        } else {
            $('.woocs_roll_blocks_width').hide(200);
        }
    });


    $('#woocs_is_multiple_allowed').on("change", function () {
        var woocs_is_multiple_allowed = parseInt($(this).val(), 10);
        var woocs_is_fixed_enabled = parseInt($('#woocs_is_fixed_enabled').val(), 10);
        //***
        if (woocs_is_multiple_allowed) {
            $('input[name=woocs_is_fixed_enabled]').parents('tr').show(200);
            $('input[name=woocs_is_fixed_coupon]').parents('tr').show(200);
            $('input[name=woocs_is_fixed_shipping]').parents('tr').show(200);
            if (woocs_is_fixed_enabled) {
                $('input[name=woocs_force_pay_bygeoip_rules]').parents('tr').show(200);
            }
        } else {
            $('input[name=woocs_is_fixed_enabled]').parents('tr').hide(200);
            $('input[name=woocs_is_fixed_coupon]').parents('tr').hide(200);
            $('input[name=woocs_is_fixed_shipping]').parents('tr').hide(200);
            $('input[name=woocs_force_pay_bygeoip_rules]').parents('tr').hide(200);
        }
    });



    //***

    init_switcher23();

    document.addEventListener('woocs_blind_option', function (e) {
        //_this.change_field(e.detail.page_id, e.detail.name, 'checkbox', e.detail.value);
        if (parseInt(e.detail.value, 10)) {
            alert(woocs_lang.blind_option);
        }

        //***

        if (e.detail.name === 'woocs_is_fixed_enabled') {
            if (parseInt(e.detail.value, 10)) {
                jQuery('input[name=woocs_force_pay_bygeoip_rules]').parents('tr').show(200);
            } else {
                jQuery('input[name=woocs_force_pay_bygeoip_rules]').parents('tr').hide(200);
            }
        }



    });


    document.addEventListener('woocs_is_auto_switcher', function (e) {
        if (parseInt(e.detail.value, 10)) {
            $('#tabs-6 .form-table tbody > tr').not(':first').show(200);
            $('#tabs-6 .form-table').not(':first').show(200);
            $('#tabs-6 .demo-img-1').show(200);
        } else {
            $('#tabs-6 .form-table tbody > tr').not(':first').hide(200);
            $('#tabs-6 .form-table').not(':first').hide(200);
            $('#tabs-6 .demo-img-1').hide(200);
        }
    });

    //***

    $('.woocs-select-all-in-select').on('click', function () {
        $(this).parents('td').find('select option').attr('selected', true);
        $(this).parents('td').find('select').trigger('change');
        return false;
    });

    $('.woocs-clear-all-in-select').on('click', function () {
        $(this).parents('td').find('select option').attr('selected', false);
        $(this).parents('td').find('select').trigger('change');
        return false;
    });

    //***
    //https://gromo.github.io/jquery.scrollbar/demo/advanced.html
    jQuery('.scrollbar-external').scrollbar({
        autoScrollSize: false,
        scrollx: $('.external-scroll_x'),
        scrolly: $('.external-scroll_y')
    });


});

jQuery(function ($) {

    jQuery('.wfc-tabs').wfcTabs();

    jQuery("#woocs_list").sortable({
        handle: '.woocs_settings_move img'
    });

    jQuery('#woocs_add_currency').life('click', function () {
        jQuery('#woocs_list').append(jQuery('#woocs_item_tpl').html());
        return false;
    });
    jQuery('.woocs_del_currency').life('click', function () {
        jQuery(this).parents('tr').hide(220, function () {
            jQuery(this).remove();
        });
        return false;
    });

    jQuery('.woocs_is_etalon').life('click', function () {
        jQuery('.woocs_is_etalon').next('input[type=hidden]').val(0);
        jQuery('.woocs_is_etalon').prop('checked', 0);
        jQuery(this).next('input[type=hidden]').val(1);
        jQuery(this).prop('checked', 1);
        jQuery(this).parents('tr').find("input[name='woocs_rate[]']").val(1);
        jQuery(this).parents('tr').find("input[name='woocs_rate_plus[]']").val('');
        //instant save
        var currency_name = jQuery(this).parents('tr').find('input[name="woocs_name[]"]').val();
        if (currency_name.length) {
            woocs_show_stat_info_popup(woocs_lang.loading + ' ...');
            var data = {
                action: "woocs_save_etalon",
                currency_name: currency_name
            };
            jQuery.post(ajaxurl, data, function (request) {
                try {
                    request = jQuery.parseJSON(request);

                    jQuery.each(request, function (index, value) {
                        var elem = jQuery('input[name="woocs_name[]"]').filter(function () {
                            return this.value.toUpperCase() == index;
                        });

                        if (elem) {
                            jQuery(elem).parents('tr').find('input[name="woocs_rate[]"]').val(value);
                            jQuery(elem).parents('tr').find('input[name="woocs_rate[]"]').text(value);
                        }
                    });

                    woocs_hide_stat_info_popup();
                    woocs_show_info_popup(woocs_lang.save_changes, 1999);
                } catch (e) {
                    woocs_hide_stat_info_popup();
                    alert('Request error! Try later or another agregator!');
                }
            });
        }

        return true;
    });


    jQuery('.woocs_flag_input').life('change', function ()
    {
        jQuery(this).next('a.woocs_flag').find('img').attr('src', jQuery(this).val());
    });

    jQuery('.woocs_flag').life('click', function ()
    {
        var input_object = jQuery(this).prev('input[type=hidden]');
        window.send_to_editor = function (html)
        {
            woocs_insert_html_in_buffer(html);
            var imgurl = jQuery('#woocs_buffer').find('a').eq(0).attr('href');
            woocs_insert_html_in_buffer("");
            jQuery(input_object).val(imgurl);
            jQuery(input_object).trigger('change');
            tb_remove();
        };
        tb_show('', 'media-upload.php?post_id=0&type=image&TB_iframe=true');

        return false;
    });

    jQuery('.woocs_get_fresh_rate').life('click', function () {
        var currency_name = jQuery(this).parents('tr').find('input[name="woocs_name[]"]').val();
        //console.log(currency_name);
        var _this = this;
        jQuery(_this).parent().find('input[name="woocs_rate[]"]').val(woocs_lang.loading.toLowerCase() + ' ...');
        var data = {
            action: "woocs_get_rate",
            currency_name: currency_name
        };
        jQuery.post(ajaxurl, data, function (value) {
            jQuery(_this).parent().find('input[name="woocs_rate[]"]').val(value);
        });

        return false;
    });

    //***

    $('.label.container').life('click', function () {
        $(this).find('input[type=radio]').trigger('click');
        return true;
    });

    //loader
    jQuery(".woocs-admin-preloader").fadeOut("slow");

});


//*********************

function woocs_update_all_rates() {
    jQuery('.woocs_is_etalon:checked').trigger('click');
}

function woocs_add_money_sign2() {
    jQuery('a[href=#tabs-2]').trigger('click');
    jQuery('#tabs-2').find('#woocs_customer_signs').focus();
    jQuery('#woocs_customer_signs').scroll();
}

function init_switcher23(container = '') {
    Array.from(document.querySelectorAll(container + ' .switcher23')).forEach((button) => {
        button.addEventListener('click', function () {

            if (this.value > 0) {
                this.value = 0;
                this.previousSibling.value = 0;
                this.removeAttribute('checked');
            } else {
                this.value = 1;
                this.previousSibling.value = 1;
                this.setAttribute('checked', 'checked');
            }

            if (this.previousSibling.getAttribute('name') === 'woocs_shop_is_cached') {
                if (parseInt(this.value, 10)) {
                    jQuery('input[name=woocs_shop_is_cached_preloader]').parents('tr').show(200);
                } else {
                    jQuery('input[name=woocs_shop_is_cached_preloader]').parents('tr').hide(200);
                }
            }

            //Trigger the event
            if (this.getAttribute('data-event').length > 0) {
                //window.removeEventListener(this.getAttribute('data-event'));
                document.dispatchEvent(new CustomEvent(this.getAttribute('data-event'), {detail: {
                        name: this.previousSibling.getAttribute('name'),

                        value: parseInt(this.value, 10)
                    }}));


                //this.setAttribute('data-event-attached', 1);
            }


            return true;
        });
    });
}

