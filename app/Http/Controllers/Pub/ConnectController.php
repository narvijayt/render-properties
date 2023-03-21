<?php

namespace App\Http\Controllers\Pub;
use App\VendorCategories;
use App\Category;
use App\Enums\UserAccountType;
use App\Http\Controllers\Controller;
use App\Http\Utilities\Geo\USStates;
use App\Services\Geo\GeolocationService;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ConnectController extends Controller
{
	/**
	 * Get the default params merged with the user input
	 *
	 * @param array $overrideParams
	 * @return object
	 */
	protected function defaultParams(array $overrideParams = []) {
	    $long = config('app.default_latitude');
		$lat = config('app.default_longitude');
		$location = config('app.default_location');
        $user = auth()->user();
       	if(
			$user != null
				&& isset($user->latitude)
				&& isset($user->longitude)
		) {
			$long = $user->longitude;
			$lat = $user->latitude;
			$location = "{$user->city}, {$user->state} {$user->zip}";
		}
        $searchDefault = [
			'lat' => $lat,
			'long' => $long,
			'location' => $location,
			'radius' => config('app.default_radius', 10),
			'page' => 1,
			'search_type' => 'radius',
			'state' => null,
			'category'=>null,
		];
	 $params = array_merge($searchDefault, $overrideParams);
        return (object) $params;
	}

	/**
	 * Index action
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
      public function index(Request $request)
	   {
	   if(!auth()->user()) {
        }
        $v = Validator::make($request->input(), [
	    ]);
    	$v->sometimes('radius', 'required|integer|min:10|max:500', function($input) {
			return $input->search_type === 'radius';
		});
        $v->sometimes('location', 'required|string', function($input) {
			return $input->search_type === 'radius';
		});
        $v->sometimes('state', 'required|in:'.implode(',', USStates::abbr()), function($input) {
			return $input->search_type === 'state';
		});
		$v->sometimes('name', 'required|string', function($input) {
			return $input->search_type === 'name';
		});
		$v->sometimes('name', 'required|string', function($input) {
			return $input->search_type === 'name';
		});
        $params = $this->defaultParams($request->input());
		$v->validate();
	    $query = User::where('user_type','=','realtor')
			->active()
			->with('reviews');
        if ($params->search_type === 'radius') {
			$geoService = app()->make(GeolocationService::class);
			$location = $geoService->query($params->location);
            $params->lat = $location->lat;
			$params->long = $location->long;
            $query->selectDistance($params->lat, $params->long)
				->distance($params->lat, $params->long, $params->radius)
				->orderBy('distance', 'asc');
		} else if ($params->search_type === 'state') {
			$query->where('state', $params->state);
		} else if ($params->search_type === 'name') {
			$query->where('first_name', $params->name);
			$query->orWhere('last_name', $params->name);
		}
        $users = $query->get();
        $query1 = User::where('user_type','=','broker')
			->whereNotNull('braintree_id')
			->active()
			->with('reviews');
        if ($params->search_type === 'radius') {
			$geoService = app()->make(GeolocationService::class);
			$location = $geoService->query($params->location);
            $params->lat = $location->lat;
			$params->long = $location->long;
            $query1->selectDistance($params->lat, $params->long)
				->distance($params->lat, $params->long, $params->radius)
				->orderBy('distance', 'asc');
		} else if ($params->search_type === 'state') {
			$query1->where('state', $params->state);
		} else if ($params->search_type === 'name') {
			$query1->where('first_name', $params->name);
			$query1->orWhere('last_name', $params->name);
		}
	    $users1 = $query1->get();
		$users = ($users1->merge($users))->shuffle();
        $users = $this->arrayPaginator($users, $params->page, $request);
        return view('pub.connect.index', compact('users', 'params'));
	}
	
	public function lenderProfiles(Request $request)
	    {
	   	$v = Validator::make($request->input(), [
		]);
        $v->sometimes('radius', 'required|integer|min:10|max:500', function($input) {
			return $input->search_type === 'radius';
		});
        $v->sometimes('location', 'required|string', function($input) {
			return $input->search_type === 'radius';
		});
        $v->sometimes('state', 'required|in:'.implode(',', USStates::abbr()), function($input) {
			return $input->search_type === 'state';
		});
		$v->sometimes('name', 'required|string', function($input) {
			return $input->search_type === 'name';
		});
        $params = $this->defaultParams($request->input());
        $v->validate();
        
        $query1 = User::where('user_type','=','broker')->where('user_id','!=','3')->where('payment_status', 1)->active()->inRandomOrder()->with('reviews')->whereNotNull('designation');
		$query3 = User::where('user_type','=','broker')->where('user_id','!=','3')->where('payment_status', 1)->active()->inRandomOrder()->whereNull('designation');
        $query4 = User::where('user_type','=','broker')->where('user_id','!=','3')->where('payment_status', 1)->whereDate('created_at', '<', '2020-01-01 00:00:00')->active()->inRandomOrder()->with('reviews')->whereNull('designation');
        
          if ($params->search_type === 'radius') {
			$geoService = app()->make(GeolocationService::class);
			$location = $geoService->query($params->location);
            $params->lat = $location->lat;
			$params->long = $location->long;
			$query1->selectDistance($params->lat, $params->long)->distance($params->lat, $params->long, $params->radius)->orderBy('distance', 'asc');
    		$query3->selectDistance($params->lat, $params->long)->distance($params->lat, $params->long, $params->radius)->orderBy('distance', 'asc');
    		$query4->selectDistance($params->lat, $params->long)->distance($params->lat, $params->long, $params->radius)->orderBy('distance', 'asc');
    		
		} else if ($params->search_type === 'state') {
		    $query1->where('state', $params->state);
			$query3->where('state', $params->state);
			$query4->where('state', $params->state);
		} else if ($params->search_type === 'name') {
		    $name = $params->name;
		   if ( preg_match('/\s/',$name) ){
		        $name1 = strtolower(substr($name, 0, strrpos($name, ' ')));
                $name2 = strtolower(substr($name, strpos($name, ' ') + 1));
                /*$query1->where('first_name', 'ilike', '%'. $name1. '%');
    			$query1->where('last_name', 'ilike', '%'. $name2. '%');
    			$query1->orWhere('first_name', 'ilike', '%'. $name2. '%');
    			$query1->where('last_name', 'ilike', '%'. $name1. '%');*/
    			
    			$query1->where(function ($query) use ($name1, $name2) {
    			    $query->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });
    			
    			/*$query3->where('first_name', 'ilike', '%'. $name1. '%');
    			$query3->where('last_name', 'ilike', '%'. $name2. '%');
    			$query3->orWhere('first_name', 'ilike', '%'. $name1. '%');*/
    			
    			$query3->where(function ($query) use ($name1, $name2) {
    			    $query->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });
    		    
    			/*$query4->where('first_name', 'ilike', '%'. $name1. '%');
    			$query4->where('last_name', 'ilike', '%'. $name2. '%');
    			$query4->orWhere('first_name', 'ilike', '%'. $name2. '%');
    			$query4->where('last_name', 'ilike', '%'. $name1. '%');*/
    			
    			$query4->where(function ($query) use ($name1, $name2) {
    			    $query->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });
    			
            } else {
               	/*$query1->where('first_name', 'ilike', '%'. $params->name. '%');
    			$query1->orWhere('last_name', 'ilike', '%'. $params->name. '%');*/
    			$query1->where(function ($query) use ($params) {
                    $query->where(DB::raw('lower(first_name)'), 'like', '%'. strtolower($params->name). '%')
                        ->orwhere(DB::raw('lower(last_name)'), 'like', '%'. strtolower($params->name). '%');
                });
    			
    			/*$query3->where('first_name', 'ilike', '%'. $params->name. '%');
    			$query3->orWhere('last_name', 'ilike', '%'. $params->name. '%');
    			$query3->orWhere('first_name', 'ilike', '%'. $params->name. '%');*/
    			$query3->where(function ($query) use ($params) {
                    $query->where(DB::raw('lower(first_name)'), 'like', '%'. strtolower($params->name). '%')
                        ->orwhere(DB::raw('lower(last_name)'), 'like', '%'. strtolower($params->name). '%');
                });
    			
    			/*$query4->where('first_name', 'ilike', '%'. $params->name. '%');
    			$query4->orWhere('last_name', 'ilike', '%'. $params->name. '%');
    			$query4->orWhere('first_name', 'ilike', '%'. $params->name. '%');*/
    			$query4->where(function ($query) use ($params) {
                    $query->where(DB::raw('lower(first_name)'), 'like', '%'. strtolower($params->name). '%')
                        ->orwhere(DB::raw('lower(last_name)'), 'like', '%'. strtolower($params->name). '%');
                });
    	  }
		}

        // $query1->where('user_type','=','broker');
        
        $goldLender = $query1->get()->shuffle();
        $paidLender = $query3->get()->shuffle();
        $unpaidLender = $query4->get()->shuffle();
        
        $users= $goldLender->merge($paidLender)->merge($unpaidLender);
        $goldUsers =  $this->arrayPaginator($goldLender, $params->page, $request);
        $paidUser = $this->arrayPaginator($paidLender, $params->page, $request);
        $unpaidUser = $this->arrayPaginator($unpaidLender, $params->page, $request);
        $users = $this->arrayPaginator($users, $params->page, $request);
        return view('pub.connect.index', compact('users', 'params','goldUsers','paidUser','unpaidUser'));
	}


	public function realtorProfiles(Request $request)
	{
	    $v = Validator::make($request->input(), [
		]);
        $v->sometimes('radius', 'required|integer|min:10|max:500', function($input) {
			return $input->search_type === 'radius';
		});
        $v->sometimes('location', 'required|string', function($input) {
			return $input->search_type === 'radius';
		});
        $v->sometimes('state', 'required|in:'.implode(',', USStates::abbr()), function($input) {
			return $input->search_type === 'state';
		});
        $v->sometimes('name', 'required|string', function($input) {
			return $input->search_type === 'name';
		});
        $params = $this->defaultParams($request->input());
        $v->validate();
        $query1 = User::where('user_type','=','realtor')->where('user_id','!=','3')->active()->inRandomOrder()->with('reviews')->whereNotNull('designation');
	    $query3 = User::where('user_type','=','realtor')->where('user_id','!=','3')->active()->inRandomOrder()->with('reviews')->whereNotNull('billing_first_name')->whereNotNull('braintree_id')->whereNull('designation');
		$query4 = User::where('user_type','=','realtor')->where('user_id','!=','3')->active()->inRandomOrder()->with('reviews')->whereNull('billing_first_name')->whereNull('designation')->whereNull('braintree_id');
		if ($params->search_type === 'radius') {
			$geoService = app()->make(GeolocationService::class);
			$location = $geoService->query($params->location);
            $params->lat = $location->lat;
			$params->long = $location->long;
            $query1->selectDistance($params->lat, $params->long)
				->distance($params->lat, $params->long, $params->radius)
				->orderBy('distance', 'asc');
			$query3->selectDistance($params->lat, $params->long)
				->distance($params->lat, $params->long, $params->radius)
				->orderBy('distance', 'asc');
			$query4->selectDistance($params->lat, $params->long)
				->distance($params->lat, $params->long, $params->radius)
				->orderBy('distance', 'asc');
		} else if ($params->search_type === 'state') {
			$query1->orderby('designation')->where('state', $params->state);
		    $query3->where('state', $params->state);
			$query4->where('state', $params->state);
		} else if ($params->search_type === 'name') {
		    $name = $params->name;
           if ( preg_match('/\s/',$name) ){
                $name1 = strtolower(substr($name, 0, strrpos($name, ' ')));
                $name2 = strtolower(substr($name, strpos($name, ' ') + 1));
            	/*$query1->where('first_name', 'ilike', '%'. $name1. '%');
    			$query1->where('last_name', 'ilike', '%'. $name2. '%');
    			$query1->orWhere('first_name', 'ilike', '%'. $name2. '%');
    			$query1->where('last_name', 'ilike', '%'. $name1. '%');*/
				$query1->where(function ($query) use ($name1, $name2) {
    			    $query->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });

    		    /*$query3->where('first_name', 'ilike', '%'. $name1. '%');
    			$query3->where('last_name', 'ilike', '%'. $name2. '%');
    			$query3->orWhere('first_name', 'ilike', '%'. $name2. '%');
    			$query3->where('last_name', 'ilike', '%'. $name1. '%');*/
				$query3->where(function ($query) use ($name1, $name2) {
    			    $query->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });

    			/*$query4->where('first_name', 'ilike', '%'. $name1. '%');
    			$query4->where('last_name', 'ilike', '%'. $name2. '%');
    			$query4->orWhere('first_name', 'ilike', '%'. $name2. '%');
    			$query4->where('last_name', 'ilike', '%'. $name1. '%');*/
				$query4->where(function ($query) use ($name1, $name2) {
    			    $query->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });
    		} else {
    			/*$query1->where('first_name', 'ilike', '%'. $params->name. '%');
    			$query1->orWhere('last_name', 'ilike', '%'. $params->name. '%');*/
				$query1->where(function ($query) use ($params) {
                    $query->where(DB::raw('lower(first_name)'), 'like', '%'. strtolower($params->name). '%')
                        ->orwhere(DB::raw('lower(last_name)'), 'like', '%'. strtolower($params->name). '%');
                });
				
    			/*$query3->where('first_name', 'ilike', '%'. $params->name. '%');
    			$query3->orWhere('last_name', 'ilike', '%'. $params->name. '%');
    			$query3->orWhere('first_name', 'ilike', '%'. $params->name. '%');*/
				$query3->where(function ($query) use ($params) {
                    $query->where(DB::raw('lower(first_name)'), 'like', '%'. strtolower($params->name). '%')
                        ->orwhere(DB::raw('lower(last_name)'), 'like', '%'. strtolower($params->name). '%');
                });

    			/*$query4->where('first_name', 'ilike', '%'. $params->name. '%');
    			$query4->orWhere('last_name', 'ilike', '%'. $params->name. '%');
    			$query4->orWhere('first_name', 'ilike', '%'. $params->name. '%');*/
				$query4->where(function ($query) use ($params) {
                    $query->where(DB::raw('lower(first_name)'), 'like', '%'. strtolower($params->name). '%')
                        ->orwhere(DB::raw('lower(last_name)'), 'like', '%'. strtolower($params->name). '%');
                });
            }
		}
	    $query1->where('user_type','=','realtor');
        $goldUsers = $query1->where('user_type','=','realtor')->whereNotNull('designation')->get()->shuffle();
        $paidRealtor = $query3->where('user_type','=','realtor')->whereNotNull('billing_first_name')->whereNotNull('braintree_id')->whereNull('designation')->get()->shuffle();
        $unPaidRealtor = $query4->where('user_type','=','realtor')->whereNull('billing_first_name')->whereNull('designation')->whereNull('braintree_id')->get()->shuffle();
        $users= $goldUsers->merge($paidRealtor)->merge($unPaidRealtor);
        $users = $this->arrayPaginator($users, $params->page, $request);
        $paidUser = $this->arrayPaginator($paidRealtor, $params->page, $request);
        $unpaidUser = $this->arrayPaginator($unPaidRealtor, $params->page, $request);
        return view('pub.connect.index', compact('users', 'params','goldUsers','paidUser','unpaidUser'));
	}	


	/**
	 * Paginate a collection of users
	 *
	 * @param Collection $array
	 * @param $params
	 * @param Request $request
	 * @return LengthAwarePaginator
	 */
    public function arrayPaginator(Collection $array, $page, Request $request)
    {
        $perPage = config('app.default_connects_per_page');
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(
        	$array->slice($offset, $perPage),
			$array->count(),
			$perPage,
			$page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }
    
    
    public function vendorProfiles(Request $request){
       	$v = Validator::make($request->input(), [
		]);
        $v->sometimes('radius', 'required|integer|min:10|max:500', function($input) {
			return $input->search_type === 'radius';
		});
        $v->sometimes('location', 'required|string', function($input) {
			return $input->search_type === 'radius';
		});
        $v->sometimes('state', 'required|in:'.implode(',', USStates::abbr()), function($input) {
			return $input->search_type === 'state';
		});
        $v->sometimes('name', 'required|string', function($input) {
			return $input->search_type === 'name';
		});
        $params = $this->defaultParams($request->input());
        $v->validate();
        
        $query1 = User::where('user_type','=','vendor')->active()->inRandomOrder()->with('reviews')->whereNotNull('designation');
		$query2 = User::where('user_type','=','vendor')->active()->inRandomOrder()->with('reviews')->whereNull('designation');
		
		if ($params->search_type === 'radius') {
			$geoService = app()->make(GeolocationService::class);
			$location = $geoService->query($params->location);
            $params->lat = $location->lat;
			$params->long = $location->long;
            $query1->selectDistance($params->lat, $params->long)->distance($params->lat, $params->long, $params->radius)->orderBy('distance', 'asc');
			$query2->selectDistance($params->lat, $params->long)->distance($params->lat, $params->long, $params->radius)->orderBy('distance', 'asc');
			
		} else if ($params->search_type === 'state') {
			$query1->orderby('designation')->where('state', $params->state);
			$query2->where('state', $params->state);
		} else if ($params->search_type === 'name') {
		    $name = $params->name;
           if ( preg_match('/\s/',$name) ){
                $name1 = strtolower(substr($name, 0, strrpos($name, ' ')));
                $name2 = strtolower(substr($name, strpos($name, ' ') + 1));
            	
            	/*$query1->where('first_name', 'ilike', '%'. $name1. '%');
    			$query1->where('last_name', 'ilike', '%'. $name2. '%');
    			$query1->orWhere('first_name', 'ilike', '%'. $name2. '%');
    			$query1->where('last_name', 'ilike', '%'. $name1. '%');*/
    			
    			$query1->where(function ($query) use ($name1, $name2) {
    			    $query->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });
                
    			/*$query2->where('first_name', 'ilike', '%'. $name1. '%');
    			$query2->where('last_name', 'ilike', '%'. $name2. '%');
    			$query2->orWhere('first_name', 'ilike', '%'. $name2. '%');
    			$query2->where('last_name', 'ilike', '%'. $name1. '%');*/
    			
    			$query2->where(function ($query) use ($name1, $name2) {
    			    $query->where(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name1. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name2. '%');
                    })->orWhere(function ($subQuery) use ($name1, $name2) {
                        $subQuery->where(DB::raw('lower(first_name)'), 'like', '%'. $name2. '%')
                            ->where(DB::raw('lower(last_name)'), 'like', '%'. $name1. '%');
                    });
                });
    		} else {
    			/*$query1->where('first_name', 'ilike', '%'. $params->name. '%');
    			$query1->orWhere('last_name', 'ilike', '%'. $params->name. '%');*/
    			
    			$query1->where(function ($query) use ($params) {
                    $query->where(DB::raw('lower(first_name)'), 'like', '%'. strtolower($params->name). '%')
                        ->orwhere(DB::raw('lower(last_name)'), 'like', '%'. strtolower($params->name). '%');
                });
                
    			/*$query2->where('first_name', 'ilike', '%'. $params->name. '%');
    			$query2->orWhere('last_name', 'ilike', '%'.$params->name. '%');*/
    			
    			$query2->where(function ($query) use ($params) {
                    $query->where(DB::raw('lower(first_name)'), 'like', '%'. strtolower($params->name). '%')
                        ->orwhere(DB::raw('lower(last_name)'), 'like', '%'. strtolower($params->name). '%');
                });
            }
		} else if ($params->search_type === 'category')
		{
		      $cat = intval($params->category);
		      $query1->with('categories')
                ->whereHas('categories', function ($q) use ($cat) {
                    $q->where('category_id', '=', $cat);
                    $q->orWhere('category_id', 'like', '%,'.$cat. ',%');
                 });
    		  $query2->with('categories')
                ->whereHas('categories', function ($q) use ($cat) {
                    $q->where('category_id', '=', $cat);
                    $q->orWhere('category_id', 'like', '%,'.$cat. ',%');  
               });
    	}
		$query1->where('user_type','=','vendor');
        $goldUsers = $query1->get()->shuffle();
        $query2->where('user_type','=','vendor');
        $simpleUsers = $query2->get()->shuffle();
        $users= $goldUsers->merge($simpleUsers);
        $users = $this->arrayPaginator($users, $params->page, $request);
        return view('pub.connect.index', compact('users', 'params','goldUsers')); 
    }
    
    
    public function searchProfile(Request $request)
    {
        $allCategory = Category::orWhereNotNull('braintree_id')->get();
        foreach($allCategory as $category){
            $allVendorWithCategory[] = $category->category_id;
        }
        $uniqueCategory = implode(',',$allVendorWithCategory);
        $categoryFilter = array_filter(explode(',', $uniqueCategory));
        $uniqueCategories = array_unique($categoryFilter);
        $searlizeCat = VendorCategories::orderBy('name','asc')->get();
        foreach($searlizeCat as $searlizedCategory){
            $seralisedArr[] = $searlizedCategory->id;
        }
       $categoryIndexMap = array_flip($uniqueCategories);
       $orderedCategories = [];
       foreach($seralisedArr as $key => $value){
            if(isset($categoryIndexMap[$value]))
                $orderedCategories[$categoryIndexMap[$value]] = $value;
       }
       if (in_array("19", $orderedCategories)){ 
         $key = array_search ('19', $orderedCategories);
         unset($orderedCategories[$key]); 
         array_push($orderedCategories,"19");
        } 
       foreach($orderedCategories as $catInfo){
          $findVendorCategory[$catInfo]  = VendorCategories::find(intval($catInfo));
        }
      return view('pub.connect.search', compact('findVendorCategory')); 
    }
    
    public function fetchVendorCategory(Request $request){
        $categoryId = intval($request->categoryid);
        $query1 = User::where('user_type','=','vendor')
			->active()->inRandomOrder()
			->with('reviews')->whereNotNull('designation');
		$query2 = User::where('user_type', 'vendor')
			->active()->inRandomOrder()
			->with('reviews')->whereNull('designation');
	    $query1->with('categories')
                ->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('category_id', '=', $categoryId);
                    $q->orWhere('category_id', 'like', '%,'.$categoryId. ',%');
                 });
    	  $query2->with('categories')
            ->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('category_id', '=', $categoryId);
                $q->orWhere('category_id', 'like', '%,'.$categoryId. ',%');  
           });
        $query1->where('user_type','=','vendor');
        $goldUsers = $query1->get()->shuffle();
        $avatarImg = config('upload.user_avatar_avatar');
		$randomDefaultImg = array_random($avatarImg);
	    $query2->where('user_type','vendor');
        $simpleUsers = $query2->get()->shuffle();
       	$users= $goldUsers->merge($simpleUsers);
	    return json_encode($users);
    }
    
    
    public function fetchVendorCategoryUsers($slug){
        $findCatBySlug = VendorCategories::where('slug', '=', $slug)->get();
        if(count($findCatBySlug) > 0){
        $findCat =  VendorCategories::find($findCatBySlug[0]->id); 
        $categoryId = $findCat->id;
        $query = User::where('user_type','=','vendor')
			->active()->inRandomOrder()
			->with('reviews');
	    $query->with('categories')
            ->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('category_id', '=', $categoryId);
                $q->orWhere('category_id', 'like', '%,'.$categoryId. ',%');  
           });
        $query->where('user_type','=','vendor')->whereNotNull('braintree_id');
        $simpleUsers = $query->paginate(20);
        $users = $simpleUsers;
        $selectedCategory = VendorCategories::find($categoryId);
       	return view('pub.connect.vendor', compact('users','selectedCategory')); 
        }else{
            return redirect()->route('pub.connect.searchVendorProfile')->with('error','No such category available.');
        }
    }

}
