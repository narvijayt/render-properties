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
    public function index () {

        $data['user'] = Auth::user();
        $data['showLeads'] = false;
        $city = strtolower($data['user']->city);
        
        $data['leads'] = BuySellProperty::whereRaw('LOWER(city) = ?', [$city])->where('state', '=' ,$data['user']->state)->get();
        $data['role'] = $data['user']->user_type;

        if (($data['user']->user_type === "broker" && $data['user']->payment_status == 1) ||
            ($data['user']->user_type === "realtor" && $data['user']->availableMatchCount() > 0)) {

            $data['showLeads'] = true;
        }

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
        $data['user'] = Auth::user();
        $data['lead'] = BuySellProperty::find($lead_id);
        
        // $leads_relation = \App\LeadNotificationRelationships::where(['property_form_id' => $lead_id, 'agent_id' => $data['user']->id])->get();
        // if ($leads_relation->isEmpty()) {
        //     return redirect()->route('pub.profile.leads');
        // }
        // dd($leads_relation);
        // dd($data['lead']->areLeadsVisible()->get()->toArray());


        if (!$data['lead']) {
            return redirect()->route('profile.leads')->withErrors('Lead not found.');
        }
        // dd($data['user']->availableMatchCount());
        // dd($data['user']->user_type === "realtor" && $data['user']->availableMatchCount() > 0);
        if (($data['user']->user_type === "broker" && $data['user']->payment_status == 1) ||
            ($data['user']->user_type === "realtor" && $data['user']->availableMatchCount() > 0)) {

            return view('pub.profile.leads.view', $data);
        }
        
        return redirect()->route('pub.profile.leads');
        

    }

}
