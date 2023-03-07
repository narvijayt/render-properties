<?php
/**
 * Created by PhpStorm.
 * User: jeremycloutier
 * Date: 9/13/17
 * Time: 3:10 PM
 */

namespace App\Http\Controllers\Pub\Profile;

use App\BraintreePlan;
use App\Enums\MatchPurchaseType;
use App\Events\Subscriptions\CancelledSubscription;
use App\Events\Subscriptions\ChangedSubscription;
use App\Events\Subscriptions\NewSubscription;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Profile\PaymentPurchaseMatchesRequest;
use App\Http\Requests\Pub\Profile\PaymentSubscribeRequest;
use App\MatchPurchase;
use App\User;
use Braintree\Result\Successful;
use Braintree_ClientToken;
use Illuminate\Http\Request;
use App\Subscribe;
use Mail;
use App\Payment;
use Auth;
use App\Mail\VendorSubscriptionUpgrade;
use App\Mail\EmailVerification;
use App\Mail\WelcomeEmail;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use App\PreviousPlan;
use App\VendorDetails;
use App\Category;
class PaymentController extends Controller
{

	/**
	 * Index action
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function index()
	{
	//	$this->authorize('manage-payment', User::class);
		/** @var \App\User $user */
		$user = auth()->user();

		if (!$user->isPayingCustomer()) {
			return redirect()->route('pub.profile.payment.plans');
		}
		$subscription = $user->subscription('main');

		return view('pub.profile.payment.index', compact('user', 'subscription'));
	}

	/**
	 * Get a braintree token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function token()
	{
	//	$this->authorize('manage-payment', User::class);

		return response()->json([
			'data' => [
				'token' => Braintree_ClientToken::generate(),
			],
		]);
	}

	/**
	 * Plans action
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function plans()
	{
	    $id = auth()->user()->braintree_id;
        $plan = BraintreePlan::where('braintree_plan_id', $id)->first();
        if(empty($plan)) { 
            $id = auth()->user()->user_id;
            $subscribe = Subscribe::where('user_id', $id)->first();
        } else {
            $subscribbe = '';
        }
       if(auth()->user()->user_type =='vendor' && $id !=""){
             $userId  = auth()->user()->user_id;
             $subId = auth()->user()->payment_transaction_id;
             if($subId !="cash"){
             $prevSubscription = Payment::where('subscription_id','=',$subId)->where('user_id','=',$userId)->get();
             }else{
                 $prevSubscription = array();
             }
             $vendorDetail = VendorDetails::where('user_id','=',$userId)->get();
             return view('pub.profile.payment.vendor_plan', compact('plan', 'subscribe','prevSubscription','vendorDetail'));
        }else{
            return view('pub.profile.payment.plans', compact('plan', 'subscribe'));
        }
	}

	/**
	 * Show action will display the available plans
	 *
	 * @param BraintreePlan $braintreePlan
	 * @return $this
	 */
	public function show(BraintreePlan $braintreePlan)
	{
	//	$this->authorize('create-subscription', User::class);
		/** @var \App\User $user */
		$user = auth()->user();

		return view('pub.profile.payment.show')->with([
			'plan' => $braintreePlan,
			'user' => $user,
		]);
	}

	/**
	 * Subscribe action
	 *
	 * @param PaymentSubscribeRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function subscribe(PaymentSubscribeRequest $request)
	{
		//$this->authorize('create-subscription', User::class);

		$plan = BraintreePlan::find($request->get('plan'));
		/** @var \App\User $user */
		$user = $request->user();
		try {
			$subscription = $user->newsubscription('main', $plan->braintree_plan)
				->trialDays(30)
				->create($request->nonce, [
					'firstName' => $user->first_name,
					'lastName' => $user->last_name,
					'email' => $user->email,
					'creditCard' => [
						'billingAddress' => [
							'firstName' => $request->billing_first_name,
							'lastName' => $request->billing_last_name,
							'company' => $request->billing_company,
							'streetAddress' => $request->billing_address_1,
							'locality' => $request->billing_locality,
							'region' => $request->billing_region,
							'postalCode' => $request->billing_postal_code
						]
					]
				]
			);

			if($subscription->active()) {
				$user->update($request->only([
					'billing_first_name',
					'billing_last_name',
					'billing_company',
					'billing_address_1',
					'billing_address_2',
					'billing_locality',
					'billing_region',
					'billing_postal_code',
				]));
			}

			flash('Successfully subscribed to '. $plan->name)->success();
			event(new NewSubscription($subscription));
		} catch (\Exception $e) {
			flash($e->getMessage())->error()->important();

			return redirect()->back()->withInput($request->except('nonce'));
		}

		return redirect()->route('pub.profile.payment.index');
	}

	/**
	 * cancelSubscribe action
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function cancelSubscription(Request $request)
	{
		//$this->authorize('cancel-subscription', User::class);

		/** @var \App\User $user */
		$user = $request->user();
		$subscription = $user->subscription('main');
		$subscription->cancel();

		event(new CancelledSubscription($subscription));
		flash('Successfully cancelled subscription plan')->success();

		return redirect()->route('pub.profile.payment.index');
	}

	/**
	 * resumeSubscription action
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function resumeSubscription(Request $request)
	{
	//	$this->authorize('resume-subscription', User::class);

		/** @var User $user */
		$user = $request->user();
		$user->subscription('main')->resume();

		flash('Successfully resumed subscription plan')->success();

		return redirect()->route('pub.profile.payment.index');
	}

	/**
	 * downloadInvoice action
	 *
	 * @param Request $request
	 * @param $invoiceId
	 * @return mixed
	 */
	public function downloadInvoice(Request $request, $invoiceId)
	{
		return $request->user()->downloadInvoice($invoiceId, [
			'vendor' => 'Render',
			'product' => 'Subscription',
		]);
	}

	/**
	 * changeSubscriptionShow action
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function changeSubscriptionShow()
	{
	//	$this->authorize('change-subscription', User::class);

		/** @var User $user */
		$user = auth()->user();
		$subscription = $user->subscription('main');
		$plans = BraintreePlan::where('active', true)->get();

		return view('pub.profile.payment.change-subscription', compact('user', 'subscription', 'plans'));
	}

	/**
	 * changeSubscriptionStore action
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changeSubscriptionStore(Request $request)
	{
	//	$this->authorize('change-subscription', User::class);

		/** @var User $user */
		$user = $request->user();
		$subscription = $user->subscription('main');

		$subscription->swap($request->plan_id);

		flash('Successfully changed subscription plan')->success();
		$plan = BraintreePlan::where('braintree_plan', $request->plan_id)->first();

		event(new ChangedSubscription($subscription, $plan));

		return redirect()->route('pub.profile.payment.index');
	}

	/**
	 * updateCardShow action
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updateCardShow()
	{
		//$this->authorize('manage-payment-methods', User::class);

		$user = auth()->user();

		return view('pub.profile.payment.update-card', compact('user'));
	}

	/**
	 * updateCardStore action
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updateCardStore(Request $request)
	{
	//	$this->authorize('manage-payment-methods', User::class);

		/** @var User $user */
		$user = $request->user();

		try {
			$user->updateCard($request->nonce, [
				'billingAddress' => [
					'firstName' => $request->billing_first_name,
					'lastName' => $request->billing_last_name,
					'company' => $request->billing_company,
					'streetAddress' => $request->billing_address_1,
					'locality' => $request->billing_locality,
					'region' => $request->billing_region,
					'postalCode' => $request->billing_postal_code
				]
			]);
		} catch (\Exception $e) {
			flash()->error($e->getMessage());

			return redirect()->back();
		}

		$user->update($request->only([
			'billing_first_name',
			'billing_last_name',
			'billing_company',
			'billing_address_1',
			'billing_address_2',
			'billing_locality',
			'billing_region',
			'billing_postal_code',
		]));

		flash('Payment method successfully changed')->success();

		return redirect()->route('pub.profile.payment.index');
	}

	public function purchaseMatchesShow(Request $request)
	{
		//$this->authorize('purchase-additional-matches', User::class);
		if($request->has('return_url')) {
			$request->session()->put('return_url', $request->get('return_url'));
		}

		$user = auth()->user();

		return view('pub.profile.payment.purchase-matches', compact('user'));
	}

	public function purchaseMatchesStore(PaymentPurchaseMatchesRequest $request)
	{
		//$this->authorize('purchase-additional-matches', User::class);

		$cost = 59.99;
		$total = $request->quantity * $cost;
		/** @var User $user */
		$user = $request->user();

		/** @var Successful $res */
		$res = $user->invoiceFor($request->quantity.' x Additional Matches @ 59.99', number_format($total, 2));
		if (!$res->success) {
			flash('Unable to process payment at this time.');

			return redirect()->route('pub.profile.matches.index');
		}

		MatchPurchase::create([
			'user_id' => $user->user_id,
			'type' => MatchPurchaseType::PURCHASED,
			'quantity' => $request->quantity,
			'braintree_transaction_id' => $res->transaction->id,
		]);

		flash('You now have '.$request->quantity.' additional new matches!')->success();

		if ($request->session()->has('return_url')) {
			$url = $request->session()->get('return_url');
			$request->session()->remove('return_url');
			return redirect()->to($url);
		}
		return redirect()->route('pub.profile.payment.index');

	}
	
	
		public function loadUpgradePlan($id)
	{
	    $findUser = User::find($id);
	    $userBrainTreeId = $findUser->braintree_id;
	    $subscriptonData  = Subscribe::where('user_id','=',$id)->get();
	    if($userBrainTreeId !="NULL" || $userBrainTreeId !="")
	    {
	        return view('pub.profile.payment.monthlypayment')->with('findUser',$findUser);
	        
	    }else{
	        return redirect()->back()->with('error','Already having plan account');
	    }
	}
	
	public function upgradePlan(Request $request)
	{
	    $userId = $request->user_id;
        $cardNo = $request->card_num;
        $expMonth = $request->exp_month;
        $expYear = $request->exp_year;
        $cvcCode = $request->cvc;
        $findUserData = User::find($userId);
        $firstName = $findUserData->first_name;
        $lastName = $findUserData->last_name;
        $emailAdd = $findUserData->email;
        $phoneNo = $findUserData->phone_number;
        $findPlan = BraintreePlan::find(12);
        $planName = $findPlan->name;
        $planPrice = $findPlan->cost;
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize.login'));
        $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
        $refId = 'ref' . time();
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName($planName);
        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength(30);
        $interval->setUnit("days");
        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new \DateTime(date('Y-m-d')));
        $paymentSchedule->setTotalOccurrences(9999);
        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount($planPrice);
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNo);
        $expiry = $expYear . '-' . $expMonth;
        $creditCard->setExpirationDate($expiry);
        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);
        $subscription->setPayment($payment);
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber(mt_rand(10000, 99999));   
        $order->setDescription("monthly Subscription For 9.00 USD"); 
        $subscription->setOrder($order); 
        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName($findUserData->first_name);
        $billTo->setLastName($findUserData->last_name);
        $billTo->setCompany($findUserData->firm_name);
        $billTo->setAddress('N/A');
        $billTo->setCity($findUserData->city);
        $billTo->setState($findUserData->state);
        $billTo->setZip($findUserData->zip);
        $billTo->setCountry("US");	
        $subscription->setBillTo($billTo);
        $customerData = new AnetAPI\CustomerType();
        $customerData->setType("individual");
        $customerData->setEmail($findUserData->email);
        $subscription->setCustomer($customerData);
        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            $cid = $response->getProfile()->getCustomerProfileId();
            $cpid = $response->getProfile()->getCustomerPaymentProfileId();
                $user = [
                    'billing_first_name' => $findUserData->first_name,
                    'billing_last_name' => $findUserData->last_name,
                    'billing_locality' => $findUserData->city,
                    'billing_region' => $findUserData->state,
                    'braintree_id' => 12,
                    'billing_company' => $findUserData->firm_name,
                    'billing_postal_code' => $findUserData->zip,
                    'payment_transaction_id' => $response->getSubscriptionId(),
                    'customer_profile_id' => $cid,
                    'customer_payment_profile_id' => $cpid,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                User::Where('user_id', $userId)->update($user);
                $subscribeUser = Subscribe::where('user_id', $userId)->first();
                $createPayment = new Payment();
                $createPayment->user_id = $userId;
                $createPayment->subscription_id = $response->getSubscriptionId();
                $createPayment->braintree_id = 12;
                $createPayment->total_amount = $planPrice;
                $createPayment->user_type = $findUserData->user_type;
                $createPayment->payment_mode = 'Credit Card';
                $createPayment->payment_status = 'Completed';
                $createPayment->paid_by_user_id = $userId;
                $createPayment->save();
                if(!empty($subscribeUser)) 
                {
                    $arr = [
                        'braintree_id' => 12,
                        'braintree_plan' => $planName,
                        'updated_at' => \Carbon\Carbon::now()
                    ];
                    Subscribe::Where('user_id', $userId)->update($arr);
                } else {
                    Subscribe::create(['user_id' => $userId,
                        'name' => 'main',
                        'braintree_id' => 12,
                        'braintree_plan' => $planName,
                        'quantity' => 1,
                        'ends_at' => null,
                        'created_at' => \Carbon\Carbon::now()->subDay(1),
                        'updated_at' => \Carbon\Carbon::now()->subDay(1)
                    ]);
                }
            $user= User::find($userId);
            Auth::login($user);
                return redirect('/profile/detail')->with('message', 'Thanks '.ucfirst($findUserData->first_name).'. Your account has been successfully upgraded.');                       
            } else {
           	$errorMessages = $response->getMessages()->getMessage();
           	return redirect()->back()->with('error',$errorMessages[0]->getText());
            }
    }
    
    public function loadCancelUpgrade($id){
        $findUserSubscription = User::find($id);
        $planId = $findUserSubscription->braintree_id;
        $subscriptionId = $findUserSubscription->payment_transaction_id;
        if($subscriptionId!="")
        {
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName(config('services.authorize.login'));
            $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
            // Set the transaction's refId
            $refId = 'ref' . time();
            $request = new AnetAPI\ARBCancelSubscriptionRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscriptionId($subscriptionId);
                $controller = new AnetController\ARBCancelSubscriptionController($request);
                $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
                {
                    $successMessages = $response->getMessages()->getMessage();
                    $findUserSubscription->payment_transaction_id = 'NULL';
                    $findUserSubscription->braintree_id = 'NULL';
                    $findUserSubscription->customer_profile_id = 'NULL';
                    $findUserSubscription->customer_payment_profile_id = 'NULL';
                    $findUserSubscription->update();
                    $subscriptionDet = Subscribe::where('user_id',$id)->get();
                    if(count($subscriptionDet) > 0)
                    {
                        foreach($subscriptionDet as $sub)
                        {
                            $subscription_id = $sub->id;
                            $findSubscription = Subscribe::find($subscription_id);
                            $findSubscription->delete();
                        }
                    }
                    $paymentCheck = Payment::where('user_id','=',$id)->where('subscription_id','=',$subscriptionId)->get();
                    if(count($paymentCheck) > 0)
                    {
                        foreach($paymentCheck as $transaction)
                        {
                            $paymentId = $transaction->id;
                            $findPayment = Payment::find($paymentId);
                            $findPayment->delete();
                        }
                    }
                    return redirect()->back()->with('message','You Plan has been Cancelled.');
                }
                else
                {
                    $errorMessages = $response->getMessages()->getMessage();
                    return redirect()->back()->with('error',$errorMessages[0]->getText());
                }
              
        }else{
            return redirect()->back()->with('error','No subscription available for this user');
        }
    }
    
    public function loadUpgradeVendorPlan()
    {
      $user = auth()->user();
      if(auth()->user()->user_type =='vendor' && auth()->user()->braintree_id !="")
      {
           $id = auth()->user()->braintree_id;
           if($id !=""){
                $plan = BraintreePlan::where('braintree_plan_id', $id)->first();
                $vendorDetails = VendorDetails::where('user_id','=',auth()->user()->user_id)->get();
               if(empty($vendorDetails)){
                   $vendorDetails = array();
               }
            }else{
              $plan ='';
              $vendorDetails = array();
            }
           return view('pub.profile.payment.upgrade-vendor-plan', compact('user','plan','vendorDetails'));  
      }else{
           return redirect()->back()->with('error','You have no access to previous layout.');
      }
    }
    
    public function upgradeVendorPlan(Request $request)
    {
      $vendorDetail = VendorDetails::where('user_id','=',$request->user_id)->get();
        if(!empty($vendorDetail))
        {
           $prevPackageAmount = $vendorDetail[0]->payable_amount; 
           $addState = json_decode($vendorDetail[0]->additional_state, true); 
           $addCity = json_decode($vendorDetail[0]->additional_city, true);
           $previousCity =  $vendorDetail[0]->package_selected_city;
           $previousState = $vendorDetail[0]->package_selected_state;
          
        }else{
           $prevPackageAmount = 0; 
           $addState = "";
           $addCity = "";
           $previousCity = "";
           $previousState = "";
        }
        /******Billing Details***********/
          $firstname = $request->billing_first_name;
          $lastname = $request->billing_last_name;
          $firmName = $request->billing_company;
          $address1 = $request->billing_address_1;
          $emailAdd = $request->email;
          $address2 = $request->billing_address_2;
          $userCity = $request->billing_locality;
          $userState = $request->billing_region;
          $userZip = $request->billing_postal_code;
         /****End Billing Details*********/
        $cityName = $request->city_name;
        $additionalCity = $request->additional_city;
        $prevBraintreeId = $request->previous_braintree_id;
        $previousSubscription = $request->prev_subscription_id;
        $userId = $request->user_id;
        $cardNo = $request->card_num;
        $expMonth = $request->exp_month;
        $expYear = $request->exp_year;
        $cvc = $request->cvc;
        $transactionId = $request->payment_transaction_id;
        $us = $request->selected_us;
        $stateName = $request->state_name;
        $additionalState = $request->additional_state;
        $CurrCity = $request->curr_state;
        $finalamount = array();
        $plan = array();
            if($request->additional_city !="")
            {
                $countPackageAmount = count($request->additional_city);
                $finalamount[] = $countPackageAmount * 79;
                $plan[] = 8;
            }
            if($request->additional_state !="")
            {
                $countStatePackageAmount = count($request->additional_state);
                $finalamount[] = $countStatePackageAmount * 599;
                $plan[] = 10;
            }
            if($request->selected_us == '11')
            {
                $finalamount[] = 8995.00;
                $plan[] = 11;
            }
            if($request->additional_city == "" && $request->city_name!=""){
                $finalamount[] = 99.00;
                $plan[] = 7;
            }
            if($request->additional_state =="" && $request->state_name!=""){
                $finalamount[] = 799.00;
                $plan[] = 9;
            }
            $overallSelPackageAmount = $finalamount[0] + $prevPackageAmount;//detailed package amount
            $planId = $plan[0];
            $findBrainTreePlan = BraintreePlan::find($planId);
            $planName = $findBrainTreePlan->name;
            $amount = $overallSelPackageAmount;
            $credCard = str_replace(" ", '', trim($request->card_num));
            $cvc = $request->cvc;
            $cardHolderName = $request->name;
            $getUserDetails = User::find($userId);
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName(config('services.authorize.login'));
            $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
            $refId = 'ref' . time();
            $subscription = new AnetAPI\ARBSubscriptionType();
            $subscription->setName($planName);
            $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
            $interval->setLength(30);
            $interval->setUnit("days");
            $paymentSchedule = new AnetAPI\PaymentScheduleType();
            $paymentSchedule->setInterval($interval);
            $paymentSchedule->setStartDate(new \DateTime(date('Y-m-d')));
            $paymentSchedule->setTotalOccurrences(9999);
            $subscription->setPaymentSchedule($paymentSchedule);
            $subscription->setAmount($amount);
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($credCard);
            $expiry = $expYear . '-' . $expMonth;
            $creditCard->setExpirationDate($expiry);
            $payment = new AnetAPI\PaymentType();
            $payment->setCreditCard($creditCard);
            $subscription->setPayment($payment);
            $order = new AnetAPI\OrderType();
            $order->setInvoiceNumber(mt_rand(10000, 99999));   
            $order->setDescription($planName); 
            $subscription->setOrder($order); 
            $billTo = new AnetAPI\NameAndAddressType();
            $billTo->setFirstName($firstname);
            $billTo->setLastName($lastname);
            $billTo->setLastName($lastname);
            if($address1 !=""){
                  $billTo->setAddress($address1);
            }else{
                if($address2 !=""){
                 $billTo->setAddress($address2);
                }
            }
          
            $billTo->setCity($userCity);
            $billTo->setState($userState);
            $billTo->setZip($userZip);
            $billTo->setCountry("US");	
            $subscription->setBillTo($billTo);
            $customerData = new AnetAPI\CustomerType();
            $customerData->setType("individual");
            $customerData->setEmail($emailAdd);
            $subscription->setCustomer($customerData);
            $request = new AnetAPI\ARBCreateSubscriptionRequest();
            $request->setmerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscription($subscription);
            $controller = new AnetController\ARBCreateSubscriptionController($request);
            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
            {
             $findPayment = Payment::where('subscription_id','=',$previousSubscription)->get();
             $createPreviousPlan = new PreviousPlan();
             $createPreviousPlan->user_id = $userId;
             $createPreviousPlan->subscription_id = $previousSubscription;
             $createPreviousPlan->braintree_id =  $prevBraintreeId;
             $createPreviousPlan->user_type =  'vendor';
             $createPreviousPlan->total_amount = $findPayment[0]->total_amount;
             $createPreviousPlan->description = $planName;
             if($previousState !="")
             {
               $createPreviousPlan->previous_state = $previousState;   
             }
             if($previousCity !="")
             {
                $createPreviousPlan->previous_city = $previousCity;
             }
             if($addState !="" && $addState!="null")
             {
               $createPreviousPlan->previous_additional_state = json_encode($addState);  
             }
             if($addCity !="" && $addCity!="null")
             {
                $createPreviousPlan->previous_additional_city = json_encode($addCity);
             }
             $createPreviousPlan->save();
             
              $user = [
                    'billing_first_name' => $firstname,
                    'billing_last_name' => $lastname,
                    'billing_address_1' => $address1,
                    'billing_locality'	=> 	$userCity,
                    'billing_region' => $userState,		
                    'billing_postal_code' =>$userZip,
                    'braintree_id' => $planId,
                    'billing_company' => $firmName,
                    'payment_transaction_id' => $response->getSubscriptionId(),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                User::Where('user_id', $userId)->update($user);
                    $subscribeUser = Subscribe::where('user_id', $userId)->first();
                    $createPatment = new  Payment();
                    $createPatment->user_id = $userId;
                    $createPatment->subscription_id = $response->getSubscriptionId();
                    $createPatment->braintree_id = $planId;
                    $createPatment->total_amount = $overallSelPackageAmount;
                    $createPatment->user_type = 'vendor';
                    $createPatment->payment_mode = 'Credit Card';
                    $createPatment->payment_status = 'Completed';
                    $createPatment->paid_by_user_id = $userId;
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
                        if($addCity !=""){
                          $mergeAdditionalCity = array_merge($addCity, $additionalCity);
                          $updateVendorDet->additional_city = json_encode($mergeAdditionalCity);
                        }else{
                        $updateVendorDet->additional_city = json_encode($additionalCity);
                        }
                    }
                   if($stateName !="")
                    {
                        $updateVendorDet->package_selected_state = $stateName;
                    }
                    if(count($additionalState)>0)
                    {
                        if($addState!=""){
                          $mergeAdditionalStates = array_merge($addState, $additionalState);
                          $updateVendorDet->additional_state = json_encode($mergeAdditionalStates);
                         }else{
                            $updateVendorDet->additional_state = json_encode($additionalState);
                        }
                    }
                    $updateVendorDet->payable_amount = $overallSelPackageAmount;
                    $updateVendorDet->payment_status = 'Completed';
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
                 $this->CancelVendorPreviousSubscription($userId, $previousSubscription);
                 return redirect('/profile/detail')->with('message', 'Thanks '.$firstname.'. Your payment has successfully completed.');  
                
            }else{
                $errorMessages = $response->getMessages()->getMessage();
               // \Log::error('Upgrade Vendor Package.',$errorMessages[0]->getText());
                return redirect()->back()->with('error',$errorMessages[0]->getText());
            }
    }
   
   
    public function CancelVendorPreviousSubscription($userId, $previousSubscription){
        $findUserSubscription = User::find($userId);
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName(config('services.authorize.login'));
            $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
            $refId = 'ref' . time();
            $request = new AnetAPI\ARBCancelSubscriptionRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscriptionId($previousSubscription);
                $controller = new AnetController\ARBCancelSubscriptionController($request);
                $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
                {
                      $user = User::where('user_type','=','vendor')->where('user_id','=',$userId)->with('categories')->with('payment_details')->with('vendor_details')->get();
                      if(count($user) >0){
                      $this->sendAdminNotificationUpgrade($user);
                       return;
                      }else{
                           return;
                      }
               
                }else{
                    return;
                }
       }
     
     	public function sendAdminNotificationUpgrade($user)
	{
        try {
            $email = new VendorSubscriptionUpgrade($user);
            Mail::to(config('mail.from.address'))->send($email);
            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }
    
	
}
