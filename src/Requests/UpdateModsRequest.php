<?php

namespace Smarch\Amazo\Requests;

use App\Http\Requests\Request;

class UpdateModsRequest extends Request
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

    public function messages()
    {
        foreach($this->request->get('modifier') as $key => $val) {
            $messages['modifier.'.$key.'.damage.required_with'] = 'Modifier #'.($key + 1).' requires a damage type.';
            $messages['modifier.'.$key.'.damage.numeric'] = 'Modifier #'.($key + 1).' must be numeric.';
            
            $messages['modifier.'.$key.'.amount.required_with'] = 'Modifier #'.($key + 1).' requires a damage amount.';
            $messages['modifier.'.$key.'.amount.numeric'] = 'Modifier #'.($key + 1).' must be numeric.';

            $messages['modifier.'.$key.'.type.required_with'] = 'Modifier #'.($key + 1).' requires a modifier type.';
            $messages['modifier.'.$key.'.type.in'] = 'Modifier #'.($key + 1).' must be either a multiplier or an addition.';
        }
            
        return $messages;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       $rules = [];

        if ($this->request->has('modifier')) {
            foreach($this->request->get('modifier') as $key => $val) {
                $rules['modifier.'.$key.'.damage'] = 'required_with:modifier.'.$key.'.amount|required_with:modifier.'.$key.'.type|numeric';
                $rules['modifier.'.$key.'.amount'] = 'required_with:modifier.'.$key.'.damage|required_with:modifier.'.$key.'.type|numeric';
                $rules['modifier.'.$key.'.type'] = 'required_with:modifier.'.$key.'.amount|required_with:modifier.'.$key.'.damage|in:*,+';
            }
        }

        return $rules;

    }
}