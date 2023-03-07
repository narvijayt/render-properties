<?php

namespace App\Http\Requests\Pub\Profile;

use Illuminate\Foundation\Http\FormRequest;

class RealtorSalesStoreRequest extends FormRequest
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
			'sales_year'    => 'required|numeric|min:1900|max:9999',
			'sales_month'   => 'required|numeric|min:1|max:12',
			'sales_total'   => 'required|nullable|numeric|min:0',
        ];
    }
}
