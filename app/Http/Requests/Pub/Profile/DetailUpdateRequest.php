<?php

namespace App\Http\Requests\Pub\Profile;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class DetailUpdateRequest extends FormRequest
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
			'first_name' 	=>	'required|string|max:250',
			'last_name' 	=>	'required|string|max:250',
			'email' 		=>	'required|string|email|max:255|unique:users,email,'.$this->get('user_id').',user_id',
			'city'			=>	'required|string',
			'state'		 	=>	'required|string|min:2|max:2',
			'zip' 			=>	'required',
			'phone_number'	=>	'required|alpha_dash',
			'phone_ext'		=>	'nullable|alpha_dash',
			'firm_name'		=>	'nullable|string',
			'website'		=>	'nullable|string',
            'specialties' => 'nullable',
            'video_url' => 'nullable',
            'license' => 'required',
            'units_closed_monthly' =>	'nullable|string',
            'volume_closed_monthly' =>	'nullable|string'
		];
		
		/*$rules = [];

        if ($this->attributes->has('first_name')) {
             $rules['first_name'] = 'required|string|max:250';
        }
        if ($this->attributes->has('last_name')) {
             $rules['last_name'] = 'required|string|max:250';
        }
        if ($this->attributes->has('email')) {
             $rules['email'] = 'required|string|email|max:255|unique:users,email,'.$this->get('user_id').',user_id';
        }
        if ($this->attributes->has('city')) {
             $rules['city'] = 'required|string';
        }
        if ($this->attributes->has('state')) {
             $rules['state'] = 'required|string|min:2|max:2';
        }
        if ($this->attributes->has('zip')) {
             $rules['zip'] = 'required';
        }
        if ($this->attributes->has('phone_number')) {
             $rules['phone_number'] = 'required|alpha_dash';
        }
        if ($this->attributes->has('phone_ext')) {
             $rules['phone_ext'] = 'nullable|alpha_dash';
        }
        if ($this->attributes->has('firm_name')) {
             $rules['firm_name'] = 'nullable|string';
        }
         if ($this->attributes->has('website')) {
             $rules['website'] = 'nullable|string';
        }
         if ($this->attributes->has('specialties')) {
             $rules['specialties'] = 'nullable';
        }
         if ($this->attributes->has('video_url')) {
             $rules['video_url'] = 'nullable';
        }
         if ($this->attributes->has('license')) {
             $rules['license'] = 'required';
        }
         if ($this->attributes->has('units_closed_monthly')) {
             $rules['units_closed_monthly'] = 'nullable|string';
        }
         if ($this->attributes->has('volume_closed_monthly')) {
             $rules['volume_closed_monthly'] = 'nullable|string';
        }
     return $rules;*/
	}

	public function messages()
	{
	  	return [
			'dob.required'			=>	'The date of birth field is required',
			'city.required'			=>	'The city field is required',
			'zip.required'			=>	'The zip code field is required',
			'state.required'		=>	'The state field is required',
			'license.required'		=>	'The license field is required',
		//	'specialties.required'		=>	'The specialties field is required',
			'phone_number.required'	=>	'The phone number field is required',
			'firm_name'				=>	'The Company name must be a string',
		];
		
        
        
	}
}
