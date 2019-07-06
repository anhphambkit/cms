/*=========================================================================================
    File Name: product.js
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
miniCart.setTemplateElement('#mini-cart-content');
miniCart.afterParseTemplate(() => {
    $('[data-toggle="tooltip"]').tooltip();
});

/* register handlebar */
let quickShopModal = new HandlebarRender();
quickShopModal.setSourceElement('#template-quick-shop-modal');
quickShopModal.setTemplateElement('#content-quick-shop-modal');
quickShopModal.afterParseTemplate(() => {
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).on('click', '.add-to-wish-list', function(e) {
    let productId = $(this).data('product-id');
    let _this = $(this);
    let request = axios.post(PRODUCT.ADD_PRODUCT_TO_WISH_LIST, { 'product_id' : productId });

    request
        .then(function(data){
            if (data.data.type_update === 'add')
                _this.find('i.icon-wish-list').removeClass('far').addClass('fas');
            else
                _this.find('i.icon-wish-list').removeClass('fas').addClass('far');
            Lcms.showNotice('success', data.data.message, Lcms.languages.notices_msg.success);
        })
        .catch(function(error){
            if (error.response.status === 401)
                Lcms.showNotice('error', "Please login to use this feature!", Lcms.languages.notices_msg.error);
            else
                Lcms.showNotice('error', "Please contact IT support!", Lcms.languages.notices_msg.error);
        })
        .then(function(data){ // Finally
        });
});

$(document).ready(function() {
    initSliderProductGalleriesPage();

    fixedSidebar();

    $(document).on('click', '.item-product-attribute', function(event) {
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
            let productId = $(this).parents('.product-detail').data('product-id');
            let dataAttributes = getAllAttributeValue();
            let data = {
                'product_attribute_info' : dataAttributes,
                'product_id' : productId,
            }
            let request = axios.get(PRODUCT.GET_DETAIL_PRODUCT_BY_ATTRIBUTES, { params: data});
            let _this = this;

            return request
                .then(function(data){
                    if (data.data.link_product) {
                        if ($(_this).parents('.product-detail').hasClass('product-detail-section-page')) {
                            window.location.replace(`${PRODUCT.DETAIL_PRODUCT_PAGE}/${data.data.link_product}`);
                        }
                        else {
                            destroySlider();
                            quickShopModal.setData(data.data.product_info);
                            quickShopModal.parseTemplate();
                            initSliderProductGalleriesModal();
                        }
                    }
                    // console.log(data.data.product_info);
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

    $(document).on('click', '.quantity-action', function (event) {
        event.preventDefault();
        let currentQuantity = parseInt($(this).parents('.product-quantity-section').find('.quantity-product').data('quantity'));
        let newQuantity = currentQuantity;
        let actionQuantity = $(this).data('action');
        if (actionQuantity === 'minus') {
            if (currentQuantity > 1)
                newQuantity -= 1;
        }
        else if (actionQuantity === 'plus') {
            newQuantity += 1;
        }
        $(this).parents('.product-quantity-section').find('.quantity-product').text(newQuantity);
        $(this).parents('.product-quantity-section').find('.quantity-product').data('quantity', newQuantity);
    });

    $(document).on('click', '.add-to-cart-btn', function (event) {
        event.preventDefault();
        Lcms.beginLoading('.product-detail');
        let productId = $(this).parents('.product-detail').data('product-id');
        let products = {};
        let newProduct = {};
        let quantity = $(this).parents('.product-detail').find('.quantity-product').data('quantity');
        newProduct[productId] = quantity;
        products = Object.assign(products, newProduct);
        let dataAttributes = getAllAttributeValue();
        $('.add-to-cart-success').remove();
        let request = axios.post(API_SHOP.ADD_TO_CART, { 'products' : products, 'is_update_product' : false, 'product_attributes' : dataAttributes });
        request
            .then(function(data){
                updateInfoUICart(data.data);

                $('ul.menu-info-customer li.noti-added-to-cart').append(
                    `<div class="add-to-cart-success">
                        <span class="close close-noti-added-to-cart"><i class="fas fa-times"></i></span>
                        <div class="mb-2">Your item(s) have been added to cart</div>
                        <a href="/cart" class="go-to-cart">
                            <button class="btn btn-custom btn-sm btn-block justify-content-center">Go to Cart and Checkout</button>
                        </a>
                    </div>`
                );
            })
            .catch(function(data){
                if (data.response.status === 401)
                    Lcms.showNotice('error', "Please login to use this feature!", Lcms.languages.notices_msg.error);
                else
                    Lcms.showNotice('error', "Please contact IT support!", Lcms.languages.notices_msg.error);
            })
            .then(function(data){
                Lcms.endLoading('.product-detail');
            });
    });

    $(document).on('click', '.close-noti-added-to-cart', function () {
        $('.add-to-cart-success').remove();
    });

    $(document).on('click', '.btn-show-quick-shop-modal', function (event) {
        event.preventDefault();
        let productId = $(this).data('product-id');
        let data = {
            'product_id' : productId,
        }
        let request = axios.get(PRODUCT.GET_DETAIL_PRODUCT, { params: data});
        let _this = this;

        return request
            .then(function(data){
                quickShopModal.setData(data.data);
                quickShopModal.parseTemplate();
                $('#item-quick-shop-modal').modal('show');
            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    });

    $('#item-quick-shop-modal').on('shown.bs.modal', function (e) {
        initSliderProductGalleriesModal();
    });

    $('#item-quick-shop-modal').on('hidden.bs.modal', function (e) {
        destroySlider();
    });

    function getAllAttributeValue() {
        let data = [];
        $('.product-attributes .product-attribute').each(function (el) {
            let attributeId = $(this).data('product-attribute');
            let attributeValueId = $(this).data('attribute-selected-id');
            let productId = $(this).parents('.product-detail').data('product-id');
            data.push({
                'attribute_id' : attributeId,
                'attribute_value_id' : attributeValueId,
                'product_id' : productId,
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

            if(window.innerWidth > 991){
                windowScrollTop > headerHeight && windowScrollTop < productHeight ? productSidebar.addClass('is-sticky') : productSidebar.removeClass('is-sticky');
            }
        });
    }

    function initSliderProductGalleriesPage() {
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
    }

    function initSliderProductGalleriesModal() {
        $('#item-quick-shop-modal .slider-for').slick({
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

        $('#item-quick-shop-modal .slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            accessibility: false,
            infinite: false,
            dots: false,
            arrows: false,
            focusOnSelect: true
        });
    }

    function destroySlider() {
        if ($('#item-quick-shop-modal .slider-nav').slick('getSlick') !== undefined) {
            $('#item-quick-shop-modal .slider-nav').slick('unslick');

        }

        if ($('#item-quick-shop-modal .slider-for').slick('getSlick') !== undefined) {
            $('#item-quick-shop-modal .slider-for').slick('unslick')
        }

        $('#item-quick-shop-modal .slider-for').unbind()
        $('#item-quick-shop-modal .slider-nav').unbind()
    }
});