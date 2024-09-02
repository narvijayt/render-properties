<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BuySellProperty;

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
        $data['leads'] = BuySellProperty::latest()->get();
        $data['leads_count'] = BuySellProperty::count();

        return view('admin.leads.index', $data);
    }
    
    /**
     * View the specific lead
     * 
     * @since 1.0.0
     * 
     * @param lead_id
     * @return html
     */
    public function viewLead ($lead_id = '') {

        // Get lead by ID
        $data['lead'] = BuySellProperty::find($lead_id);

        // Check if lead exists.
        if (!$data['lead']) {
            return redirect()->route('admin.leads')->with('error', 'The requested lead could not be found.');
        }

        $data['lead_sent_to'] = $data['lead']->areLeadsVisible()->with('getAgentDetails')->get();
        // dd($data['lead']->areLeadsVisible()->with('getAgentDetails')->get());

        return view('admin.leads.view', $data);
    }

    public function getLeadsByFilter (Request $request) {
        // dd($request->all());
        $value = $request->search_value;
        $option_value = $request->search_option_value;

        $data['leads_count'] = BuySellProperty::count();
        $query = BuySellProperty::latest();
        
        if ($request->search_type === "name") {
            $nameParts = explode(' ', $value);

            // Check if we have both first and last names
            if (count($nameParts) === 2) {
                $firstName = $nameParts[0];
                $lastName = $nameParts[1];

                $query = $query->where(function ($q) use ($firstName, $lastName) {
                    $q->where('first_name', 'like', '%' . $firstName . '%')
                    ->orWhere('last_name', 'like', '%' . $lastName . '%');
                });

            } else {
                // If only one name is provided, use it for both first and last name search
                $name = $nameParts[0];
                $query = $query->where(function ($q) use ($name) {
                    $q->where('first_name', 'like', '%' . $name . '%')
                    ->orWhere('last_name', 'like', '%' . $name . '%');
                });
            }

        } else if ($request->search_type === "email") {
            $query = $query->where('email', 'like', '%' . $value . '%');
            
        } else if ($request->search_type === "phone_number") {
            $query = $query->where('phone_number', 'like', '%' . $value . '%');

        } else if ($request->search_type === "state") {
            $query = $query->where('state', 'like', '%' . $value . '%');

        } else if ($request->search_type === "city") {
            $query = $query->where('city', 'like', '%' . str_to_lower($value) . '%');
            
        } else if ($request->search_type === "form_type") {
            $query = $query->where('formPropertyType', 'like', '%' . $option_value . '%');

        }

        $data['leads'] = $query->get();
        
        // dd($data);
        $data['content']= view('admin.leads.render-leads', $data)->render();
        return response()->json($data);
    }
}
