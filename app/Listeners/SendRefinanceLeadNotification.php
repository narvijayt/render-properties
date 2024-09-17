<?php

namespace App\Listeners;

use App\Events\RefinanceLeadNotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\RefinanceNotificationRelationships;
use App\User;
use App\RedirectLinks;
use App\Refinance;
use Illuminate\Support\Facades\Mail;
use App\Mail\RefinanceNotificationMail;
use App\Services\TwilioService;

class SendRefinanceLeadNotification
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
     * @param  RefinanceLeadNotificationEvent  $event
     * @return void
     */
    public function handle(RefinanceLeadNotificationEvent $event)
    {
        $refinanceForm = $event->refinanceForm;

        // Generate Short Link
        $app_url = config('app.url');
        $generateShortURLPath = generateUniqueShortURLPath();
        // $destinationPath = "profile/refinance-leads/view/$refinanceForm->id";
        $destinationPath = "profile/leads/refinance/view/$refinanceForm->id";

        // Create short link
        $createShortLink = new RedirectLinks;
        $createShortLink->short_url_path = $generateShortURLPath;
        $createShortLink->destination_url_path = $destinationPath;
        $createShortLink->save();

        // Complete Short URl
        $completeShortURL = "$app_url/r/$generateShortURLPath";

        // Filter users with city and state
        $city = strtolower($refinanceForm->city);
        // $users = User::whereRaw('LOWER(city) = ?', [$city])->where('state', '=' , $refinanceForm->state)->get();
        $users = User::where('state', '=' , $refinanceForm->state)->get();
        // dd($users->where('user_type', 'broker')->where('payment_status', 1));

        // Get users with broker (Loan Officer) role
        $usersWithRoles = $users->where('user_type', 'broker');
        $brokerCount = $usersWithRoles->count();

        // Get Form Details
        $formDetails = Refinance::find($refinanceForm->id);
        $formSubmittedBy = "$formDetails->firstName $formDetails->lastName";

        // Find Richard User ID
        $findRichardUserId = User::where('email', '=', 'richardtocado@gmail.com')->first();
        // $recipient_email = "richardtocado@gmail.com";
        $recipient_name = "Richard Tocado";
        $recipient_email = "iamabhaykumar2002@gmail.com";

        // Send email to Richard Tocado if no Broker found in the area.
        if (!$brokerCount > 0) {

            // Email/Notification Type.
            $email_type = "detailed_with_no_broker_found";

            // Save the lead to whom the email is sent.
            $lead = new RefinanceNotificationRelationships;
            $lead->refinance_form_id = $refinanceForm->id;
            $lead->agent_id = $findRichardUserId->user_id ?? -1;
            $lead->notification_type = $email_type;

            // Send Email
            if (env('APP_ENV') != "local") {
                Mail::to($recipient_email)->send(new RefinanceNotificationMail($refinanceForm->id, $email_type, $recipient_name, $completeShortURL));
            }

            $lead->save();
        }


        // Send an email to users with role broker.
        foreach ($usersWithRoles as $currentUser) {

            // $toPhoneNumber = $currentUser->phone_number;
            $toPhoneNumber = "+91 7876161790";
            // $user_email = $currentUser->email;
            $user_name = "$currentUser->first_name $currentUser->last_name";

            // Save the lead to whom the email is sent.
            $lead = new RefinanceNotificationRelationships;
            $lead->refinance_form_id = $refinanceForm->id;
            $lead->agent_id = $currentUser->user_id;            

            // Check if the user is Paid LO / Unpaid LO and send Emails and SMS accordingly
            if ($currentUser->user_type === "broker") {
                $isPaid = $currentUser->payment_status == 1;
                
                // Paid and Unpaid Broker Case
                if ($isPaid) {

                    $lead->notification_type = "detailed_with_paid_loan_officer";

                    // Send Email and SMS
                    if (env('APP_ENV') != "local") {
                        $message = "Render: $formSubmittedBy wants to refinance their home loan. Please click on the link below to view details:\n$completeShortURL";
                        if (!is_null($toPhoneNumber)) (new TwilioService())->sendSMS($toPhoneNumber, $message);

                        Mail::to($recipient_email)->send(new RefinanceNotificationMail($refinanceForm->id, $lead->notification_type, $user_name, $completeShortURL));
                    }
                    
                    $lead->save();

                } else {

                    $lead->notification_type = "subscription_upgrade";

                    // Send Email and SMS
                    if (env('APP_ENV') != "local") {
                        $message = "Render: $formSubmittedBy wants to refinance their home loan. Please upgrade your subscription to view the details.\n$completeShortURL";
                        if (!is_null($toPhoneNumber)) (new TwilioService())->sendSMS($toPhoneNumber, $message);
                        
                        Mail::to($recipient_email)->send(new RefinanceNotificationMail($refinanceForm->id, $lead->notification_type, $user_name, $completeShortURL));
                    }

                    $lead->save();
                }
            }
        }


    }
}
