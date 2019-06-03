/*=========================================================================================
    File Name: cart.js
    ----------------------------------------------------------------------------------------
    Author: AnhPham
==========================================================================================*/
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

(function(window, document, $) {
    'use strict';
    $(document).on('change', '.quantity-product-item-input', function(e) {
        let products = {};
        let newProduct = {};
        let productId = $(this).parents('.row-product').data('product-id');
        newProduct[productId] = $(this).val();
        products = Object.assign(products, newProduct);
        let _this = $(this);
        let request = axios.post(API_SHOP.UPDATE_PRODUCT_IN_CART, { 'products' : products, 'is_update_product' : true });

        request
            .then(function(data){
                let totalItems = data.data.total_items;
                if (totalItems > 0) // Update UI cart number
                    $('.shopping-cart-quantity i').html(`(${totalItems})`);
                else
                    $('.shopping-cart-quantity i').html();

                $('.cart-info-total .sub-total-cart').html(`$${data.data.total_price}`);
                $('.cart-info-total .total-price-cart').html(`$${data.data.total_price}`);
                $('.cart-info-total .saved-price-cart').html(`$${data.data.saved_price}`);
                $('.cart-info-total .wanting-price').html(`$${data.data.free_design.wanting_price}`);
                $('.cart-info-total .total-free-designs-cart').html(`to qualify for ${data.data.free_design.total_free_design + 1} FREE DESIGN`);
            })
            .catch(function(error){
            })
            .then(function(data){ // Finally
            });
    });

    $(document).on('click', '.btn-remove-product-in-cart', function(e) {
        let productId = $(this).parents('.row-product').data('product-id');
        let _this = $(this);
        let request = axios.post(API_SHOP.DELETE_PRODUCT_IN_CART, { 'product_id' : productId });
        request
            .then(function(data){
                let totalItems = data.data.total_items;
                if (totalItems > 0) // Update UI cart number
                    $('.shopping-cart-quantity i').html(`(${totalItems})`);
                else
                    $('.shopping-cart-quantity i').html();
                $('.cart-info-total .sub-total-cart').html(`$${data.data.total_price}`);
                $('.cart-info-total .total-price-cart').html(`$${data.data.total_price}`);
                $('.cart-info-total .saved-price-cart').html(`$${data.data.saved_price}`);
                $('.cart-info-total .wanting-price').html(`$${data.data.free_design.wanting_price}`);
                $('.cart-info-total .total-free-designs-cart').html(`to qualify for ${data.data.free_design.total_free_design + 1} FREE DESIGN`);
                _this.parents('.row-product').remove();
            })
            .catch(function(error){
            })
            .then(function(data){ // Finally
            });
    });

    function ttInputCounter() {
        $(document).on("click", ".btn-minus-quantity-item, .btn-plus-quantity-item", function(event) {
            event.preventDefault();
            let $input = $(this).parents('.quantity-product-item').find('input.quantity-product-item-input');
            let count = parseInt($input.val(), 10) + parseInt(event.currentTarget.className === 'btn btn-plus-quantity-item' ? 1 : -1, 10);
            $input.val(count).change();
        });
        $(document).on("change", '.quantity-product-item-input', function() {
            let _ = $(this);
            let min = 1;
            let val = parseInt(_.val(), 10) || 0;
            let max = parseInt(_.attr('size'), 10) || 99;
            val = Math.min(val, max);
            val = Math.max(val, min);
            _.val(parseInt(val));
        })
        .on("keypress", function( e ) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }

            e = (e) ? e : window.event;
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        });
    };
    ttInputCounter();
})(window, document, jQuery);