<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Category;
use App\VendorCategories;
use App\Package;
use Auth;
use Mail;
use App\BraintreePlan;
use App\Subscribe;
use DB;
use App\Jobs\SendEmailVerification;
use App\Mail\EmailVerification;
use App\Mail\WelcomeEmail;
use File;
use App\User;
use App\VendorDetails;
use App\Payment;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

use App\VendorPackages;
use App\Services\Stripe;
use App\UserSubscriptions;
use App\Mail\PaymentConfirmation;
use Response;
use Illuminate\Support\Facades\Log;
use App\Mail\NewUserAdminNotification;

class Vendor extends Controller
{
	
	public function emailVerification(User $user)
	{
	   // return;
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
	
	
		public function welcomeEmail(User $user)
	{
	   // return;
        try {
            $email = new WelcomeEmail($user);
		    Mail::to($user->email)->send($email);
            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }


    public function packagePayment(Request $request){
       
        if($request->input('accept_terms') == false){
            return redirect()->back()->with('error',"Please accpet terms and condition to complete the order.");
        }
        
        $userId = $request->id;
        /************City Details******/
        $package_name = $request->package;
        $cityName = $request->city_name;
        $additionalCity = $request->additional_city;
        $cityTotalAmount = $request->curr_city;
        /*************End City**********/
        /*************Card Details************/
        $cardNo = $request->number;
        $expiryDate = str_replace(" ", "", $request->expiry);
        $expiryDate = explode('/',$expiryDate);
        $expiryDate = array_values(array_filter($expiryDate));
        $year = 2000;
        if (($key = array_search('/', $expiryDate)) !== false) {
            unset($expiryDate[$key]);
            $expiryDate = array_values($expiryDate);
        }
        if(strlen($expiryDate[1]) == '4'){
            $expiryYear = $expiryDate[1];
        }else{
            $expiryYear = $year + $expiryDate[1];
        }
        $expiryMonth = $expiryDate[0];
        $expiry = "$expiryYear-$expiryMonth";
        $cvcno = $request->cvc;
        $cardName = $request->name;
        /*************End Card Details**********/
        /**************State Details***********/
        $stateName = $request->state_name;
        $additionalStates = $request->additional_state;
        $stateTotalAmount = $request->curr_state;
        $packageUs = $request->selected_us;
        /************End State DEtails********/
        /****Billing Details****/
        $firstname = $request->first_name;
        $lastname = $request->last_name;
        $emailAdd = $request->email;
        $firmName = $request->firm_name;
        $address = $request->address;
        $address2 = $request->address2;
        $userCity = $request->city;
        $userState = $request->state;
        $userZip = $request->zip;
        /************End Billing Details****/
        
        $finalamount = array();
        $plan = array();
        if($request->additional_city !="")
        {
            $countPackageAmount = count($request->additional_city);
            $finalamount[] = $countPackageAmount * 79 + 99;
            $plan[] = 8;
        }
        if($request->additional_state !="")
        {
            $countStatePackageAmount = count($request->additional_state);
            $finalamount[] = $countStatePackageAmount * 599 + 799;
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
            $finalamount[] =  799.00;
            $plan[] = 9;
        }
        //detailed package amount
        
        
        /*****Paid Vendor**********/
        $overallSelPackageAmount = $finalamount[0];
        $planId = $plan[0];
        $findBrainTreePlan = BraintreePlan::find($planId);
        $planName = $findBrainTreePlan->name;
        $amount = $overallSelPackageAmount;
        /**********End Paid Vendor*******/
        
        
        /***********Paid Vendor**************/
        //$amount = 1;
        $credCard = str_replace(" ", '', trim($request->number));
        $expiryDate = $request->expiry;
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
        if($address !=""){
        $billTo->setAddress($address);
        }else{
            if($address2!=""){
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
        // $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
        {
            
                $user = [
                'billing_first_name' => $firstname,
                'billing_last_name' => $lastname,
                'billing_address_1' => $address,
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
            if(count($findvendorDetails) > 0){
                foreach($findvendorDetails as $vendor){
                    $updateVendorDet = VendorDetails::find($vendor->id);
                    if($cityName !=""){
                        $updateVendorDet->package_selected_city = $cityName;
                    }
                    if(count($additionalCity)>0){
                        $updateVendorDet->additional_city = json_encode($additionalCity);
                    }
                    if($stateName !=""){
                        $updateVendorDet->package_selected_state = $stateName;
                    }
                    if(count($additionalStates)>0){
                        $updateVendorDet->additional_state = json_encode($additionalStates);
                    }
                    $updateVendorDet->payable_amount = $overallSelPackageAmount;
                    $updateVendorDet->payment_status = 'Completed';
                    $updateVendorDet->update();
                }
            }else{
                $createVendorDetails = new VendorDetails();
                $createVendorDetails->user_id = $userId;
                $createVendorDetails->vendor_coverage_area = null;
                if($cityName !=""){
                    $createVendorDetails->package_selected_city = $cityName;
                }
                if(count($additionalCity)>0){
                    $createVendorDetails->additional_city = json_encode($additionalCity);
                }
                if($stateName !=""){
                    $createVendorDetails->package_selected_state = $stateName;
                }
                if(count($additionalStates)>0){
                    $createVendorDetails->additional_state = json_encode($additionalStates);
                }
                $createVendorDetails->vendor_service = null;
                $createVendorDetails->payable_amount = $overallSelPackageAmount;
                $createVendorDetails->payment_status = 'Completed';
                $createVendorDetails->save();
            }
            $checkCategoryExists = Category::where('user_id','=',$userId)->get();
            if(count($checkCategoryExists) > 0){
                $updateCat = Category::find($checkCategoryExists[0]->id);
                $updateCat->braintree_id = $planId;
                $updateCat->update();
            }else{
                $createCategory = new Category();
                $createCategory->user_id = $userId;
                $createCategory->category_id = 0;
                $createCategory->braintree_id = $planId;
                $createCategory->save();
            }
            $user= User::find($userId);
            $this->emailVerification($user);
            $this->welcomeEmail($user);
            Auth::login($user);
            return redirect('/profile/detail')->with('message', 'Thanks '.$firstname.'. Your payment has successfully completed.');                       
        }else{
            $errorMessages = $response->getMessages()->getMessage();
            \Log::error('vendor registeration failed');
            return redirect()->back()->with('error',$errorMessages[0]->getText());
        }
        /****************End Paid Vendor*************/
    }

    
    public function createCustomerSubscription(Request $request){
        parse_str($request->input('formData'), $formdata);
        
        $user = User::with('userSubscription')->find($request->input('user_id'));
        $paymentMethod = $request->input('paymentMethod');
        if($user->stripe_customer_id == ''){
            $customer = (new Stripe())->createCustomer(
                [
                    'name' => $user->first_name.' '.$user->last_name, 
                    'email' => $user->email,
                    'payment_method' => $paymentMethod['id'],
                    'invoice_settings'  =>  [
                        'default_payment_method'    =>  $paymentMethod['id']
                    ]
                ]
            );
            if(isset($customer->id)){
                User::Where('user_id', $user->user_id)->update(['stripe_customer_id' => $customer->id]);
                $user = User::with('userSubscription')->find($user->user_id);
            }else{
                return Response::json($customer, 400);
            }
        }
        
        $customerPaymentMethod = (new Stripe())->attachPaymentMethodToCustomer($user->stripe_customer_id, $paymentMethod['id']);
        
        $vendorPackage = VendorPackages::find($formdata['packageId']);
        // echo '<pre>'; print_r($vendorPackage); echo '</pre>';
        if($user->userSubscription->exists == false){
            $subscriptionArray = [
                'customer' => $user->stripe_customer_id,
                "default_payment_method" => $paymentMethod['id'],
            ];
            if($vendorPackage->packageType == "usa"){
                $subscriptionArray["items"] = [
                    [ "price" => $vendorPackage->priceId ]
                ];
            }else{
                $quantity = 1;
                if($vendorPackage->packageType == "city"){
                    $quantity += count($formdata['additional_'.$vendorPackage->packageType]);
                }else if($vendorPackage->packageType == "state"){
                    $quantity += count($formdata['additional_'.$vendorPackage->packageType]);
                }
                $subscriptionArray["items"] = [
                    [ 
                        "quantity" => $quantity,
                        "price" => $vendorPackage->priceId
                    ]
                ];
            }

            // dd($subscriptionArray);
            $subscription = (new Stripe())->createSubscription($subscriptionArray);
            /*if($subscription->id){
                $updateSubscription = (new Stripe())->updateSubscription($subscription->id, ['default_payment_method' => $paymentMethod['id']]);
            }*/
        }else{
            $subscription = (new Stripe())->updateSubscription($user->userSubscription->stripe_subscription_id, ['default_payment_method' => $paymentMethod['id'], 'billing_cycle_anchor' => 'now']);
        }

        if(isset($subscription->id)){

            $created = date("Y-m-d H:i:s", $subscription->created); 
            $current_period_start = date("Y-m-d H:i:s", $subscription->current_period_start); 
            $current_period_end = date("Y-m-d H:i:s", $subscription->current_period_end); 
            $status = $subscription->status;        

            if(isset($user->userSubscription) && $user->userSubscription->exists == true){
                $userSubscription = UserSubscriptions::find($user->userSubscription->id);
                $userSubscription->plan_interval_count = $userSubscription->plan_interval_count +1;
            }else{
                $userSubscription = new UserSubscriptions();
                $userSubscription->user_id = $user->user_id;
                $userSubscription->plan_id = $vendorPackage->priceId;
                $userSubscription->payment_method = "Stripe";
                $userSubscription->stripe_subscription_id = $subscription->id;
                $userSubscription->customer_name = $user->first_name.' '.$user->last_name;
                $userSubscription->customer_email = $user->email;
                // $userSubscription->couponId = $couponId;
            }
            
            if(!is_object($subscription->latest_invoice)){
                $subscriptionInvoice = (new Stripe())->getInvoice($subscription->latest_invoice);
            }else{
                $subscriptionInvoice = $subscription->latest_invoice;
            }

            $userSubscription->stripe_payment_intent_id = $paymentMethod['id'];
            $userSubscription->paid_amount = ($subscriptionInvoice->amount_paid/100);
            $userSubscription->currency = $subscriptionInvoice->currency;
            $userSubscription->plan_interval = $subscription->plan->interval;
            $userSubscription->plan_period_start = $current_period_start;
            $userSubscription->plan_period_end = $current_period_end;
            $userSubscription->attach_payment_status = 1;
            $userSubscription->status = $status;

            $userSubscription->save();

            if($userSubscription->status == "active" || $userSubscription->status == "trialing"){
                User::Where('user_id', $user->user_id)->update(['payment_status' => 1, 'packageId' => $vendorPackage->id]);
            }

            $vendorDetails = VendorDetails::where('user_id','=',$user->user_id)->first();
            if(is_null($vendorDetails)){
                $vendorDetails = new VendorDetails();
                $vendorDetails->user_id = $user->user_id;
                $vendorDetails->vendor_coverage_area = null;
            }
            
            if($vendorPackage->packageType == "city"){
                $vendorDetails->package_selected_city = $formdata[$vendorPackage->packageType.'_name'];
                if( count($formdata['additional_'.$vendorPackage->packageType]) > 0){
                    $vendorDetails->additional_city = json_encode($formdata['additional_'.$vendorPackage->packageType]);
                }
            }else if($vendorPackage->packageType == "state"){
                $vendorDetails->package_selected_state = $formdata[$vendorPackage->packageType.'_name'];
                if( count($formdata['additional_'.$vendorPackage->packageType]) > 0){
                    $vendorDetails->additional_state = json_encode($formdata['additional_'.$vendorPackage->packageType]);
                }
            }
            $vendorDetails->payable_amount = $userSubscription->paid_amount;
            $vendorDetails->payment_status = 'Completed';
            $vendorDetails->save();

            if(isset($user->userSubscription) && $user->userSubscription->exists == true){
                // After Payment and Subscription Created Successfully
                
            }else{
                if($user->verified == false){
                    $this->newUserAdminNotification($user);
                    // $this->welcomeEmail($user);
                    // $this->emailVerification($user);
                }
            }

            if($userSubscription->paid_amount > 0){
                $user = User::with("userSubscription")->find($userSubscription->user_id);
                $email = new PaymentConfirmation($user);
                Mail::to($user->email)->send($email);
            }

            return Response::json(['subscription' => $userSubscription], 200);
        }else{
            return Response::json($customer, 400);
        }
    }

    public function updateCustomerPaymentMethod(Request $request){
        parse_str($request->input('formData'), $formdata);
        $user = User::with('userSubscription')->find($request->input('user_id') );
        $customer_id = $user->stripe_customer_id;
        $paymentMethod = $request->input('paymentMethod');
        if(!empty($customer_id)){
            $vendorDetails = VendorDetails::where('user_id','=',$user->user_id)->first();
            $vendorPackage = VendorPackages::find($formdata['packageId']);
            if(isset($formdata['oldPackageId'])){
                $vendorOldPackage = VendorPackages::find($formdata['oldPackageId']);
            }
            $customerPaymentMethod = (new Stripe())->attachPaymentMethodToCustomer($customer_id, $paymentMethod['id']);
            if($customerPaymentMethod->id){
                if(isset($formdata["oldPackageId"]) && $formdata["oldPackageId"] == $formdata["packageId"]){
                    $userSubscription = UserSubscriptions::where("user_id",$user->user_id)->first();
                    $subscriptionUpdateArray = [
                        'default_payment_method' => $paymentMethod['id'], 
                        'billing_cycle_anchor' => 'now'
                    ];
                    if($vendorPackage->packageType != "usa"){
                        $quantity = 1;
                        $quantity += count($formdata['additional_'.$vendorPackage->packageType]);

                        $subscriptionArray["items"] = [
                            [ 
                                "quantity" => $quantity,
                            ]
                        ];
                    }
                    $subscriptionData = (new Stripe())->updateSubscription($userSubscription->stripe_subscription_id, $subscriptionUpdateArray);
                    if($subscriptionData->id){
                        UserSubscriptions::Where('user_id', $userSubscription->user_id)->update(['attach_payment_status' => 1]);
                        
                        $subscription = (new Stripe())->getSubscription($userSubscription->stripe_subscription_id);
                        if(!is_object($subscription->latest_invoice)){
                            $subscriptionInvoice = (new Stripe())->getInvoice($subscription->latest_invoice);
                        }else{
                            $subscriptionInvoice = $subscription->latest_invoice;
                        }

                        $vendorDetails->package_selected_city = '';
                        $vendorDetails->package_selected_state = '';
                        $vendorDetails->additional_city = '';
                        $vendorDetails->additional_state = '';
                        if($vendorPackage->packageType != "usa"){
                            $package_selected_label = 'package_selected_'.$vendorPackage->packageType;
                            $additional_label = 'additional_'.$vendorPackage->packageType;
                            $vendorDetails->$package_selected_label = $formdata[$vendorPackage->packageType.'_name'];
                            if( count($formdata['additional_'.$vendorPackage->packageType]) > 0){
                                $vendorDetails->$additional_label = json_encode($formdata['additional_'.$vendorPackage->packageType]);
                            }
                        }

                        $vendorDetails->payable_amount = ($subscriptionInvoice->amount_paid/100);
                        $vendorDetails->payment_status = 'Completed';
                        $vendorDetails->save();
                    }

                    return Response::json(['customerPaymentMethod' => $customerPaymentMethod, 'subscription' => $subscriptionData], 200);
                }else{
                    
                }
            }

            return Response::json(['customerPaymentMethod' => $customerPaymentMethod], 200);
        }
    }

    public function newUserAdminNotification(User $user)
    {
    //return;
        try
        {
            $email = new NewUserAdminNotification($user);
            // Mail::to(config('mail.from.address'))->send($email);
            Mail::to("amit@culture-red.com")->send($email);
            // Mail::to("richardtocado@gmail.com")->send($email); 
            return back();
        }
        catch(Exception $e)
        {
            echo "catch";
            DB::rollback();
            return back();
        }
    }
}