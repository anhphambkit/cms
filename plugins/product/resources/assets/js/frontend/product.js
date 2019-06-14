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