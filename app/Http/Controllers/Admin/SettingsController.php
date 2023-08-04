<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\RegistrationPlans;
use App\Services\Stripe;

class SettingsController extends Controller
{
    //

    public function pricing(){
        $pricing = (new RegistrationPlans())->first();
        return view("admin.settings.pricing", compact("pricing"));
    }

    public function storePricing(Request $request){
        $input = $request->all();
        $rules = array(
            'regular_price'    => 'required', // make sure the email is an actual email
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if($request->input('sale_price')){
                if($request->input('sale_price') >= $request->input('regular_price')){
                    return redirect()->back()->with("error", "Sale Price must be less than the Regular Price.")->withInput();
                }
                if($request->input('sale_period') == ""){
                    return redirect()->back()->with("error", "Sale Period is required with Sale Price.")->withInput();
                }
            }

            $pricing = (new RegistrationPlans())->first();
            
            $createCoupon = false;
            if(!empty($pricing)){
                if($request->input('sale_price') != ""){
                    if($request->input('sale_price') != $pricing->sale_price){
                        $createCoupon = true;
                    }else if($pricing->couponId == null){
                        $createCoupon = true;
                    }
                }
            }else{
                if($request->input('sale_price') != ""){
                    $createCoupon = true;
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

            
            $pricing = (new RegistrationPlans())->first();
            
            if(is_null($pricing) || $pricing->exists === false){
                $pricing = new RegistrationPlans();
            }

            $pricing->regular_price = $request->input('regular_price');
            $pricing->sale_price = $request->input('sale_price');
            $pricing->sale_period = $request->input('sale_period');
            $pricing->couponId = $createCoupon == true? $coupon->id : null;
            if($pricing->save()){
                return redirect()->route("settings.pricing")->with("message", "Price updated successfully.");
            }else{
                return redirect()->back()->with("error", "Failed to update the Price. Please try again later.")->withInput();
            }

        }   
    }
}
