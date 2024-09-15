<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BuySellProperty;
use App\Refinance;

class LeadsController extends Controller
{
    /**
     * Show the property leads listing
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function indexPropertyLeads () {
        $data['leads'] = BuySellProperty::latest()->get();
        $data['leads_count'] = BuySellProperty::count();

        return view('admin.leads.property.index', $data);
    }
    
    /**
     * View the specific lead
     * 
     * @since 1.0.0
     * 
     * @param lead_id
     * @return html
     */
    public function viewPropertyLead (Request $request, $lead_id = '') {
        // Get lead by ID   
        $data['lead'] = BuySellProperty::find($lead_id);
        
        if (isset($request->prev_url) && $request->prev_url == "property") {
            $data['prev_url'] = route('admin.leads.property');
        }

        // Check if lead exists.
        if (!$data['lead']) {
            return redirect()->route('admin.leads.property')->with('error', 'The requested lead could not be found.');
        }

        $data['brokerSentLeads'] = $data['lead']->areLeadsVisible()
            ->whereHas('getAgentDetails', function ($query) {
                $query->where('user_type', 'broker');
            })
            ->with(['getAgentDetails' => function ($query) {
                $query->where('user_type', 'broker');
            }])->paginate(10, ['*'], 'brokers');

        $data['realtorSentLeads'] = $data['lead']->areLeadsVisible()
            ->whereHas('getAgentDetails', function ($query) {
                $query->where('user_type', 'realtor');
            })
            ->with(['getAgentDetails' => function ($query) {
                $query->where('user_type', 'realtor');
            }])->paginate(10, ['*'], 'realtors');

        $data['richardTocadoLeads'] = $data['lead']->areLeadsVisible()
            ->whereHas('getAgentDetails', function ($query) {
                $query->where('email', 'richardtocado@gmail.com');
            })
            ->with(['getAgentDetails' => function ($query) {
                $query->where('email', 'richardtocado@gmail.com');
            }])
            ->get();

        return view('admin.leads.property.view', $data);
    }


    /**
     * Get Property/Refinance Leads By Filter 
     * 
     * @since 1.0.0
     * 
     * @return ajax | html
     */
    public function getLeadsByFilter(Request $request) {
        if ($request->filter_type == "property") {
            $formTypeValue = strtolower($request->input('search_form_type', ''));
        }

        $value = strtolower($request->input('search_value', ''));
        $stateValue = strtolower($request->input('search_state', ''));
    
        $limit = 10;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;
    
        if ($request->filter_type == "property") {
            $query = BuySellProperty::latest();
        } else if ($request->filter_type == "refinance") {
            $query = Refinance::latest();
        }

        $data['total_records'] = $query->count();
        
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
        $data['leads'] = $leads;
        $data['filter_type'] = $request->filter_type;
        $data['total_filtered_records'] = $totalRecords;
        $data['content'] = view('admin.leads.render-leads', $data)->render();

        return response()->json($data);
    }

    
    /**
     * Show the refinance leads listing
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function indexRefinanceLeads () {
        $data['leads'] = Refinance::latest()->get();
        $data['leads_count'] = Refinance::count();

        return view('admin.leads.refinance.index', $data);
    }


    /**
     * View the specific Refinance lead
     * 
     * @since 1.0.0
     * 
     * @param lead_id
     * @return html
     */
    public function viewRefinanceLead (Request $request, $lead_id = '') {

        if (isset($request->prev_url) && $request->prev_url == "refinance") {
            $data['prev_url'] = route('admin.leads.refinance');
        }

        // Get lead by ID
        $data['lead'] = Refinance::find($lead_id);

        // Check if lead exists.
        if (!$data['lead']) {
            return redirect()->route('admin.leads.refinance')->with('error', 'The requested lead could not be found.');
        }

        $data['brokerSentLeads'] = $data['lead']->areLeadsVisible()
            ->whereHas('getAgentDetails', function ($query) {
                $query->where('user_type', 'broker');
            })
            ->with(['getAgentDetails' => function ($query) {
                $query->where('user_type', 'broker');
            }])->paginate(10, ['*'], 'brokers');


        $data['richardTocadoLeads'] = $data['lead']->areLeadsVisible()
            ->whereHas('getAgentDetails', function ($query) {
                $query->where('email', 'richardtocado@gmail.com');
            })
            ->with(['getAgentDetails' => function ($query) {
                $query->where('email', 'richardtocado@gmail.com');
            }])
            ->get();

        return view('admin.leads.refinance.view', $data);
    }

}
