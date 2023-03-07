<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Users\UserStoreRequest;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\NotifyUser;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\Geo\GeolocationService;
use SimpleXMLElement;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;

class UploadUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = 'Render | Admin | Users uploaded by Sheet';
        $page_description = 'Render Dashboard';

        $this->authorize('view', User::class);
//    	$users = User::all();
        if($request->input('registered') ){
            $users = User::where('uploaded','=','1')->where('registered','=',$request->input('registered') )->orderBy('user_id','desc')->paginate(20);
            // echo User::where('uploaded','=','1')->where('registered','=',$request->input('registered') )->orderBy('user_id','desc')->toSql(); die;
        }else{
    	    $users = User::where('uploaded','=','1')->orderBy('user_id','desc')->paginate(20);
        }

        return view('admin.users.uploaded', compact('page_title', 'page_description', 'users'));
    }

    public function import(Request $request){
        $file = $request->file('file');
        if ($file) {
            ini_set('memory_limit', -1);
            // ini_set('display_errors', 1);
            // ini_set('display_startup_errors', 1);
            // error_reporting(E_ALL);

            $this->validate($request, [
                'file'  => 'required|mimes:xls,xlsx'
            ]);
            
            $this->authorize('create', User::class);
            
            $path = $request->file('file')->getRealPath();
            // echo $path; die;
            $data = Excel::load($path)->get();
            
            $errorMessage = [];
            $loopIndex = 0;
            
            if($data->count() > 0)
            {
                foreach($data->toArray() as $key => $row)
                {   
                    
                    if(empty($row['email'])){
                        continue;
                    }
                    // echo '<pre>'; print_r($row); echo '</pre>'; die;
                    // echo $row['email'] .' '.$this->checkUsername($row['email']).' Email '.$this->checkEmail($row['email']).' Phone '.$this->checkPhone($row['phone']).'<br/>';
                    if($this->checkUsername($row['email']) == "exist"){
                        $errorMessage['errors'][]= "Username ".$row['email']." already exist.";
                        $this->save_custom_logs([$row['email'] => "Username ".$row['email']." already exist."],"error");
                        continue;
                    }else if($this->checkEmail($row['email']) == "exist" ){
                        $errorMessage['errors'][]= "Email ".$row['email']." already exist.";
                        $this->save_custom_logs([$row['email'] => "Email ".$row['email']." already exist."],"error");
                        continue;
                    }else if ($this->checkPhone($row['phone']) == "exist"){
                        $errorMessage['errors'][]= "Phone ".$row['phone']." already exist.";
                        $this->save_custom_logs([$row['email'] => "Phone ".$row['phone']." already exist."],"error");
                        continue;
                    }
                    $userType = strtolower($row['user_type']);
                    try{
                        $user = new User();
                        $user->username = $row['email'];
                        $user->first_name = $row['first_name'];
                        $user->last_name = $row['last_name'];
                        $user->email = $row['email'];
                        $user->phone_number = $row['phone'];
                        $user->city = $row['city'];
                        $user->state = $row['state'];
                        $user->password = Hash::make(str_random(8));
                        $user->uploaded = 1;
                        $user->active = true;
                        $user->user_type = $userType;
                        $user->updated_at = date('Y-m-d H:i:s');
                        $user->register_ts = date('Y-m-d H:i:s');
                        $user->save();

                        $user->assign('user');
                        $user->assign($userType);

                        $this->save_custom_logs([$row['email'] => "User account created successully!"],"success");
                    }catch(\Exception $e){
                        // do task when error
                        // $e->getMessage();   // insert query
                        $this->save_custom_logs([$row['email'] => $e->getMessage()],"error");
                    }
                    $loopIndex++;
                }
            }            
            // echo '<pre>'; print_r($errorMessage); echo '</pre>'; die;
            if(!empty($errorMessage) && !empty($loopIndex)){
                return redirect()->route('uploadedUsers')->with('message', $loopIndex." records successfully uploaded")->withErrors($errorMessage);
            }else if(!empty($errorMessage) ){
                return redirect()->route('uploadedUsers')->withErrors($errorMessage);
            }else {    
                return redirect()->route('uploadedUsers')->with('message', $loopIndex." records successfully uploaded");
            }
        } else { 
            //no file was uploaded
            // throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
            return redirect()->back()->withErrors("No file was uploaded");
        }
    }

     /*
    ** validate file import
    */
    public function checkUploadedFileProperties($extension, $fileSize){
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

    /*
    ** check duplicate username
    */
    public function checkUsername($username = '') {
        if(empty($username))
            return false;

        $user = User::Where('username', $username)->first();
        // echo '<pre>'; print_r($user); echo '</pre>';
        if(isset($user) && !empty($user)) {
            return 'exist';
        }
        return false;
    }

    /*
    ** check duplicate email
    */
    public function checkEmail($email = '') {
        if(empty($email))
            return false;

        $user = User::Where('email', $email)->first();

        if(isset($user) && !empty($user)) {
            return 'exist';
        }

        return false;
    }

    /*
    ** check duplicate phone
    */
    public function checkPhone($phone = '') {
        if(empty($phone))
            return false;

        $user = User::Where('phone_number', $phone)->first();

        if(isset($user) && !empty($user)) {
            return 'exist';
        }

        return false;
    }

    /**
     * Save Log of users upload sheet to keep the track of each record
     * 
     */
    public function save_custom_logs($message = '', $type = '') { 
        if(is_array($message)) { 
            $message = json_encode($message); 
        }
        if (!file_exists(base_path() .'/logs')) {
            mkdir(base_path() .'/logs', 0777, true);
        }
        if($type == "success"){
            $fileName = date("Y-m-d").'_Success_log.log';
        }else if($type == "error"){
            $fileName = date("Y-m-d").'_Errors_log.log';
        }
        $file = fopen(base_path() ."/logs/{$fileName}","a");
        fwrite($file, "\n" . date('Y-m-d h:i:s') . " :: " . $message."\n"); 
        fclose($file); 
        return true;
    }
}
    