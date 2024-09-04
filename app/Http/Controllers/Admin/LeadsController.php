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


    public function getLeadsByFilter(Request $request) {
        $value = strtolower($request->input('search_value', ''));
        $formTypeValue = strtolower($request->input('search_form_type', ''));
        $stateValue = strtolower($request->input('search_state', ''));
    
        $limit = 10;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;
    
        $query = BuySellProperty::latest();
        
        // Apply the filters based on the search type
        switch ($request->input('search_type')) {
            case 'name':
                $nameParts = explode(' ', $value);
                if (count($nameParts) === 2) {
                    $firstName = $nameParts[0];
                    $lastName = $nameParts[1];
                    $query->where(function ($q) use ($firstName, $lastName) {
                        $q->whereRaw('LOWER("firstName") LIKE ?', ['%' . strtolower($firstName) . '%'])
                        ->orWhereRaw('LOWER("lastName") LIKE ?', ['%' . strtolower($lastName) . '%']);
                    });
                } else {
                    $query->where(function ($q) use ($value) {
                        $q->whereRaw('LOWER("firstName") LIKE ?', ['%' . $value . '%'])
                        ->orWhereRaw('LOWER("lastName") LIKE ?', ['%' . $value . '%']);
                    });
                }
                break;
            
            case 'email':
                $query->whereRaw('LOWER("email") LIKE ?', ['%' . $value . '%']);
                break;
            
            case 'phone_number':
                $query->whereRaw('LOWER("phoneNumber") LIKE ?', ['%' . $value . '%']);
                break;
            
            case 'state':
                $query->whereRaw('LOWER("state") LIKE ?', ['%' . $stateValue . '%']);
                break;
            
            case 'city':
                $query->whereRaw('LOWER("city") LIKE ?', ['%' . $value . '%']);
                break;
            
            case 'form_type':
                $query->whereRaw('LOWER("formPropertyType") LIKE ?', ['%' . $formTypeValue . '%']);
                break;
        }
    
        // Calculate total records and pages
        $totalRecords = $query->count();
        $totalPages = ceil($totalRecords / $limit);
        
        // Get the paginated results
        $leads = $query->skip($offset)->take($limit)->get();
    
        // Prepare the response data
        $data['totalPages'] = $totalPages;
        $data['startIndex'] = $offset + 1;
        // dd($page);
        $data['leads'] = $leads;
        $data['content'] = view('admin.leads.render-leads', $data)->render();
        return response()->json($data);
    }
    
  
}
