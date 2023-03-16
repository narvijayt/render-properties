<?php

namespace API\Http\Controllers\BrokerSales;

use API\Http\Controllers\Controller;
use API\Http\Requests\BrokerSales\CreateRequest;
use API\Http\Requests\BrokerSales\UpdateRequest;
use API\Transformers\BrokerSalesTransformer;
use App\BrokerSale;
use App\Http\Requests;
use App\Http\Requests\BrokerSalesCreateRequest;
use App\Http\Requests\BrokerSalesUpdateRequest;
use Illuminate\Http\Response;


class BrokerSalesController extends Controller
{
	protected $resourceClass = BrokerSale::class;
	protected $transformerClass = BrokerSalesTransformer::class;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = $this->getUser();

		$sales = $this->model()
			->secure($user)
			->orderBy('sales_year', 'asc')
			->orderBy('sales_month', 'asc')
			->get();

		return $this->createCollectionResponse($sales)
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
		$brokerSale = $this->model()
			->create($request->only([
				'broker_id',
				'sales_year',
				'sales_month',
				'sales_total',
			]));

		return $this->createItemResponse($brokerSale)
			->respond(Response::HTTP_CREATED);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  BrokerSale $brokerSale
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(BrokerSale $brokerSale)
	{
		return $this->createItemResponse($brokerSale)
			->respond();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  UpdateRequest $request
	 * @param  BrokerSale   $brokerSale
	 *
	 * @return Response
	 */
	public function update(UpdateRequest $request, BrokerSale $brokerSale)
	{
		$brokerSale->update($request->only([
			'sales_year',
			'sales_month',
			'sales_total',
		]));

		return $this->createItemResponse($brokerSale)
			->respond();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  BrokerSale $brokerSale
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(BrokerSale $brokerSale)
	{
		$result = $brokerSale->delete();

		return response()->json([
			'data' => [
				'message' => 'Sale deleted.',
				'deleted' => $result,
			]
		]);
	}
}
