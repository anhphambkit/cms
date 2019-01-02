<?php

namespace Plugins\Cmsplugin\Http\Requests;

use Core\Master\Http\Requests\Request;

class CmspluginRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Sang Nguyen
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
