<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Match;
use DB;


class RealtorsController extends Controller
{
    /*
     ** index
     */
    public function index(Request $request)
    {
        $page_title = 'Render | Admin | Realtors';
        $page_description = 'Render Dashboard';

        $this->authorize('view', User::class);
        $query = User::where('user_type', 'realtor');
        
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
        
        $users = $query->orderBy('user_id','desc')->paginate(20);

        return view('admin.users.realtors', compact('page_title', 'page_description', 'users'));
    }

    /*
    ** edit
    */
    public function edit($id)
    {
        $page_title = 'Render | Admin | Realtors | Edit';
        $page_description = 'Render Dashboard';
        if($id == null) {
            return redirect('cpldashrbcs/realtors');
        }

        $user = User::find($id);

        return view('admin.users.edit_realtors', compact('page_title', 'page_description', 'user'));
    }

    /*
    ** edit
    */
    public function update(Request $request)
    {
        $input = $request->all();
        $update = array('active' => $input['active']);
        User::where('user_id', $input['user_id'])->update($update);
        if($input['segment'] == 'realtors') {
            return redirect('cpldashrbcs/realtors');
        } elseif($input['segment'] == 'brokers') {
            return redirect('cpldashrbcs/brokers');
        } elseif($input['segment'] == 'paid-brokers') {
            return redirect('cpldashrbcs/paid-brokers');
        } elseif($input['segment'] == 'unpaid-brokers') {
            return redirect('cpldashrbcs/unpaid-brokers');
        } elseif($input['segment'] == 'consumers') {
            return redirect('cpldashrbcs/consumers');
        }
    }
    
    
      public function listRealtorMatches(Request $request)
      {
          $page_title = 'Render | Admin | Realtor';
          $page_description = 'Render Dashboard';
          $listrealtormatch= Match::with('matchrelatordata')->with('matchuserbeoker')->with('match_log_broker')->orderBy('updated_at', 'asc')->get();
          return view('admin.users.realtor_matchlist',['listrealtormatch'=>$listrealtormatch,'page_title'=>$page_title,'page_description'=>$page_description]);      
      }
    
    
}
