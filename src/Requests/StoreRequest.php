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

       $rules = [
            'slug' => 'required|unique:damage_types|max:255|min:4',
            'name' => 'required|unique:damage_types|max:32|min:4',
            'enabled' => 'required|boolean',
            'notes' => 'string|max:255|min:2'
        ];

 /**       if ($this->request->has('modifier')) {
            foreach($this->request->get('character_id') as $key => $val)
            {
                $rules['character_id.'.$key] = 'integer|min:1';
            }
        }
**/
        return $rules;

    }
}