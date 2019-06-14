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

    $('.item-product-attribute').on('click', function(event) {
        event.preventDefault();
        let attributeType = $(this).parents('.product-attribute').data('attribute-type');
        if (attributeType === 'color_picker') {
            $('.item-product-attribute.item-color-attribute').removeClass('active');
        }
        $(this).addClass('active');
        $(this).parents('.product-attribute').find('.attribute-selected-title').text($(this).data('attribute-value-name'));
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

    $('.add-to-cart-btn').on('click', function (event) {
        event.preventDefault();
        let products = {};
        let newProduct = {};
        let quantity = $('.quantity-product').data('quantity');
        newProduct[PRODUCT_ID] = quantity;
        products = Object.assign(products, newProduct);
        let dataAttributes = getAllAttributeValue();

        let request = axios.post(API_SHOP.ADD_TO_CART, { 'products' : products, 'is_update_product' : false, 'product_attributes' : dataAttributes });
        request
            .then(function(data){
                let totalItems = data.data.total_items;
                if (totalItems > 0) {
                    $('.shopping-cart-quantity i').html(`(${totalItems})`);
                } // Update UI cart number
                else
                    $('.shopping-cart-quantity i').html();
            })
            .catch(function(data){
                if (data.response.status === 401)
                    Lcms.showNotice('error', "Please login to use this feature!", Lcms.languages.notices_msg.error);
                else
                    Lcms.showNotice('error', "Please contact IT support!", Lcms.languages.notices_msg.error);
            })
            .then(function(data){

            });
    });

    function getAllAttributeValue() {
        let data = [];
        $('.product-attributes .product-attribute').each(function (el) {
            let attributeId = $(this).data('product-attribute');
            let attributeValueId = $(this).data('attribute-selected-id');
            data.push({
                'attribute_id' : attributeId,
                'attribute_value_id' : attributeValueId,
                'product_id' : PRODUCT_ID,
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