<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\RegistrationPlans;
use App\VendorPackages;
use App\Services\Stripe;
use Auth;

class SettingsController extends Controller
{
    //

    public function pricing(){
        $lenderPackage = RegistrationPlans::where(['packageType' => 'lender'])->first();
        $vendorPackage = RegistrationPlans::where(['packageType' => 'vendor'])->first();
        // $vendorPackages = VendorPackages::paginate(10);
        return view("admin.settings.pricing", compact("lenderPackage", "vendorPackage"));
    }

    public function storePricing(Request $request){
        $input = $request->all();
        $rules = array(
            'regular_price'    => 'required', // make sure the email is an actual email
        );

        $validator = Validator::make($input, $rules);

        $packageType = ucfirst($request->input('packageType'));
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if($request->input('sale_price')){
                if($request->input('sale_price') >= $request->input('regular_price')){
                    return redirect()->back()->with("error", $packageType." Sale Price must be less than the Regular Price.")->withInput();
                }
                if($request->input('sale_period') == ""){
                    return redirect()->back()->with("error", $packageType." Sale Period is required with Sale Price.")->withInput();
                }
            }

            $pricing = RegistrationPlans::where(['packageType' => $request->input('packageType')])->first();
            
            $createPlan = $createCoupon = false;
            if(!empty($pricing)){
                if($request->input('sale_price') != ""){
                    if($request->input('sale_price') != $pricing->sale_price){
                        $createCoupon = true;
                    }else if($pricing->couponId == null){
                        $createCoupon = true;
                    }
                }

                if($request->input("regular_price") != $pricing->regular_price){
                    $createPlan = true;
                }
            }else{
                if($request->input('sale_price') != ""){
                    $createCoupon = true;
                }
                $createPlan = true;
            }
            
            $product_id = env('APP_ENV') == "production" ? env('STRIPE_LIVE_PRODUCT_ID') : env('STRIPE_TEST_PRODUCT_ID');
            if($request->input('packageType') == "vendor"){
                $product_id = env('APP_ENV') == "production" ? env('STRIPE_LIVE_VENDOR_PRODUCT_ID') : env('STRIPE_TEST_VENDOR_PRODUCT_ID');
            }
            
            if($createPlan == true){
                $priceData = [
                    "currency" => "usd",
                    "unit_amount" => ($request->input('regular_price')*100),
                    'recurring' => ['interval' => 'month'],
                    'product' => $product_id,
                ];
                $plan = (new Stripe())->createPricePlan($priceData);
                if($plan->error == true){
                    return redirect()->back()->with("errors", $plan->message)->withInput();
                }
            }
            
            if($createCoupon == true){
                $couponData = [
                    "duration" => $request->input('sale_period') == 1 ? "once" : "repeating",
                    "amount_off" => ($request->input('regular_price') - $request->input('sale_price') ),
                ];
                if($request->input('sale_period') > 1){
                    $couponData["duration_in_months"] =  $request->input('sale_period');
                }
                $coupon = (new Stripe())->createCoupon($couponData);
                if($coupon->error == true){
                    return redirect()->back()->with("errors", $coupon->message)->withInput();
                }
            }

            
            $planId = env('APP_ENV') == "production" ? env('STRIPE_LIVE_PRICE_ID') : env('STRIPE_TEST_PRICE_ID');
            $couponId = $createCoupon == true ? $coupon->id : null;
            $pricing = RegistrationPlans::where(['packageType' => $request->input('packageType')])->first();
            if(is_null($pricing) || $pricing->exists === false){
                $pricing = new RegistrationPlans();
            }else{
                $planId = ($pricing->planId != "") ? $pricing->planId : $planId;
                // $couponId = $createCoupon == true ? $coupon->id : $pricing->couponId;
            }

            $pricing->regular_price = $request->input('regular_price');
            $pricing->sale_price = $request->input('sale_price');
            $pricing->sale_period = $request->input('sale_period');
            $pricing->packageType = $request->input('packageType');
            $pricing->couponId = $couponId;
            $pricing->planId = $createPlan == true? $plan->id : $planId;
            
            if($pricing->save()){
                return redirect()->route("settings.pricing")->with("message", $packageType." Price updated successfully.");
            }else{
                return redirect()->back()->with("error", "Failed to update the Price for ".$packageType.". Please try again later.")->withInput();
            }

        }   
    }

    public function createVendorPackage(){
        $packageTypes = ['city', 'state', 'usa'];
        return view("admin.settings.pricing.create", compact("packageTypes"));
    }
    
    public function editVendorPackage($packageId){
        $packageTypes = ['city', 'state', 'usa'];
        $package = VendorPackages::find($packageId);
        return view("admin.settings.pricing.edit", compact("packageTypes", "package"));
    }
    
    public function storeVendorPackage(Request $request){
        $input = $request->all();
        $rules = array(
            'title'    => 'required', 
            'status'    => 'required', 
        );
        if($request->input('packageId') == false){
            $rules['packageType']    = 'required'; 
            $rules['basePrice']    = 'required'; 
            // $rules['addOnPrice']    = 'required'; 
        }

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $productId = env('APP_ENV') == "production" ? env('STRIPE_LIVE_VENDOR_PRODUCT_ID') : env('STRIPE_TEST_VENDOR_PRODUCT_ID');
            if($request->input('packageId') == false){
                $vendorPrice = [
                    "billing_scheme" =>  "tiered",
                    "recurring" => [
                        "usage_type" =>  "licensed",
                        "interval" =>  "month",
                        "interval_count" =>  "1",
                        "trial_period_days" =>  "0"
                    ],
                    "tiers_mode" =>  "graduated",
                    "tax_behavior" =>  "inclusive",
                    "currency" =>  "usd",
                    "tiers" => [
                        "0" => [
                            "up_to" =>  "1",
                            "unit_amount_decimal" =>  is_float($request->basePrice) ? $request->basePrice : $request->basePrice * 100
                        ],
                        "1" => [
                            "up_to" =>  "inf",
                            "unit_amount_decimal" =>  is_float($request->addOnPrice) ? $request->addOnPrice : $request->addOnPrice * 100
                        ]
                    ],
                    "product" =>  $productId,
                    "expand" => [
                        "tiers"
                    ]
                ];

                $plan = (new Stripe())->createPricePlan($vendorPrice);
                if($plan->error == true){
                    return redirect()->back()->with("errors", $plan->message)->withInput();
                }
            }

            if($request->input('status') != 0 ){
                if($request->input('packageId')){    
                    $package = VendorPackages::find($request->input('packageId'));
                    $packageType = $package->packageType;
                }else{
                    $packageType = $request->input('packageType');
                }
                VendorPackages::where([
                    'status'    =>  1,
                    'packageType'    =>  $packageType,
                ])->update(['status' => 0]);
            }

            if($request->input('packageId')){
                $vendorPackage = VendorPackages::find($request->input('packageId'));
            }else{
                $vendorPackage = new VendorPackages();
                $vendorPackage->userId = Auth::user()->user_id;
                $vendorPackage->packageType = $request->input('packageType');
                $vendorPackage->basePrice = $request->input('basePrice');
                $vendorPackage->addOnPrice = $request->input('addOnPrice');
                $vendorPackage->priceId = $plan->id;
                $vendorPackage->productId = $productId;
            }
            $vendorPackage->title = $request->input('title');
            $vendorPackage->status = $request->input('status');
            

            if($vendorPackage->save()){
                $message = $request->input('packageId') ? "Vendor Package updated successfully. " : "Vendor Package addedd successfully. ";
                if($existActive == true){
                    $message .= "Another Package already active for the ".ucfirst($vendorPackage->packageType). " package type";
                }
                return redirect()->route("settings.pricing")->with("message", $message);
            }else{
                $message = $request->input('packageId') ? "Failed to update the Vendor Package." : "Failed to create the Vendor Package.";
                return redirect()->back()->with("error", $message)->withInput();
            }
        }
    }
}
