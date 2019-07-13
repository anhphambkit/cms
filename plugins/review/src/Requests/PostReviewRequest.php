<?php

namespace Plugins\Review\Requests;

use Core\Master\Requests\CoreRequest;

class PostReviewRequest extends CoreRequest
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
            'content' => 'required|string|max:1000',
        ];
    }
}
