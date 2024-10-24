<?php
use Illuminate\Support\HtmlString;
use App\User;
use App\Subscribe;
use App\BraintreePlan;
use App\RedirectLinks;
use Illuminate\Support\Str;

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

/**
 * Print and test data in anywhere 
 */
if (!function_exists('pr')) {
    function pr($array = []) {
        echo '<pre>'; print_r($array); echo '</pre>';
    }
}

/**
 * Generate unique short url path
 */
if (!function_exists('generateUniqueShortURLPath')) {
    function generateUniqueShortURLPath($length = 6) {
		do {
			$randomString = Str::random($length);
	
			$exists = RedirectLinks::where('short_url_path', $randomString)->exists();
		} while ($exists); // do until short url path exists.
	
		return $randomString;
	}
}


function leads_csv_builder(\Illuminate\Database\Eloquent\Collection $leads, $formType) {
	
	$sellPropertyColumns = [
		'First Name',
		'Last Name',
		'Email',
		'Phone Number',
		'Street Address',
		'Street Address Line 2',
		'City',
		'State',
	    'Zip',
	    'Best Time To Contact You',
	    'How Soon Do You Need To Sell',
	    'Do You Currently Live in the House',
	    'Would you like a free home valuation?',
	    'Would you like to offer a buyer agent commission?',
	    'Why Are You Selling?',
	    'What Type of Property?',
	    'Lead Sent to Loan Officers',
	    'Lead Sent to Realtors',
	];

	$buyPropertyColumns = [
		'First Name',
		'Last Name',
		'Email',
		'Phone Number',
		'Street Address',
		'Street Address Line 2',
		'City',
		'State',
	    'Zip',
	    'Do you currently Own or Rent?',
	    'What is your timeframe for moving?',
	    'How many bedrooms do you need?',
	    'How many bathrooms do you need?',
	    'What is your price range?',
	    'Have you been preapproved for a mortgage?',
	    'Do you need to sell a home before you buy?',	   
	    'Is there anything else that will help us find your new home?',
		'Lead Sent to Loan Officers',
	    'Lead Sent to Realtors',
	];


	$refinanceColumns = [
		'First Name',
		'Last Name',
		'Email',
		'Phone Number',
		'Street Address',
		'Street Address Line 2',
		'City',
		'State',
	    'Zip',
	    'What type of property you are refinancing?',
	    'Estimate your credit score.',
	    'How will this property be used?',
	    'Do you have second mortgage?',
	    'Would you like to borrow additional cash?',
	    'What is your employment status?',
	    'Bankruptcy, short sale, or foreclosure in the last 3 years?',	   
	    'Can you show proof of income?',
	    'What is your average monthly income?',
	    'What are your average monthly expenses?',
	    'Do you currently have an FHA loan?',
		'Lead Sent to Loan Officers',
	];

	$file = fopen('php://temp', 'w+');
	
	if ($formType == "buy") {
		fputcsv($file, $buyPropertyColumns);
	} else if ($formType == "sell") { 
		fputcsv($file, $sellPropertyColumns);
	} else if ($formType == "refinance") {
		fputcsv($file, $refinanceColumns);
	}

	if ($formType == "buy" || $formType == "sell") {
		$leads->each(function ($propertyLead) use ($file, $formType) {
			
			// Get details of all paid loan officers to whom this lead was sent. 
			$paidBrokers = $propertyLead->areLeadsVisible()
			->whereHas('getAgentDetails', function ($query) {
				$query->where('user_type', 'broker');
			})
			->with(['getAgentDetails' => function ($query) {
				$query->where('user_type', 'broker');
			}])->where("notification_type", "detailed")->get();

			// Get details of all matched realtors to whom this lead was sent. 
			$matchedRealtors = $propertyLead->areLeadsVisible()
			->whereHas('getAgentDetails', function ($query) {
				$query->where('user_type', 'realtor');
			})
			->with(['getAgentDetails' => function ($query) {
				$query->where('user_type', 'realtor');
			}])->where("notification_type", "detailed_with_lead_matched")->get();

			// Variables
			$paidBrokerNames = [];
			$matchedRealtorNames = [];

			foreach($paidBrokers as $lead) {
				$lead_sent_detail = $lead->getAgentDetails()->first();
				$paidBrokerNames[] = "$lead_sent_detail->first_name $lead_sent_detail->last_name";
			}

			foreach($matchedRealtors as $lead) {
				$lead_sent_detail = $lead->getAgentDetails()->first();
				$matchedRealtorNames[] = "$lead_sent_detail->first_name $lead_sent_detail->last_name";
			}


			if ($formType === "sell") {
				$timeToContact = implode(", ", json_decode($propertyLead->timeToContact, true)) ?? 'N/A';
				$sellUrgency = implode(", ", json_decode($propertyLead->sellUrgency, true)) ?? 'N/A';
			}

			fputcsv($file, [
				$propertyLead->firstName,
				$propertyLead->lastName,
				$propertyLead->email,
				"'".$propertyLead->phoneNumber,
				$propertyLead->streetAddress,
				$propertyLead->streetAddressLine2,
				$propertyLead->city,
				$propertyLead->state,
				$propertyLead->postal_code,
				$formType == "sell" ? $timeToContact : $propertyLead->currentlyOwnOrRent,
				$formType == "sell" ? $sellUrgency : $propertyLead->timeframeForMoving,
				$formType == "sell" ? $propertyLead->liveInHouse : $propertyLead->numberOfBedrooms,
				$formType == "sell" ? $propertyLead->freeValuation : $propertyLead->numberOfBathrooms,
				$formType == "sell" ? $propertyLead->offerCommission : $propertyLead->priceRange,
				$formType == "sell" ? $propertyLead->whyAreYouSelling : $propertyLead->preapprovedForMontage,
				$formType == "sell" ? $propertyLead->propertyType : $propertyLead->sellHomeBeforeBuy,
				$formType == "buy" ? $propertyLead->helpsFindingHomeDesc : null,
				implode(", ", $paidBrokerNames),
				implode(", ", $matchedRealtorNames),
			]);
		});
	} else if ($formType == "refinance") {
		$leads->each(function ($refinanceLead) use ($file) {
			
			// Get details of all paid loan officers to whom this lead was sent. 
			$refinancePaidBrokers = $refinanceLead->areLeadsVisible()
            ->whereHas('getAgentDetails', function ($query) {
                $query->where('user_type', 'broker');
            })
            ->with(['getAgentDetails' => function ($query) {
                $query->where('user_type', 'broker');
            }])->where("notification_type", "detailed_with_paid_loan_officer")->get();

			// Variables
			$paidBrokerNames = [];

			foreach($refinancePaidBrokers as $lead) {
				$lead_sent_detail = $lead->getAgentDetails()->first();
				$paidBrokerNames[] = "$lead_sent_detail->first_name $lead_sent_detail->last_name";
			}

			fputcsv($file, [
				$refinanceLead->firstName,
				$refinanceLead->lastName,
				$refinanceLead->email,
				"'".$refinanceLead->phone_number,
				$refinanceLead->street_address,
				$refinanceLead->street_address_line_2,
				$refinanceLead->city,
				$refinanceLead->state,
				$refinanceLead->postal_code,
				$refinanceLead->type_of_property,
				$refinanceLead->estimate_credit_score,
				$refinanceLead->how_property_used,
				$refinanceLead->have_second_mortgage,
				'$'.$refinanceLead->borrow_additional_cash,
				$refinanceLead->employment_status,
				$refinanceLead->bankruptcy_shortscale_foreclosure,
				$refinanceLead->proof_of_income,
				'$'.$refinanceLead->average_monthly_income,
				'$'.$refinanceLead->average_monthly_expenses,
				$refinanceLead->currently_have_fha_loan,
				implode(", ", $paidBrokerNames),
			]);
		});
	}

	rewind($file);

	return stream_get_contents($file);
}

/**
 * Set canonical URL
 */
if (!function_exists('canonical_url')) {
    function canonical_url()
    {
        // Get the current full URL.
        $currentUrl = url()->full();
		
        // Remove www. from the url.
        $formattedUrl = str_replace('https://www.', 'https://', $currentUrl);

        // Add trailing slash to the path if it’s missing
        $urlParts = parse_url($formattedUrl);
        $path = isset($urlParts['path']) ? rtrim($urlParts['path'], '/') . '/' : '/';
        $query = isset($urlParts['query']) ? '?' . $urlParts['query'] : '';

        // Reconstruct the URL with the path and query parameters
        return "https://render.properties{$path}{$query}";
    }
}

