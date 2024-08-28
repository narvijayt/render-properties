<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BuySellProperty;
use App\LeadNotificationRelationships;
use App\User;
use App\RedirectLinks;
use App\Mail\LeadNotification;
use Illuminate\Support\Facades\Mail;
// use App\Services\TwilioService;
use Twilio\Rest\Client;
use App\Events\LeadNotificationEvent;

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
            
            // Validate Form Types
            if (!$request->has('formPropertyType') || !in_array($request->formPropertyType, $allowedFormTypes)) {
                return \Redirect::back()->with('error', 'Failed to submit form. Please try again later.')->withInput($request->input());
            }

            // Validate forms fields
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

                $app_url = config('app.url');
                $generateShortURLPath = generateUniqueShortURLPath();
                $destinationPath = "/profile/leads/view/$propertyForm->id";
                
                // Create short link
                $createShortLink = new RedirectLinks;
                $createShortLink->short_url_path = $generateShortURLPath;
                $createShortLink->destination_url_path = $destinationPath;
                $createShortLink->save();
                
                // Complete Short URl
                $completeShortURL = "$app_url/r/$generateShortURLPath";

                // Filter users with city and state
                $city = strtolower($request->city);
                $users = User::whereRaw('LOWER(city) = ?', [$city])->where('state', '=' ,$request->state)->get();
                
                // Get users with realtor (REA) and broker (Loan Officer) roles
                $usersWithRoles = $users->whereIn('user_type', ['realtor', 'broker']);
                $realtorCount = $users->where('user_type', 'realtor')->count();
                $brokerCount = $users->where('user_type', 'broker')->count();

                // Trigger the event
                event(new LeadNotificationEvent($propertyForm, $usersWithRoles, $realtorCount, $brokerCount, $completeShortURL));

                return redirect()->back()->with('success', 'Form Submitted Successfully!');

            } else {
                return redirect()->back()->with('error', 'An unexpected error occurred while submitting the form.');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }

    }
}
