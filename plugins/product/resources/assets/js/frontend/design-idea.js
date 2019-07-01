/*=========================================================================================
    File Name: design-idea.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/

import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

$(document).on('click', '.look-book-tag-product .icon-show-popup', function (e) {
    e.preventDefault();
    let productId = $(this).parents('.look-book-tag-product').data('product-id');
    let data = {
        "product_id" : productId
    };
    let request = axios.get(PRODUCT.GET_OVERVIEW_INFO_POPUP, { params: data});
    let _this = this;

    return request
        .then(function(data){
            closeAllOpenedPopup();
            $(_this).parents('.look-book-tag-product').addClass('close-popup');
            $(_this).parents('.look-book-tag-product').removeClass('show-popup');
            let leftPosition = $(_this).parents('.look-book-tag-product').data('left');
            let topPosition = $(_this).parents('.look-book-tag-product').data('top');
            let classProductPopupPosition = generateClassProductPopupPosition(parseFloat(leftPosition), parseFloat(topPosition));
            let htmlPopup = `<div class="tag-popup-info tag-product-popup ${classProductPopupPosition}">
                        <div class="thumbnail thumbnail-product-popup">
                            <img class="img-product-popup" src="${data.data.image_feature}">
                        </div>
                        <div class="product-specs mb-0">
                            <div class="title">
                                <a href="${PRODUCT.DETAIL_PRODUCT_PAGE}/${data.data.slug}.${data.data.id}" class="link-product-detail">${data.data.name}</a>
                            </div>
                            <div class="price">
                                <div class="main">$${(data.data.is_has_sale) ? data.data.price : data.data.sale_price}</div>
                                <div class="discount ${(data.data.is_has_sale) ? 'd-none' : ''}">$${(data.data.is_has_sale) ? data.data.price : data.data.sale_price}</div>
                                <div class="sale ${(data.data.is_has_sale) ? 'd-none' : ''}">${(data.data.is_has_sale) ? data.data.percent_sale : 0}% off</div>
                            </div>
                        </div>
                    </div>`;
            $(_this).parents('.look-book-tag-product').find('.tt-btn .icon-show-popup').hide();
            $(_this).parents('.look-book-tag-product').find('.tt-btn .icon-close-popup').show();
            $(_this).parents('.look-book-tag-product').append(htmlPopup);
        })
        .catch(function(data){
            console.log("error", data);
        })
        .then(function(data){

        });
})

$(document).on('click', '.look-book-tag-product .icon-close-popup', function (e) {
    e.preventDefault();
    $(this).parents('.look-book-tag-product').addClass('show-popup');
    $(this).parents('.look-book-tag-product').removeClass('close-popup');
    $(this).parents('.look-book-tag-product').find('.tag-product-popup').remove();
    $(this).parents('.look-book-tag-product').find('.tt-btn .icon-show-popup').show();
    $(this).parents('.look-book-tag-product').find('.tt-btn .icon-close-popup').hide();
})

function generateClassProductPopupPosition(left, top) {
    let classPosition = '';
    if (left <= 40)
        classPosition += ' right-';
    else if (left >= 60)
        classPosition += ' left-';

    if (top <= 60)
        classPosition += 'bottom-product-popup';
    else
        classPosition += 'top-product-popup';

    return classPosition;
}

function closeAllOpenedPopup() {
    $('.look-book-tag-product.close-popup').each(function (el) {
        $(this).addClass('show-popup');
        $(this).removeClass('close-popup');
        $(this).find('.tag-product-popup').remove();
        $(this).find('.tt-btn .icon-show-popup').show();
        $(this).find('.tt-btn .icon-close-popup').hide();
    })
}