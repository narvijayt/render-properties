<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BuySellProperty;
use App\LeadNotificationRelationships;
use App\User;
use App\Mail\LeadNotification;
use Illuminate\Support\Facades\Mail;

class PropertyController extends Controller
{
    /**
     * Sell property form
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function sellPropertyForm() {
        return view('pub.property.sell');
    }


    /**
     * Buy property form
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function buyPropertyForm() {
        return view('pub.property.buy');
    }


    /**
     * Store
     * 
     * @since 1.0.0
     * 
     * @return Response
     */
    public function store(Request $request) {
        try {
            
            // Allowed form types
            $allowedFormTypes = ["buy", "sell"];
            
            if (!$request->has('formPropertyType') || !in_array($request->formPropertyType, $allowedFormTypes)) {
                return \Redirect::back()->with('error', 'Failed to submit form. Please try again later.')->withInput($request->input());
            }
            
            // Validate forms
            $validator = \Validator::make($request->all(), BuySellProperty::$rules, BuySellProperty::$messages);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }
            
            // Save Buy or Sell Property Form
            $propertyForm = new BuySellProperty;
            $propertyForm->firstName = $request->firstName;
            $propertyForm->lastName = $request->lastName;
            $propertyForm->email = $request->email;
            $propertyForm->phoneNumber = $request->phoneNumber;
            $propertyForm->streetAddress = $request->streetAddress;
            $propertyForm->streetAddressLine2 = $request->streetAddressLine2;
            $propertyForm->city = $request->city;
            $propertyForm->state = $request->state;
            $propertyForm->postal_code = $request->postal_code;
            
            if ($request->formPropertyType === "sell") {
                $propertyForm->timeToContact = json_encode($request->timeToContact);
                $propertyForm->sellUrgency = json_encode($request->sellUrgency);
                $propertyForm->liveInHouse = $request->liveInHouse;
                $propertyForm->freeValuation = $request->freeValuation;
                $propertyForm->offerCommission = $request->offerCommission;
                $propertyForm->whyAreYouSelling = $request->whyAreYouSelling;
                $propertyForm->propertyType = $request->propertyType;
                
            } else if ($request->formPropertyType === "buy") {
                $propertyForm->currentlyOwnOrRent = $request->currentlyOwnOrRent;
                $propertyForm->timeframeForMoving = $request->timeframeForMoving;
                $propertyForm->numberOfBedrooms = $request->numberOfBedrooms;
                $propertyForm->numberOfBathrooms = $request->numberOfBathrooms;
                $propertyForm->priceRange = $request->priceRange;
                $propertyForm->preapprovedForMontage = $request->preapprovedForMontage;
                $propertyForm->sellHomeBeforeBuy = $request->sellHomeBeforeBuy;
                $propertyForm->helpsFindingHomeDesc = $request->helpsFindingHomeDesc;
            }
            
            $propertyForm->formPropertyType = $request->formPropertyType;
    
            if ($propertyForm->save()) {

                // Filter users from zip code
                $users = User::where('zip', $request->postal_code);
                // echo "<pre>$users</pre>";
                
                // Get users with realtor (REA) and broker (Loan Officer) roles
                $usersWithRoles = $users->whereIn('user_type', ['realtor', 'broker']);
                $usersWithRoles = $usersWithRoles->get();
                
                // If there are no users with roles realtor and broker.
                if ($usersWithRoles->isEmpty()) {
                    // Send email to Richard Tocado if neither REA nor Broker is found
                    // No need to send OTP
                    // Mail::to('iamabhaykumar2002@gmail.com')->send(new LeadNotification($propertyForm->id));
                    // return;
                }
    
                // Available Matches of Users
                foreach ($usersWithRoles as $currentUser) {
                    // Add Lead Email Sent Relationship
                    $lead = new LeadNotificationRelationships;
                    $lead->property_form_id = $propertyForm->id;
                    $lead->agent_id = $currentUser->user_id;

                    // Loan Officer
                    if ($currentUser->user_type === "broker") {
                        $isPaid = $currentUser->payment_status == 1;
    
                        if ($isPaid) {
                            // TODO: Send email to Paid Broker (Email with details)
                            // TODO: SMS
                            $lead->notification_type = "detailed";
                            
                        } else {
                            // TODO: Send email to Unpaid Broker (New lead received in your area, please upgrade your subscription)
                            // TODO: SMS
                            $lead->notification_type = "subscription_upgrade";
                            
                        }
    
                    } else if ($currentUser->user_type === "realtor") {
                        $availableMatches = $currentUser->availableMatchCount();
                        $hasMatches = $availableMatches > 0;
    
                        if ($hasMatches) {
                            // TODO: Send email to REA with matches (Email with details)
                            // TODO: SMS
                            $lead->notification_type = "detailed_with_lead_matched";
    
                        } else {
                            // TODO: Send email to REA with no matches (New lead received in your area, please match with someone to check the details)
                            // TODO: SMS
                            $lead->notification_type = "lead_unmatched";
                        }
                    }
                    
                    
                    if ($lead->save()) {
                        return redirect()->back()->with('success', 'Form Submitted Successfully!');
                    } else {
                        return redirect()->back()->with('error', 'An unexpected error occurred while submitting the form.');
                    }
                }

            } else {
                return redirect()->back()->with('error', 'An unexpected error occurred while submitting the form.');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }

    }
}
