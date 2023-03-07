<?php

namespace App\Http\Controllers\Pub;

use App\Enums\PageIdEnum;
use App\Http\Controllers\Controller;
use App\Page;
use App\Meta;

class TermsAndConditionsController extends Controller
{
	public function index()
	{
        $data['termsPage'] = Page::find(PageIdEnum::TERMS_CONDITION);
        $termPage = Meta::where('page_id','=',PageIdEnum::TERMS_CONDITION)->get();
        if($termPage->isNotEmpty()){
           $data['termMeta'] = Meta::find($termPage[0]->id);
        }else{
            $data['termMeta'] = null;
        }
        return view('pub.terms-and-conditions.index', $data);
	}
}
