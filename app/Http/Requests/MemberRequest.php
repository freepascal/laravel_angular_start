<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MemberRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array(
            'name'      => 'required|alpha_spaces|max:100',
            'address'   => 'required|alpha_spaces|max:300',

            // digits_between:1,2
            'age'       => 'required|integer|min:1|max:99',
            'photo'     => 'mimes:jpeg,png,gif'
        );
    }

    public function messages()
    {
        return array(
            'name.required'         => 'Name must be required',
            'name.max'              => 'Name length must be <= 100',

            'address.max'           => 'Address length must be <= 300',

            'age.integer'           => 'Age must be an integer',
            'age.min'               => 'Age must be a positive integer',
            'age.max'               => 'Age must be <= 99',

            'photo.mimes'           => 'The photo must be a jpge, png or gif'
        );
    }
}

?>
