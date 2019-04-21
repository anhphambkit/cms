<?php

namespace Plugins\Blog\Requests;

use Core\Master\Requests\CoreRequest;
use Plugins\Blog\Models\Category;

class CategoryRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        $model = Category::class;
        $id    = $this->route()->parameter('id');

        return [
            'name'        => 'required|max:120',
            'description' => 'max:400',
            'slug'        => 'required',
            'parent_id'   => "mutiple_level_parent:{$id},{$model}"
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'parent_id.mutiple_level_parent' => 'Test custom message'
        ];
    }
}
