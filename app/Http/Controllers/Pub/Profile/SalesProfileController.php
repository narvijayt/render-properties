<?php

namespace App\Http\Controllers\Pub\Profile;

use App\Enums\UserRolesEnum;
use App\Http\Requests\Pub\Profile\MonthlySaleUpdateRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Profile\RealtorProfileUpdateRequest;
use App\MonthlySale;
use App\Realtor;
use App\RealtorSale;
use Carbon\Carbon;


class SalesProfileController extends Controller
{
	/**
	 * index action
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
        $this->authorize('edit', MonthlySale::class);

		/** @var \App\User $user */
		$user = $this->auth
			->user();
//			->load('sales');

		$sales_data = MonthlySale::where('user_id', $user->user_id)
			->orderByDesc('sales_year')
			->orderByDesc('sales_month')
			->limit(12)
			->get();

		$defaults = $this->createDefaultCollection();

		$sales = $defaults->map(function(MonthlySale $defaultSale) use ($sales_data) {
			return $sales_data->first(function(MonthlySale $sale) use ($defaultSale) {
					return (
						$sale->sales_year === $defaultSale->sales_year
							&& $sale->sales_month === $defaultSale->sales_month
					);
				}, $defaultSale);
		});

		return view('pub.profile.sales.index', compact('user', 'sales'));
	}

//	/**
//	 * Create action
//	 *
//	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//	 */
//	public function create()
//	{
//		$this->authorize('create', Realtor::class);
//
//		return view('pub.profile.sales.create');
//	}

	/**
	 * store action
	 *
	 * @param MonthlySaleUpdateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(MonthlySaleUpdateRequest $request)
	{
		$this->authorize('edit', MonthlySale::class);

		$user = $this->auth->user();

		$sales = MonthlySale::hydrate($request->sales)
			->filter(function(MonthlySale $sale) {
				return $sale->sales_total !== null;
			})
			->map(function(MonthlySale $sale) use ($user) {
				$sale->user_id = $user->user_id;
				$sale->updateOrcreate(
					[
						'user_id' => $user->user_id,
						'sales_year' => $sale->sales_year,
						'sales_month' => $sale->sales_month,
					],
					$sale->toArray()
				);
				return $sale;
			});
//		dd($sales->toArray(), $request->all());
//
//		// Filter out empty form fields and return populated items as
//		// new RealtorSale objects
//		$sales = array_reduce(
//			$request->get('sales'),
//			function($sales, $sale) {
//				if ($sale['sales_total'] !== null) {
//					$sales[] = new RealtorSale([
//						'sales_year' => $sale['sales_year'],
//						'sales_month' => $sale['sales_month'],
//						'sales_total' => $sale['sales_total'],
//					]);
//				}
//				return $sales;
//			},
//			[] // seed value for reducer
//		);
//
//		$realtorData = $request->only([
//			'years_exp',
//		]);
//
//		$realtorData['active'] = true;
//
//		$realtor = new Realtor();
//		$realtor->fill($realtorData);
//
//		// Save
//		$user->realtor()->save($realtor);
//		$user->realtor->sales()->saveMany($sales);

		return redirect()->route('pub.profile.sales.index');
	}


	/**
	 * update action
	 *
	 * @param RealtorProfileUpdateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(RealtorProfileUpdateRequest $request, Realtor $realtor)
	{
        $this->authorize('edit', $realtor);

		$realtor->update($request->only([
			'years_exp',
		]));

		flash('Realtor Profile updated successfully!')->success();

		return redirect()->route('pub.profile.sales.index');
	}

	public function createDefaultCollection()
	{
        $salesData = [];
        $user = auth()->user();

        for ($i = 1; $i <= 12 ; $i++) {
        	$time = Carbon::now()->firstOfMonth()->subMonth($i);

			$sale = app()->make(MonthlySale::class);
        	$sale->fill([
        		'user_id' => $user->user_id,
				'sales_year' => (int) $time->format('Y'),
				'sales_month' => (int) $time->format('n'),
//				'sales_total' => null,
			]);

        	$salesData[] = $sale;
		}

		return collect($salesData);
////        if(count($user->sales)) {
//
//            $sales_data = $user->sales->reduce(function ($data, \App\MonthlySale $sale) {
//                if (!isset($data[$sale->sales_year])) {
//                    $data[$sale->sales_year] = [];
//                }
//                $data[$sale->sales_year][$sale->sales_month] = $sale;
//
//                return $data;
//            },
//                $sales_data
//            );
//        }
	}
}
