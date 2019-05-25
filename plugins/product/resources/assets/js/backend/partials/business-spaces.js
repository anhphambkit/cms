/*=========================================================================================
    File Name: business-spaces.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/

import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let businessSpaceIndex = BUSINESS_SPACE_INDEX;
let applyAllSpaceIndex = ALL_SPACE_INDEX;


$(".select-space-list").select2({
    placeholder: "Select a space",
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

// Spaces select
let listSpaces = $.map(ALL_SPACES, function(item) {
    return {
        id : item.id,
        text: item.text,
        image_feature: item.image_feature,
    };
});

$(`.select-all-space-list`).empty();

$(`.select-all-space-list`).select2({
    placeholder: "Select a space",
    minimumResultsForSearch: Infinity,
    data: listSpaces,
    templateResult: iconFormat,
    templateSelection: iconFormat,
    escapeMarkup: function(es) { return es; }
});

$('.select-all-space-list').each(function(i, obj) {
    let allSpaceId = $(this).data('init-all-space-id');
    $(this).val(allSpaceId).trigger('change');
});

// Add specific space:
$(document).on("click", ".add-specific-space", function(event) {
    let request = axios.get(API.GET_DEFAULT_BUSINESS_TYPE);

    return request
        .then(function(data){
            let newSelectBusinessSpace = `<div class="row business-space-row business-space-row-${businessSpaceIndex}">
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
                                                <a class="action-space delete-space-action delete-business-space delete-business-space-${businessSpaceIndex}" data-business-space-index="${businessSpaceIndex}">
                                                    <i class="far fa-trash-alt icon-business-space-delete"></i>
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>`;

            $('.render-space-business-specific-selected').show();
            $('.render-space-business-specific-selected').append(newSelectBusinessSpace);

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

// Add apply all space:
$(document).on("click", ".add-space-apply-all", function(event) {
    let request = axios.get(API.GET_ALL_SPACES);

    return request
        .then(function(data){
            let newApplyAllSpaceSelect = `<div class="row all-space-row all-space-row-${applyAllSpaceIndex}">
                                        <div class="form-group col-md-5 mb-2">
                                            <label class="control-label required" for="select-space">Space</label>
                                            <select class="select2-placeholder-multiple form-control select-space-${applyAllSpaceIndex} select-all-space-list" name="all_space[${applyAllSpaceIndex}][space_id]" data-all-space-index='${applyAllSpaceIndex}' data-init-all-space-id="0">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2 mb-2">
                                            <label class="control-label" for="action-space">Actions</label>
                                            <div class="action-space-area">
                                                <a class="action-space delete-space-action delete-all-space delete-all-space-${applyAllSpaceIndex}" data-all-space-index="${applyAllSpaceIndex}">
                                                    <i class="far fa-trash-alt icon-business-space-delete"></i>
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>`;

            $('.render-space-apply-all-selected').show();
            $('.render-space-apply-all-selected').append(newApplyAllSpaceSelect);

            $(`.select-all-space-list.select-space-${applyAllSpaceIndex}`).select2({
                placeholder: "Select a space",
                minimumResultsForSearch: Infinity,
                data: data.data,
                templateResult: iconFormat,
                templateSelection: iconFormat,
                escapeMarkup: function(es) { return es; }
            });

            applyAllSpaceIndex++;
        })
        .catch(function(data){
            console.log("error", data);
        })
        .then(function(data){

        });
});

// Delete All Space:
$(document).on('click', '.delete-all-space', function () {
    let allSpaceIndex = $(this).data('all-space-index');
    $(`.all-space-row-${allSpaceIndex}`).remove();
    if ($('.render-space-apply-all-selected .all-space-row').length <= 0) {
        $('.render-space-apply-all-selected').hide();
    }
});

// Delete Specific Space:
$(document).on('click', '.delete-business-space', function () {
    let businessSpaceIndex = $(this).data('business-space-index');
    $(`.business-space-row-${businessSpaceIndex}`).remove();
    if ($('.render-space-business-specific-selected .business-space-row').length <= 0) {
        $('.render-space-business-specific-selected').hide();
    }
});