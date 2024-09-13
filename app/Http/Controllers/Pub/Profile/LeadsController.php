<?php

namespace App\Http\Controllers\Pub\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\BuySellProperty;
use App\User;
use App\Refinance;

class LeadsController extends Controller
{
    /**
     * Show the leads listing
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function index()
    {
        // User details
        $data['user'] = Auth::user();
        $agentId = $data['user']->user_id;
        $data['role'] = $data['user']->user_type;
        $state = $data['user']->state;
        $city = strtolower($data['user']->city);
        
        // Set show lead flag
        $data['showLeads'] = false;

        // Redirect to Home page if user role is vendor. 
        if ($data['user']->user_type === "vendor") {
            return redirect()->route('home');
        }

        // Show leads if user is paid broker or matched REA
        if (($data['user']->user_type === "broker" && $data['user']->payment_status == 1) ||
            ($data['user']->user_type === "realtor" && $data['user']->availableMatchCount() > 0)) {

            // Filter leads those matches with city and state
            // Where has will list only those which were sent via email to REA or LO, if we remove them it will show all of city and state.
            $data['leads'] = BuySellProperty::whereRaw('LOWER(city) = ?', [$city])->where('state', '=', $state)
                            ->whereHas('areLeadsVisible', function ($query) use ($agentId) {
                                $query->where('agent_id', $agentId);
                            })->latest()->get();

            $data['showLeads'] = true;
        }

        // Show the page
        return view('pub.profile.leads.index', $data);
    }




    /**
     * View the specific lead
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function viewLead($lead_id = '') {
        $user = Auth::user();
        $agentId = $user->user_id;

        // Get lead by ID
        $data['lead'] = BuySellProperty::find($lead_id);

        // Check if lead exists.
        if (!$data['lead']) {
            return redirect()->route('pub.profile.leads')->with('error', 'The requested lead could not be found.');
        }

        // If user is accesing the lead through url and is Unpaid Lo or Unmatched REA then throw an error.
        if ($user->user_type === "broker" && $user->payment_status != 1) {
            return redirect()->route('pub.profile.leads')->with('error', 'Please upgrade your subscription to access this lead.');
            
        } else if ($user->user_type === "realtor" && $user->availableMatchCount() < 0) {
            return redirect()->route('pub.profile.leads')->with('error', 'Please match with someone to view the lead details.');
        }

        // Check if the user has access to view the lead/ Only those can see who received the email.
        $hasLeadAccess = $data['lead']->areLeadsVisible()->where('agent_id', $agentId)->get();
        if ($hasLeadAccess->isEmpty()) {
            return redirect()->route('pub.profile.leads')->with('error', 'You do not have permission to view this lead.');
        }

        // Show the page.
        return view('pub.profile.leads.view', $data);
    }



    /**
     * Show the Refinance leads listing
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function indexRefinanceLeads()
    {
        // User details
        $data['user'] = Auth::user();
        $agentId = $data['user']->user_id;
        $data['role'] = $data['user']->user_type;
        $state = $data['user']->state;
        $city = strtolower($data['user']->city);
        
        // Set show lead flag
        $data['showLeads'] = false;

        // Redirect to Home page if user role is vendor. 
        if ($data['user']->user_type === "vendor" || $data['user']->user_type === "realtor") {
            return redirect()->route('home');
        }

        // Show leads if user is paid broker 
        if (($data['user']->user_type === "broker" && $data['user']->payment_status == 1)) {

            // Filter leads those matches with city and state
            // Where has will list only those which were sent via email to REA or LO, if we remove them it will show all of city and state.
            $data['leads'] = Refinance::whereRaw('LOWER(city) = ?', [$city])->where('state', '=', $state)
                            ->whereHas('areLeadsVisible', function ($query) use ($agentId) {
                                $query->where('agent_id', $agentId);
                            })->latest()->get();
                        
            $data['showLeads'] = true;
        }

        // Show the page
        return view('pub.profile.leads.refinance.index', $data);
    }


    /**
     * View the specific refinance lead
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function viewRefinanceLead($lead_id = '') {
        $user = Auth::user();
        $agentId = $user->user_id;

        // Get lead by ID
        $data['lead'] = Refinance::find($lead_id);

        // Check if lead exists.
        if (!$data['lead']) {
            return redirect()->route('pub.profile.refinance-leads')->with('error', 'The requested lead could not be found.');
        }

        // If user is accesing the lead through url and is Unpaid Lo or Unmatched REA then throw an error.
        if ($user->user_type === "broker" && $user->payment_status != 1) {
            return redirect()->route('pub.profile.refinance-leads')->with('error', 'Please upgrade your subscription to access this lead.');   
        }

        // Check if the user has access to view the lead/ Only those can see who received the email.
        $hasLeadAccess = $data['lead']->areLeadsVisible()->where('agent_id', $agentId)->get();
        if ($hasLeadAccess->isEmpty()) {
            return redirect()->route('pub.profile.refinance-leads')->with('error', 'You do not have permission to view this lead.');
        }

        // Show the page.
        return view('pub.profile.leads.refinance.view', $data);
    }


}
