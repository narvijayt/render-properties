<?php

namespace App\Http\Controllers\Pub\Matching;

use App\User;
use App\Http\Controllers\Controller;
use App\Facades\Suggest;
use Illuminate\Http\Request;
use Auth;

class SuggestController extends Controller {
	/**
	 * Suggest byUser action
	 *
	 * @param \App\User $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function byUser(User $user) {
		$coll = Suggest::byUser($user);
		dd($user, $coll->map(function($user, $key) {
			$user->load('sales');
			return ['id' => $user->user_id, 'state' => $user->state, 'exp' => $user->years_of_exp, 'sales' => $user->sales_total_avg(), 'value' => $user->sales_value_avg(), 'obj' => $user];
		}));
	}

	/**
	 * Suggest byState action
	 *
	 * @param string $state
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function byState(string $state) {
		$coll = Suggest::byState($state);
		dd($state, $coll->map(function($user, $key) {
			$user->load('sales');
			return ['id' => $user->user_id, 'state' => $user->state, 'exp' => $user->years_of_exp, 'sales' => $user->sales_total_avg(), 'value' => $user->sales_value_avg(), 'obj' => $user];
		}));
	}

	/**
	 * Suggest byExp action
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function byExp(Request $request) {
		$coll = collect([]);
		if ($request->has('min') || $request->has('max')) {
			$coll = Suggest::byExp($request->input('min'), $request->input('max'));
		}
		dd($request->input(), $coll->map(function($user, $key) {
			$user->load('sales');
			return ['id' => $user->user_id, 'state' => $user->state, 'exp' => $user->years_of_exp, 'sales' => $user->sales_total_avg(), 'value' => $user->sales_value_avg(), 'obj' => $user];
		}));
	}

	/**
	 * Suggest bySalesTotal action
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function bySalesTotal(Request $request) {
		$coll = collect([]);
		if ($request->has('min') || $request->has('max')) {
			$coll = Suggest::bySalesTotal($request->input('min'), $request->input('max'));
		}
		dd($request->input(), $coll->map(function($user, $key) {
			$user->load('sales');
			return ['id' => $user->user_id, 'state' => $user->state, 'exp' => $user->years_of_exp, 'sales' => $user->sales_total_avg(), 'value' => $user->sales_value_avg(), 'obj' => $user];
		}));
	}

	/**
	 * Suggest bySalesValue action
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function bySalesValue(Request $request) {
		$coll = collect([]);
		if ($request->has('min') || $request->has('max')) {
			$coll = Suggest::bySalesValue($request->input('min'), $request->input('max'));
		}
		dd($request->input(), $coll->map(function($user, $key) {
			$user->load('sales');
			return ['id' => $user->user_id, 'state' => $user->state, 'exp' => $user->years_of_exp, 'sales' => $user->sales_total_avg(), 'value' => $user->sales_value_avg(), 'obj' => $user];
		}));
	}
}
