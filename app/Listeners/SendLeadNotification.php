<?php

namespace App\Listeners;

use App\Events\LeadNotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\LeadNotificationRelationships;
use App\User;
use App\RedirectLinks;
use App\BuySellProperty;
use App\Mail\LeadNotification;
use Illuminate\Support\Facades\Mail;
use App\Services\TwilioService;

class SendLeadNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LeadNotificationEvent  $event
     * @return void
     */
    public function handle(LeadNotificationEvent $event)
    {
        // Get data from event
        $propertyForm = $event->propertyForm;

        // Generate Short Link
        $app_url = config('app.url');
        $generateShortURLPath = generateUniqueShortURLPath();
        // $destinationPath = "profile/leads/view/$propertyForm->id";
        $destinationPath = "profile/leads/property/view/$propertyForm->id";

        // Create short link
        $createShortLink = new RedirectLinks;
        $createShortLink->short_url_path = $generateShortURLPath;
        $createShortLink->destination_url_path = $destinationPath;
        $createShortLink->save();

        // Complete Short URl
        $completeShortURL = "$app_url/r/$generateShortURLPath";

        // Filter users with city and state
        $city = strtolower($propertyForm->city);
        
        $users_in_city = User::whereRaw('LOWER(city) = ?', [$city])->where('state', '=' ,$propertyForm->state);
        $realtorCount = $users_in_city->where('user_type', 'realtor')->count();
        $brokerCount = User::where('state', '=' , $propertyForm->state)->where('user_type', 'broker')->count();

        $users = User::where('state', '=' , $propertyForm->state)->whereIn('user_type', ['broker', 'realtor'])->get();
        
        // Get Form Details
        $formDetails = BuySellProperty::find($propertyForm->id);
        $smsHeaderMessage = "$formDetails->firstName $formDetails->lastName wants to $formDetails->formPropertyType property";
        
        // Find Richard User ID
        $findRichardUserId = User::where('email', '=', 'richardtocado@gmail.com')->first();
        $recipient_name = "Richard Tocado";
        $recipient_email = "richardtocado@gmail.com";

        // Send Email to Richard Tocado if there is Realtor in the area but not the Broker in state.
        if ($realtorCount > 0 && !$brokerCount > 0) {

            // Email/Notification Type.
            $email_type = "detailed_with_no_broker_found";

            // Save the lead to whom the email is sent.
            $lead = new LeadNotificationRelationships;
            $lead->property_form_id = $propertyForm->id;
            $lead->agent_id = $findRichardUserId->user_id ?? -1;
            $lead->notification_type = $email_type;
            
            // Send Email
            if (env('APP_ENV') != "local") {
                Mail::to($recipient_email)->send(new LeadNotification($propertyForm->id, $email_type, $recipient_name, $completeShortURL));
            }

            $lead->save();
        }

        // Send Email to Richard Tocado if there is Broker in the state but not the Realtor in area.
        if (!$realtorCount > 0 && $brokerCount > 0) {

            // Email/Notification Type.
            $email_type = "detailed_with_no_realtor_found";
            
            // Save the lead to whom the email is sent.
            $lead = new LeadNotificationRelationships;
            $lead->property_form_id = $propertyForm->id;
            $lead->agent_id = $findRichardUserId->user_id ?? -1;
            $lead->notification_type = $email_type;
            
            // Send Email
            if (env('APP_ENV') != "local") {
                Mail::to($recipient_email)->send(new LeadNotification($propertyForm->id, $email_type, $recipient_name, $completeShortURL));
            }

            $lead->save();
        }

        // Send Email to Richard Tocado if neither Realtor nor Broker found in the area/state.
        if (!$realtorCount > 0 && !$brokerCount > 0) {

            // Email/Notification Type.
            $email_type = "detailed_with_neither_realtor_nor_broker_found";

            // Save the lead to whom the email is sent.
            $lead = new LeadNotificationRelationships;
            $lead->property_form_id = $propertyForm->id;
            $lead->agent_id = $findRichardUserId->user_id ?? -1;
            $lead->notification_type = $email_type;

            // Send Email
            if (env('APP_ENV') != "local") {
                Mail::to($recipient_email)->send(new LeadNotification($propertyForm->id, $email_type, $recipient_name, $completeShortURL));
            }

            $lead->save();
        }


        // Send an email and SMS message to users with the roles of realtor and broker.
        foreach ($users as $currentUser) {
            $toPhoneNumber = $currentUser->phone_number;
            $user_email = $currentUser->email;
            $user_name = "$currentUser->first_name $currentUser->last_name";

            // Save the lead to whom the email is sent.
            $lead = new LeadNotificationRelationships;
            $lead->property_form_id = $propertyForm->id;
            $lead->agent_id = $currentUser->user_id;

            // Check if the user is Paid LO / Unpaid LO / Matched REA / Unmatched REA, and send Emails and SMS accordingly
            if ($currentUser->user_type === "broker") {
                $isPaid = $currentUser->payment_status == 1;
                
                // Paid and Unpaid Broker Case
                if ($isPaid) {

                    $lead->notification_type = "detailed";

                    // Send Email and SMS
                    if (env('APP_ENV') != "local") {
                        $message = "Render: $smsHeaderMessage. Please click on the link below to view details:\n$completeShortURL";
                        if (!is_null($toPhoneNumber)) (new TwilioService())->sendSMS($toPhoneNumber, $message);
                        
                        Mail::to($user_email)->send(new LeadNotification($propertyForm->id, $lead->notification_type, $user_name, $completeShortURL));
                    }
                    
                    $lead->save();

                } else {

                    $lead->notification_type = "subscription_upgrade";

                    // Send Email and SMS
                    if (env('APP_ENV') != "local") {
                        $message = "Render: $smsHeaderMessage. Please upgrade your subscription to view the details.\n$completeShortURL";
                        if (!is_null($toPhoneNumber)) (new TwilioService())->sendSMS($toPhoneNumber, $message);
                        
                        Mail::to($user_email)->send(new LeadNotification($propertyForm->id, $lead->notification_type, $user_name, $completeShortURL));                            
                    }

                    $lead->save();
                }

            } else if ($currentUser->user_type === "realtor" && strtolower($currentUser->city) == $city) {
                // Check match count
                $availableMatches = $currentUser->getAvailableMatchCount();
                $hasMatches = $availableMatches > 0;
                
                // Matched and Unmatched REA case.
                if ($hasMatches) {

                    $lead->notification_type = "detailed_with_lead_matched";
                    
                    // Send Email and SMS
                    if (env('APP_ENV') != "local") {
                        $message = "Render: $smsHeaderMessage. Please click on the link below to view details.\n$completeShortURL";
                        if (!is_null($toPhoneNumber)) (new TwilioService())->sendSMS($toPhoneNumber, $message);
                        
                        Mail::to($user_email)->send(new LeadNotification($propertyForm->id, $lead->notification_type, $user_name, $completeShortURL));
                    }

                    $lead->save();
                    
                } else {

                    $lead->notification_type = "lead_unmatched";
                    
                    // Send Email and SMS
                    if (env('APP_ENV') != "local") {
                        $message = "Render: $smsHeaderMessage. Please match with a Loan Officer in your area to view the details.\n$completeShortURL";
                        // Edit: Do not send SMS in case of unmatched REA
                        // if (!is_null($toPhoneNumber)) (new TwilioService())->sendSMS($toPhoneNumber, $message);
                        
                        Mail::to($user_email)->send(new LeadNotification($propertyForm->id, $lead->notification_type, $user_name, $completeShortURL));
                    }

                    $lead->save();
                }
            }
        }
    }
}