<?php

namespace App\Http\Requests\Pub\Profile;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSubscribeRequest extends FormRequest
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
			'billing_first_name'	=> 'required|string',
			'billing_last_name'		=> 'required|string',
			'billing_company'		=> 'nullable|string',
			'billing_address_1'		=> 'required|string',
			'billing_address_2'		=> 'nullable|string',
			'billing_locality'		=> 'required|string',
			'billing_region'		=> 'required|string',
			'billing_postal_code'	=> 'required|zip',
		];
	}

	public function messages()
	{
		return [
			'billing_postal_code.zip' => 'Zip must be maximum 9 characters in length and container only numbers and dashes'
		];
	}
}
