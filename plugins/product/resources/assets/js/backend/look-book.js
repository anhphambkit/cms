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
    let businessSpaceIndex = BUSINESS_SPACE_INDEX;
    let currentProductId = 0;

    // Single Select Placeholder
    $("#select-category-list").select2({
        placeholder: "Select a category",
    });

    $(".select-business-type-list").select2({
        placeholder: "Select a business type",
    });

    $(".select-space-list").select2({
        placeholder: "Select a space",
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

    // Format icon
    function iconFormat(icon) {
        if (!icon.id) return icon.text;
        var $icon = `<img class="image-item-select" src="${icon.image_feature}" />${icon.text}`
        return $icon;
    }

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

    // Business Space:
    $(document).on("change", '.select-business-type-list', function(e) {
        // Do something
        e.preventDefault();
        let data = {
            "business_type_id" : $(this).val()
        };
        let request = axios.get(API.GET_SPACES_BY_BUSINESS_TYPE, { params: data});

        let businessTypeIndex = $(this).data('business-type-index');

        return request
            .then(function(data){
                $(`.select-space-${businessTypeIndex}`).empty();
                $(`.select-space-${businessTypeIndex}`).select2({
                    placeholder: "Select a space",
                    minimumResultsForSearch: Infinity,
                    data: data.data,
                    templateResult: iconFormat,
                    templateSelection: iconFormat,
                    escapeMarkup: function(es) { return es; }
                });
                let currentSpaceId = $(`.select-space-${businessTypeIndex}`).data('init-space-id');
                if (currentSpaceId > 0) {
                    $(`.select-space-${businessTypeIndex}`).val(currentSpaceId).trigger('change');
                    $(`.select-space-${businessTypeIndex}`).data('init-space-id', 0);
                }
            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    });

    $('.select-business-type-list').each(function(i, obj) {
        $(this).trigger('change');
    });

    // Add space:
    $(document).on("click", ".btn.add-space-business", function(event) {
        let request = axios.get(API.GET_DEFAULT_BUSINESS_TYPE);

        return request
            .then(function(data){
                let newSelectBusinessSpace = `<div class="row business-space-row-${businessSpaceIndex}">
                                        <div class="form-group col-md-5 mb-2">
                                            <label class="control-label required" for="select-business-type">Business Type</label>
                                            <select class="select2-placeholder-multiple form-control select-business-type-${businessSpaceIndex} select-business-type-list" name="space_business[${businessSpaceIndex}][business_type_id]" data-business-type-index='${businessSpaceIndex}'>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5 mb-2">
                                            <label class="control-label required" for="select-space">Space</label>
                                            <select class="select2-placeholder-multiple form-control select-space-${businessSpaceIndex} select-space-list" name="space_business[${businessSpaceIndex}][space_id]" data-space-index='${businessSpaceIndex}' data-init-space-id="0">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2 mb-2">
                                            <label class="control-label" for="action-space">Actions</label>
                                            <div class="action-space-area">
                                                <a class="action-space delete-business-space delete-business-space-${businessSpaceIndex}" data-business-space-index="${businessSpaceIndex}">
                                                    <i class="far fa-trash-alt icon-business-space-delete"></i>
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>`
                $('.render-space-business-select').append(newSelectBusinessSpace);

                // let defaultBusinessTypes = $.map(data.data, function(el) { return el; });

                $(`.select-space-list.select-space-${businessSpaceIndex}`).select2({
                    placeholder: "Select a space",
                });

                $(`.select-business-type-list.select-business-type-${businessSpaceIndex}`).select2({
                    placeholder: "Select a business type",
                    data: data.data,
                });

                $(`.select-business-type-list.select-business-type-${businessSpaceIndex}`).trigger('change');

                businessSpaceIndex++;
            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    });

    // Delete Space:
    $(document).on('click', '.delete-business-space', function () {
        let businessSpaceIndex = $(this).data('business-space-index');
        $(`.business-space-row-${businessSpaceIndex}`).remove();
    });
})(window, document, jQuery);