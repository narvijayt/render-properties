<?php
namespace App\Http\Controllers\Pub\Users;
use App\Enums\MatchPurchaseType;
use App\Enums\UserAccountType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Users\UserBlockRequest;
use App\Http\Requests\Pub\Users\UsersReportViolationRequest;
use App\Http\Requests\Pub\Users\UserUnblockRequest;
use Illuminate\Support\Facades\Redirect;
use App\MatchPurchase;
use App\PartialRegistration;
use App\Services\Geo\GeolocationService;
use App\UserProfileViolation;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\UserProvider;
use App\Subscribe;
use App\VendorCategories;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Jobs\SendEmailVerification;
use Auth;
use DB;
use Mail;
use App\Mail\EmailVerification;
use App\Mail\NewUserAdminNotification;
use App\Mail\WelcomeEmail;
use App\User;
use App\State;
use Carbon\Carbon;
use App\City;
use App\Banner;
use App\SocialReview;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

use App\Services\MobileVerificationService;
use App\Services\TwilioService;
use App\Match;
use App\Services\Stripe;
use App\UserSubscriptions;
use Response;
use Illuminate\Support\Facades\Log;
use App\Mail\SubscriptionPaymentFailed;
use App\Mail\SubscriptionCancelled;
use App\Mail\PaymentConfirmation;

class UsersController extends Controller
{

    
	/**
	 * Show action
	 *
	 * @param string $username
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function show($user_id) 
    {
        $isGuestViewer = $this->auth->guest();
        $categoryName = array();
        $fetchOverallData = array();
        $findBanner = array();
        if(Auth::user()){
            $createdYear = $this->auth->user()->created_at->year;
            $time = "2020-01-01 00:00:00";
            $date = new Carbon( $time );   
            $currYear = $date->year;
        }
        
        $userSocialReviews = SocialReview::where('userid','=',$user_id)->first();
        if(!empty($userSocialReviews)){
            if(!empty($userSocialReviews->zillow_screenname)){
                $userSocialReviews->socialReviews = $this->getZillowSocialReviews($userSocialReviews->zillow_screenname);
                // echo '<pre>'; print_r($userSocialReviews); die;
            }
        }
        
        if(Auth::user() && $this->auth->user()->user_type == "broker"){
            // if (!$isGuestViewer && $this->auth->user()->cannot('broker-view-profiles', User::class) && $createdYear >= $currYear)
            if($this->auth->user()->payment_status == 0)
            {
              return redirect('partially-registration/'.$this->auth->user()->user_id);
            }
        }
        
        $user = User::where('user_id', $user_id)->firstOrFail();
        if (!$isGuestViewer) 
        {
            $user->add_profile_view($this->auth->user());
        }
        $findUser = User::find($user_id);
        if($findUser->user_type =="vendor"){
            $fetchOverallData = User::where('user_id',$user_id)->with('categories')->with('vendor_details')->get();
            if(($findUser !="") && ($findUser->user_type =="vendor") && (!empty($fetchOverallData) && $fetchOverallData[0]->categories->isNotEmpty()))
            {
                $vendorCategory = $fetchOverallData[0]->categories[0]->category_id;
                $strCat = array_filter(explode(",",$vendorCategory));
                foreach($strCat as $cat)
                {
                $fetchAllCategory = VendorCategories::find($cat);
                if($fetchAllCategory !="")
                $categoryName[] = $fetchAllCategory->name;
                }
                if($findUser->braintree_id !="" && $findUser->billing_first_name !="")
                {
                    $findBanner = Banner::where('user_id',$user->user_id)->get();
                    return view('pub.users.premium', compact('user','findBanner','categoryName','fetchOverallData','userSocialReviews'));
                }else{
                    return view('pub.users.show', compact('user','categoryName','fetchOverallData','userSocialReviews'));
                }
            }
        }

        $match = false;
        if(Auth::user()){
            $authUser = auth()->user();
            if($authUser->isMatchedWith($user)){
                $match = Match::findForUsers($authUser, $user, true);
            }
        }

        /*if(($findUser !="") && ($findUser->user_type =="broker"))
        {
            if($findUser->payment_status == 1)
            {
                return view('pub.users.premium_users', compact('user','findBanner','categoryName','fetchOverallData','userSocialReviews'));
            }
        }*/
        /*if(($findUser !="") && ($findUser->user_type =="realtor"))
        {
            if($findUser->braintree_id !="" && $findUser->billing_first_name !="")
            {
                return view('pub.users.premium_users', compact('user','findBanner','categoryName','fetchOverallData','userSocialReviews'));
            }
        }*/

        //if(env('APP_ENV') == "local"){
            return view('pub.users.user-details', compact('user','categoryName','fetchOverallData','userSocialReviews', 'match'));
        /*
        }
        return view('pub.users.show', compact('user','categoryName','fetchOverallData','userSocialReviews'));
        */
    }
    
    /**
     * get Zillow Reviews using cURL API
     *
     */
    public function getZillowSocialReviews($screenName = '')
    {
        if(empty($screenName))
            return false;
            
        $args = array(
            'zws-id'    =>  'X1-ZWz1imr6ozkdmz_8i7yl',
            // 'screenname'    =>  $screenName,
            'count' =>  10,
            'output'    =>  'json',
            'returnTeamMemberReviews'   =>  true
        );
        
        if(strpos($screenName, "@")){
            $args['email'] = $screenName;
        }else{
            $args['screenname'] = $screenName;
        }
        // echo '<pre>'; print_r($args); die;
        $queryString = http_build_query($args);
        
        $queryString = (!empty($queryString)) ? "?".$queryString : $queryString;
        
        $url = "http://www.zillow.com/webservice/ProReviews.htm".$queryString;
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $headers = array(
           "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
        
        $responseArray = json_decode($resp);
        // echo '<pre>'; print_r($responseArray); die;
        if($responseArray->message->text == "Request successfully processed"){
            return $responseArray->response->results;
        }else{
            return false;
        }
    }

	/**
	 * Report action
	 *
	 * @param UsersReportViolationRequest $request
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function report(UsersReportViolationRequest $request, User $user)
    {
        $this->authorize('create', UserProfileViolation::class);
        $violation = new UserProfileViolation;
            $violation->fill([
                'reported_by_id'	=> $this->auth->user()->user_id,
                'subject_id' 		=> $user->user_id,
                'report'			=> $request->get('report'),
            ]);
        $violation->save();
        flash('Profile violation has been reported. An admin will review it shortly')->success();
        return redirect()->back();
    }

	/**
	 * Block a given user
	 *
	 * @param UserBlockRequest $request
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function block(UserBlockRequest $request, User $user)
    {
        $this->auth->user()->block($user, $request->get('reason'));
        flash($user->first_name.' has been blocked!')->success();
        return redirect()->back();
    }

	/**
	 * Unblock a given user
	 *
	 * @param UserUnblockRequest $request
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function unblock(UserUnblockRequest $request, User $user)
    {
        $this->auth->user()->unblock($user, $request->get('reason'));
        flash($user->first_name.' has been blocked!')->success();
        return redirect()->back();
    }

	/**
	 * Request a match with a user
	 *
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function requestMatch(User $user)
    {
        $this->authorize('requestMatch', $user);
        $authUser = $this->auth->user();
        /** @var \App\Services\Matching\Matching $matchingService */
        $matchingService = app()->make(\App\Services\Matching\Matching::class);
        $match = $matchingService->request($authUser, $user);
        if ($match !== false) {
            flash('Match request sent!')->success();
        } else {
            flash('Unable to send match request')->error();
        }
        return redirect()->back();
    }

    public function confirmMatch(User $user)
    {
        $this->authorize('confirmMatch', $user);
        $authUser = $this->auth->user();
        /** @var \App\Services\Matching\Matching $matchingService */
        $matchingService = app()->make(\App\Services\Matching\Matching::class);
        $match = $matchingService->findForUsers($authUser, $user);
        if ($match === false ) 
        {
            flash('Unable to confirm match')->error();
            return redirect()->back();
        }
        if ($matchingService->accept($match->match_id, $authUser) !== true) 
        {
            flash('Unable to confirm match')->error();
            return redirect()->back();
        }
        flash('You have successfully matched with '.$user->full_name())->success();
        return redirect()->back();
    }
	
	/* 
	** welcome Email 
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
	
	/* 
	** email verification 
	*/
    public function emailVerification(User $user)
    {
    //return;
        try
        {
            $email = new EmailVerification($user);
            Mail::to($user->email)->send($email);
            return back();
        }
        catch(Exception $e)
        {
            echo "catch";
            DB::rollback();
            return back();
        }
    }
    
    /* 
	** Admin notification of new user registration
	*/
    public function newUserAdminNotification(User $user)
    {
    //return;
        try
        {
            $email = new NewUserAdminNotification($user);
            // Mail::to(config('mail.from.address'))->send($email);
            // Mail::to("amit@culture-red.com")->send($email);
            Mail::to("richardtocado@gmail.com")->send($email); 
            return back();
        }
        catch(Exception $e)
        {
            echo "catch";
            DB::rollback();
            return back();
        }
    }

    public function loadLenderBillingDetails($id){
        $userDetails = User::with('userSubscription')->find($id);
        
        if(Auth::user()){
            return redirect()->route("login");
        }else if($userDetails->user_type != "broker"){
            flash('Invalid Request.')->success();
            return redirect()->route("login");
        }
        if($userDetails->payment_status == 1){
            flash('You have already paid for the your subscription.')->success();
            return redirect()->route("login");
        }
        
        return view('auth.partials.loan-office-billing-information', compact('userDetails') );
    }
    
    
    public function storeLenderBillingDetails(Request $request){
            
        /*if($request->input('accept_terms') == false){
            return redirect()->back()->with('error',"Please accpet terms and condition to complete the order.");
        }*/
        $input = $request->all();
        
        $input['number'] = str_replace(" ","",$input['number']);
        
        $input['expiry'] = str_replace(" ","",str_replace("/","-",$input['expiry']));
        list($input['exp_month'],$input['exp_year']) = explode("-",$input['expiry']);
        if($input['amount'] == '29.00') {
            $braintree = '1';
            $braintree_pln = 'launch-monthly';
            $description = "Monthly Lender Membership For 29.00 USD";
        }
        
        if(isset($input['disclaimer_text'])) {
            $disclaimer_text = $input['disclaimer_text'];
        } else {
            $disclaimer_text = 'No comment';
        }
        // dd($input); die;
        
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize.login'));
        $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
        $refId = 'ref' . time();
        
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName($description);
        
        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength(30);
        $interval->setUnit("days");
        
        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new \DateTime(date('Y-m-d')));
        $paymentSchedule->setTotalOccurrences(9999);
        
        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount($input['amount']);
        
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber(trim($input['number']));
        $expiry = $input['exp_year'] . '-' . $input['exp_month'];
        $creditCard->setExpirationDate(trim($expiry));
        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);
        
        $subscription->setPayment($payment);
        
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber(mt_rand(10000, 99999));   
        $order->setDescription($description); 
        $subscription->setOrder($order);
        
        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName($input['first_name']);
        $billTo->setLastName($input['last_name']);
        $billTo->setCompany($input['firm_name']);
        $billTo->setAddress($input['city'].', '.$input['state']);
        $billTo->setCity($input['city']);
        $billTo->setState($input['state']);
        $billTo->setZip($input['zip']);
        $billTo->setCountry("US");	
        $subscription->setBillTo($billTo);
        
        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        
        $controller = new AnetController\ARBCreateSubscriptionController($request);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        // $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
        // dd($response); die;
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") ){
            
            $user = [
                'billing_first_name' => $input['first_name'],
                'billing_last_name' => $input['last_name'],
                'billing_locality' => $input['city'],
                'billing_region' => $input['state'],
                'braintree_id' => $braintree,
                'billing_company' => $input['firm_name'],
                'billing_postal_code' => $input['zip'],
                'payment_transaction_id' => $response->getSubscriptionId(),
                'updated_at' => date('Y-m-d H:i:s'),
                'disclaimer_text' => $disclaimer_text
            ];
            User::Where('user_id', $input['user_id'])->update($user);
            $subscribeUser = Subscribe::where('user_id', $input['user_id'])->first();
            if(!empty($subscribeUser)) {
                $arr = [
                    'braintree_id' => $braintree,
                    'braintree_plan' => $braintree_pln,
                    'updated_at' => \Carbon\Carbon::now()
                ];
            Subscribe::Where('user_id', $input['user_id'])->update($arr);
            } else {
                Subscribe::create(['user_id' => $input['user_id'],
                    'name' => 'main',
                    'braintree_id' => $braintree,
                    'braintree_plan' => $braintree_pln,
                    'quantity' => 1,
                    'ends_at' => null,
                    'created_at' => \Carbon\Carbon::now()->subDay(1),
                    'updated_at' => \Carbon\Carbon::now()->subDay(1)
                ]);
            }
            $realUser= User::find($input['user_id']);
            $this->emailVerification($realUser);
            $this->welcomeEmail($realUser);
            Auth::login($realUser);
            return redirect('/profile/detail')->with('message', 'Thanks '.ucfirst($realUser['first_name']).'. Your payment has successfully completed.');                       
        }else {
            $errorMessages = $response->getMessages()->getMessage();
            \Log::error($description.' failed');
            return redirect('/lender-billing-details/'.$input['user_id'])->with('error', 'Transaction Failed - ' . $errorMessages[0]->getText());
        }
    }


    public function createSubscription(Request $request){

        $user = User::find($request->input('user_id'));
        if($user->stripe_customer_id == ''){
            $customer = (new Stripe())->createCustomer(['name' => $user->first_name.' '.$user->last_name, 'email' => $user->email]);
            if(isset($customer->id)){
                User::Where('user_id', $user->user_id)->update(['stripe_customer_id' => $customer->id]);
                $user = User::find($user->user_id);
            }else{
                return Response::json($customer, 400);
            }
        }

        $subscription = UserSubscriptions::where('user_id', $user->user_id)->first();
        if($subscription->exists == false){
            $subscription = (new Stripe())->createSubscription(['stripe_customer_id' => $user->stripe_customer_id, 'price_id' => env('APP_ENV') == "production" ?  env('STRIPE_LIVE_PRICE_ID') : env('STRIPE_TEST_PRICE_ID')]);
        }

        if(isset($subscription->id)){
            $output = [ 
                'subscriptionId' => $subscription->id, 
                'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret, 
                'customerId' => $user->stripe_customer_id 
            ];          
            return Response::json($output, 200);
        }else{
            return Response::json($customer, 400);
        }
    }

    public function createStripePayment(Request $request){
        $payment_intent = $request->input('payment_intent'); 
        $subscription_id = $request->input('subscription_id');
        $customer_id = $request->input('customer_id');
        $subscr_plan_id = env('APP_ENV') == "production" ?  env('STRIPE_LIVE_PRICE_ID') : env('STRIPE_TEST_PRICE_ID'); 

        $customer = (new Stripe())->getCustomer($customer_id);
        $user = User::with('userSubscription')->find($request->input('user_id'));
        // Check whether the charge was successful 
        if(!empty($payment_intent) && $payment_intent['status'] == 'succeeded'){
            // $updateSubscription = (new Stripe())->updateSubscription($subscription_id, ['default_payment_method' => $payment_intent['payment_method']]);
            $subscription = (new Stripe())->getSubscription($subscription_id);

            $created = date("Y-m-d H:i:s", $payment_intent['created']); 
            $status = $payment_intent['status'];
            $current_period_start = $current_period_end = ''; 
            if(!empty($subscription)){ 
                $created = date("Y-m-d H:i:s", $subscription->created); 
                $current_period_start = date("Y-m-d H:i:s", $subscription->current_period_start); 
                $current_period_end = date("Y-m-d H:i:s", $subscription->current_period_end); 
                $status = $subscription->status;
            }

            if(isset($user->userSubscription) && $user->userSubscription->exists == true){
                $userSubscription = UserSubscriptions::find($user->userSubscription->id);
                $userSubscription->plan_interval_count = $userSubscription->plan_interval_count +1;
            }else{
                $userSubscription = new UserSubscriptions();
                $userSubscription->user_id = $user->user_id;
                $userSubscription->plan_id = env('APP_ENV') == "production" ? env('STRIPE_LIVE_PRICE_ID') : env('STRIPE_TEST_PRICE_ID');
                $userSubscription->payment_method = "Stripe";
                $userSubscription->stripe_subscription_id = $subscription->id;
                $userSubscription->customer_name = $user->first_name.' '.$user->last_name;
                $userSubscription->customer_email = $user->email;
            }
            
            $userSubscription->stripe_payment_intent_id = $payment_intent['id'];
            $userSubscription->paid_amount = ($payment_intent['amount']/100);
            $userSubscription->currency = $payment_intent['currency'];
            $userSubscription->plan_interval = $subscription->plan->interval;
            $userSubscription->plan_period_start = $current_period_start;
            $userSubscription->plan_period_end = $current_period_end;
            $userSubscription->status = $status;

            $userSubscription->save();

            if($userSubscription->status == "active"){
                User::Where('user_id', $user->user_id)->update(['payment_status' => 1]);
            }

            if(isset($user->userSubscription) && $user->userSubscription->exists == true){
                // After Payment and Subscription Created Successfully
                
            }else{
                if($user->verified == false){
                    $this->newUserAdminNotification($user);
                    $this->welcomeEmail($user);
                    $this->emailVerification($user);
                }
            }

            $email = new PaymentConfirmation($user);
            Mail::to($user->email)->send($email);

            return Response::json(['subscription' => $userSubscription], 200);
        }else{
            return Response::json(['status' => $payment_intent['status'], 'payment_intent' => $payment_intent ], 400);
        }
    }

    public function paymentStatus($user_id){
        $user = User::find($user_id);
        $userSubscription = UserSubscriptions::where('user_id', $user_id)->first();
        
        if($userSubscription->count()){
            if($userSubscription->status == "active"){

                Auth::login($user);

                return redirect()->route("pub.profile.subscription.index")->with('message', 'Thank you for the payment. Your Account has been registered successfully.');
            }
        }else{
            flash("Subscription membership is missing.")->error();
            return redirect()->route("lenderBillingDetails", ["id" => $user_id]);
        }
    }

    
    
    public function updateCustomerPaymentMethod(Request $request){
        $user = User::with('userSubscription')->find($request->input('user_id') );
        $customer_id = $user->stripe_customer_id;
        $paymentMethod = $request->input('paymentMethod');
        if(!empty($customer_id)){
            $customerPaymentMethod = (new Stripe())->attachPaymentMethodToCustomer($customer_id, $paymentMethod['id']);
            if($customerPaymentMethod->id){
                $userSubscription = UserSubscriptions::where("user_id",$user->user_id)->first();

                $subscriptionData = (new Stripe())->updateSubscription($userSubscription->stripe_subscription_id, ['default_payment_method' => $paymentMethod['id'], 'billing_cycle_anchor' => 'now']);
                if($subscriptionData->id){
                    UserSubscriptions::Where('user_id', $userSubscription->user_id)->update(['attach_payment_status' => 1]);
                }

                return Response::json(['customerPaymentMethod' => $customerPaymentMethod, 'subscription' => $subscriptionData], 200);
            }

            return Response::json(['customerPaymentMethod' => $customerPaymentMethod], 200);
        }
    }

    public function subscriptionRenewed($user_id = ''){
        if(empty($user_id))
            return redirect()->route('login')->with('error', 'Invalid Request!');

        $user = User::with('userSubscription')->find($user_id);
        
        if($user->userSubscription->exists == true){
            if($user->userSubscription->status == "active"){
                Auth::login($user);
                return redirect()->route("pub.profile.subscription.index")->with('message', 'Thank you for the payment. Your subscription plan has been renewed successfully.');
            }else{
                return view('auth.partials.subscription-information', compact('user') );
            }
        }else{
            flash("Subscription membership is missing.")->error();
            return redirect()->route("lenderBillingDetails", ["id" => $user_id]);
        }

    }

    public function billingInformation(Request $request) 
    {
        Validator::extend('honey_pot', function ($attribute, $value, $parameters) {
            return $value == '';
        });
        
        $rules = array('honey_pot' => 'honey_pot');
        $messages = array('honey_pot' => 'Nothing Here');

        $validation = Validator::make(Input::all(), $rules, $messages);
        
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }else{
         
            $data = $request->all();
            $geolocationService = new GeolocationService();
            $location = $geolocationService->cityStateZip($data['city'],$data['state'],$data['zip']);
            if($data['city'] === "Select City" || $data['city'] == '0' || $data['city'] === "Other")
            {
                $c = $data['anotherCity']; 
            } else {
                $c= $data['city'];  
            }
            
            if(empty($data['units_closed_monthly'])){
                $data['units_closed_monthly'] = null;
            }
            if(empty($data['volume_closed_monthly'])){
                $data['volume_closed_monthly'] = null;
            }
            if(empty( $data['phone_ext'])){
                $data['phone_ext'] = null;
            }
            
            $emailPosted = $data['email'];
        
            $Checkemail = User::where('email','=',$emailPosted)->where('user_type','=','broker')->get();
            if(count($Checkemail) > 0){
                return redirect()->back()->withErrors(['error' => 'Email already exists.']);
            }
            
            if(strpos($data['zip'],",")){
                $data['zip'] = implode(",", array_map('trim', explode(",", $data['zip'])) );
            }

            $data['postal_code_service'] = (isset($data['postal_code_service'])) ? $data['postal_code_service'] : $data['zip'];
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
                'register_ts' 	=> new \DateTime(),
                'verify_ts' 	=> null,
                'years_of_exp'	=> null,
                'specialties' => $data['specialties'],
                'latitude'		=> $location->lat,
                'longitude'		=> $location->long,
                'phone_number'	=> $data['phone_number'],
                'phone_ext'		=> $data['phone_ext'],
                'website'		=> $data['website'],
                'firm_name'		=> $data['firm_name'],
                'units_closed_monthly' =>  $data['units_closed_monthly'],
                'volume_closed_monthly' =>  $data['volume_closed_monthly'],
                'license' =>  $data['license'],
                /****Free User*************/
                'billing_first_name' => $data['first_name'],
                'billing_last_name' => $data['last_name'],
                'billing_locality' => $data['city'],
                'billing_region' => $data['state'],
                'billing_company' => $data['firm_name'],
                'billing_postal_code' => $data['zip'],
                'payment_transaction_id' => null,
                'contact_term' => (isset($request->agree)) ? $request->agree : '',
                /*****End Free Users******/
                'braintree_id' => 1,
                'payment_status'    =>  0
            ]);
            
            $user->assign('user');
            $user->assign($user['user_type']);
            if(!isset($user['receive_email'])){
                $settings = $user->settings;
                $settings->email_receive_match_suggestions = false;
                $settings->save();
            }
            if (isset($data['provider']) && $data['provider'] !== null && isset($data['provider_id']) && $data['provider_id'] !== null){
                $this->createUserProvider($data, $user);
            }
            
            /*$realUser= User::find($user->user_id);
            $this->newUserAdminNotification($realUser);
            $this->emailVerification($realUser);
            $this->welcomeEmail($realUser);

            flash('Account has been registered successfully.')->success();
            
            if(isset($user->phone_number) && !empty($user->phone_number) ){
                $response = (new MobileVerificationService())->generateOtp($user->user_id);
                // echo '<pre>'; print_r($response); die;
                (new TwilioService())->sendOTPVerificationSMS($user, $response->otp);
    
                return redirect()->route('verify.phone', ['id' => $user->user_id])->with('message', 'An OTP has been sent on your registered phone number. Please confirm your contact details.');
            }
            // return redirect()->route('register.thankyou', ['id' => $user->user_id]);
            */
            
            return redirect('/lender-billing-details/'.$user->user_id);
        }
    }
    
    public function testEmailSample($user_id){
        $realUser= User::find($user_id);
        $this->newUserAdminNotification($realUser);
    }
    
    public function registerThankyou($id){
        $userDetails = User::find($id);
        return view('auth.partials.registration-thankyou', compact('userDetails'));
    }
    
    public function accountStatus($id){
        $userDetails = User::find($id);
        return view('auth.partials.account-information', compact('userDetails'));
    }

   /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
 /* public function createUser() {
         $your_pdt_identity_token = "6wxmb7Rk4Gauw5c4ZHnDJxl5uCmiYjghgaan653NGIOqpWXXTqvvxbmNT2G";
        $request = curl_init();
        curl_setopt_array($request, array
        (
            CURLOPT_URL => 'https://www.paypal.com/cgi-bin/webscr',
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => http_build_query(array
            (
                'cmd' => '_notify-synch',
                'tx' => $_GET['tx'],
                'at' => $your_pdt_identity_token,
            )),
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => FALSE,
        ));
        $response = curl_exec($request);
        $status = curl_getinfo($request, CURLINFO_HTTP_CODE);
        curl_close($request);
        if ($status == 200 AND strpos($response, 'SUCCESS') === 0) {
            $response = $this->cleanArray($response);
           if($response['payment_gross'] == '59.00') {
                $braintree = '1';
                $braintree_pln = 'launch-monthly';
            } else {
                $braintree = '3';
                $braintree_pln = 'launch-yearly';
            }
            $user = [
                'billing_first_name' => $response['first_name'],
                'billing_last_name' => $response['last_name'],
                'billing_address_1' => $response['address_street'].','.$response['address_city'].','.$response['address_country'],
                'billing_locality' => $response['address_city'],
                'billing_region' => $response['address_state'],
                'braintree_id' => $braintree,
                'billing_company' => $response['custom'],
                'billing_postal_code' => $response['address_zip'],
                'payment_transaction_id' => $response['txn_id'],
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            User::Where('user_id', $response['item_number'])->update($user);
            
            Subscribe::create(['user_id' => $response['item_number'],
                                'name' => 'main',
                                'braintree_id' => $braintree,
                                'braintree_plan' => $braintree_pln,
                                'quantity' => 1,
                                'ends_at' => null,
                                'created_at' => \Carbon\Carbon::now()->subDay(1),
                                'updated_at' => \Carbon\Carbon::now()->subDay(1)
                            ]);
                            
            $realUser= User::find($response['item_number']);
            Auth::login($realUser);
            return redirect('/profile/detail')->with('message', 'Thanks '.ucfirst($realUser['first_name']).'. Your payment has successfully completed.');
        } else {
            return redirect('/login')->with('message', 'Something went wrong. Please try again.');

        }

    } */
    
  /*  public function createUser(Request $request) {
		$input = $request->all();
		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize.login'));
        $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
        $refId = 'ref'.time();
		
		// Create the payment data for a credit card
		$creditCard = new AnetAPI\CreditCardType();
		$creditCard->setCardNumber($input['card_num']);
		$expiry = $input['exp_year'] . '-' . $input['exp_month'];
		$creditCard->setExpirationDate($expiry);
		$paymentOne = new AnetAPI\PaymentType();
		$paymentOne->setCreditCard($creditCard);
		/* customer detail 
		$customerAddress = new AnetAPI\CustomerAddressType();
		$customerAddress->setFirstName($input['first_name']);
		$customerAddress->setLastName($input['last_name']);
		$customerAddress->setCompany($input['custom']);
		$customerAddress->setAddress($input['address']);
		$customerAddress->setCity($input['city']);
		$customerAddress->setState($input['state']);
		$customerAddress->setZip($input['zip']);
		$customerAddress->setCountry("CANADA");		
		
		// Create a transaction
		$transactionRequestType = new AnetAPI\TransactionRequestType();
		$transactionRequestType->setTransactionType("authCaptureTransaction");
		$transactionRequestType->setAmount($input['amount']);
		$transactionRequestType->setPayment($paymentOne);
		$transactionRequestType->setBillTo($customerAddress);
		$request = new AnetAPI\CreateTransactionRequest();
		$request->setMerchantAuthentication($merchantAuthentication);
		$request->setRefId( $refId);
		$request->setTransactionRequest($transactionRequestType);
		$controller = new AnetController\CreateTransactionController($request);
		$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
		if ($response != null)
		{
			$tresponse = $response->getTransactionResponse();
			if (($tresponse != null) && ($tresponse->getResponseCode()=="1"))
			{
			
				if($input['amount'] == '59.00') {
					$braintree = '1';
					$braintree_pln = 'launch-monthly';
				} else {
					$braintree = '3';
					$braintree_pln = 'launch-yearly';
				}
				
				$user = [
					'billing_first_name' => $input['first_name'],
					'billing_last_name' => $input['last_name'],
					'billing_address_1' => $input['address'],
					'billing_locality' => $input['city'],
					'billing_region' => $input['state'],
					'braintree_id' => $braintree,
					'billing_company' => $input['custom'],
					'billing_postal_code' => $input['zip'],
					'payment_transaction_id' => $tresponse->getTransId(),
					'updated_at' => date('Y-m-d H:i:s'),
				];
				
				User::Where('user_id', $input['user_id'])->update($user);
				
				Subscribe::create(['user_id' => $input['user_id'],
									'name' => 'main',
									'braintree_id' => $braintree,
									'braintree_plan' => $braintree_pln,
									'quantity' => 1,
									'ends_at' => null,
									'created_at' => \Carbon\Carbon::now()->subDay(1),
									'updated_at' => \Carbon\Carbon::now()->subDay(1)
								]);
								
				$realUser= User::find($input['user_id']);
				Auth::login($realUser);
				
				return redirect('/profile/detail')->with('message', 'Thanks '.ucfirst($realUser['first_name']).'. Your payment has successfully completed.');                       	
				
			} else  {
				return redirect('/login')->with('message', 'Charge Credit Card ERROR :  Invalid response');
			}
		} else {
			return redirect('/login')->with('message', 'Charge Credit Card Null response returned');
		}
			
    }
*/

    public function createUser(Request $request)
    {
        $input = $request->all();
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize.login'));
        $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
        $refId = 'ref' . time();
            if($input['amount'] == '99.00') {
                $braintree = '1';
                $braintree_pln = 'launch-monthly';
            } elseif($input['amount'] == '995.00') {
                $braintree = '3';
                $braintree_pln = 'launch-yearly';
            }
            if(isset($input['disclaimer_text'])) {
                $disclaimer_text = $input['disclaimer_text'];
            } else {
                $disclaimer_text = 'No comment';
            }
            if($input['amount'] == '99.00') 
            {
                $subscription = new AnetAPI\ARBSubscriptionType();
                $subscription->setName("Lender Monthly Subscription For 99.99 USD");
                $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
                $interval->setLength(30);
                $interval->setUnit("days");
                $paymentSchedule = new AnetAPI\PaymentScheduleType();
                $paymentSchedule->setInterval($interval);
                $paymentSchedule->setStartDate(new \DateTime(date('Y-m-d')));
                $paymentSchedule->setTotalOccurrences(9999);
                $subscription->setPaymentSchedule($paymentSchedule);
                $subscription->setAmount($input['amount']);
                //$subscription->setAmount(1);
                $creditCard = new AnetAPI\CreditCardType();
                $creditCard->setCardNumber($input['card_num']);
                $expiry = $input['exp_year'] . '-' . $input['exp_month'];
                $creditCard->setExpirationDate($expiry);
                $payment = new AnetAPI\PaymentType();
                $payment->setCreditCard($creditCard);
                $subscription->setPayment($payment);
                $order = new AnetAPI\OrderType();
                $order->setInvoiceNumber(mt_rand(10000, 99999));   
                $order->setDescription("Monthly Subscription For 99.99 USD"); 
                $subscription->setOrder($order); 
                $billTo = new AnetAPI\NameAndAddressType();
                $billTo->setFirstName($input['first_name']);
                $billTo->setLastName($input['last_name']);
                $billTo->setCompany($input['custom']);
                $billTo->setAddress($input['address']);
                $billTo->setCity($input['city']);
                $billTo->setState($input['state']);
                $billTo->setZip($input['zip']);
                $billTo->setCountry("US");	
                $subscription->setBillTo($billTo);
                $request = new AnetAPI\ARBCreateSubscriptionRequest();
                $request->setmerchantAuthentication($merchantAuthentication);
                $request->setRefId($refId);
                $request->setSubscription($subscription);
                $controller = new AnetController\ARBCreateSubscriptionController($request);
                $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
                {
                    $user = [
                        'billing_first_name' => $input['first_name'],
                        'billing_last_name' => $input['last_name'],
                        'billing_address_1' => $input['address'],
                        'billing_locality' => $input['city'],
                        'billing_region' => $input['state'],
                        'braintree_id' => $braintree,
                        'billing_company' => $input['custom'],
                        'billing_postal_code' => $input['zip'],
                        'payment_transaction_id' => $response->getSubscriptionId(),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'disclaimer_text' => $disclaimer_text
                        
                    ];
                    User::Where('user_id', $input['user_id'])->update($user);
                    $subscribeUser = Subscribe::where('user_id', $input['user_id'])->first();
                        if(!empty($subscribeUser)) {
                            $arr = [
                                'braintree_id' => $braintree,
                                'braintree_plan' => $braintree_pln,
                                'updated_at' => \Carbon\Carbon::now()
                            ];
                        Subscribe::Where('user_id', $input['user_id'])->update($arr);
                        } else {
                            Subscribe::create(['user_id' => $input['user_id'],
                                'name' => 'main',
                                'braintree_id' => $braintree,
                                'braintree_plan' => $braintree_pln,
                                'quantity' => 1,
                                'ends_at' => null,
                                'created_at' => \Carbon\Carbon::now()->subDay(1),
                                'updated_at' => \Carbon\Carbon::now()->subDay(1)
                            ]);
                        }
                        $realUser= User::find($input['user_id']);
                        $this->emailVerification($realUser);
                        $this->welcomeEmail($realUser);
                        Auth::login($realUser);
                        return redirect('/profile/detail')->with('message', 'Thanks '.ucfirst($realUser['first_name']).'. Your payment has successfully completed.');                       
                    } else {
                        $errorMessages = $response->getMessages()->getMessage();
                        \Log::error('Lender membership on monthly basis for 99.00 failed');
                        return redirect('/partially-registration/'.$input['user_id'])->with('message', 'Transaction Failed.  Error Code  -  ' . $errorMessages[0]->getCode() .' Error Message - ' . $errorMessages[0]->getText());
                    }
            } 
            if($input['amount'] == '995.00') 
            {
                $subscription = new AnetAPI\ARBSubscriptionType();
                $subscription->setName("Lender Yearly Subscription For 995.00 USD");
                $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
                $interval->setLength(365);
                $interval->setUnit("days");
                $paymentSchedule = new AnetAPI\PaymentScheduleType();
                $paymentSchedule->setInterval($interval);
                $paymentSchedule->setStartDate(new \DateTime(date('Y-m-d')));
                $paymentSchedule->setTotalOccurrences(9999);
                $subscription->setPaymentSchedule($paymentSchedule);
                $subscription->setAmount($input['amount']);
                //$subscription->setAmount(1);
                $creditCard = new AnetAPI\CreditCardType();
                $creditCard->setCardNumber($input['card_num']);
                $expiry = $input['exp_year'] . '-' . $input['exp_month'];
                $creditCard->setExpirationDate($expiry);
                $payment = new AnetAPI\PaymentType();
                $payment->setCreditCard($creditCard);
                $subscription->setPayment($payment);
                $order = new AnetAPI\OrderType();
                $order->setInvoiceNumber(mt_rand(10000, 99999));   
                $order->setDescription("Yearly Subscription For 995.00 USD"); 
                $subscription->setOrder($order); 
                $billTo = new AnetAPI\NameAndAddressType();
                $billTo->setFirstName($input['first_name']);
                $billTo->setLastName($input['last_name']);
                $billTo->setCompany($input['custom']);
                $billTo->setAddress($input['address']);
                $billTo->setCity($input['city']);
                $billTo->setState($input['state']);
                $billTo->setZip($input['zip']);
                $billTo->setCountry("US");	
                $subscription->setBillTo($billTo);
                $customerData = new AnetAPI\CustomerType();
                $customerData->setType("individual");
                $customerData->setEmail($input['email']);
                $subscription->setCustomer($customerData);
                $request = new AnetAPI\ARBCreateSubscriptionRequest();
                $request->setmerchantAuthentication($merchantAuthentication);
                $request->setRefId($refId);
                $request->setSubscription($subscription);
                $controller = new AnetController\ARBCreateSubscriptionController($request);
                $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
                {
                    $user = [
                        'billing_first_name' => $input['first_name'],
                        'billing_last_name' => $input['last_name'],
                        'billing_address_1' => $input['address'],
                        'billing_locality' => $input['city'],
                        'billing_region' => $input['state'],
                        'braintree_id' => $braintree,
                        'billing_company' => $input['custom'],
                        'billing_postal_code' => $input['zip'],
                        'payment_transaction_id' => $response->getSubscriptionId(),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'disclaimer_text' => $disclaimer_text
                    ];
                    User::Where('user_id', $input['user_id'])->update($user);
                    $subscribeUser = Subscribe::where('user_id', $input['user_id'])->first();
                    if(!empty($subscribeUser)) {
                        $arr = [
                        'braintree_id' => $braintree,
                        'braintree_plan' => $braintree_pln,
                        'updated_at' => \Carbon\Carbon::now()
                        ];
                    Subscribe::Where('user_id', $input['user_id'])->update($arr);
                    } else {
                        Subscribe::create(['user_id' => $input['user_id'],
                            'name' => 'main',
                            'braintree_id' => $braintree,
                            'braintree_plan' => $braintree_pln,
                            'quantity' => 1,
                            'ends_at' => null,
                            'created_at' => \Carbon\Carbon::now()->subDay(1),
                            'updated_at' => \Carbon\Carbon::now()->subDay(1)
                        ]);
                    }
                    $user= User::find($input['user_id']);
                    $this->emailVerification($user);
                    $this->welcomeEmail($user);
                    Auth::login($user);
                    return redirect('/profile/detail')->with('message', 'Thanks '.ucfirst($user['first_name']).'. Your payment has successfully completed.');                       
                } else {
                    $errorMessages = $response->getMessages()->getMessage();
                    \Log::error('Lender membership on monthly basis for 995.00 failed.');
                    return redirect('/partially-registration/'.$input['user_id'])->with('message', 'Transaction Failed.  Error Code  -  ' . $errorMessages[0]->getCode() .' Error Message - ' . $errorMessages[0]->getText());
                }
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

    public function deletePartialRegistrations($user, $userprovider)
    {
        $previous = PartialRegistration::where(['email' => $user->email, 'provider' => $userprovider->provider])->first();
        if ($previous !== null) 
        {
            $previous->delete();
        }
    }

    /* create consumer */
    public function createConsumer(Request $request)
    {
        $data = $request->all();
        $geolocationService = new GeolocationService();
        $location = $geolocationService->cityStateZip($data['city'],$data['state'],$data['zip']);
            $user = User::create([
                //   'username' 		=> $data['username'],
                'first_name' 	=> $data['first_name'],
                'last_name' 	=> $data['last_name'],
                'email' 		=> strtolower($data['email']),
                'password' 		=> bcrypt($data['password']),
                'email_token'	=> Uuid::uuid4()->toString(),
                'verified' 		=> false,
                'user_type' 	=> $data['user_type'],
                'city' 			=> $data['city'],
                'state' 		=> $data['state'],
                'zip' 			=> $data['zip'],
                'register_ts' 	=> new \DateTime(),
                'verify_ts' 	=> null,
                'latitude'		=> $location->lat,
                'longitude'		=> $location->long,
                'phone_number'	=> $data['phone_number'],
                'phone_ext'		=> $data['phone_ext'],
                'uid' => Uuid::uuid4(),
                'contact_term' => $data['agree']
                //'anonymous ' => $an
            ]);
        $findUser = User::find($user->user_id);
        $findUser->contact_term = $data['agree'];
        $findUser->update();
        //$user->assign('user');
        // $user->assign($user['user_type']);
        $this->emailVerification($user);
        $realUser= User::find($user->user_id);
        if(Auth::login($realUser, true)) {
            return redirect('/profile');
        } else {
            return redirect('/login');
        }
    }
   /**
     * @param $email
     */
    public function partiallyRegistration($id)
    {
        $data = User::find($id);
        return view('auth.register.billing-information', $data);
    }
    
    public function platiniuMemberUpgrade($id)
    {
        $data = User::find($id);
        return view('auth.register.patinium-membership-upgrade', $data);
    }
    
    
     /**
     * @param $response
     * @return array|bool|false|string
     */
    public function cleanArray($response) 
    {
        if (strpos($response, "SUCCESS")) 
        {
            $response = substr($response, 7);
        }
        $response = urldecode($response);
        // Turn into associative array
        preg_match_all('/^([^=\s]++)=(.*+)/m', $response, $m, PREG_PATTERN_ORDER);
        $response = array_combine($m[1], $m[2]);
        return $response;
    }
    
    function getCity(Request $request)
    {
        $input = $request->get('state');
        $state = State::where('state_code', $input)->first();
            if(is_null($state)){
                return;
            }else{
                $id = $state->id;
                $cities = City::where('state_id', $id)->get();
                echo '<option value="">Select City</option>';
                    if(isset($cities) && !empty($cities) && count($cities) > 0) 
                    {
                        foreach($cities as $city) 
                        {
                            echo '<option value="'.$city['name'].'">'.$city['name'].'</option>';
                        }
                        echo '<option value="Other">Other</option>';
                    } else {
                        echo '<option value="Other">Other<option>';
                    }
            }
    }
	
    function getPreviousCity(Request $request)
    {
        $input = $request->get('state');
        $state = State::where('state_code', $input)->first();
        if(is_null($state)){
            return;
        }else{
            $id = $state->id;
            $cities = City::where('state_id', $id)->get();
            echo '<option value="">Select City</option>';
            if(isset($cities) && !empty($cities) && count($cities) > 0)
            {
                foreach($cities as $city) 
                {
                    echo '<option value="'.$city['name'].'">'.$city['name'].'</option>';
                }
                echo '<option value="Other">Other</option>';
            } else {
                echo '<option value="Other">Other<option>';
            }
        }
    }
	
}