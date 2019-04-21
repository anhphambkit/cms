/*=========================================================================================
    File Name: form-select2.js
    Description: Select2 is a jQuery-based replacement for select boxes.
    It supports searching, remote data sets, and pagination of results.
    ----------------------------------------------------------------------------------------
    Item Name: Modern Admin - Clean Bootstrap 4 Dashboard HTML Template
   Version: 3.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

(function(window, document, $) {
    'use strict';



    // Single Select Placeholder
    $("#select-category-list").select2({
        placeholder: "Select a category",
    });

    $('#select-category-list').on('change', function (e) {
        // Do something
        e.preventDefault();
        let data = {
            "category_id" : $(this).val()
        };
        let request = axios.get(API.GET_PRODUCTS_BY_CATEGORY, { params: data});

        return request
            .then(function(data){
                alert(data);
            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    });

    $('#select-category-list').trigger('change');

    let left = 0;
    let top = 0;

    $("img.preview-look-book-image").on("click", function(event) {
        $('#look-book-tag-modal').modal('show')
        // let leftOffset = event.offsetX - 19 - 4; // 19px is width of tag and 4px is padding in tag icon
        // let topOffset = event.offsetY - 19 - 4;
        // let width = $(this).width();
        // let height = $(this).height();
        // left = (leftOffset/width)*100;
        // top = (topOffset/height)*100;
        // $('.width').text('Width: ' + left);
        // $('.height').text('Height: ' + top);
        // $('#popup-lookbook').removeClass('d-none');
    });

    let index = 0;

})(window, document, jQuery);
