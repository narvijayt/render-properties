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
                $customer = \Stripe\Customer::create([ 
                    'name' => $data['name'],
                    'email' => $data['email']
                ]);

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
                    'payment_behavior' => 'default_incomplete', 
                    'expand' => ['latest_invoice.payment_intent'], 
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
}