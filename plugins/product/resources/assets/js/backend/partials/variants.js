/*=========================================================================================
    File Name: variants.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

(function(window, document, $) {
    'use strict';
    let productAttributes = $.map(PRODUCT_ATTRIBUTES, function(item) {
        return {
            id : item.id,
            text: item.text,
            slug: item.slug
        };
    });

    $(`#select-product-attributes-list`).empty();

    $(`#select-product-attributes-list`).select2({
        placeholder: "Select a product attribute",
        data: productAttributes
    });

    // Add attribute area:
    $(document).on("click", '.btn-add-attribute', function(e) {
        // Do something
        e.preventDefault();
        let attributeSelected = $('#select-product-attributes-list').val();

        if (attributeSelected === undefined || attributeSelected === null || attributeSelected == '')
            return;

        let attributeSlug = getPropertyOfAttribute(productAttributes, attributeSelected, 'id', 'slug');
        let attributeName = getPropertyOfAttribute(productAttributes, attributeSelected, 'id', 'text');
        reRenderProductAttributesSelect(attributeSelected)

        let data = {
            "attribute_id" : attributeSelected
        };
        let request = axios.get(API.GET_LIST_VALUE_OF_ATTRIBUTE, { params: data});

        return request
            .then(function(data){
                let htmlAttribute = `<div class="attribute-item-area attribute-item-${attributeSelected}" data-attribute-id="${attributeSelected}">
                                        <input type="text" hidden name="product_attribute[${attributeSlug}][attribute_id]" value="${attributeSelected}">
                                        <div id="heading-${attributeSlug}" class="card-header bg-light">
                                            <a data-toggle="collapse" href="#${attributeSlug}" aria-expanded="true" aria-controls="${attributeSlug}" class="card-title lead white">
                                                ${attributeName} - Product Attribute
                                            </a>
                                            <a class="delete-attribute">
                                                <i class="far fa-trash-alt icon-delete-attribute"></i>
                                                Delete
                                            </a>
                                        </div>
                                        <div id="${attributeSlug}" role="tabpanel" aria-labelledby="heading-${attributeSlug}" class="card-collapse collapse show" aria-expanded="true">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="row product-attribute-area">
                                                        <div class="form-group col-md-4 mb-2">
                                                            <label class="control-label" for="select-attributes-list-${attributeSlug}">${attributeName}</label>
                                                            <select data-attribute-id="${attributeSelected}" data-attribute-name="${attributeName}" data-attribute-slug="${attributeSlug}" class="select2-placeholder-multiple form-control select-attribute-${attributeSlug} select-attribute-list select-use-variant" id="attribute-${attributeSlug}-select" name="product_attribute[${attributeSlug}][value_attributes][]">
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 action-attribute-btn">
                                                            <label class="control-label" for="show_${attributeSlug}_in_product_page">Show in product page</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse show_${attributeSlug}_in_product_page-switch checkbox-large" style="display: block;">
                                                                <input type="checkbox" name="product_attribute[${attributeSlug}][show_in_product_page]" class="onoffswitch-checkbox" id="show_${attributeSlug}_in_product_page" value="1">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="show_${attributeSlug}_in_product_page"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 action-attribute-btn">
                                                            <label class="control-label" for="use_${attributeSlug}_for_variants">Use for variants</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse use_${attributeSlug}_for_variants-switch checkbox-large" style="display: block;">
                                                                <input type="checkbox" name="product_attribute[${attributeSlug}][use_for_variants]" data-element-use-variant='#attribute-${attributeSlug}-select' class="onoffswitch-checkbox use-variant-btn" id="use_${attributeSlug}_for_variants" value="1">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="use_${attributeSlug}_for_variants"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;

                $('.attribute-render-area').append(htmlAttribute);
                $(`.select-attribute-${attributeSlug}`).select2({
                    placeholder: "Select a attribute",
                    data: data.data,
                    multiple: true,
                });

                $(`.select-attribute-${attributeSlug}`).trigger('change');
            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    });

    // Remove Attribute area
    $(document).on("click", '.delete-attribute', function(e) {
        e.preventDefault();
        $(this).parents('.attribute-item-area').remove();
        updateListVariantProducts();
        reRenderProductAttributesSelect();
    });

    // Use Attribute For Variant Btn
    $(document).on("click", '.use-variant-btn', function(e) {
        updateListVariantProducts();
    });

    // On change select attribute:
    $(document).on("change", '.select-use-variant', function (e) {
        // Do something
        e.preventDefault();
        updateListVariantProducts();
    });

    // On change use the same:
    $(document).on("change", '.on-off-same-variant', function (e) {
        // Do something
        e.preventDefault();
        let valueStatus = $(this).prop('checked');
        let elementTarget = $(this).data('target-element');
        let typeRender = $(this).data('type-render');
        if (valueStatus) {
            switch (typeRender) {
                case 'normal':
                    $(elementTarget).prop('disabled', true);
                    break;
                case 'image':
                    $(elementTarget).find('.image-box-actions').hide();
                    break;
                case 'gallery':
                    $(elementTarget).find('.btn_select_gallery').hide();
                    $(elementTarget).find('.reset-gallery').hide();
                    break;
                case 'editor':
                    let editor = CKEDITOR.instances[elementTarget];
                    if (editor)
                        editor.setReadOnly(true);
                    else
                        $(`#${elementTarget}`).prop('disabled', true);
                    break;
            }
        }
        else {
            switch (typeRender) {
                case 'normal':
                    $(elementTarget).prop('disabled', false);
                    break;
                case 'image':
                    $(elementTarget).find('.image-box-actions').show();
                    break;
                case 'gallery':
                    $(elementTarget).find('.btn_select_gallery').show();
                    $(elementTarget).find('.reset-gallery').show();
                    break;
                case 'editor':
                    let editor = CKEDITOR.instances[elementTarget];
                    if (editor)
                        editor.setReadOnly(false);
                    else
                        $(`#${elementTarget}`).prop('disabled', false);
                    break;
            }
        }
    });

    function reRenderProductAttributesSelect(attributeSelected = null) {
        let request = axios.get(API.GET_CUSTOM_ATTRIBUTES);

        return request
            .then(function(data){
                productAttributes = data.data;
                $('.attribute-item-area').each(function(i, obj) {
                    let attributedIdSelected = $(this).data('attribute-id');
                    productAttributes = removeItemByPropertyInArray(productAttributes, attributedIdSelected, 'id');
                });

                // Remove item just added
                if (attributeSelected !== null)
                    productAttributes = removeItemByPropertyInArray(productAttributes, attributeSelected, 'id');

                // Reset select2:
                $(`#select-product-attributes-list`).empty();

                $(`#select-product-attributes-list`).select2({
                    placeholder: "Select a product attribute",
                    data: productAttributes
                });

                // Hide when empty
                if (productAttributes.length == 0)
                    $('.product-attribute-add-area').hide();
                else
                    $('.product-attribute-add-area').show();

            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    }

    function renderVariantProduct(variantProducts) {
        $('.variant-products-area').html('');
        for (let i = 0; i < variantProducts.length; i++) {
            let inputCombinations = '';
            let nameVariantProduct = '';

            for (let j = 0; j < variantProducts[i].length; j++) {
                let combination = `<input type="text" hidden name="variant_products[${i}][combination][${j}][attribute_id]" value="${variantProducts[i][j]['attribute_id']}">
                                <input type="text" hidden name="variant_products[${i}][combination][${j}][value_id]" value="${variantProducts[i][j]['id']}">`;
                inputCombinations += combination;

                let name = `${variantProducts[i][j]['attribute_name']}: ${variantProducts[i][j]['text']}`;
                nameVariantProduct += name;
                if ((j + 1) < variantProducts[i].length)
                    nameVariantProduct += ' | ';
            }

            let variantProductHtml = `<div class="variant-product-item">` + inputCombinations + `
                                <div id="heading-variant-${i}" class="card-header bg-light">
                                    <a data-toggle="collapse" href="#variant-product-${i}" aria-expanded="true" aria-controls="variant-product-${i}" class="card-title lead white">
                                        ${nameVariantProduct}
                                    </a>
                                </div>
                                <div id="variant-product-${i}" role="tabpanel" aria-labelledby="heading-variant-${i}" class="collapse">
                                    <div class="card card-variant">
                                        <div class="card-header">
                                            <h4 class="card-title" id="from-actions-bottom-right">Generals</h4>
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collpase show">
                                            <div class="card-body">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label for="name">Name</label>
                                                             <input type="text" class="form-control variant-product-attr variant-product-name-${i}" id="variant-product-name-${i}" name="variant_products[${i}][name]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label" for="same_name_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][is_same_name]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_name_${i}" value="1" data-target-element="#variant-product-name-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="same_name_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label for="upc">UPC</label>
                                                            <input type="text" class="form-control variant-product-attr variant-product-upc-${i}" id="variant-product-upc-${i}" name="variant_products[${i}][upc]">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label for="sku">SKU</label>
                                                            <input type="text" class="form-control variant-product-attr variant-product-sku-${i}" id="variant-product-sku-${i}" name="variant_products[${i}][sku]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label required" for="same_sku_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][is_same_sku]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_sku_${i}" value="1" data-target-element="#variant-product-sku-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="same_sku_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-variant">
                                        <div class="card-header">
                                            <h4 class="card-title" id="from-actions-bottom-right">Price Information</h4>
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collpase show">
                                            <div class="card-body">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label class="control-label">Price</label>
                                                            <input type="number" class="form-control variant-product-attr variant-product-price-${i}" id="variant-product-price-${i}" name="variant_products[${i}][price]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label required" for="same_price_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][is_same_price]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_price_${i}" value="1" data-target-element="#variant-product-price-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="same_price_${i}"></label>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label for="name">Sale Price</label>
                                                            <input type="number" class="form-control variant-product-attr variant-product-sale-price-${i}" id="variant-product-sale-price-${i}" name="variant_products[${i}][sale_price]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label required" for="same_sale_price_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][is_same_sale_price]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_sale_price_${i}" value="1" data-target-element="#variant-product-sale-price-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="same_sale_price_${i}"></label>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label class="control-label required">Inventory</label>
                                                            <input type="number" class="form-control variant-product-attr variant-product-inventory-${i}" id="variant-product-inventory-${i}" name="variant_products[${i}][inventory]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label required" for="same_sale_price_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][is_same_inventory]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_inventory_${i}" value="1" data-target-element="#variant-product-inventory-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="same_inventory_${i}"></label>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-variant">
                                        <div class="card-header">
                                            <h4 class="card-title" id="from-actions-bottom-right">Image feature</h4>
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collpase show">
                                            <div class="card-body">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label class="control-label required">Image Feature</label>
                                                            <div class="image-box variant-product-attr variant-product-image-feature-${i}" id="variant-product-image-feature-${i}">
                                                                <input type="hidden"
                                                                       name="variant_products[${i}][image_feature]"
                                                                       value=""
                                                                       class="image-data">
                                                                <img src="/backend/core/media/images/default-image_mediumThumb.png"
                                                                    alt="preview image" class="preview_image">
                                                                <div class="image-box-actions">
                                                                    <a class="btn_gallery" data-result="variant_products[${i}][image_feature]" data-action="select-image" data-multiple="true">
                                                                        Choose image
                                                                    </a> |
                                                                    <a class="btn_remove_image">
                                                                        Remove image
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="image" name="variant_products[${i}][image_feature]" class="onoffswitch-checkbox on-off-same-variant" id="image_feature_${i}" value="1" data-target-element="#variant-product-image-feature-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="image_feature_${i}"></label>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-variant">
                                        <div class="card-header">
                                            <h4 class="card-title" id="from-actions-bottom-right">Gallery Images</h4>
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collpase show">
                                            <div class="card-body">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label class="control-label required" for="role">Gallery</label>
                                                            <div class="gallery-image-box variant-product-attr variant-product-image-gallery-${i}" id="variant-product-image-gallery-${i}">
                                                                <input type="text" hidden id="gallery-data" class="gallery-data form-control" name="variant_products[${i}][image_gallery]" value="">
                                                                <div>
                                                                    <div class="list-photos-gallery">
                                                                        <div class="row">
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    <div class="form-group">
                                                                        <a href="#" class="btn_select_gallery">Choose image</a>&nbsp;
                                                                        <a href="#" class="text-danger reset-gallery hidden">Remove image</a>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade edit-gallery-item" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-danger">
                                                                                <h4 class="modal-title"><i class="til_img"></i><strong>Delete image gallery</strong></h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            </div>
                                                            
                                                                            <div class="modal-footer">
                                                                                <button class="float-left btn btn-danger delete-gallery-item" href="#">Delete</button>
                                                                                <button class="float-right btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="gallery" name="variant_products[${i}][is_same_image_gallery]" class="onoffswitch-checkbox on-off-same-variant" id="image_gallery_${i}" value="1" data-target-element="#variant-product-image-gallery-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="image_gallery_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-variant">
                                        <div class="card-header">
                                            <h4 class="card-title" id="from-actions-bottom-right">Description Information</h4>
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collpase show">
                                            <div class="card-body">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-2 the-same-source">
                                                            <label class="control-label" for="is_same_long_desc_${i}">Long description the same with source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="editor" name="variant_products[${i}][is_same_long_desc]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_long_desc_${i}" value="1" data-target-element="variant-product-long-desc-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="is_same_long_desc_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12 mb-2">
                                                            <label for="name">Long Description</label>
                                                            <textarea class="variant-editor editor-ckeditor variant-product-attr variant-product-long-desc-${i}" id="variant-product-long-desc-${i}" with-short-code="" rows="10" name="variant_products[${i}][long_desc]" cols="50"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-2 the-same-source">
                                                            <label class="control-label" for="is_same_short_description_${i}">Short description the same with source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="editor" name="variant_products[${i}][is_same_short_description]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_short_description_${i}" value="1" data-target-element="variant-product-short-description-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="is_same_short_description_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12 mb-2">
                                                            <label for="name">Short Description</label>
                                                            <textarea class="variant-editor editor-ckeditor variant-product-attr variant-product-short-description-${i}" id="variant-product-short-description-${i}" with-short-code="" rows="10" name="variant_products[${i}][short_description]" cols="50"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card card-variant">
                                        <div class="card-header">
                                            <h4 class="card-title" id="from-actions-bottom-right">Weight/Dimension And Specifications Information</h4>
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collpase show">
                                            <div class="card-body">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label class="control-label" for="role">Product Dimension</label>
                                                            <input type="text" class="form-control variant-product-attr variant-product-product-dimension-${i}" id="variant-product-product-dimension-${i}" name="variant_products[${i}][product_dimension]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label" for="is_same_product_dimension_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][product_dimension]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_product_dimension_${i}" value="1" data-target-element="#variant-product-product-dimension-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="is_same_product_dimension_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label for="name">Package Dimension</label>
                                                            <input type="text" class="form-control variant-product-attr variant-product-package-dimension-${i}" id="variant-product-package-dimension-${i}" name="variant_products[${i}][package_dimension]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label" for="is_same_package_dimension_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][package_dimension]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_package_dimension_${i}" value="1" data-target-element="#variant-product-package-dimension-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="is_same_package_dimension_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label class="control-label required" for="role">Product Weight</label>
                                                            <input type="number" class="form-control variant-product-attr variant-product-product-weight-${i}" id="variant-product-product-weight-${i}" name="variant_products[${i}][product_weight]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label" for="is_same_product_weight_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][product_weight]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_product_weight_${i}" value="1" data-target-element="#variant-product-product-weight-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="is_same_product_weight_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-8 mb-2">
                                                            <label for="name">Package Weight</label>
                                                            <input type="number" class="form-control variant-product-attr variant-product-package-weight-${i}" id="variant-product-package-weight-${i}" name="variant_products[${i}][package_weight]">
                                                        </div>
                                                        <div class="form-group col-md-4 mb-2 the-same-source">
                                                            <label class="control-label" for="is_same_package_weight_${i}">The same source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="normal" name="variant_products[${i}][package_weight]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_package_weight_${i}" value="1" data-target-element="#variant-product-package-weight-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="is_same_package_weight_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-2 the-same-source">
                                                            <label class="control-label" for="is_same_weight_dimension_description_${i}">Weights & Dimensions the same with source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="editor" name="variant_products[${i}][is_same_weight_dimension_description]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_weight_dimension_description_${i}" value="1" data-target-element="variant-product-weight-dimension-description-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="is_same_weight_dimension_description_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12 mb-2">
                                                            <label for="name">Weights & Dimensions</label>
                                                            <textarea class="variant-editor editor-ckeditor variant-product-attr variant-product-weight-dimension-description-${i}" id="variant-product-weight-dimension-description-${i}" with-short-code="" rows="10" name="variant_products[${i}][weight_dimension_description]" cols="50"></textarea>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-2 the-same-source">
                                                            <label class="control-label" for="is_same_specification_${i}">Specifications the same with source</label>
                                                            <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
                                                                <input type="checkbox" data-type-render="editor" name="variant_products[${i}][is_same_specification]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_specification_${i}" value="1" data-target-element="variant-product-specification-${i}">
                                                                <div class="state p-success">
                                                                    <i class="icon fas fa-check"></i>
                                                                    <label class="onoffswitch-label" for="is_same_specification_${i}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12 mb-2">
                                                            <label for="name">Specifications</label>
                                                            <textarea class="variant-editor editor-ckeditor variant-product-attr variant-product-specification-${i}" id="variant-product-specification-${i}" with-short-code="" rows="10" name="variant_products[${i}][specification]" cols="50"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            $('.variant-products-area').append(variantProductHtml);
        }
        Lcms.initMediaIntegrate();
        let $ckEditor = $('.editor-ckeditor');
        let $tinyMce = $('.editor-tinymce');
        if ($ckEditor.length > 0) {
            $('.variant-editor').each(function () {
                editorManagement.initCkEditor($(this).prop('id'), {});
            })
        }
        if ($tinyMce.length > 0) {
            $('.variant-editor').each(function () {
                editorManagement.initTinyMce($(this).prop('id'));
            })
        }
    }

    function updateListVariantProducts() {
        let arrayResultAttributes = [];
        $('.use-variant-btn').each(function () {
            let statusBtn = $(this).prop('checked');
            if (statusBtn) {
                let elemetSelect = $(this).data('element-use-variant');
                let arraySelected = [];
                $(`${elemetSelect} option:selected`).each(function(){
                    var option = $(this);
                    var label = option.text();
                    var value = option.val();
                    let attributeId = $(`${elemetSelect}`).data('attribute-id');
                    let attributeSlug = $(`${elemetSelect}`).data('attribute-slug');
                    let attributeName = $(`${elemetSelect}`).data('attribute-name');
                    let itemSelected = {
                        'attribute_id' : attributeId,
                        'attribute_slug' : attributeSlug,
                        'attribute_name' : attributeName,
                        'id' : value,
                        'text' : label
                    }
                    arraySelected.push(itemSelected);
                });
                arrayResultAttributes.push(arraySelected);
            }
        })
        let variantProducts = createVariantItemFromAttributes(...arrayResultAttributes);
        renderVariantProduct(variantProducts);
    }

})(window, document, jQuery);

// <div class="form-group col-md-4 mb-2 the-same-source">
//     <label class="control-label required" for="same_upc_${i}">The same source</label>
// <div class="onoffswitch pretty p-icon p-round p-pulse checkbox-large" style="display: block;">
//     <input type="checkbox" data-type-render="normal" name="variant_products[${i}][is_same_upc]" class="onoffswitch-checkbox on-off-same-variant" id="is_same_upc_${i}" value="1" data-target-element="#variant-product-upc-${i}">
//     <div class="state p-success">
//     <i class="icon fas fa-check"></i>
//     <label class="onoffswitch-label" for="same_upc_${i}"></label>
//     </div>
//     </div>
//     </div>