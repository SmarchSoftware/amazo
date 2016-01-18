<?php

namespace Smarch\Amazo\Requests;

use App\Http\Requests\Request;

class StoreRequest extends Request
{

    /**
     * 
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
            'slug' => 'required|unique:damage_types|max:255|min:4',
            'name' => 'required|unique:damage_types|max:32|min:4',
            'enabled' => 'required|boolean',
            'notes' => 'string|max:255|min:2'
        ];

    }
}