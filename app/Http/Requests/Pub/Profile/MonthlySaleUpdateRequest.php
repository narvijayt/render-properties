<?php

namespace App\Http\Requests\Pub\Profile;

use Illuminate\Foundation\Http\FormRequest;

class MonthlySaleUpdateRequest extends FormRequest
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
			'sales.*.sales_year'    => 'numeric|min:1900|max:9999',
			'sales.*.sales_month'   => 'numeric|min:1|max:12',
			'sales.*.sales_total'   => 'nullable|required_with:sales.*.sales_value|numeric|min:0|max:32000',
			'sales.*.sales_value'   => 'nullable|required_with:sales.*.sales_total|numeric|min:0|max:99999999999999999999',
		];
    }

	public function messages() {
    	return [
    		'sales.*.sales_total.numeric'			=> 'Must be an integer',
    		'sales.*.sales_total.max'				=> 'Must be less than 32000',
			'sales.*.sales_value.numeric'			=> 'Must be an integer',
			'sales.*.sales_value.max'				=> 'Lets be real... Can I have some?',
			'sales.*.sales_total.required_with'		=> 'Required with sale value',
			'sales.*.sales_value.required_with'		=> 'Required with sale quantity',
		];
	}
}
