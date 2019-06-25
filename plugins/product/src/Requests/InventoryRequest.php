<?php
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;

class InventoryRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        return [
            'csv' => 'required|file',
        ];
    }
}