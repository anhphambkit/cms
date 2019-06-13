/*=========================================================================================
    File Name: product.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

$(document).on('click', '.add-to-wish-list', function(e) {
    let productId = $(this).data('product-id');
    let _this = $(this);
    let request = axios.post(PRODUCT.ADD_PRODUCT_TO_WISH_LIST, { 'product_id' : productId });

    request
        .then(function(data){
            
        })
        .catch(function(error){
        })
        .then(function(data){ // Finally
        });
});