<?php

namespace API\Http\Controllers\RealtorSales;

use API\Http\Controllers\Controller;
use API\Http\Requests\RealtorSales\CreateRequest;
use API\Http\Requests\RealtorSales\UpdateRequest;
use API\Transformers\RealtorSalesTransformer;
use App\Http\Requests;
use App\Http\Requests\RealtorSalesCreateRequest;
use App\Http\Requests\RealtorSalesUpdateRequest;
use App\RealtorSale;
use Illuminate\Http\Response;


class RealtorSalesController extends Controller
{
	protected $resourceClass = RealtorSale::class;
	protected $transformerClass = RealtorSalesTransformer::class;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = $this->getUser();

		$realtorSales = $this->model()
			->secure($user)
			->get();

		return $this->createCollectionResponse($realtorSales)
			->respond();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  CreateRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateRequest $request)
	{
		$realtorSale = $this->model()
			->create($request->only([
				'realtor_id',
				'sales_year',
				'sales_month',
				'sales_total',
			]));

		return $this->createItemResponse($realtorSale)
			->respond(Response::HTTP_CREATED);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(RealtorSale $realtorSale)
	{
		return $this->createItemResponse($realtorSale)
			->respond();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  UpdateRequest $request
	 * @param  RealtorSale   $realtorSale
	 *
	 * @return Response
	 */
	public function update(UpdateRequest $request, RealtorSale $realtorSale)
	{
		$realtorSale->update($request->only([
			'sales_year',
			'sales_month',
			'sales_total',
		]));

		return $this->createItemResponse($realtorSale)
			->respond();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  RealtorSale $realtorSale
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(RealtorSale $realtorSale)
	{
		$result = $realtorSale->delete();

		return response()->json([
			'data' => [
				'message' => 'Sale deleted.',
				'deleted' => $result,
			]
		]);
	}
}
