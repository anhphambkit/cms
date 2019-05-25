/*=========================================================================================
    File Name: look-book.js
    ----------------------------------------------------------------------------------------
    Author: AnhPham
==========================================================================================*/
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

(function(window, document, $) {
    'use strict';
    let index = START_INDEX;
    let currentProductId = 0;

    // Single Select Placeholder
    $("#select-category-list").select2({
        placeholder: "Select a category",
    });

    $(".select-business-type-list").select2({
        placeholder: "Select a business type",
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
                $('#select-product-list').empty();
                $('#select-product-list').select2({
                    placeholder: "Select a product",
                    minimumResultsForSearch: Infinity,
                    data: data.data,
                    templateResult: iconFormat,
                    templateSelection: iconFormat,
                    escapeMarkup: function(es) { return es; }
                });
                if (currentProductId > 0)
                    $("#select-product-list").val(currentProductId).trigger('change');
            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    });

    $('#select-category-list').trigger('change');

    $(document).on("click", "img.preview-look-book-image", function(event) {
        currentProductId = 0;
        let leftOffset = event.offsetX - 19 - 4; // 19px is width of tag and 4px is padding in tag icon
        let topOffset = event.offsetY - 19 - 4;
        let width = $("img.preview-look-book-image").width();
        let height = $("img.preview-look-book-image").height();
        let left = (leftOffset/width)*100;
        let top = (topOffset/height)*100;
        $('.position-dataX').val(left);
        $('.position-dataY').val(top);
        $('#look-book-tag-modal').data('tag-index', index);
        $('#look-book-tag-modal').modal('show');
    });

    $(document).on('click', '.look-book-tag-save', function () {
        let productId = $('#select-product-list').val();
        let productCategoryId = $('#select-category-list').val();
        let left = $('.position-dataX').val();
        let top = $('.position-dataY').val();
        let tagId = $('#look-book-tag-modal').data('tag-index');

        if (tagId === index) {
            let newHotspot = `<div class="tt-hotspot tt-tag-${tagId}" style="left: ${left}%; top: ${top}%;" data-left="${left}" data-top="${top}" data-tag-id="${tagId}">
                                <div class="tt-btn">
                                    <i class="icon-tag fas fa-tag"></i>
                                </div>
                            <input type="number" hidden name="tag[${tagId}][index]" value="${tagId}">
                            <input type="number" hidden name="tag[${tagId}][left]" value="${left}">
                            <input type="number" hidden name="tag[${tagId}][top]" value="${top}">
                            <input type="number" hidden name="tag[${tagId}][product_id]" value="${productId}">
                            <input type="number" hidden name="tag[${tagId}][product_category_id]" value="${productCategoryId}">
                            </div>
                          `;
            $('.look-book-box-preview').append(newHotspot);
            index++;
        }
        else {
            $(`input[name="tag[${tagId}][left]"]`).val(left);
            $(`input[name="tag[${tagId}][top]"]`).val(top);
            $(`input[name="tag[${tagId}][product_category_id]"]`).val(productCategoryId);
            $(`input[name="tag[${tagId}][product_id]"]`).val(productId);
            $(`.tt-tag-${tagId}`).css('left', `${left}%`);
            $(`.tt-tag-${tagId}`).css('top', `${top}%`);
            $(`.tt-tag-${tagId}`).data('left', `${left}`);
            $(`.tt-tag-${tagId}`).data('top', `${top}`);
        }

        $('#look-book-tag-modal').modal('hide');
    });

    /**
     * Delete look book tag
     */
    $(document).on('click', '#delete-tag-item', function () {
        let tagId = $('#look-book-tag-modal').data('tag-index');
        $(`.tt-tag-${tagId}`).remove();
        $('#look-book-tag-modal').modal('hide');
    });

    // Event click on tag:
    $(document).on("click", '.tt-btn', function(event) {
        let tagId = $(this).parent('.tt-hotspot').data('tag-id');
        currentProductId = $(`input[name="tag[${tagId}][product_id]"]`).val();
        let productCategoryId = $(`input[name="tag[${tagId}][product_category_id]"]`).val();
        $("#select-category-list").val(productCategoryId).trigger('change');

        let left = $(`input[name="tag[${tagId}][left]"]`).val();
        let top = $(`input[name="tag[${tagId}][top]"]`).val();
        $('.position-dataX').val(left);
        $('.position-dataY').val(top);
        $('#look-book-tag-modal').data('tag-index', tagId);
        $('#look-book-tag-modal').modal('show');
    });

    // Type layout change:
    $(document).on("change", '#select-type-layout-list', function(e) {
        // Do something
        e.preventDefault();
        let typeLayout = $(this).val();
        let imageValue = $('.image-look-book input.image-data').val();
        if (typeLayout === 'Normal') {
            $('.is-main-form').show();
            setNormalLayoutLookBookImage();
        }
        else {
            $('.is-main-form').hide();
            setVerticalLayoutLookBookImage();
        }

        if (imageValue === '' || imageValue === null) {
            $('.look-book-box-preview').removeClass('normal-layout');
            $('.look-book-box-preview').removeClass('vertical-layout');
        }
        $('#is_main').prop('checked', false);
    });

    $(document).on("change", '.image-look-book input.image-data', function(e) {
        // Do something
        e.preventDefault();
        let imageValue = $(this).val();

        if (imageValue !== '' && imageValue !== null) {
            let typeLayout = $('#select-type-layout-list').val();
            if (typeLayout === 'Normal') {
                setNormalLayoutLookBookImage();
            }
            else {
                setVerticalLayoutLookBookImage();
            }
        }
        else {
            $('.look-book-box-preview').removeClass('normal-layout');
            $('.look-book-box-preview').removeClass('vertical-layout');
        }
    });

    function setNormalLayoutLookBookImage() {
        $('.look-book-box-preview').addClass('normal-layout');
        $('.look-book-box-preview').removeClass('vertical-layout');
    }

    function setVerticalLayoutLookBookImage() {
        $('.look-book-box-preview').addClass('vertical-layout');
        $('.look-book-box-preview').removeClass('normal-layout');
    }

    let loadedTypeLayout = $('#select-type-layout-list').val();
    if (loadedTypeLayout !== 'Normal')
        $('#select-type-layout-list').val(loadedTypeLayout).trigger('change');
})(window, document, jQuery);
