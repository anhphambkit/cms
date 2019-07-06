/*=========================================================================================
    File Name: coupon.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/
import { HandlebarRender } from '@coreComponents/base/inc/handlebarForm';
import { Handlebars } from '@pluginComponents/product/product-handlebar';
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/* register handlebar */
let miniCart = new HandlebarRender();
miniCart.setSourceElement('#template-mini-cart');
miniCart.setTemplateElement('#mini-cart-header');
miniCart.afterParseTemplate(() => {
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).on('click', '.add-coupon-btn', function (e) {
    e.preventDefault();
    let couponCode = $(this).parents('.coupon-form').find('.coupon_code').val();
    let data = {
        coupon_code : couponCode
    };
    let _this = this;
    let request = axios.post(API_SHOP.ADD_COUPON_TO_CART, data);
    request
        .then(function(data){
            if (data.data.coupon) {
                $('.coupon-in-use').html(``);

                $('.coupon-in-use').append(`<div class="row coupon-${data.data.coupon.id}">
                                               <div class="text-uppercase mb-2 col-md-8 coupon-code-text">${data.data.coupon.code}</div>
                                               <div class="text-uppercase mb-2 col-md-4">
                                                   <a class="action-delete-coupon delete-coupon-${data.data.coupon.id}" data-coupon-id="${data.data.coupon.id}">
                                                       <i class="far fa-trash-alt icon-action-delete-coupon"></i>
                                                       Delete
                                                   </a>
                                               </div>
                                           </div>`);
            }
            updateInfoUICart(data.data);
            if (data.data.status === 'success') {
                $('#coupon_code').val('');
                Lcms.showNotice('success', data.data.message, Lcms.languages.notices_msg.success);
            }
            else {
                Lcms.showNotice('error', data.data.message, Lcms.languages.notices_msg.error);
            }
        })
        .catch(function(data){
            console.log("error", data);
        })
        .then(function(data){

        });
});

$(document).on('click', '.action-delete-coupon', function (e) {
    e.preventDefault();
    let couponId = $(this).data('coupon-id');
    let data = {
        coupon_id : couponId
    };

    let request = axios.delete(API_SHOP.DELETE_COUPON_IN_CART, { params: data});
    request
        .then(function(data){
            $(`.coupon-in-use .coupon-${couponId}`).remove();
            updateInfoUICart(data.data);
            if (data.data.status === 'success') {
                Lcms.showNotice('success', data.data.message, Lcms.languages.notices_msg.success);
            }
            else {
                Lcms.showNotice('error', data.data.message, Lcms.languages.notices_msg.error);
            }
        })
        .catch(function(data){
            console.log("error", data);
        })
        .then(function(data){

        });
});