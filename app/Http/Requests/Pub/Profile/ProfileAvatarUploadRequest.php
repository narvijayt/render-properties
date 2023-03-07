<?php

namespace App\Http\Requests\Pub\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileAvatarUploadRequest extends FormRequest
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
         //   'avatar' => 'required|image|mimes:jpeg,png|max:1024|dimensions:min_width=200,min_height=200,max_width=1200,max_height:1200',
         'avatar' => 'required'
        ];
    }

    public function messages()
	{
		return [
			'avatar.size' => 'The image must be less than 1MB in size',
			'avatar.dimensions' => 'Minimum dimensions: 200x200, Max dimensions: 1200x1200',
		];
	}
}
