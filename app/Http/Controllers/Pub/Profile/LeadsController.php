<?php

namespace App\Http\Controllers\Pub\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\BuySellProperty;
use App\User;

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
        $data['user'] = Auth::user();
        $state = $data['user']->state;
        $agentId = $data['user']->user_id;
        $city = strtolower($data['user']->city);
        
        // Get leads that match the user's city and state, were sent by email to the user
        $data['leads'] = BuySellProperty::whereRaw('LOWER(city) = ?', [$city])
            ->where('state', $state)
            ->whereHas('areLeadsVisible', function ($query) use ($agentId) {
                $query->where('agent_id', $agentId);
            })
            ->with('areLeadsVisible')
            ->get();
        
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

        // Check if the user has access to view the lead
        $hasLeadAccess = $data['lead']->areLeadsVisible()->where('agent_id', $agentId)->get();
        
        if ($hasLeadAccess->isEmpty()) {
            return redirect()->route('pub.profile.leads')->with('error', 'You do not have permission to view this lead.');
        }
        
        // Check leads visibility
        $checkVisibility = $hasLeadAccess->whereIn('notification_type', ['lead_unmatched', 'subscription_upgrade']);
        if ($checkVisibility->isNotEmpty()) {
            
            // Set role based error messages.
            $message = '';
            if ($user->user_type === "realtor") {
                $message = "Please match with someone to view the lead details.";
            } else if ($user->user_type === "broker") {
                $message = "Please upgrade your subscription to access this lead.";
            }

            return redirect()->route('pub.profile.leads')->with('error', $message);
        }

        return view('pub.profile.leads.view', $data);
    }

}
