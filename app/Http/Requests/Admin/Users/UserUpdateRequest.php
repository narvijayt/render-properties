<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
			'username' 		=> 'required|string|max:250|unique:users,username,'.$this->get('user_id').',user_id',
			'first_name' 	=> 'required|string|max:250',
			'last_name' 	=> 'required|string|max:250',
			'email' 		=> 'required|string|email|max:255|unique:users,email,'.$this->get('user_id').',user_id',
			'active'		=> 'required|boolean',

		];
    }
}
