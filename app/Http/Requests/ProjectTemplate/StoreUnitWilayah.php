<?php

namespace App\Http\Requests\ProjectTemplate;

use App\Http\Requests\CoreRequest;

class StoreUnitWilayah extends CoreRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unit_wilayah_name' => 'required'
        ];
    }

}
