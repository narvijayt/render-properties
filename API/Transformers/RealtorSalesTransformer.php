<?php

namespace API\Transformers;

use League\Fractal\TransformerAbstract;
use App\RealtorSale;

/**
 * Class RealtorSalesTransformer
 * @package namespace API\Transformers;
 */
class RealtorSalesTransformer extends TransformerAbstract
{
	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'realtor',
	];

    /**
     * Transform the \RealtorSales entity
     * @param RealtorSale $realtorSale
     *
     * @return array
     */
    public function transform(RealtorSale $realtorSale)
    {
        return [
            'realtor_sales_id'	=> (int) $realtorSale->realtor_sales_id,
			'realtor_id'		=> (int) $realtorSale->realtor_id,
			'sales_year'		=> (int) $realtorSale->sales_year,
			'sales_month'		=> (int) $realtorSale->sales_month,
			'sales_total'		=> (int) $realtorSale->sales_total,
            'created_at'		=> (string) $realtorSale->created_at,
            'updated_at'		=> (string) $realtorSale->updated_at,
        ];
    }

	/**
	 * Include the user relation
	 *
	 * @param RealtorSale $realtorSale
	 * @return \League\Fractal\Resource\Item
	 */
    public function includeRealtor(RealtorSale $realtorSale)
	{
		return $this->item($realtorSale->realtor, new RealtorTransformer());
	}
}
