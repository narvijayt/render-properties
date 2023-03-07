<?php

namespace App\Http\Controllers\Pub;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\ContactRequest;
use App\Mail\ContactFormReceived;
use App\Enums\PageIdEnum;
use App\Page;
use App\Meta;


class ContactController extends Controller
{
    public function index()
	{
	    $contactPage = Page::find(PageIdEnum::CONTACT);
	    $findContactPageMeta = Meta::where('page_id','=',PageIdEnum::CONTACT)->get();
	    if($findContactPageMeta->isNotEmpty()){
	        $contactPagemeta = Meta::find($findContactPageMeta[0]->id);
	    }else{
	        $contactPagemeta = null;
	    }
		return view('pub.contact.index', compact('contactPage','contactPagemeta'));
	}

	public function send(ContactRequest $request)
	{
	  	$message = (object) $request->only([
			'name',
			'phone',
			'email',
			'subject',
			'message',
		]);

		$mail = new ContactFormReceived($message);

		\Mail::send($mail);

	    flash('Thank you for submitting a contact request')->success();
		return redirect()->back();

	}
	
	public function advertise() {
	    $advPage = Page::find(PageIdEnum::ADVERTISE);
	    $findAdvMeta = Meta::where('page_id','=',PageIdEnum::ADVERTISE)->get();
	    if($findAdvMeta->isNotEmpty()){
	      $advMeta = Meta::find($findAdvMeta[0]->id);
	    }else{
	        $advMeta = null;
	    }
		return view('pub.contact.advertise', compact('advPage','advMeta'));
	}
	
	public function registerToday() {
	    $regPage = Page::find(PageIdEnum::REGISTER);
	    $findRegMeta = Meta::where('page_id','=',PageIdEnum::REGISTER)->get();
	    if($findRegMeta->isNotEmpty()){
	        $regMeta = Meta::find($findRegMeta[0]->id);
	    }else{
	        $regMeta = null;
	    }
		return view('pub.contact.registerToday', compact('regPage','regMeta'));
	}
}
