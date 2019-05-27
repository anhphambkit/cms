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
            'name' => 'required',
            'upc' => 'required',
            'sku' => 'required',
            'category_id' => 'required',
            'manufacturer_id' => 'required',
            'image_gallery' => 'required',
            'price' => 'required',
            'inventory' => 'required',
            'image_feature' => 'required',
            'all_space' => 'required_without:space_business',
            'space_business' => 'required_without:all_space',
            'variant_products' => 'required_with:product_attribute.*.use_for_variants',
            'variant_products.*.combination' => 'required',
            'variant_products.*.name' => 'required_without:is_same_name',
            'variant_products.*.upc' => 'required',
            'variant_products.*.sku' => 'required_without:is_same_sku',
            'variant_products.*.image_gallery' => 'required_without:is_same_image_gallery',
            'variant_products.*.price' => 'required_without:is_same_price',
            'variant_products.*.inventory' => 'required_without:is_same_inventory',
            'variant_products.*.image_feature' => 'required_without:is_same_image_feature',
        ];
    }
}
