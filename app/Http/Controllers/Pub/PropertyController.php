<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BuySellProperty;
use App\LeadNotificationRelationships;
use App\User;
use App\Mail\LeadNotification;
use Illuminate\Support\Facades\Mail;
// use App\Services\TwilioService;
use Twilio\Rest\Client;

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
                // $users = User::where('zip', $request->postal_code);
                // dd($request->city);
                
                // $users = User::where('city', $request->city);
                $city = strtolower($request->city);
                $users = User::whereRaw('LOWER(city) = ?', [$city])->where('state', '=' ,$request->state)->get();
                // echo "<pre>$users</pre>";
                
                // Get users with realtor (REA) and broker (Loan Officer) roles
                $usersWithRoles = $users->whereIn('user_type', ['realtor', 'broker']);
                $realtorCount = $users->where('user_type', 'realtor')->count();
                $brokerCount = $users->where('user_type', 'broker')->count();
                // dd($realtorCount);
                // dd($brokerCount);
                // $realtorCount = 0;
                // $brokerCount = 0;
                // dd($brokerCount);
                // $usersWithRoles = [];

                $findRichardUserId = User::where('email', '=', 'richardtocado@gmail.com')->first();
                // dd($findRichardUserId->user_id);
                // If there are no users with roles realtor and broker.
                // dd(empty($usersWithRoles));
                // if ($usersWithRoles->isEmpty()) {
                // dd($realtorCount > 0 && ($brokerCount > 0));
                $recipient_name = "Richard Tocado";

                if ($realtorCount > 0 && !$brokerCount > 0) {
                    $email_type = "detailed_with_no_broker_found";
                    $lead = new LeadNotificationRelationships;
                    $lead->property_form_id = $propertyForm->id;
                    $lead->agent_id = $findRichardUserId->user_id ?? -1;
                    $lead->notification_type = $email_type;
                    
                    // Send Mail to Richard Tocado :  There is no paid LO found in this area
                    Mail::to('iamabhaykumar2002@gmail.com')->send(new LeadNotification($propertyForm->id, $email_type, $recipient_name));
                    $lead->save();
                }
                
                if (!$realtorCount > 0 && $brokerCount > 0) {
                    $email_type = "detailed_with_no_realtor_found";
                    
                    $lead = new LeadNotificationRelationships;
                    $lead->property_form_id = $propertyForm->id;
                    $lead->agent_id = $findRichardUserId->user_id ?? -1;
                    $lead->notification_type = $email_type;
                    
                    // Send Mail to Richard Tocado : There is no matched REA found in this area
                    Mail::to('iamabhaykumar2002@gmail.com')->send(new LeadNotification($propertyForm->id, $email_type, $recipient_name));
                    $lead->save();
                }
                
                if (!$realtorCount > 0 && !$brokerCount > 0) {
                    $email_type = "detailed_with_neither_realtor_nor_broker_found";

                    $lead = new LeadNotificationRelationships;
                    $lead->property_form_id = $propertyForm->id;
                    $lead->agent_id = $findRichardUserId->user_id ?? -1;
                    $lead->notification_type = $email_type;

                    // Send Mail to Richard Tocado : There is no paid LO and matched REA found in this area.
                    Mail::to('iamabhaykumar2002@gmail.com')->send(new LeadNotification($propertyForm->id, $email_type, $recipient_name));
                    $lead->save();
                }
                
                // dd('Email Sent!');
                // dd($usersWithRoles);
                // Available Matches of Users
                foreach ($usersWithRoles as $currentUser) {
             
                    $twilioSid = env('TWILIO_SID');
                    $twilioToken = env('TWILIO_TOKEN');
                    $twilioPhoneNumber = env('TWILIO_NUMBER');
                    $toPhoneNumber = '+917876161790'; // Replace with the recipient's phone number
                    // dd($twilioPhoneNumber);
                    // echo $currentUser->email;
                    $twilio = new Client($twilioSid, $twilioToken);
                    // dd($twilio);
                    // dd(env('TWILIO_TOKEN') );
                    $recipient_name = $currentUser->username ?? '';
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
                            
                            // Send SMS
                            // $phoneNumber = $currentUser->phone_number; // Use the user's phone number from the database

                            $twilio->messages->create(
                                (string) $toPhoneNumber,
                                [
                                    // "from" => env('TWILIO_PHONE_NUMBER'), // Your Twilio phone number
                                    "from" => $twilioPhoneNumber,
                                    "body" => "Hi $recipient_name,\nRender: A new lead has been received in your area. Please click on the link below to view details:\nhttps://shorturl.at/MthWk"
                                ]
                            );

                            
                            Mail::to('iamabhaykumar2002@gmail.com')->send(new LeadNotification($propertyForm->id, $lead->notification_type, $recipient_name));
                            
                        } else {
                            // TODO: Send email to Unpaid Broker (New lead received in your area, please upgrade your subscription)
                            // TODO: SMS
                            $twilio->messages->create(
                                (string) $toPhoneNumber,
                                [
                                    // "from" => env('TWILIO_PHONE_NUMBER'), // Your Twilio phone number
                                    "from" => $twilioPhoneNumber,
                                    "body" => "Hi $recipient_name,\nRender: A new lead has been received in your area. Please upgrade your subscription to view the details. https://shorturl.at/MthWk"
                                ]
                            );

                            $lead->notification_type = "subscription_upgrade";
                            Mail::to('iamabhaykumar2002@gmail.com')->send(new LeadNotification($propertyForm->id, $lead->notification_type, $recipient_name));                            
                        }
    
                    } else if ($currentUser->user_type === "realtor") {
                        // dd($currentUser);
                        $availableMatches = $currentUser->availableMatchCount();
                        $hasMatches = $availableMatches > 0;
                        
                        if ($hasMatches) {
                            // TODO: Send email to REA with matches (Email with details)
                            // TODO: SMS
                            $twilio->messages->create(
                                (string) $toPhoneNumber,
                                [
                                    // "from" => env('TWILIO_PHONE_NUMBER'), // Your Twilio phone number
                                    "from" => $twilioPhoneNumber,
                                    "body" => "Hi $recipient_name,\nRender: A new lead has been received in your area. Please click on the link below to view details:\nhttps://shorturl.at/MthWk"
                                ]
                            );

                            $lead->notification_type = "detailed_with_lead_matched";
                            Mail::to('iamabhaykumar2002@gmail.com')->send(new LeadNotification($propertyForm->id, $lead->notification_type, $recipient_name));
                            // dd($recipient_name);
                            
                        } else {
                            // TODO: Send email to REA with no matches (New lead received in your area, please match with someone to check the details)
                            // TODO: SMS

                            $message = $twilio->messages->create(
                                (string) $toPhoneNumber,
                                [
                                    'from' => $twilioPhoneNumber,
                                    "body" => "Hi $recipient_name,\nRender: A new lead has been received in your area. Please match with some Loan Officer in your area to view the details. https://shorturl.at/MthWk"
                                ]
                            );
                            
                            $lead->notification_type = "lead_unmatched";
                            Mail::to('iamabhaykumar2002@gmail.com')->send(new LeadNotification($propertyForm->id, $lead->notification_type, $recipient_name));
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
