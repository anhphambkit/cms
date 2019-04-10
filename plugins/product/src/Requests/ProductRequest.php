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
        ];
    }
}
