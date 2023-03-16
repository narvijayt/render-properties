<?php

namespace API\Transformers;

use League\Fractal\TransformerAbstract;
use App\BrokerSale;

/**
 * Class BrokerSalesTransformer
 * @package namespace API\Transformers;
 */
class BrokerSalesTransformer extends TransformerAbstract
{
	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'broker',
	];

	/**
	 * Transform the \RealtorSales entity
	 * @param BrokerSale $brokerSale
	 *
	 * @return array
	 */
	public function transform(BrokerSale $brokerSale)
	{
		return [
			'broker_sales_id'	=> (int) $brokerSale->broker_sales_id,
			'broker_id'			=> (int) $brokerSale->broker_id,
			'sales_year'		=> (int) $brokerSale->sales_year,
			'sales_month'		=> (int) $brokerSale->sales_month,
			'sales_total'		=> (int) $brokerSale->sales_total,
			'created_at'		=> (string) $brokerSale->created_at,
			'updated_at'		=> (string) $brokerSale->updated_at,
		];
	}

	/**
	 * Include the user relation
	 *
	 * @param BrokerSale $brokerSale
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeRealtor(BrokerSale $brokerSale)
	{
		return $this->item($brokerSale->broker, new BrokerTransformer());
	}
}
