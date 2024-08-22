<?php

namespace App\Http\Controllers\Pub\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\BuySellProperty;
use App\User;

class LeadsController extends Controller
{
    public function index () {
        $data['user'] = Auth::user();
        $data['showLeads'] = false;
        $data['leads'] = BuySellProperty::where('postal_code', $data['user']->zip)->get();
        $data['role'] = $data['user']->user_type;
        // dd($data['user']->user_type);
        // dd($data['user']->payment_status);
        // dd($data['user']->availableMatchCount());

        if (($data['user']->user_type === "broker" && $data['user']->payment_status == 1) ||
            ($data['user']->user_type === "realtor" && $data['user']->availableMatchCount() > 0)) {
            // dd(1);
            $data['showLeads'] = true;
        }

        return view('pub.profile.leads.index', $data);
    }


    public function viewLead($lead_id = '') {
        $data['user'] = Auth::user();
        $data['lead'] = BuySellProperty::find($lead_id);
        // dd($data['lead']);

        if (!$data['lead']) {
            return redirect()->route('profile.leads')->withErrors('Lead not found.');
        }

        return view('pub.profile.leads.view', $data);
    }

}
