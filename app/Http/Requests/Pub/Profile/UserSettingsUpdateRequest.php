<?php

namespace App\Http\Requests\Pub\Profile;

use App\Http\Utilities\Geo\USStates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserSettingsUpdateRequest extends FormRequest
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
			'email_receive_conversation_messages'			=> 'required|boolean',
			'email_receive_match_requests'					=> 'required|boolean',
			'email_receive_match_suggestions'				=> 'required|boolean',
			'email_receive_review_messages'					=> 'required|boolean',
			'email_receive_weekly_update_emails'			=> 'required|boolean',
			'match_by_exp_min'								=> 'required|integer|min:0|ltfield:match_by_exp_max',
			'match_by_exp_max'								=> 'required|integer|max:100|gtfield:match_by_exp_min',
			'match_by_sales_total_min'						=> 'required|integer|min:0|ltfield:match_by_sales_total_max',
			'match_by_sales_total_max'						=> 'required|integer|max:1000|gtfield:match_by_sales_total_min',
			'match_by_states.*'								=> [
				'required',
				'string',
				Rule::in(USStates::abbr()),
			],
		];
	}

	public function messages()
	{
		return [
			'match_by_exp_min.ltfield'			=> 'Must be less than max years experience.',
			'match_by_exp_max.gtfield'			=> 'Must be greater than min years experience.',
			'match_by_sales_total_min.ltfield'	=> 'Must be less than max sales total',
			'match_by_sales_total_max.gtfield'	=> 'Must be greater than min sales total',
		];
	}
}
