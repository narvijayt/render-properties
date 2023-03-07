<?php

namespace App\Http\Requests\Pub\Profile;

use Illuminate\Foundation\Http\FormRequest;

class BrokerProfileStoreRequest extends FormRequest
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
			'years_exp'		        => 'required|numeric|min:0',
			'sales.*.sales_year'    => 'numeric|min:1900|max:9999',
			'sales.*.sales_month'   => 'numeric|min:1|max:12',
			'sales.*.sales_total'   => 'nullable|numeric|min:0',
		];
	}
}
