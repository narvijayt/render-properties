<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;
use File;

class VendorAdvertisement extends Controller
{
	public function uploadAdvertisementBanner(Request $request)
	{
	    if ($request->isMethod('get'))
			return view('advertisement/banner');
		else {
			$validator = Validator::make($request->all(),
			[
			'file' => 'mimes:jpeg,bmp,png,gif,svg,pdf',
			],
			[
			'file.image' => 'The file must be an image (jpeg, png, bmp, gif, svg or pdf)'
			]);
			if ($validator->fails())
				return array(
				'fail' => true,
				 'errors' => $validator->errors()
				);
			$extension = $request->file('file')->getClientOriginalExtension();
			$dir = 'public/banner/';
			$filename = uniqid() . '_' . time() . '.' . $extension;
			$request->file('file')->move($dir, $filename);
			return $filename;
		}
		
		
    }
}
