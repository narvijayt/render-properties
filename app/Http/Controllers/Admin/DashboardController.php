<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Match;
use Carbon\Carbon;
use App\MatchLog;
use Ramsey\Uuid\Uuid;
use App\Enums\MatchActionType;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$page_title = 'Render | Admin | Dashboard';
    	$page_description = 'Render Dashboard';

    	$lenders = User::where('user_type', 'broker')->count();
    	$realtors = User::where('user_type', 'realtor')->count();
    	$lenders_paid = User::where('user_type', 'broker')
                        ->where('billing_first_name','!=', null)
                        ->count();
        $lenders_unpaid = User::where('user_type', 'broker')
                        ->where('billing_first_name', null)
                        ->count();
        $consumers = User::where('user_type', null)
                    ->where('username', '!=', 'admin')
                    ->count();
        $all = User::where('username', '!=','admin')->count();
        $users = User::orderBy('user_id', 'desc')->paginate(8);

        return view('admin.index', compact('page_title', 'page_description', 'lenders',
                    'realtors', 'lenders_paid', 'all', 'lenders_unpaid', 'consumers', 'users'));
    }


    public function adminAddmatches(Request $request){
         $page_title = 'Render | Admin | Add manual Matches';
         $page_description = 'Render Dashboard';
         $selectalllender = User::where('user_type','=','broker')->distinct()->get();
         $relator = User::where('user_type','=','realtor')->doesnthave('checkuser_with_unmatch')->get();
         return view('admin.users.add_manual_matches',['page_title'=>$page_title,'page_description'=>$page_description,'relator'=>$relator,'selectalllender'=>$selectalllender]);            
        }
        
    public function add_manual_matches(Request $request){
         $realtorId = $request->addrelator;
          $lenderId = $request->lenderlist;
          $checkPreviousLog = MatchLog::where('user_init','=',$lenderId)->where('user_with','=',$realtorId)->get();
          if(count($checkPreviousLog) > 0 )
          {
                      foreach($checkPreviousLog as $overAllPreviousLog)
                      {
                          $deleteMatchLog = MatchLog::find($overAllPreviousLog->match_log_id);
                          
                          $deleteMatchLog->delete();
                      }
                      $checkMatch = Match::where('user_id1','=',$lenderId)->where('user_id2','=',$realtorId)->get();
                      foreach($checkMatch as $matchuser){
                          $findmatch = Match::find($matchuser->match_id);
                          $findmatch->delete();
                       }
                       if(empty($checkMatch) && $checkPreviousLog){
                       $mid = Uuid::uuid4();
                     	$obj = Match::create([
            				'match_id' 			=> $mid,
            				'user_id1' 			=> $lenderId,
            				'user_type1' 		=> 'broker',
            				'accepted_at1' 		=> Carbon::now(),
            				'user_id2' 			=> $realtorId,
            				'user_type2' 		=> 'realtor',
            				'accepted_at2' 		=> Carbon::now(),
            			]);
            			$updateMatch = MatchLog::create([
            				'match_id'		=> $obj->match_id,
            				'user_init'		=> $lenderId,
            				'user_with'		=> $realtorId,
            				'match_action'	=> MatchActionType::ACCEPT,
            			]);
            		    if($updateMatch)
                          {
                       return redirect()->back()->with('message', 'Successfully Updated Pending Match.');  
                          }
                       }
            }
          if(count($checkPreviousLog) == 0 )
          {
            $addMatch = new Match();
            $mid = Uuid::uuid4();
         	$obj = Match::create([
				'match_id' 			=> $mid,
				'user_id1' 			=> $lenderId,
				'user_type1' 		=> 'broker',
				'accepted_at1' 		=> Carbon::now(),
				'user_id2' 			=> $realtorId,
				'user_type2' 		=> 'realtor',
				'accepted_at2' 		=> Carbon::now(),
			]);
			$log = MatchLog::create([
				'match_id'		=> $obj->match_id,
				'user_init'		=> $lenderId,
				'user_with'		=> $realtorId,
				'match_action'	=> MatchActionType::ACCEPT,
			]);
			if($log ){
			    return redirect()->back()->with('message', 'Successfully Added Manual Match.');
			}
			
          }
     	}
     	
     	public function fetchAvailableLender(Request $request){
          $lenderId  = $request->lenderid;
         $checkRelator = Match::with('match_log_broker')->where('user_id1','=',$lenderId)->with('matchrelatordata')->get();
         if(count($checkRelator) > 0){
         return json_encode($checkRelator);
          }
          if(count($checkRelator) == 0){
             return $result['confirm'] = 0;
          }
     }
        
        
}
