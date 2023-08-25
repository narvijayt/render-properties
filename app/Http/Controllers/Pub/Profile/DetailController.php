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
    		   $user  = User::with('userSubscription')->find(Auth::user()->user_id);
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
        	        return redirect()->route('loadVendorPackages', ['id' => $userid]); 
        		   }
        	   /* }else{
        	        $userid = Auth::user()->user_id;
        	        Auth::logout();
        	        return redirect()->route('vendorPayment', [$userid]);
        	    }*/
    		}else{
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
            'phone_number',
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
		$user->email = strtolower($user->email);
        $userUpdate = $user->update($details);
        
        if($user->user_type == "realtor"){
            $findUser = User::find($user->user_id);
            
            // $findUser->rbc_free_marketing = $request->rbc_free_marketing;
            $findUser->lo_matching_acknowledged = $request->lo_matching_acknowledged;
            $findUser->open_to_lender_relations = $request->open_to_lender_relations;
            $findUser->co_market = isset($request->co_market) ? $request->co_market : 'No';
            $findUser->contact_me_for_match = isset($request->contact_me_for_match) ? $request->contact_me_for_match : null;
            $findUser->how_long_realtor = $request->how_long_realtor;
            $findUser->referral_fee_acknowledged = (isset($request->referral_fee_acknowledged)) ? $request->referral_fee_acknowledged : null;
            
            $findUser->update();
        }
		if ($userUpdate === true) {
			flash('Profile updated successfully')->success();
		} else {
			flash('Profile failed to update.')->warning();
		}

		return redirect()->back();
	}
	
}
