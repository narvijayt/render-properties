<?php
use Illuminate\Support\HtmlString;
use App\User;
use App\Subscribe;
use App\BraintreePlan;

function datepickerFormat($format, $dateString)
{
	return date($format, strtotime($dateString));
}

function meta($name, $content)
{
	return new HtmlString("<meta name=\"$name\" content=\"$content\">");
}

function twitter($name, $content)
{
	return meta($name, $content);
}

function openGraph($name, $content)
{
	return new HtmlString("<meta property=\"$name\" content=\"$content\">");
}

function googlePlus($name, $content)
{
	return new HtmlString("<meta itemprop=\"$name\" content=\"$content\">");
}

function real_url($url)
{
	if (str_contains($url, 'http')) {
		return $url;
	}

	return 'http://'.$url;
}

/**
 * Build a csv file from a collection of users
 *
 * @param \Illuminate\Database\Eloquent\Collection $users
 * @return bool|string
 */
 
 
 function builder_user_report_csv(\Illuminate\Database\Eloquent\Collection $users) {
	$columns = [
	    'User ID',
		'Email',
		'First Name',
		'Last Name',
		'Created At',
		'User Type',
		'City',
		'State',
	    'Zip',
	    'Firm Name',
	    'Phone Number',
	    'Website',
	    'Specialties',
	    'License',
	    'Postal Code Service',
	    'Transactions Closed in 12 Months',
	    'Unit Closed Monthly',
	    'Paid Account',
	];

	$file = fopen('php://temp', 'w+');
	fputcsv($file, $columns);

	$users->each(function (App\User $user) use ($file) {
	    /*$paidAccount = "No";
	    $subscribeUser = Subscribe::where('user_id', $user->user_id)->first();
	    if(!empty($subscribeUser)) {
	        $braintreePlan  = BraintreePlan::where('braintree_plan', $subscribeUser->braintree_plan)->first();
	        if(!empty($braintreePlan)) {
	            $paidAccount = ($braintreePlan->cost > "0") ? "Yes" : "No";
	        }
	    }*/
		$paidAccount = ($user->payment_status == 1) ? "Yes" : "No";
	   	fputcsv($file, [
			$user->user_id,
			$user->email,
			$user->first_name,
			$user->last_name,
			$user->created_at,
			title_case($user->user_type === 'broker' ? 'lender' : $user->user_type),
			$user->city,
			$user->state,
			$user->zip,
			$user->firm_name,
			$user->phone_number.' '.$user->phone_ext,
			$user->website,
			preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$user->specialties),
			$user->license,
			$user->postal_code_service,
			$user->volume_closed_monthly,
			$user->units_closed_monthly,
			$paidAccount,
		]);
	    
	});

	rewind($file);

	return stream_get_contents($file);
}




function bulider_csv(\Illuminate\Database\Eloquent\Collection $users) {
	$columns = [
	    'User ID',
		'Email',
		'First Name',
		'Last Name',
		 'Match',
		'Created At',
		'User Type',
		'City',
		'State',
	    'Zip',
	    'Firm Name',
	    'Phone Number',
	    'Website',
	    'Specialties',
	    'License',
	    'Postal Code Service',
	    'Transactions Closed in 12 Months',
	    'Unit Closed Monthly',
	    'Paid Account',
	   
	];

	$file = fopen('php://temp', 'w+');
	fputcsv($file, $columns);

	$users->each(function (App\User $user) use ($file) {
	    
	    $paidAccount = ($user->payment_status == 1) ? "Yes" : "No";
	    /*$subscribeUser = Subscribe::where('user_id', $user->user_id)->first();
	    if(!empty($subscribeUser)) {
	        $braintreePlan  = BraintreePlan::where('braintree_plan', $subscribeUser->braintree_plan)->first();
	        if(!empty($braintreePlan)) {
	            $paidAccount = ($braintreePlan->cost > "0") ? "Yes" : "No";
	        }
	    }*/

	    
	    if($user->checkuser_with_unmatch == 'null'){
    		fputcsv($file, [
    			$user->user_id,
    			$user->email,
    			$user->first_name,
    			$user->last_name,
    			'No Match',
    			$user->created_at,
    			title_case($user->user_type === 'broker' ? 'lender' : $user->user_type),
    			$user->city,
    			$user->state,
    			$user->zip,
    			$user->firm_name,
    			$user->phone_number.' '.$user->phone_ext,
    			$user->website,
    			preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$user->specialties),
    			$user->license,
    			$user->postal_code_service,
    			$user->volume_closed_monthly,
    			$user->units_closed_monthly,
    			$paidAccount,
    		]);
	    }else{
	         if(isset($user->checkuser_with_unmatch) && $user->checkuser_with_unmatch['match_action'] =='accept'){
	            $findUser = User::find($user->checkuser_with_unmatch['user_init']);
        	            fputcsv($file, [
        			$user->user_id,
        			$user->email,
        			$user->first_name,
        			$user->last_name,
        			$findUser->first_name.' '.$findUser->last_name,
        			$user->created_at,
        			title_case($user->user_type === 'broker' ? 'lender' : $user->user_type),
        			$user->city,
        			$user->state,
        			$user->zip,
        			$user->firm_name,
        			$user->phone_number.' '.$user->phone_ext,
        			$user->website,
        			preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$user->specialties),
        			$user->license,
        			$user->postal_code_service,
        			$user->volume_closed_monthly,
        			$user->units_closed_monthly,
        		    $paidAccount,
        		]);
	         }else{
	             fputcsv($file, [
        			$user->user_id,
        			$user->email,
        			$user->first_name,
        			$user->last_name,
        			'No Match',
        			$user->created_at,
        			title_case($user->user_type === 'broker' ? 'lender' : $user->user_type),
        			$user->city,
        			$user->state,
        			$user->zip,
        			$user->firm_name,
        			$user->phone_number.' '.$user->phone_ext,
        			$user->website,
        			preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$user->specialties),
        			$user->license,
        			$user->postal_code_service,
        			$user->volume_closed_monthly,
        			$user->units_closed_monthly,
        		    $paidAccount,
        		]);
	             
	         }
	    }
	});

	rewind($file);

	return stream_get_contents($file);
}


function weekly_csv(\Illuminate\Database\Eloquent\Collection $users) {
	$columns = [
		'User ID',
	    'Email',
		'First Name',
		'Last Name',
		'Match',
		'Created At',
		'User Type',
		'City',
		'State',
		'Zip',
		'Firm Name',
		'Phone',
		'Website',
		'Specialties',
	    'License',
	    'Postal Code Service',
	    'Transactions Closed in 12 Months',
	    'Unit Closed Monthly',
	    'Paid Account'
	];

	$file = fopen('php://temp', 'w+');
	fputcsv($file, $columns);

	$users->each(function (App\User $user) use ($file) {
	    /*$paidAccount = "No";
	    $subscribeUser = Subscribe::where('user_id', $user->user_id)->first();
	    if(!empty($subscribeUser)) {
	        $braintreePlan  = BraintreePlan::where('braintree_plan', $subscribeUser->braintree_plan)->first();
	        if(!empty($braintreePlan)) {
	            $paidAccount = ($braintreePlan->cost > "0") ? "Yes" : "No";
	        }
	    }*/
		$paidAccount = ($user->payment_status == 1) ? "Yes" : "No";

	    if($user->checkuser_with_unmatch == 'null'){
           	fputcsv($file, [
			$user->user_id,
			$user->email,
			$user->first_name,
			$user->last_name,
			 "No Match",
			$user->created_at,
			title_case($user->user_type === 'broker' ? 'lender' : $user->user_type),
			$user->city,
			$user->state,
			$user->zip,
			$user->firm_name,
			$user->phone_number.' '.$user->phone_ext,
			$user->website,
			preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$user->specialties),
		   	$user->license,
			$user->postal_code_service,
			$user->volume_closed_monthly,
			$user->units_closed_monthly,
		    $paidAccount,
			]); 
        }else{
        if($user->checkuser_with_unmatch['match_action'] =='accept'){
            $findUser = User::find($user->checkuser_with_unmatch['user_init']);
            fputcsv($file, [
			$user->user_id,
			$user->email,
			$user->first_name,
			$user->last_name,
			$findUser->first_name.' '.$findUser->last_name,
			$user->created_at,
			title_case($user->user_type === 'broker' ? 'lender' : $user->user_type),
			$user->city,
			$user->state,
			$user->zip,
			$user->firm_name,
			$user->phone_number.' '.$user->phone_ext,
			$user->website,
			preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$user->specialties),
		   	$user->license,
			$user->postal_code_service,
			$user->volume_closed_monthly,
			$user->units_closed_monthly,
		    $paidAccount,
		]);
        }else{
           fputcsv($file, [
			$user->user_id,
			$user->email,
			$user->first_name,
			$user->last_name,
			"No Match",
			$user->created_at,
			title_case($user->user_type === 'broker' ? 'lender' : $user->user_type),
			$user->city,
			$user->state,
			$user->zip,
			$user->firm_name,
			$user->phone_number.' '.$user->phone_ext,
			$user->website,
			preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$user->specialties),
		   	$user->license,
			$user->postal_code_service,
			$user->volume_closed_monthly,
			$user->units_closed_monthly,
		    $paidAccount,
			]); 
        }
        }
		
	});

	rewind($file);

	return stream_get_contents($file);
}


if(!function_exists('get_locked_html_string')){
	function get_locked_html_string($value = ''){
		if(empty($value))
			return false;		
		
		if(!Auth::user()){
			return '<a href="'.route('login').'">Please login to view</a>';
		}else{
			$string_length = strlen($value);
			$new_string = '';
			for($loop=1;$loop<=$string_length;$loop++){
				$new_string .= 'X';
			}
			return '<span class="text-locked">'.$new_string.'</span>';
		}
	}
}

if(!function_exists('get_application_name')){
	function get_application_name(){
		return 'Render<sup>TM</sup>';
	}
}


if(!function_exists('user_verified_badge')){
	function user_verified_badge($user_id = '', $showDeatils = false, $className = ''){
		if(empty($user_id))
			return false;

		$user = User::find($user_id);

		if($user->verified == false)
			return false;

		if($user->mobile_verified == false)
			return false;

		$response = '<span class="verified-badge '.$className.'"><img src="'.url('/').'/img/verified.png" /></span>';
		if($showDeatils == true){
			$response .= '<span class="verified-details text-warning">verified contact details</span>';
		}
		return $response;
	}
}

if(!function_exists('get_decimal_value')){
	function get_decimal_value($number){
		if($number <= 0)
			return $number;
		
		$whole = floor($number); // 1
		return $number - $whole; // .25
	}
}


if(!function_exists('subscription_cancelation_reasons')){
	function subscription_cancelation_reasons(){
		return [
			'too_expensive'	=>	'It’s too expensive',
			'missing_features'	=>	'Some features are missing',
			// 'switched_service'	=>	'I’m switching to a different service',
			'unused'	=>	'I don’t use the service enough',
			// 'customer_service'	=>	'Customer service was less than expected',
			// 'too_complex'	=>	'Ease of use was less than expected',
			// 'low_quality'	=>	'Quality was less than expected',
			'other'	=>	'Other reason',
		];
	}
}