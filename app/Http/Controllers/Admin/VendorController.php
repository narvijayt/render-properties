<?php

namespace App\Http\Controllers\Admin;
use App\Enums\UserAccountType;
use App\Jobs\SendEmailVerification;
use App\Mail\NewUserAdminNotification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Match;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\VendorDetails;
use App\VendorCategories;
use Mail;
use App\Mail\EmailVerification;
use App\Mail\WelcomeEmail;
use App\User;
use App\Banner;
use App\Category;
use App\BraintreePlan;
use App\Subscribe;
use App\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use File;


class VendorController extends Controller
{
    public function emailVerification(User $user)
	{
		try
		{
		    $email = new EmailVerification($user);
		    Mail::to($user->email)->send($email);
			
			return back();
		}
		catch(Exception $e)
		{
			DB::rollback();
			return back();
		}
	}
	
	public function welcomeEmail(User $user)
	{
        try {
            $email = new WelcomeEmail($user);
		    Mail::to($user->email)->send($email);

            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }

    public function laodAddVendorLayout(Request $request)
    {
        $page_title = 'Render | Admin |Add Vendor';
        $page_description = 'Render Dashboard';
        return view('admin.vendor.add_vendor',['page_title'=>$page_title,'page_description'=>$page_description]);
    }
    
    public function registerVendorWithDetails(Request $request)
    {
        if($request->select_category !="")
        {
        $website = $request->website;
        if($website !=""){
            $user = User::create([
            'first_name' 	=> $request->first_name,
            'last_name' 	=> $request->last_name,
            'email' 		=>strtolower($request->email),
            'password' 		=> bcrypt($request->password),
            'email_token'	=> Uuid::uuid4()->toString(),
            'verified' 		=> false,
            'register_ts' 	=> new \DateTime(),
            'user_type'     => UserAccountType::VENDOR,
            'phone_number'	=> $request->phone_no,
            'firm_name'		=> $request->company_name,
            'uid'			=> Uuid::uuid4(),
            'bio'           => $request->short_description,
            'website'  =>$website
         ]);
        }else{
            $user = User::create([
            'first_name' 	=> $request->first_name,
            'last_name' 	=> $request->last_name,
            'email' 		=>strtolower($request->email),
            'password' 		=> bcrypt($request->password),
            'email_token'	=> Uuid::uuid4()->toString(),
            'verified' 		=> false,
            'register_ts' 	=> new \DateTime(),
            'user_type'     => UserAccountType::VENDOR,
            'phone_number'	=> $request->phone_no,
            'firm_name'		=> $request->company_name,
            'uid'			=> Uuid::uuid4(),
            'bio'           => $request->short_description
         ]);
        }
             $vendorDetails = new VendorDetails();
             if($user->user_id !="")
             {
                $vendorDetails->user_id = $user->user_id;
             }
             if($request->vendor_coverage_units !="")
             {
                $vendorDetails->vendor_coverage_area = $request->vendor_coverage_units;
             }
             if($request->services !="")
             {
                  $vendorDetails->vendor_service = $request->services;
             }
             $vendorDetails->save();
             
         
        $user->assign('user');
        $user->assign($user['user_type']);
        $this->emailVerification($user);
        $this->welcomeEmail($user);
            
                if($request->file_name !="")
                {
                    $createBanner = new Banner();
                    $createBanner->user_id = $user->user_id;
                    $createBanner->banner_image = $request->file_name;
                    $advBanner = $createBanner->save();
                }
                if(count($request->select_category) > 0)
                {
                    $createCategory = new Category();
                    $createCategory->user_id = $user->user_id;
                    $createCategory->category_id  = implode(',',$request->select_category);
                    $createCategory->save();
                }
                return Redirect::route('loadVendPackages', array('id' => $user->user_id));
          }else{
        	return redirect()->back()->with('error','Please Select one of given category.');
        }
     }
    
    public function loadAllPackages($id)
    {
        $findVendor = User::where('user_id','=',$id)->where('user_type','=','vendor')->get();
         if(count($findVendor) == 0)
         {
             return redirect('/cpldashrbcs/add-vendor')->with('error','No vendor found with this details.');
         }
          $findCategory = Category::where('user_id','=',$id)->get();
         if(!empty($findVendor) && !empty($findCategory))
         {
             if($findCategory[0]->braintree_id =="")
             {
                 $page_title = 'Render | Admin |Vendor Packages';
                 $page_description = 'Render Dashboard';
                 return view('admin.vendor.vendorPackages',['id'=>$id,'page_title'=>$page_title,'page_description'=>$page_description]);
             }else{
                 return redirect('/cpldashrbcs/add-vendor')->with('message','You have already done payment for registeration.');
             }
         }
    }
    
    
    public function loadPaymentLayout(Request $request)
    {
         $selectedPackage = $request->has('package') ? $request->get('package') : '';
           $checkVendor = User::where('user_id','=',$request->id)->where('user_type','=','vendor')->get();
           if(count($checkVendor) == 0)
             {
                 return redirect('/cpldashrbcs/add-vendor')->with('error','No vendor found with this details.');
             }
           $checkCat = Category::where('user_id','=',$request->id)->get();
            if(!empty($checkVendor) && !empty($checkCat))
             {
             if($checkCat[0]->braintree_id =="")
             {
                 $page_title = 'Render | Admin |Vendor Packages';
                 $page_description = 'Render Dashboard';
                return view('admin.vendor.vendorPayment',['selectedPackage'=>$selectedPackage,'page_title'=>$page_title,'page_description'=>$page_description]);
             }else{
                 return redirect('/cpldashrbcs/add-vendor')->with('message','You have already done payment for registeration.');
             }
             
         }
    }
    
    public function makeVendorPackagePayment(Request $request)
    {
        $userId = $request->id;
        /************City Details******/
        $package_name = $request->package;
        $cityName = $request->city_name;
        $additionalCity = $request->additional_city;
        $cityTotalAmount = $request->curr_city;
        /*************End City**********/
        /**************State Details***********/
        $stateName = $request->state_name;
        $additionalStates = $request->additional_state;
        $stateTotalAmount = $request->curr_state;
        $packageUs = $request->selected_us;
        /************End State DEtails********/
        $finalamount = array();
        $packagePrice = $request->package_price;
        $plan = array();
            if($request->additional_city !="")
            {
                $countPackageAmount = count($request->additional_city);
                $finalamount[] = $countPackageAmount * 795 + 995;
                $plan[] = 8;
            }
            if($request->additional_state !="")
            {
                $countStatePackageAmount = count($request->additional_state);
                $finalamount[] = $countStatePackageAmount * 6995 + 8995;
                $plan[] = 10;
            }
            if($request->selected_us == '11')
            {
                $finalamount[] = 97995.00;
                $plan[] = 11;
            }
            if($request->additional_city == "" && $request->city_name!=""){
                $finalamount[] = 995.00;
                $plan[] = 7;
            }
            if($request->additional_state =="" && $request->state_name!=""){
                $finalamount[] = 8995.00;
                $plan[] = 9;
            }
            $overallSelPackageAmount = $finalamount[0];//detailed package amount
            $planId = $plan[0];
            $findBrainTreePlan = BraintreePlan::find($planId);
            $planName = $findBrainTreePlan->name;
            $getUserDetails = User::find($userId);
            $firstname = $getUserDetails->first_name;
            $lastname = $getUserDetails->last_name;
            $phone_no = $getUserDetails->phone_number;
            $emailAdd = $getUserDetails->email;
            if($cityName !="" || $stateName!="" || $packageUs!="")
            {
                $user = [
                    'billing_first_name' => $firstname,
                    'billing_last_name' => $lastname,
                    'braintree_id' => $planId,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                User::Where('user_id', $userId)->update($user);
                
                    $subscribeUser = Subscribe::where('user_id', $userId)->first();
                    $createPatment = new  Payment();
                    $createPatment->user_id = $userId;
                    $createPatment->subscription_id = 'null';
                    $createPatment->braintree_id = $planId;
                    $createPatment->total_amount = $overallSelPackageAmount;
                    $createPatment->user_type = 'vendor';
                    $createPatment->payment_mode = 'Cash';
                    $createPatment->paid_by_user_id = 3;
                    $createPatment->save();
                if(!empty($subscribeUser))
                {
                    $arr = [
                    'braintree_id' => $planId,
                    'braintree_plan' => $planName,
                    'updated_at' => \Carbon\Carbon::now()
                    ];
                    Subscribe::Where('user_id', $userId)->update($arr);
                } else {
                    Subscribe::create(['user_id' => $userId,
                        'name' => 'main',
                        'braintree_id' => $planId,
                        'braintree_plan' => $planName,
                        'quantity' => 1,
                        'ends_at' => null,
                        'created_at' => \Carbon\Carbon::now()->subDay(1),
                        'updated_at' => \Carbon\Carbon::now()->subDay(1)
                    ]);
                }
                  $findvendorDetails = VendorDetails::where('user_id','=',$userId)->get();
                  if(count($findvendorDetails) > 0)
                  {
                     foreach($findvendorDetails as $vendor)
                    {
                    $updateVendorDet = VendorDetails::find($vendor->id);
                    if($cityName !="")
                    {
                        $updateVendorDet->package_selected_city = $cityName;
                    }
                    if(count($additionalCity)>0)
                    {
                        $updateVendorDet->additional_city = json_encode($additionalCity);
                    }
                   if($stateName !="")
                    {
                        $updateVendorDet->package_selected_state = $stateName;
                    }
                    if(count($additionalStates)>0)
                    {
                       
                        $updateVendorDet->additional_state = json_encode($additionalStates);
                    }
                    
                        $updateVendorDet->update();
                    }
                  }
                 $checkCategoryExists = Category::where('user_id','=',$userId)->get();
                if(count($checkCategoryExists) > 0)
                {
                    $updateCat = Category::find($checkCategoryExists[0]->id);
                    $updateCat->braintree_id = $planId;
                    $updateCat->update();
                }
                $user= User::find($userId);
                $this->emailVerification($user);
                $this->welcomeEmail($user);
                return redirect('/cpldashrbcs/all-vendors')->with('message', 'Succesfully made payment for vendor registration.');
            }
     }
     
     public function listAllVendor(Request $request)
     {
        $page_title = 'Render | Admin |All Vendor';
        $page_description = 'Render Dashboard';
        $query = User::where('user_type','=','vendor')->with('categories')->with('vendorPackage')->with('vendor_details')->with('userSubscription');

        if($request->input('search')){
            $search_string = strtolower(trim($request->input('search')));
            if(strpos($search_string, "@") ){
                $query->where(DB::raw('lower(email)'), 'like', '%'. $search_string. '%');
            }else if(strpos($search_string, ' ')){
                $name1 = substr($search_string, 0, strrpos($search_string, ' '));
                $name2 = substr($search_string, strpos($search_string, ' ') + 1);
                
                $query->where(function ($childquery) use ($name1, $name2) {
    			    $childquery->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });
                
            }else{
                $query->where(function ($childquery) use ($search_string) {
                    $childquery->where(function ($subQuery) use ($search_string) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $search_string. '%')
                        ->orWhere(DB::raw('lower(last_name)'), 'like', '%'. $search_string. '%');
                    })->orWhere(function ($subQuery) use ($search_string) {
                        $subQuery->where(DB::raw('lower(email)'), 'like', '%'. $search_string. '%');
                    });
                });
            }
        }
        
        if($request->input('payment_status') && $request->input('payment_status') != "all"){
            $payment_status = $request->input('payment_status') == "unpaid" ? 0 : 1;
            $query->where('payment_status', $payment_status );
        }
        $users = $query->orderBy('user_id','desc')->paginate(20);
        return view('admin.vendor.allVendor',['users'=>$users,'page_title'=>$page_title,'page_description'=>$page_description]);
     }
     
     public function loadEditVendor($id)
     {
        $page_title = 'Render | Admin |All Vendor';
        $page_description = 'Render Dashboard'; 
        $users = User::find($id);
        if($users->user_type == 'vendor')
        {
            $fetchCategory = Category::where('user_id','=',$id)->get();
            if(count($fetchCategory) > 0){
                foreach($fetchCategory as $category){
                    $allCat['category'] = $category->category_id;
                    $allCat['description'] = $category->other_description;
                }
            }else{
                $allCat = array();
            }
            $vendorDet = VendorDetails::where('user_id','=',$id)->get();
            $findBanner = Banner::where('user_id','=',$id)->get();
            return view('admin.vendor.editVendor',['findBanner'=>$findBanner,'allCat'=>$allCat,'vendorDet'=>$vendorDet,'users'=>$users,'page_title'=>$page_title,'page_description'=>$page_description]);
        }else{
          return redirect()->back()->with('error','No access to update user other than vendor.');
        }        
    }
    
    public function updateVenderDetails(Request $request)
    {
        $userId = $request->id;
        $findUser = User::find($userId);
        if($request->first_name !=""){
            $findUser->first_name = $request->first_name;
        }
        if($request->last_name !=""){
            $findUser->last_name = $request->last_name;
        }
        if($request->company_name !=""){
            $findUser->firm_name = $request->company_name;
        }
        if($request->website !=""){
            $findUser->website = $request->website;
        }
        if($request->email !=""){
           $findUser->email = $request->email;  
        }
        if($request->phone_no !=""){
            $findUser->phone_number = $request->phone_no;  
        }
        if($request->short_description !="" && $request->short_description !="null"){
            $findUser->bio = $request->short_description;  
        }
        if($request->state !="" && $request->state !="null"){
            $findUser->state = $request->state;
        }
        if($request->city !="" && $request->city !="null") { 
            $findUser->city = $request->city;
        }
        if($request->zip !="" && $request->zip !="null"){
            $findUser->zip = $request->zip;
        }
        $findUser->payment_status = $request->payment_status;
        if($request->payment_status == 1 && empty($findUser->billing_first_name)){
            $findUser->billing_first_name = $findUser->first_name;
        }
        $findUser->update();
        if($request->vendor_coverage_units !=""){
            $vendDet = VendorDetails::where('user_id','=',$userId)->get();
            if(count($vendDet) > 0 ){
                   $findVendorDetails = VendorDetails::find($vendDet[0]->id);
                   $findVendorDetails->vendor_coverage_area = $request->vendor_coverage_units;  
                    if($request->services !=""){
                        $findVendorDetails->vendor_service = $request->services;
                    }
                    $findVendorDetails->update();
            }
        }
        if(count($request->select_category) > 0 )
        {
           $findCat = Category::where('user_id','=',$userId)->get();
            if(count($findCat) > 0){
                   $findCategory = Category::find($findCat[0]->id);
                    $findCategory->category_id = ",".implode(',',$request->select_category).",";
                      if (in_array("19", $request->select_category))
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
        if($request->file_name !=""){
            $findBanner = Banner::where('user_id','=',$request->id)->get();
            if(count($findBanner) > 0 )
            {
                foreach($findBanner as $bannerUpdate)
                {
                    $updateBanner = Banner::find($bannerUpdate->id);
                    $updateBanner->banner_image = $request->file_name;
                    $updateBanner->update();
                }
            }else{
                $addBanner = new Banner();
                $addBanner->user_id = $request->id;
                $addBanner->banner_image = $request->file_name;
                $addBanner->save();
            }
        }
        return redirect()->back()->with('message','Successfully Updated Vendor Profile');
    }
    
    public function loadAddIndustry(Request $request){
        $page_title = 'Render | Admin |All Vendor';
        $page_description = 'Render Dashboard'; 
        return view('admin.vendor.addCategory', ['page_title'=>$page_title, 'page_description'=>$page_description]);
    }
    
	public function uploadIndustryFile(Request $request)
    {
	    if ($request->isMethod('get'))
			return view('admin.vendor.addCategory');
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
			$dir = 'public/services/';
			$filename = uniqid() . '_' . time() . '.' . $extension;
			$request->file('file')->move($dir, $filename);
			return $filename;
		
		}
	 }
	 
	 public function addIndustry(Request $request)
	 {
	     $industryName = $request->industry_name;
	     $findIndustry = VendorCategories::where('name','=',$industryName)->get();
	     if($findIndustry->isEmpty())
	     {
	     if($industryName!="")
	     {
	        $createIndustry = new VendorCategories();
	        $filename = $request->file_name;
	        if($filename !="")
	        {
	           $createIndustry->file_name =  $request->file_name;
	        }
	        $createIndustry->name = $industryName;
	        $createIndustry->slug = str_slug($industryName);
	        $savedIndustry = $createIndustry->save();
	        if($savedIndustry){
	            return redirect()->back()->with('message','Successfully added industry');
	        }else{
	            return redirect()->back()->with('error','Something Went Wrong');
	        }
	      }
	     }else{
	         return redirect()->back()->with('error','Industry already Exists with this name');
	     }
	    
	 }
	 
	 public function allIndustry(Request $request){
	     $page_title = 'Render | Admin |All Vendor';
         $page_description = 'Render Dashboard'; 
	     $fetchAllIndustry = VendorCategories::orderBy('name','asc')->paginate(10);
	     return view('admin.vendor.allCategory', ['fetchAllIndustry'=>$fetchAllIndustry,'page_title'=>$page_title, 'page_description'=>$page_description]);
	 }
	 
	 public function editIndustry($id){
	     $page_title = 'Render | Admin |All Vendor';
         $page_description = 'Render Dashboard'; 
	     $fetchAllIndustry = VendorCategories::find($id);
	     return view('admin.vendor.editCategory', ['fetchAllIndustry'=>$fetchAllIndustry,'page_title'=>$page_title, 'page_description'=>$page_description]);
	 }
	 
	 public function updateIndustry(Request $request){
	     $findIndustry = $request->industry_id;
	     $fileName = $request->file_name;
	     $industryName = $request->industry_name;
	        $checkIndustry = VendorCategories::find($findIndustry);
	         if($findIndustry !="" && $industryName !="" && $checkIndustry!=""){
	            $checkIndustry->name = $industryName;
	            $checkIndustry->slug = str_slug($industryName);
	            if($fileName !=""){
	               $checkIndustry->file_name =  $fileName;
	            }
	            $updateCategory = $checkIndustry->update();
	            if($updateCategory){
	                return redirect()->back()->with('message','Industry Updated Successfully.');
	            }else{
	                return redirect()->back()->with('error','Something Went Wrong.');
	            }
	         }else{
	              return redirect()->back()->with('error','Something Went Wrong.');
	         }
	 	 }
   
}
