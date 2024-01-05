<?php
namespace App\Http\Controllers\Auth;
use App\Enums\MatchPurchaseType;
use App\Enums\UserAccountType;
use App\Enums\PageIdEnum;
use App\Jobs\SendEmailVerification;
use App\Mail\NewUserAdminNotification;
use App\MatchPurchase;
use App\Page;
use DB;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Mail\WelcomeEmail;
use App\Mail\EmailVerification;
use App\PartialRegistration;
use App\User;
use App\UserProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Ramsey\Uuid\Uuid;
use App\VendorDetails;
use App\Banner;
use App\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Services\Geo\GeolocationService;

use App\Services\MobileVerificationService;
use App\Services\TwilioService;
use App\VendorPackages;
use App\Testimonial;
use App\RealtorDetail;
use App\LenderDetail;
use App\RegistrationPlans;
use App\VendorMeta;
use DateTime;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/profile';
	protected $registerView = 'auth.register';
	protected $defaultUserType = null;

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	public function showRegistrationForm(Request $request)
	{
	 $registerType = $request->has('type') ? $request->get('type') : '';
	 $lenderRegPage = Page::find(PageIdEnum::LENDERREGISTER);
	 $realtorRegPage = Page::find(PageIdEnum::REALTORREGISTER);
        if ($request->input('remember_token')) 
        {
			$user = PartialRegistration::where('remember_token', $request->input('remember_token'))->first();
			return view('auth.register', compact('user', 'registerType', 'lenderRegPage', 'realtorRegPage'));
		}
        return view('auth.register', compact('registerType', 'lenderRegPage', 'realtorRegPage'));
	}
	
	public function showLenderRegistrationForm(Request $request)
	{
	    $registerType = 'lender';
	    $lenderRegPage = Page::find(PageIdEnum::LENDERREGISTER);
	    $lenderPackage = RegistrationPlans::where(['packageType' => 'lender'])->first();
	    $optionLabel = '';
	    if(!is_null($lenderPackage)){
            $optionLabel = "Monthly - $".$lenderPackage->regular_price;
            if($lenderPackage->sale_price > 0 && !empty($lenderPackage->couponId)){
                if($lenderPackage->sale_period > 1){
                    $optionLabel = "$".number_format($lenderPackage->sale_price,2,'.','')."/month for first ".$lenderPackage->sale_period." months and $".number_format($lenderPackage->regular_price,2,'.','')."/month afterward";
                }else{
                    $optionLabel = "$".number_format($lenderPackage->sale_price,2,'.','')."/month for first month and $".number_format($lenderPackage->regular_price,2,'.','')."/month afterward";
                }
            }
        }
	    $testimonials = Testimonial::all();
        if ($request->input('remember_token')) 
        {
			$user = PartialRegistration::where('remember_token', $request->input('remember_token'))->first();
			return view('auth.lender-register', compact('user', 'registerType', 'lenderRegPage','testimonials', 'optionLabel'));
		}
        return view('auth.lender-register', compact('registerType', 'lenderRegPage','testimonials', 'optionLabel'));
	}
	
	public function showRealtorRegistrationForm(Request $request)
	{
        $registerType = 'realtor';
        $realtorRegPage = Page::find(PageIdEnum::REALTORREGISTER);
        $testimonials = Testimonial::all();
        if ($request->input('remember_token')) 
        {
    		$user = PartialRegistration::where('remember_token', $request->input('remember_token'))->first();
    		return view('auth.realtor-register', compact('user', 'registerType', 'realtorRegPage','testimonials'));
    	}        
        return view('auth.realtor-register', compact('registerType', 'realtorRegPage','testimonials'));
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
	    if($data['user_type'] == 'realtor'){
	        return Validator::make($data, [
			'provider' 		=> 'string',
			'provider_id' 	=> 'string',
			'first_name' 	=> 'required|string|max:250',
			'last_name' 	=> 'required|string|max:250',
			'email' 		=> 'required|string|email|max:255|unique:users',
			'password' 		=> 'required|string|min:6|confirmed',
			'user_type' 	=> 'required|string|in:realtor,broker',
			'city' 			=> 'nullable|string',
			'state' 		=> 'required|string|min:2|max:2',
			'zip' 			=> 'required',
			'years_of_exp'	=> 'numeric|min:0|max:100',
            // 'specialties' => 'nullable|string',
			'phone_number'	=>	'required|alpha_dash',
			'phone_ext'		=>	'nullable|alpha_dash',
			'firm_name'		=>	'nullable|string',
			'website'		=>	'nullable|string',
			'receive_email'	=>	'nullable',
            'license' => 'required|string|max:255',
            'volume_closed_monthly' =>	'nullable|string',
			// 'require_financial_solution' => 'required',
			// 'require_professional_service' => 'required',
			// 'partnership_with_lender' => 'required',
			// 'partnership_with_vendor' => 'required',
			// 'can_realtor_contact' => 'required',
		], [
			'zip.required' => 'Zip field is required',
			'postal_code_service.required' => 'Postal code of service area field is required',
			'phone_number.required'	=>	'The phone number field is required',
			'firm_name.string'	=>	'The company name must be a string',
			'user_type.required' => 'You must select either real estate agent or lender',
			// 'require_financial_solution.required' => 'You must select either real estate agent or lender',
		]);
	    }else{
		return Validator::make($data, [
			'provider' 		=> 'string',
			'provider_id' 	=> 'string',
			'first_name' 	=> 'required|string|max:250',
			'last_name' 	=> 'required|string|max:250',
			'email' 		=> 'required|string|email|max:255|unique:users',
			'password' 		=> 'required|string|min:6|confirmed',
			'user_type' 	=> 'required|string|in:realtor,broker',
			'city' 			=> 'nullable|string',
			'state' 		=> 'required|string|min:2|max:2',
			'zip' 			=> 'required',
			'postal_code_service' => 'required|string|max:200',
			'years_of_exp'	=> 'numeric|min:0|max:100',
            'specialties' => 'nullable|string',
			'phone_number'	=>	'required|alpha_dash',
			'phone_ext'		=>	'nullable|alpha_dash',
			'firm_name'		=>	'nullable|string',
			'website'		=>	'nullable|string',
			// 'receive_email'	=>	'nullable',
            'license' => 'required|string|max:255',
            'volume_closed_monthly' =>	'nullable|string'
		], [
			'zip.required' => 'Zip field is required',
			'postal_code_service.required' => 'Postal code of service area field is required',
			'phone_number.required'	=>	'The phone number field is required',
			'firm_name.string'	=>	'The company name must be a string',
			'user_type.required' => 'You must select either real estate agent or lender',
		]);
	    }
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data)
	{
	    Validator::extend('honey_pot', function ($attribute, $value, $parameters) {

        return $value == '';

         });
        $rules = array(
            'honey_pot' => 'honey_pot'
        );

        $messages = array('honey_pot' => 'Nothing Here');
	    
	    $validation = Validator::make($data, $rules, $messages);
	    
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        
        //if first name or last name contains http:// or https:// then it is invalid name.
        if(strpos($data['first_name'], 'http://') !== false || strpos($data['first_name'], 'https://') !== false){
	        return redirect()->back()->with('error','Invalid First Name.');
	    }
	    
	    if(strpos($data['last_name'], 'http://') !== false || strpos($data['last_name'], 'https://') !== false){
	        return redirect()->back()->with('error','Invalid Last Name.');
	    }
	    
	    $geolocationService = new GeolocationService();
        $location = $geolocationService->cityStateZip($data['city'],$data['state'],$data['zip']);
        if($data['city'] === "Select City" || $data['city'] == '0' || $data['city'] === "Other") {
            $c = $data['anotherCity']; 
        } else {
            $c= $data['city'];  
        }
        if($data['phone_ext'] ==''){
            $data['phone_ext'] = null;
        }
        if($data['user_type'] =='realtor'){
            // dd($data);
                $user = User::create([
                'first_name' 	=> $data['first_name'],
                'last_name' 	=> $data['last_name'],
                'email' 		=> strtolower($data['email']),
                'password' 		=> bcrypt($data['password']),
                'email_token'	=> Uuid::uuid4()->toString(),
                'verified' 		=> false,
                'user_type' 	=> $data['user_type'],
                'city' 			=> $c,
                'state' 		=> $data['state'],
                'zip' 			=> $data['zip'],
                'register_ts' 	=> new DateTime(),
                'verify_ts' 	=> null,
                'years_of_exp'	=> null,
                // 'specialties' => $data['specialties'],
                'latitude'		=> $location->lat,
                'longitude'		=> $location->long,
                'phone_number'	=> $data['phone_number'],
                'phone_ext'		=> $data['phone_ext'],
                'website'		=> $data['website'],
                'firm_name'		=> $data['firm_name'],
                'uid'			=> Uuid::uuid4(),
                'license' =>  $data['license'],
                'volume_closed_monthly' =>  $data['volume_closed_monthly'],
                'contact_term' =>  isset($data['enable_emails']) ? $data['enable_emails'] : 0,
                'promote_profile' => $data['provide_content']
            ]);
            
        }else{
            $user = User::create([
                'first_name' 	=> $data['first_name'],
                'last_name' 	=> $data['last_name'],
                'email' 		=> strtolower($data['email']),
                'password' 		=> bcrypt($data['password']),
                'email_token'	=> Uuid::uuid4()->toString(),
                'verified' 		=> false,
                'user_type' 	=> $data['user_type'],
                'city' 			=> $c,
                'state' 		=> $data['state'],
                'zip' 			=> $data['zip'],
                'postal_code_service' => $data['postal_code_service'],
                'register_ts' 	=> new DateTime(),
                'verify_ts' 	=> null,
                'years_of_exp'	=> null,
                'specialties' => $data['specialties'],
                'latitude'		=> $location->lat,
                'longitude'		=> $location->long,
                'phone_number'	=> $data['phone_number'],
                'phone_ext'		=> $data['phone_ext'],
                'website'		=> $data['website'],
                'firm_name'		=> $data['firm_name'],
                'uid'			=> Uuid::uuid4(),
                'license' =>  $data['license'],
                'volume_closed_monthly' =>  $data['volume_closed_monthly'],
                'contact_term' =>  $data['agree'],
                'promote_profile' => $data['provide_content']
            ]);
        }
        $findUser = User::find($user->user_id);
        $findUser->contact_term = $data['agree'];
        $findUser->promote_profile = $data['provide_content'];
        if($data['user_type'] =='realtor'){
            // $findUser->rbc_free_marketing = $data['rbc_free_marketing'];
            /*$findUser->lo_matching_acknowledged = $data['lo_matching_acknowledged'];
            $findUser->open_to_lender_relations = $data['open_to_lender_relations'];
            $findUser->co_market = isset($data['co_market']) ? $data['co_market'] : "No";
            $findUser->contact_me_for_match = isset($data['contact_me_for_match']) ? $data['contact_me_for_match'] : null;
            $findUser->contact_term = (isset($data['enable_emails'])) ? $data['enable_emails'] : 0;
            $findUser->referral_fee_acknowledged = isset($data['referral_fee_acknowledged']) ? $data['referral_fee_acknowledged'] : null;*/
            $findUser->how_long_realtor = $data['how_long_realtor'];
        }
        $findUser->update();
        if($data['user_type'] =='realtor'){
            $realtorDetail = RealtorDetail::where(['user_id' => $user->user_id])->first();
            if(is_null($realtorDetail)){
                $realtorDetail = new RealtorDetail();
                $realtorDetail->user_id = $user->user_id;
            }
            $realtorDetail->require_financial_solution = $data['require_financial_solution'] == "yes" ? 1 : 0;
            $realtorDetail->require_professional_service = $data['require_professional_service'] == "yes" ? 1 : 0;
            $realtorDetail->partnership_with_lender = $data['partnership_with_lender'] == "yes" ? 1 : 0;
            $realtorDetail->partnership_with_vendor = $data['partnership_with_vendor'] == "yes" ? 1 : 0;
            $realtorDetail->can_realtor_contact = $data['can_realtor_contact'] == "yes" ? 1 : 0;
            $realtorDetail->save();
        }
        $user->assign('user');
        $user->assign($user['user_type']);
        if(!isset($user['receive_email'])) 
        {
			$settings = $user->settings;
			$settings->email_receive_match_suggestions = false;
			$settings->save();
		}
        if (isset($data['provider'])
			&& $data['provider'] !== null
			&& isset($data['provider_id'])
			&& $data['provider_id'] !== null
		) {
			$this->createUserProvider($data, $user);
		}
        if(!in_array(env('APP_ENV'),['local','staging'])){
            $this->notifyAdmin($user);
            $this->emailVerification($user);
            $this->welcomeEmail($user);
        }
        if ($user->user_type === UserAccountType::BROKER) 
        {
			MatchPurchase::create([
				'user_id' => $user->user_id,
				'type' => MatchPurchaseType::COMPLIMENTARY,
				'quantity' => 2,
			]);
		} elseif ($user->user_type === UserAccountType::REALTOR) 
		{
			MatchPurchase::create([
				'user_id' => $user->user_id,
				'type' => MatchPurchaseType::COMPLIMENTARY,
				'quantity' => 1,
			]);
		}
		return $user;
    }

	/**
     * Send an email to the admin notifying them that a new user has
     * registered on the site.
     *
     * @param User $user
     */
	public function notifyAdmin(User $user) {
	    //return;
        $email = new NewUserAdminNotification($user);
        // Mail::to(config('mail.from.address'))->send($email);
        Mail::to("richardtocado@gmail.com")->send($email);
    }

	/**
	 * Sends an email to the user for verification
	 * abstracted so we can use in case they loose the verification
	 * email
	 *
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function emailVerification(User $user)
	{
	    //return;
		try
		{
			$email = new EmailVerification($user);
		    Mail::to($user->email)->send($email);
			
			return back();
		} catch(Exception $e) {
			DB::rollback();
			return back();
		}
	}

	public function createUserProvider($data, $user)
	{
		$userprovider = UserProvider::create([
			'user_id' => $user->user_id,
			'email' => strtolower($user->email),
			'provider' => isset($data['provider']) ? $data['provider'] : null,
			'provider_id' => isset($data['provider_id']) ? $data['provider_id'] : null,
		]);
		$this->deletePartialRegistrations($user, $userprovider);
	}

	/**
	 * Soft deletes any  Partial registrations
	 * @param $user
	 * @param $userprovider
	 */
	public function deletePartialRegistrations($user, $userprovider)
	{
		$previous = PartialRegistration::where(['email' => $user->email, 'provider' => $userprovider->provider])->first();
		if ($previous !== null) {
			$previous->delete();
		}
	}
	
	/* 
	** welcome email 
	*/
	public function welcomeEmail(User $user)
	{
	    //return;
        try {
            $email = new WelcomeEmail($user);
		    Mail::to($user->email)->send($email);

            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }
    
    public function loadVendorRegLayout(Request $request)
    {
        // $data['vendorPackages'] = VendorPackages::where(['status' => 1])->orderBy('packageType', 'ASC')->get();
        $vendorPackage = RegistrationPlans::where(['packageType' => 'vendor'])->first();
        $data['optionLabel'] = '';
	    if(!is_null($vendorPackage)){
            $data['optionLabel'] = "$".$vendorPackage->regular_price." Per Month";
            if($vendorPackage->sale_price > 0 && !empty($vendorPackage->couponId)){
                if($vendorPackage->sale_period > 1){
                    $data['optionLabel'] = "$".number_format($vendorPackage->sale_price,2,'.','')."/month for first ".$vendorPackage->sale_period." months and $".number_format($vendorPackage->regular_price,2,'.','')."/month afterward";
                }else{
                    $data['optionLabel'] = "$".number_format($vendorPackage->sale_price,2,'.','')."/month for first month and $".number_format($vendorPackage->regular_price,2,'.','')."/month afterward";
                }
            }
        }
        $data['vendorPackage'] = $vendorPackage;
        // $data['selectedPackage'] = $request->has('package') ? $request->get('package') : '';
        $data['testimonials'] = Testimonial::all();
        return view('auth.vendor', $data );
    }
    
    public function registerVendor(Request $request)
    {
        return $this->registerUserWithPackage($request);
    }
   
   
    public function registerUserWithPackage($request)
    {
        // dd($request->input());
         Validator::extend('honey_pot', function ($attribute, $value, $parameters) {

        return $value == '';

         });
         
          $rules = array(
        	'first_name' 	=> 'required|string|max:250',
			'last_name' 	=> 'required|string|max:250',
			'email' 		=> 'required|string|email|max:255|unique:users',
			'website'		=>	'nullable|string',
			'password' 		=> 'required|same:cpassword',
			'cpassword' 		=> 'required',
			'city' 			=> 'nullable|string',
			// 'short_description' => 'required|string',
			// 'services' => 'required|string',
			'honey_pot' => 'honey_pot',
			// 'vendor_coverage_units' => 'required|string',
			'company_name' => 'required|string',
			'state' 		=> 'required|string|min:2|max:2',
			'zip' 			=> 'required',
			'phone_no'	=>	'required|alpha_dash',
			// 'firm_name'		=>	'nullable|string',
			// 'select_category' => 'required',
			// 'billing_address_1' => 'required',
			// 'billing_address_2' => 'required',
			// 'agree'	=>	'required',
            'zip.required' => 'Zip field is required',
			'phone_number.required'	=>	'The phone number field is required',
			'company_name.string'	=>	'The company name must be a string'

         );

        $messages = array('honey_pot' => 'Nothing Here');

        $validation = Validator::make(Input::all(), $rules, $messages);
        
        if ($validation->fails()) {
            return redirect('vendor-register')->withErrors($validation)->withInput();
        }else{
            if($request->cpassword ==""){
                return redirect()->back()->with('error','Please Confirm Password.');
            }
            if($request->password ==""){
                return redirect()->back()->with('error','Please Enter Password.');
            }
            if($request->first_name ==""){
                return redirect()->back()->with('error','Please Enter First Name.');
            }
            if($request->last_name ==""){
                return redirect()->back()->with('error','Please Enter Last Name.');
            }
            if($request->email ==""){
                return redirect()->back()->with('error','Please Enter Email Address.');
            }
            if($request->phone_no ==""){
                return redirect()->back()->with('error','Please Enter Phone No.');
            }
            if($request->company_name ==""){
                return redirect()->back()->with('error','Please Enter Company Name.');
            }
            if($request->password != $request->cpassword){
                redirect()->back()->with('error','Enter Confirm Password Same as Password.');
            }else{
                if($request->select_category !=""){
                    $selPackageId = $request->selected_us;
                    if($request->website =="" || $request->website == 'null'){
                        $request->website = 'null';
                    }
                    if($request->short_description =="" || $request->short_description =="null"){
                        $request->short_description = 'null';
                    }
                    if($request->state ==""){
                        return redirect()->back()->with('error','Please Select State.');
                    }
                    $geolocationService = new GeolocationService();
                    $vendorlocation = $geolocationService->cityStateZip($request->city,$request->state,$request->zip);
                    if($request->city === "Select City" || $request->city  == '0' || $request->city === "Other") {
                        $c = $request->anotherCity; 
                    } else {
                        $c= $request->city;  
                    }
                    if(empty($request->billing_address_1)){
                        $request->billing_address_1 = null;
                    }
                    if(empty($request->billing_address_2)){
                        $request->billing_address_2 = null;
                    }
                    $user = User::create([
                        'first_name' 	=> $request->first_name,
                        'last_name' 	=> $request->last_name,
                        'email' 		=>strtolower($request->email),
                        'password' 		=> bcrypt($request->password),
                        'email_token'	=> Uuid::uuid4()->toString(),
                        'verified' 		=> false,
                        'register_ts' 	=> new DateTime(),
                        'user_type'     => UserAccountType::VENDOR,
                        'phone_number'	=> $request->phone_no,
                        'firm_name'		=> $request->company_name,
                        'uid'			=> Uuid::uuid4(),
                        'bio'           => ($request->short_description) ? $request->short_description : null,
                        'contact_term' => $request->agree,
                        'website'  =>$request->website,
                        'city' 			=> $c,
                        'state' 		=> $request->state,
                        'zip' 			=> $request->zip,
                        'latitude'		=> $vendorlocation->lat,
                        'longitude'		=> $vendorlocation->long,
                        'billing_address_1' => ($request->billing_address_1) ? $request->billing_address_1 : null,
                        'billing_address_2'=> ($request->billing_address_2) ? $request->billing_address_2 : null
                    ]);
                    $vendorDetails = new VendorDetails();
                    if($user->user_id !=""){
                    $vendorDetails->user_id = $user->user_id;
                    }
                    if($request->vendor_coverage_units !=""){
                    $vendorDetails->vendor_coverage_area = $request->vendor_coverage_units;
                    }
                    if($request->services !=""){
                        $vendorDetails->vendor_service = $request->services;
                    }
                    $vendorDetails->payment_status = 'Pending';
                    $vendorDetails->save();
                    
                    $VendorMeta = VendorMeta::where(['userId' => $user->user_id])->first();
                    if(is_null($VendorMeta)){
                        $VendorMeta = new VendorMeta();
                        $VendorMeta->userId = $user->user_id;
                    }
                    $VendorMeta->experties = $request->experties;
                    $VendorMeta->special_services = $request->special_services;
                    $VendorMeta->service_precautions = $request->service_precautions;
                    $VendorMeta->connect_realtor = $request->connect_realtor == "yes" ? 1 : 0;
                    $VendorMeta->connect_memebrs = $request->connect_memebrs == "yes" ? 1 : 0;
                    $VendorMeta->save();

                    $user->assign('user');
                    $user->assign($user['user_type']);
                    if(!in_array(env('APP_ENV'),['local','staging'])){
                        $this->emailVerification($user);
                        $this->welcomeEmail($user);
                    }
                    if($request->file_name !=""){
                        $createBanner = new Banner();
                        $createBanner->user_id = $user->user_id;
                        $createBanner->banner_image = $request->file_name;
                        $advBanner = $createBanner->save();
                    }
                    if(count($request->select_category) > 0){
                        $createCategory = new Category();
                        $createCategory->user_id = $user->user_id;
                        $createCategory->category_id  = ",".implode(',',$request->select_category).",";
                        
                        if($request->other_description !=""){
                            $createCategory->other_description = $request->other_description;
                        }
                        $createCategory->save();
                    }
                    // return Redirect::route('loadVendorPackages', array('id' => $user->user_id));
                    return Redirect::route('package-payment', array('id' => $user->user_id));
                }else{
                    return redirect()->back()->with('error','Please Select one of given category.');
                }
            }
        }
     }
     
     public function loadAllVendorPackages($id)
     {
        
        $findVendor = User::where('user_id','=',$id)->where('user_type','=','vendor')->first();
        $testimonials = Testimonial::all();
        if(count($findVendor) == 0){
            return redirect('/vendor-register')->with('error','No vendor found with this details.');
        }
        // $findCategory = Category::where('user_id','=',$id)->get();
        if($findVendor->payment_status == 0){
            $vendorPackages = VendorPackages::where(['status' => 1])->orderBy('packageType', 'ASC')->get();
            return view('auth.vendorPackages', ['id' => $id, 'vendorPackages' => $vendorPackages]);
        }else{
            return redirect('/vendor-register')->with('message','You have already done payment for registeration.');
        }
    }
      
      
       public function loadPlatiniumVendor($id)
     {
         $findVendor = User::where('user_id','=',$id)->where('user_type','=','vendor')->get();
         if(count($findVendor) == 0)
         {
             return redirect('/vendor-register')->with('error','No vendor found with this details.');
         }
          $findCategory = Category::where('user_id','=',$id)->get();
         if(!empty($findVendor) && !empty($findCategory))
         {
             if($findCategory[0]->braintree_id =="")
             {
                 return view('auth.platiniumVendor',['id'=>$id]);
             }else{
                 return redirect('/vendor-register')->with('message','You have already done payment for registeration.');
             }
         }
      }
      
      
    
    public function loadPackagePayment(Request $request)
    {
        // $selectedPackage = $request->has('package') ? $request->get('package') : '';
        $vendorPackage = RegistrationPlans::where(['packageType' => 'vendor'])->first();
        $checkVendor = User::where('user_id','=',$request->id)->where('user_type','=','vendor')->first();
        if(count($checkVendor) == 0){
            return redirect('/vendor-register')->with('error','No vendor found with this details.');
        }

        if($checkVendor->payment_status == 0){
            $userDetails = User::with('userSubscription')->find($request->id);
            if(!is_null($vendorPackage)){
                $optionLabel = "$".$vendorPackage->regular_price." Per Month"; 
                $registrationPrice = $vendorPackage->regular_price;
                if($vendorPackage->sale_price > 0 && !empty($vendorPackage->couponId)){
                    if($vendorPackage->sale_period > 1){
                        $optionLabel = "$".$vendorPackage->sale_price."/month for first ".$vendorPackage->sale_period." months and $".$vendorPackage->regular_price."/month afterward";
                    }else{
                        $optionLabel = "$".$vendorPackage->sale_price."/month for first month and $".$vendorPackage->regular_price."/month afterward";
                    }
                    $registrationPrice = $vendorPackage->sale_price;
                }
            }
            $vendorDetails = VendorDetails::where('user_id','=',$userDetails->user_id)->first();
            return view('auth.packageSelection',['vendorPackage'=>$vendorPackage,'userDetails'=>$userDetails, 'vendorDetails' => $vendorDetails, 'registrationPrice' => $registrationPrice, 'optionLabel' => $optionLabel]);
        }else{
            return redirect('/vendor-register')->with('message','You have already done payment for registeration.');
        }
    }
}


