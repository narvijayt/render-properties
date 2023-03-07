<?php

namespace App\Http\Controllers\Pub;

use App\Enums\PageIdEnum;
use App\Http\Controllers\Controller;
use App\Page;
use App\Meta;

class AboutController extends Controller
{
	public function index()
	{
        $data['aboutPage'] = Page::find(PageIdEnum::ABOUT);
        $aboutUsPageMeta = Meta::where('page_id','=',PageIdEnum::ABOUT)->get();
        if($aboutUsPageMeta->isNotEmpty()){
            $aboutPageMeta = Meta::find($aboutUsPageMeta[0]->id);
            $data['aboutMeta'] = $aboutPageMeta;
        }else{
            $data['aboutMeta'] = null;
        }
		return view('pub.about.index',$data);
	}
}
