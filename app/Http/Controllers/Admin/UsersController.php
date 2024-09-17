<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Users\UserStoreRequest;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\NotifyUser;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Geo\GeolocationService;
use SimpleXMLElement;
use Illuminate\Support\Facades\Validator;
use App\BuySellProperty;

use App\Http\Traits\AutoMatchTrait;
class UsersController extends Controller
{

    // use AutoMatchTrait Trait
	use AutoMatchTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Render | Admin | Users';
        $page_description = 'Render Dashboard';

        $this->authorize('view', User::class);
//    	$users = User::all();
    	$users = User::orderBy('user_id','desc')->paginate(10);

        return view('admin.users.index', compact('page_title', 'page_description', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

    	return view('admin.users.create', compact('page_title', 'page_description'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);

        $user = new User($request->only([
			'username',
			'first_name',
			'last_name',
			'email',
			'active',
		]));
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);

		return view('admin.users.edit', compact('page_title', 'page_description', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('edit', $user);

    	$user->update($request->only([
    		'username',
			'first_name',
			'last_name',
			'email',
			'active',
		]));


    	return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->back();
    }

    /*
    ** check duplicate username
    */
    public function checkUsername(Request $request) {
        $input = $request->all();
        $user = User::Where('username', $input['username'])->first();

        if(isset($user) && !empty($user)) {
            return 'exist';
        }
    }

    /*
    ** check duplicate email
    */
    public function checkEmail(Request $request) {
        $input = $request->all();
        $user = User::Where('email', $input['email'])->first();

        if(isset($user) && !empty($user)) {
            return 'exist';
        }
    }

    /*
    ** check duplicate phone
    */
    public function checkPhone(Request $request) {
        $input = $request->all();
        $user = User::Where('phone_number', $input['phone'])->first();

        if(isset($user) && !empty($user)) {
            return 'exist';
        }
    }

    /*
    ** check duplicate zipcode
    */
    public function checkZip(Request $request) {
        $input = $request->all();

       if($input['user_type'] == 'realtor') {
           $user = User::Where('postal_code_service', $input['zip'])
            ->where('user_type', $input['user_type'])
            ->whereNotNull('postal_code_service')->first();
        } else {
             $user = User::Where('postal_code_service', $input['zip'])
            ->where('user_type', $input['user_type'])
            ->whereNotNull('billing_first_name')
            ->whereNotNull('postal_code_service')->first();
        }
        
        if(isset($user) && !empty($user)) {
            $geolocationService = new GeolocationService();
            $location = $geolocationService->zip($input['zip']);
            $lat = $location->lat;
            $long = $location->long;

            /* get nearest zipcodes */
            $zipArr = array();
            $url = 'http://api.geonames.org/findNearbyPostalCodes?lat='.$lat.'&lng='.$long.'&radius=30&username=rituavantg';
            $contents = file_get_contents($url);
            $xml = new SimpleXMLElement($contents);
            if(!empty($xml)) {
                foreach ($xml as $val) {
                  if($input['user_type'] == 'realtor') {
                       $checkZip = User::Where('postal_code_service', $val->postalcode)
                            ->where('user_type', $input['user_type'])
                            ->whereNotNull('postal_code_service')->first();
                    } else {
                         $checkZip = User::Where('postal_code_service', $val->postalcode)
                            ->where('user_type', $input['user_type'])
                            ->whereNotNull('billing_first_name')
                            ->whereNotNull('postal_code_service')->first();
                    }
                    
                    if (empty($checkZip)) {
                        array_push($zipArr, $val->postalcode);
                    }
                }
                if(isset($zipArr) && !empty($zipArr)) {
                    $arr = array_unique($zipArr);
                    if(isset($arr) && !empty($arr)) {
                        foreach ($arr as $v) {
                            echo '<p class="notify-txt">' . $v . '</p>';
                        }
                    } else {
                        echo 'exist';
                    }
                } else {
                  echo 'exist';
                }

            } else {
                echo 'exist';
            }
        }
    }

    /*
    ** Notify Me
    */
    public function notifyMe(Request $request) {
        $email = $request->get('email');
        $zip = $request->get('zip');
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $checkEmail = NotifyUser::where('email', $email)->first();
        if(!empty($checkEmail)) {
            return 'exist';
        } else {
            $user = new NotifyUser();
            $user->email = $email;
            $user->zip = $zip;
            $user->created_at = $created_at;
            $user->updated_at = $updated_at;
            if($user->save()) {
                return 'success';
            }
        }
    }

    /*
   ** check duplicate licnese
   */
    public function checkLicense(Request $request) {
        $input = $request->all();

        $user = User::Where('license', $input['license'])->first();
        if(isset($user) && !empty($user)) {
            return 'exist';
        }
    }
    
     /**
     * admin login
     */
    public function showlogin() {
        $data['page_title'] = 'Render | Admin | Login';
        $data['page_description'] = 'Render Admin Login';
        return view('admin.auth.login', $data);
    }

    /**
     * @param Request $request
     */
    public function doLogin(Request $request) {
        $input = $request->all();
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect('cpldashrbcs/login')->withErrors($validator);
        } else {
            $userdata = array(
                'email'     => $input['email'],
                'password'  => $input['password']
            );

            if (Auth::attempt($userdata)) {
                if(auth()->user()->user_id == '3') {
                    return redirect('/cpldashrbcs');
                } else {
                    Auth::logout();
                    return redirect('cpldashrbcs/login')->with('message', 'Wrong credentials for Administrator');
                }
            } else {
                return redirect('cpldashrbcs/login')->with('message', 'Wrong Email / Password');
            }
        }
    }
	
	/**
     * @param Request $request
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteUser(Request $request) {
        $id = $request->get('id');
        User::Where('user_id', $id)->delete();
        return 'success';
    }
    
    public function loadAdddesignation(Request $request){
      $page_title = 'Render | Admin | Add Designation';
      $page_description = 'Render Admin Add Designation';
      $user = User::where('designation','=','')->orWhereNull('designation')->orderBy('first_name')->get();
      return view('admin.users.add_designation', compact('page_title', 'page_description', 'user'));
   }
   
   public function addDesignation(Request $request)
   {
       $selectedUser = $request->selected_user;
       $designation = $request->designation;
       if($selectedUser !="" && $designation!="")
       {
           $findUser = User::find($selectedUser);
           if($findUser->designation !="null"){
               return redirect('/cpldashrbcs/users-with-designation')->with('error','You have already added designation for this user.');
           }else{
           if($findUser !=""){
               $findUser->designation = $designation;
               $updatedUserDes = $findUser->update();
               if($updatedUserDes){
                   if($designation !="null"){
                   return redirect('/cpldashrbcs/users-with-designation')->with('message','Successfully Added User Designation');
                   }else{
                    return redirect('/cpldashrbcs/add-designation')->with('error','You have not selected designation for selected user');
                   }
               }
           }else{
                 return redirect()->back()->with('error','You have entered invalid user name');
           }
       }
           
       }else{
           if($selectedUser ==""){
                return redirect()->back()->with('error','Please enter valid username.');
           }
           if($designation ==""){
            return redirect()->back()->with('error','Please enable designation');
           }
       }
   }
   
   
   public function loadAllUsersWithDesignation(Request $request){
      $page_title = 'Render | Admin | Add Designation';
      $page_description = 'Render Admin Add Designation';
      $user = User::where('designation','!=','null')->whereNotNull('designation')->get();
      return view('admin.users.list_designated_users', compact('page_title', 'page_description', 'user'));
   }
   
   public function loadUpdateDesignation($id){
      $page_title = 'Render | Admin | Update User';
      $page_description = 'Render Admin Update User';
      $user = User::find($id);
      return view('admin.users.update_designation', compact('page_title', 'page_description', 'user'));
   }

    // View User Leads
    public function viewUserLeads ($user_id) {
        // Get User by ID
        $data['user'] = User::find($user_id);

        // Check if user exists.
        if (!$data['user']) {
            return redirect()->route('admin.realtors')->with('error', 'The requested user leads could not be found.');
        }

        // Users roles other than broker and realtors can not access this page.
        if (!in_array($data['user']->user_type, ["realtor", "broker"])) {
            return redirect()->route('admin.dashboard')->with('error', 'This user does not have the lead details');
        }

        // Eager load the userLeads relationship
        $data['userLeads'] = $data['user']->userLeads()->with('propertyFormDetails')->latest()->paginate(10, ['*'], 'property_leads');
        $data['user_refinance_leads'] = $data['user']->userRefinanceLeads()->with('refinanceFormDetails')->latest()->paginate(10, ['*'], 'refinance_leads');
        $data['property_lead_count'] =  $data['user']->userLeads()->with('propertyFormDetails')->count();
        $data['refinance_lead_count'] =  $data['user']->userRefinanceLeads()->with('refinanceFormDetails')->count();
        return view('admin.users.leads', $data);
    }


    public function updateDesignation(Request $request){
        $userId = $request->user_id;
        $designation = $request->designation;
        $findUser = User::find($userId);
        $findUser->designation = $designation;
        $findUser->active = $request->active;
        $findUser->phone_number = $request->phone_number;
        if($findUser->user_type=='broker'){
            $findUser->payment_status = $request->payment_status;
            if($request->payment_status == 1){
                $findUser->billing_first_name = $findUser->first_name;
            }
        }
        $updateUser = $findUser->update();
        if($updateUser){
            if($request->payment_status == 1){
                $response = $this->sendAutoMatchRequests($findUser->user_id);
            }
            return redirect()->back()->with('message','User updated successfully'); 
        }
   }
   
   public function fetchAutocompleteUser(Request $request){
      if($request->get('query'))
     {
      $query = $request->get('query');
      $data = User::where('first_name', 'LIKE', "%{$query}%")->orWhere('last_name', 'LIKE', "%{$query}%")->orderby('first_name')->where('designation','!=','')->whereNotNull('designation')->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      if(count($data) > 0){
     
      foreach($data as $row)
      {
       $output .= '
       <li value="'.$row->user_id.'"><a href="#">'.$row->first_name.' '.$row->last_name.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
      }else{
          $output .='<li value="0" ><a class="recordNotFound">No Record Found</a></li>';
          $output .= '</ul>';
         echo $output;
      }
     }
    }
   
}
