/*=========================================================================================
    File Name: product-detail.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/

import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

$(document).ready(function() {
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        accessibility: false,
        infinite: false,
        dots: false,
        arrows: true,
        // fade: true,
        asNavFor: '.slider-nav',
        prevArrow:"<i class='fas fa-arrow-left slick-prev'></i>",
        nextArrow:"<i class='fas fa-arrow-right slick-next'></i>"
    });

    $('.slider-nav').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        accessibility: false,
        infinite: false,
        dots: false,
        arrows: false,
        focusOnSelect: true
    });

    $('.item-product-attribute.item-color-attribute').on('click', function(event) {
        event.preventDefault();
        $('.item-product-attribute.item-color-attribute').removeClass('active');
        $(this).addClass('active');
        $(this).parents('.product-attribute').find('.attribute-selected-title').text($(this).data('color'));
        $(this).parents('.product-attribute').data('attribute-selected-id', $(this).data('attribute-value-id'));

        let isVariant = $(this).parents('.product-attribute').data('is-variant-attribute');
        if (isVariant) {
            let dataAttributes = getAllAttributeValue();
            let data = {
                'product_attribute_info' : dataAttributes,
                'product_id' : PRODUCT_ID,
            }
            let request = axios.get(PRODUCT.GET_DETAIL_PRODUCT, { params: data});
            let _this = this;

            return request
                .then(function(data){
                    if (data.data.link_product)
                        window.location.replace(`${PRODUCT.DETAIL_PRODUCT_PAGE}/${data.data.link_product}`);
                    else if(data.data.min_price && data.data.max_price) {
                        $('.product-specs .price.current-selected-product .main').html(`$${data.data.min_price} - $${data.data.max_price}`);
                        $('.product-specs .price.current-selected-product .discount').hide();
                        $('.product-specs .price.current-selected-product .sale').hide();
                    }
                })
                .catch(function(data){
                    console.log("error", data);
                })
                .then(function(data){

                });
        }
    });

    $('.quantity-action').on('click', function (event) {
        event.preventDefault();
        let currentQuantity = parseInt($('.quantity-product').data('quantity'));
        let newQuantity = currentQuantity;
        let actionQuantity = $(this).data('action');
        if (actionQuantity === 'minus') {
            if (currentQuantity > 1)
                newQuantity -= 1;
        }
        else if (actionQuantity === 'plus') {
            newQuantity += 1;
        }
        $('.quantity-product').text(newQuantity);
        $('.quantity-product').data('quantity', newQuantity);
    });

    function getAllAttributeValue() {
        let data = [];
        $('.product-attribute.variant-attribute').each(function (el) {
            let attributeId = $(this).data('product-attribute');
            let attributeValueId = $(this).data('attribute-selected-id');
            data.push({
                'attribute_id' : attributeId,
                'attribute_value_id' : attributeValueId,
            });
        })
        return data;
    }

    function fixedSidebar(){
        $(window).on('scroll', function(){
            var productSidebar = $('.product-sidebar'),
                headerHeight = $('#header').outerHeight() + $('.breadcrumb').outerHeight(),
                productHeight = headerHeight + $('.product-detail .product-detail-wrapper').outerHeight() - productSidebar.outerHeight(),
                windowScrollTop = $(window).scrollTop();

            // console.log(windowScrollTop +' '+ productHeight);

            if(window.innerWidth > 991){
                windowScrollTop > headerHeight && windowScrollTop < productHeight ? productSidebar.addClass('is-sticky') : productSidebar.removeClass('is-sticky');
            }
        });
    }
    fixedSidebar();
});