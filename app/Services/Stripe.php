<?php
namespace App\Services;

use Carbon\Carbon;
use App\User;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class Stripe{

    public function __construct(){
        \Stripe\Stripe::setApiKey(env('APP_ENV') != "production"  ? env('STRIPE_TEST_SECRET_KEY') : env('STRIPE_LIVE_SECRET_KEY') );

    }

    /**
     * Create a New Customer on the Stripe
     * 
     * @accept array
     * 
     * @return array or object  |   succsss or error
     */
    public function createCustomer($data = []){

        $errors = [];
        if(!isset($data['name']) || empty($data['name'])){
            $errors["invalid_name"] = "Invalid Customer Name";
        }

        if(!isset($data['email']) || empty($data['email'])){
            $errors["invalid_email"] = "Invalid Customer Email";
        }

        if(empty($errors)){

            try {   
                $customer = \Stripe\Customer::create($data);

                return $customer;
            }catch(Exception $e) {
                $errors["api_error_message"] = $e->getMessage();
            } 
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }

    /**
     * Retrieve customer info from Stripe
     * 
     * @accept $customer_id
     * 
     * @return array or object  |   succsss or error
     */
    public function getCustomer($customer_id = ''){

        $errors = [];
        if(empty($customer_id)){
            $errors["invalid_customer_id"] = "Invalid Customer ID";
        }

        if(empty($errors)){
            try {   
                $customer = \Stripe\Customer::retrieve($customer_id);  
                return $customer;
            }catch(Exception $e) {   
                $errors['api_error_message'] = $e->getMessage();   
            }
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }

    /**
     * Create New Subscription on the Stripe
     * 
     * @accept $data | array
     * 
     * @return $response    |   object  |   succsss
     *         false        |   boolean |   failed
     */
    public function createSubscription($data = []){
        $errors = [];
        if(!isset($data['stripe_customer_id']) || empty($data['stripe_customer_id'])){
            $errors["invalid_customer_id"] = "Invalid Customer Id";
        }

        if(!isset($data['price_id']) || empty($data['price_id'])){
            $errors["invalid_price_id"] = "Invalid Price Details";
        }

        if(empty($errors)){
            try { 
                $subscription = \Stripe\Subscription::create([ 
                    'customer' => $data['stripe_customer_id'], 
                    'items' => [[ 
                        'price' => $data['price_id'], 
                    ]], 
                    'collection_method' => 'charge_automatically', 
                    // 'payment_behavior' => 'default_incomplete', 
                    // 'payment_behavior' => 'default_incomplete', 
                    'expand' => ['latest_invoice.payment_intent'], 
                    'proration_behavior' => 'none',
                    'trial_end' => strtotime("+30 days"),
                ]); 
                return $subscription;
            }catch(Exception $e) { 
                $errors["api_error_message"] = $e->getMessage();
            } 
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }

    /**
     * Retrieve customer info from Stripe
     * 
     * @accept $subscription_id
     * 
     * @return array or object  |   succsss or error
     */
    public function getSubscription($subscription_id = ''){

        $errors = [];
        if(empty($subscription_id)){
            $errors["invalid_subscription_id"] = "Invalid Subscription ID";
        }

        if(empty($errors)){
            try {   
                $subscription = \Stripe\Subscription::retrieve($subscription_id);  
                return $subscription;
            }catch(Exception $e) {   
                $errors['api_error_message'] = $e->getMessage();   
            }
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }
    
    /**
     * Retrieve customer info from Stripe
     * 
     * @accept $subscription_id
     * 
     * @return array or object  |   succsss or error
     */
    public function updateSubscription($subscription_id = '', $updateData = []){

        $errors = [];
        if(empty($subscription_id)){
            $errors["invalid_subscription_id"] = "Invalid Subscription ID";
        }
        
        if(empty($updateData)){
            $errors["invalid_updateData"] = "Invalid Update Data";
        }

        if(empty($errors)){
            try {
                $updateData['proration_behavior'] =  "none";
                $subscription = \Stripe\Subscription::update($subscription_id, $updateData);  
                return $subscription;
            }catch(Exception $e) {   
                $errors['api_error_message'] = $e->getMessage();   
            }
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }


    /**
     * Retrieve webhook event details
     * 
     * @accept $payload, $sig_header  
     * 
     * @return array or object  |   succsss or error
     */
    public function getWebhookEvent($payload = '', $sig_header = ''){

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('APP_ENV') == "production" ? env('STRIPE_LIVE_WEBHOOK_SECRET') : env('STRIPE_TEST_WEBHOOK_SECRET');

        $errors = [];
        if(empty($payload)){
            $errors["invalid_payload"] = "Invalid Payload";
        }

        if(empty($sig_header)){
            $errors["invalid_sig_header"] = "Invalid Request";
        }

        if(empty($errors)){
            try {
                $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
                return $event;
            } catch(\UnexpectedValueException $e) {
                $errors['api_error_message'] = $e->getMessage();   
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
                $errors['api_error_message'] = $e->getMessage();   
            }
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }

    /**
     * Retrieve webhook event details
     * 
     * @accept $payload, $sig_header  
     * 
     * @return array or object  |   succsss or error
     */
    public function attachPaymentMethodToCustomer($customer_id = '', $paymentMethod_id = ''){

        $errors = [];
        if(empty($customer_id)){
            $errors["invalid_customer_id"] = "Customer ID is missing";
        }

        if(empty($paymentMethod_id)){
            $errors["invalid_paymentMethod_id"] = "Payment Method Data is missing";
        }

        if(empty($errors)){
            // This is your Stripe CLI webhook secret for testing your endpoint locally.
            $secret_key = env('APP_ENV') == "production" ? env('STRIPE_LIVE_SECRET_KEY') : env('STRIPE_TEST_SECRET_KEY');
            $stripe = new \Stripe\StripeClient($secret_key);

            try {   
                $customerPaymentMethod = $stripe->paymentMethods->attach(
                    $paymentMethod_id,
                    ['customer' => $customer_id]
                );
                return $customerPaymentMethod;
            }catch(Exception $e) {  
                $errors['api_error_message'] = $e->getMessage();   
            }
            return $response;
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }

    public function createPaymentIntent($customer_id, $paymentData = []){

        
        $errors = [];
        if(empty($subscription_id)){
            $errors["invalid_subscription_id"] = "Subscription ID is missing";
        }

        if(empty($updateData)){
            $errors["invalid_updateData"] = "Update Data is missing";
        }

        if(empty($errors)){
            try {   
                $subscription = \Stripe\PaymentIntents::create([
                    
                ]);  
                return $subscription;
            }catch(Exception $e) {   
                $errors['api_error_message'] = $e->getMessage();   
            }
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }


    /**
     * Retrieve invoice info from Stripe
     * 
     * @accept $subscription_id
     * 
     * @return array or object  |   succsss or error
     */
    public function getInvoice($invoice_id = ''){

        $errors = [];
        if(empty($invoice_id)){
            $errors["invalid_invoice_id"] = "Invalid Invoice ID";
        }

        if(empty($errors)){
            try {   
                $secret_key = env('APP_ENV') == "production" ? env('STRIPE_LIVE_SECRET_KEY') : env('STRIPE_TEST_SECRET_KEY');
                $stripe = new \Stripe\StripeClient($secret_key);
                $invoice = $stripe->invoices->retrieve($invoice_id);
                
                return $invoice;
            }catch(Exception $e) {   
                $errors['api_error_message'] = $e->getMessage();   
            }
        }
        return ['status' => 400, 'error' => true, 'message' => $errors];
    }
}