/*=========================================================================================
    File Name: checkout-coupon.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

$(document).on('click', '#add-coupon-btn', function (e) {
    e.preventDefault();
    let couponCode = $('#coupon_code').val();
    let data = {
        coupon_code : couponCode
    };

    let request = axios.post(API.ADD_COUPON_TO_CART, data);
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
            $('.total-price-checkout').html(`$${data.data.total_price}`);
            $('.your-saved-checkout').html(`$${data.data.saved_price}`);
            $('.checkout-get-design .wanting-price').html(`+  $${data.data.free_design.wanting_price}`);
            $('.checkout-get-design .total-free-designs-cart').html(`to qualify for ${data.data.free_design.total_free_design + 1} FREE DESIGN`);
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

    let request = axios.delete(API.DELETE_COUPON_IN_CART, { params: data});
    request
        .then(function(data){
            $(`.coupon-in-use .coupon-${couponId}`).remove();
            $('.total-price-checkout').html(`$${data.data.total_price}`);
            $('.your-saved-checkout').html(`$${data.data.saved_price}`);
            $('.checkout-get-design .wanting-price').html(`+  $${data.data.free_design.wanting_price}`);
            $('.checkout-get-design .total-free-designs-cart').html(`to qualify for ${data.data.free_design.total_free_design + 1} FREE DESIGN`);
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