<?php

namespace App\Http\Controllers\Pub\Profile;
use Illuminate\Http\Request;
use App\Conversation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Profile\DetailUpdateRequest;
use App\Message;
use App\Services\Geo\GeolocationService;
use App\UserDetail;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Category;
use App\Banner;
use App\VendorDetails;
use App\User;
use App\Subscribe;
use Carbon\Carbon;

use App\RealtorDetail;
use App\LenderDetail;
use App\VendorMeta;

class DetailController extends Controller
{
    /**
     * Profile index action
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
	public function index()
	{
	   	$user = Auth::user();
    	 if(Auth::user()->user_type == 'vendor')
    		{
    		   $user  = User::with('userSubscription','vendorMeta')->find(Auth::user()->user_id);
    		   $checkSubscription = Subscribe::where('user_id','=',Auth::user()->user_id)->get();
    		  /* if(count($checkSubscription) > 0)
    		   {*/
        		   if($user->payment_status != 0)
        		   {
        		       $vendorDet = VendorDetails::where('user_id','=',Auth::user()->user_id)->get();
        		       $getCategory = Category::where('user_id','=',Auth()->user()->user_id)->get();
        		       if(count($getCategory) > 0 )
        		       {
        		         $category['category'] = explode(',',$getCategory[0]->category_id);
        		         if($getCategory[0]->other_description !="")
        		         {
        		            $category['description'] = $getCategory[0]->other_description;
        		         }
        		       }else{
        		           $category = array();
        		       }
        		       $findBanner = Banner::where('user_id','=',Auth::user()->user_id)->get();
        		       if(count($findBanner) == 0 )
        		       {
        		          $findBanner = array();
        		       }
        		       
        		       return view('pub.profile.detail.index', compact('user','vendorDet','category','findBanner'));
        		   }else{
        		    $userid = Auth::user()->user_id;
        	        Auth::logout();
        	        // return redirect()->route('loadVendorPackages', ['id' => $userid]); 
        	        return redirect()->route('package-payment', ['id' => $userid]); 
        		   }
        	   /* }else{
        	        $userid = Auth::user()->user_id;
        	        Auth::logout();
        	        return redirect()->route('vendorPayment', [$userid]);
        	    }*/
        }else{
            if($user->user_type == "realtor"){
                $user  = User::with('realtorDetail')->find(Auth::user()->user_id);
            }else if($user->user_type == "broker"){
                $user  = User::with('lenderDetail')->find(Auth::user()->user_id);
            }
            return view('pub.profile.detail.index', compact('user'));
        }
	}

    /**
     * Profile update action
     *
     * @param DetailUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
	public function update(Request $request)
	{
	    if(Auth()->user()->user_type == 'vendor')
         {
             $userId = $request->vendor_id;
             if($userId == Auth()->user()->user_id)
             {
                 $userid = $userId;
             }else{
                 $userid = Auth()->user()->user_id;
             }
              $vendorDetails = VendorDetails::where('user_id','=',$userid)->get();
             if(count($vendorDetails) ==1)
             {
             foreach($vendorDetails as $vendordata)
             {
                 $updateVendor = VendorDetails::find($vendordata->id);
                
                 if($request->vendor_coverage_units !="")
                 {
                    $updateVendor->vendor_coverage_area = $request->vendor_coverage_units;
                 }
                 if($request->services !="")
                 {
                     $updateVendor->vendor_service = $request->services;
                 }
                 $updateVendor->update();
             }
            }
             $selCat = $request->selectcategory;
            if(count($selCat) > 0)
            {
               $checkCategory = Category::where('user_id','=',auth()->user()->user_id)->get();
               if(count($checkCategory) > 0)
               {
                  foreach($checkCategory as $catgoryDet)
                  {
                      $findCategory = Category::find($catgoryDet->id);
                      $findCategory->category_id = ",".implode(',',$request->selectcategory).",";
                       if (in_array("19", $request->selectcategory))
                          {
                            if($request->other_description !="")
                              {
                                  $findCategory->other_description = $request->other_description;
                              }else{
                                  if($request->other_description_optional !=""){
                                      $findCategory->other_description = $request->other_description_optional;
                                  }
                              }
                          }else{
                              $findCategory->other_description = "NULL";
                          }
                       $findCategory->update();
                  }
               }
           
          }
           $bannerImg  = $request->file_name;
            if($bannerImg !="")
            {
             $findBanner = Banner::where('user_id','=',auth()->user()->user_id)->get();
             if(count($findBanner) > 0 )
             {
                $updateBanner = Banner::find($findBanner[0]->id);
                $updateBanner->banner_image = $bannerImg;
                $updateBanner->update();
            }else{
                $addBanner = new Banner(); 
                $addBanner->user_id = auth()->user()->user_id;
                $addBanner->banner_image = $request->file_name;
                $addBanner->save();
            }
           }
         }
         $user = Auth::user();
    	$details = $request->only([
			'email',
			'first_name',
			'last_name',
			'bio',
			'specialties',
			'city',
			'state',
			'zip',
            'firm_name',
            'website',
            'video_url',
            'license',
            'units_closed_monthly',
            'volume_closed_monthly',
		]);
		if (
			$user->city !== $request->city
				|| $user->state !== $request->state
				|| $user->zip !== $request->zip
		) {
			$geo = app()->make(GeolocationService::class);
			$location = $geo->cityStateZip($request->city, $request->state, $request->zip);

			$details['latitude'] = $location->lat;
			$details['longitude'] = $location->long;
		}
        $details['phone_number'] = str_replace("-","",$request->phone_number);
		$user->email = strtolower($user->email);
        $userUpdate = $user->update($details);
        
        if($user->user_type == "realtor"){            
            $realtorDetail = RealtorDetail::where(['user_id' => $user->user_id])->first();
            if(is_null($realtorDetail)){
                $realtorDetail = new RealtorDetail();
                $realtorDetail->user_id = $user->user_id;
            }
            $realtorDetail->require_financial_solution = $request->require_financial_solution == "Yes" ? 1 : 0;
            $realtorDetail->require_professional_service = $request->require_professional_service == "Yes" ? 1 : 0;
            $realtorDetail->partnership_with_lender = $request->partnership_with_lender == "Yes" ? 1 : 0;
            $realtorDetail->partnership_with_vendor = $request->partnership_with_vendor == "Yes" ? 1 : 0;
            $realtorDetail->can_realtor_contact = $request->can_realtor_contact == "Yes" ? 1 : 0;
            $realtorDetail->save();
        }else if($user->user_type == "broker"){
            $lenderDetail = LenderDetail::where(['user_id' => $user->user_id])->first();
            if(is_null($lenderDetail)){
                $lenderDetail = new LenderDetail();
                $lenderDetail->user_id = $user->user_id;
            }
            $lenderDetail->stay_updated =$request->stay_updated;
            $lenderDetail->handle_challanges =$request->handle_challanges;
            $lenderDetail->unique_experties =$request->unique_experties;
            $lenderDetail->partnership_with_realtor =$request->partnership_with_realtor == "yes" ? 1 : 0;
            $lenderDetail->save();
        }else if($user->user_type == "vendor"){
            $vendorMeta = VendorMeta::where(['userId' => $user->user_id])->first();
            if(is_null($vendorMeta)){
                $vendorMeta = new VendorMeta();
                $vendorMeta->userId = $user->user_id;
            }
            $vendorMeta->experties = $request->experties;
            $vendorMeta->special_services = $request->special_services;
            $vendorMeta->service_precautions = $request->service_precautions;
            $vendorMeta->connect_realtor = $request->connect_realtor == "yes" ? 1 : 0;
            $vendorMeta->connect_memebrs = $request->connect_memebrs == "yes" ? 1 : 0;
            $vendorMeta->save();
        }
		if ($userUpdate === true) {
			flash('Profile updated successfully')->success();
		} else {
			flash('Profile failed to update.')->warning();
		}

		return redirect()->back();
	}
	
}
