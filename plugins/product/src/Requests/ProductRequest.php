<?php

namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;

class ProductRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author AnhPham
     */
    public function rules()
    {
        return [
            'name'                             => 'required|max:120',
            'upc'                              => 'required|max:150|unique:products',
            'sku'                              => 'required|max:30',
            'category_id'                      => 'required',
            'manufacturer_id'                  => 'required|integer',
            'image_gallery'                    => 'required',
            'price'                            => 'required|numeric',
            'sale_price'                       => 'numeric',
            'inventory'                        => 'required|integer',
            'image_feature'                    => 'required',
            'product_dimension'                => 'max:255',
            'package_dimension'                => 'max:255',
            'short_description'                => 'max:255',
            'rating'                           => 'integer',
            'keywords'                         => 'max:191',
            'type_product'                     => 'max:191',
            'parent_product_id'                => 'integer',
            'all_space'                        => 'required_without:space_business',
            'space_business'                   => 'required_without:all_space',
            'variant_products'                 => 'required_with:product_attribute.*.use_for_variants',
            'variant_products.*.combination'   => 'required',
            'variant_products.*.name'          => 'required_without:is_same_name',
            'variant_products.*.upc'           => 'required',
            'variant_products.*.sku'           => 'required_without:is_same_sku',
            'variant_products.*.image_gallery' => 'required_without:is_same_image_gallery',
            'variant_products.*.price'         => 'required_without:is_same_price',
            'variant_products.*.inventory'     => 'required_without:is_same_inventory',
            'variant_products.*.image_feature' => 'required_without:is_same_image_feature',
        ];
    }
}
