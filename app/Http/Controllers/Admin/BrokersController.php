<?php
namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use DB;

class BrokersController extends Controller
{
    /*
    ** index
    */
    public function index(Request $request)
    {
        $page_title = 'Render | Admin | Lenders';
        $page_description = 'Render Dashboard';

        $this->authorize('view', User::class);
        $query = User::where('user_type', 'broker');
        
        if($request->input('payment_status') && $request->input('payment_status') != "all"){
            $payment_status = $request->input('payment_status') == "unpaid" ? 0 : 1;
            $query->where('payment_status', $payment_status );
        }
        
        if($request->input('search')){
            $search_string = strtolower(trim($request->input('search')));
            if(strpos($search_string, "@") ){
                $query->where(DB::raw('lower(email)'), 'like', '%'. $search_string. '%');
            }else if(strpos($search_string, ' ')){
                $name1 = substr($search_string, 0, strrpos($search_string, ' '));
                $name2 = substr($search_string, strpos($search_string, ' ') + 1);
                
                $query->where(function ($childquery) use ($name1, $name2) {
    			    $childquery->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });
                
            }else{
                $query->where(function ($childquery) use ($search_string) {
                    $childquery->where(function ($subQuery) use ($search_string) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $search_string. '%')
                        ->orWhere(DB::raw('lower(last_name)'), 'like', '%'. $search_string. '%');
                    })->orWhere(function ($subQuery) use ($search_string) {
                        $subQuery->where(DB::raw('lower(email)'), 'like', '%'. $search_string. '%');
                    });
                });
            }
        }

        if($payment_status == 1){
            if($request->input('payment_status') == "online_paid"){
                $query->whereHas('userSubscription', function($q) {
                    $q->where('status', 'active');
                });
            }else if($request->input('payment_status') == "manual_paid"){
                $query->whereDoesntHave('userSubscription');
            }
        }
        
        // echo $query->toSql(); die;
        $users = $query->orderBy('user_id','desc')->paginate(20);

        return view('admin.users.brokers', compact('page_title', 'page_description', 'users'));
    }

    /*
    ** paid
    */
    public function paid()
    {
        $page_title = 'Render | Admin | Paid Lenders';
        $page_description = 'Render Dashboard';

        $this->authorize('view', User::class);
        $users = User::where('user_type','=','broker')
                // ->whereNotNull('billing_first_name')
                ->where('payment_status', 1)
                ->orderBy('user_id','desc')
                ->paginate(20);

        return view('admin.users.paid_brokers', compact('page_title', 'page_description', 'users'));
    }

    /*
    ** unpaid
    */
    public function unpaid()
    {
        $page_title = 'Render | Admin | Unpaid Lenders';
        $page_description = 'Render Dashboard';

        $this->authorize('view', User::class);
        $users = User::where('user_type','=','broker')
            // ->where('billing_first_name', null)
            ->where('payment_status', 0)
            ->orderBy('user_id','desc')
            ->paginate(20);
            //dd($users);

        return view('admin.users.unpaid_brokers', compact('page_title', 'page_description', 'users'));
    }
    
    
    
}