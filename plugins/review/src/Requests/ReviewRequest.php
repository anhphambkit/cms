<?php

namespace Plugins\Review\Requests;

use Core\Master\Requests\CoreRequest;

class ReviewRequest extends CoreRequest
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
            'name' => 'required',
        ];
    }
}
