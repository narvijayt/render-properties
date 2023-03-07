<?php

namespace App\Http\Controllers\Pub\Profile;

use App\RealtorSale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Profile\RealtorSalesStoreRequest;

class RealtorSalesController extends Controller
{

	// @TODO: Complete implementation when UI is available for VUE implementation
	public function store(RealtorSalesStoreRequest $request)
	{
		dd($request->all());
	}

	// @TODO: Complete implementation when UI is available for VUE implementation
    public function update(RealtorSale $realtorSale)
	{
		dd($realtorSale);
	}
}
