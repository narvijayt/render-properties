<?php

namespace API\Http\Requests\UserDetails;

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
            'dob'	=> 'required|date',
            'city'	=> 'required|string',
            'state' => 'required|string|min:2|max:2',
            'zip' 	=> 'required|alpha_dash',
			'bio'	=> 'sometimes|nullable|string'
        ];
    }
}