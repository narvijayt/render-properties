<?php

namespace App\Http\Controllers\Pub;

use App\Enums\PageIdEnum;
use App\Http\Controllers\Controller;
use App\Page;
use App\Meta;
class FaqController extends Controller
{
	public function index()
	{
        $data['faqPage'] = Page::find(PageIdEnum::FAQ);
        $faqPageMeta = Meta::where('page_id','=',PageIdEnum::FAQ)->get();
        if($faqPageMeta->isNotEmpty()){
            $data['faqMeta'] = Meta::find($faqPageMeta[0]->id);
        }else{
            $data['faqMeta'];
        }
        return view('pub.faq.index', $data);
	}
}
