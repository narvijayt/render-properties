<?php

namespace App\Http\Controllers\Pub;
use App\Enums\PageIdEnum;
use App\Http\Controllers\Controller;
use App\Page;
use App\Meta;

class PrivacyPolicyController extends Controller
{
    public function index()
	{
        $data['privacyPage'] = Page::find(PageIdEnum::PRIVACY_POLICY);
        $privacyPageMeta = Meta::find(PageIdEnum::PRIVACY_POLICY)->get();
        if($privacyPageMeta->isNotEmpty()){
            $data['privacyMeta'] = Meta::find($privacyPageMeta[0]->id);
        }else{
            $data['privacyMeta'] = null;
        }
		return view('pub.privacy-policy.index', $data);
	}
}
