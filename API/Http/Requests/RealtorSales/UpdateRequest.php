<?php

namespace API\Http\Requests\RealtorSales;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'sales_year'    => 'required|integer',
            'sales_month'   => 'required|integer',
            'sales_total'   => 'required|integer',
        ];
    }
}