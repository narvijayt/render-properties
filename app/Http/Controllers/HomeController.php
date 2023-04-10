<?php
namespace App\Http\Controllers;
use App\Enums\PageIdEnum;
use App\Page;
use App\Testimonial;
use App\Match;
use App\Message;
use App\Meta;
use App\User;
use DB;
use Cache;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $viewData = Cache::remember('home_page_queries', 20, function() {
            $realtorCount = User::where('user_type','=','realtor')->whereDoesntHave('unmatch_relator', function($q) {
                $q->where('deleted_at', null);
               })->count();
            $brokerCount = User::where('user_type','=','broker')->where('payment_status', 1)->count();
            $messageCount = Message::count();
            $connectionCount = Match::count();
            $messageCount = $messageCount > 121 ? $messageCount : 121;
            $connectionCount = $connectionCount > 31 ? $connectionCount : 31;
            $spotlightUsers = $this->checkUserIp();
            $homePage = Page::find(PageIdEnum::HOME);
            $testimonials = Testimonial::all();
            $getHomepagemeta = Meta::where('page_id','=',PageIdEnum::HOME)->get();
            if($getHomepagemeta->isNotEmpty()){
                $meta = Meta::find($getHomepagemeta[0]->id);
            }else{
                $meta = null;
            }
            return compact('realtorCount', 'brokerCount', 'messageCount', 'connectionCount', 'spotlightUsers','homePage', 'testimonials','meta');
        });
        return view('home', $viewData);
    }
    
    public function checkUserIp(){
        //whether ip is from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
        {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
        $ip = $_SERVER['REMOTE_ADDR'];
        }
        $userDetails = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if(empty($userDetails)){
            $userListing = $this->setDefaultUserListing();
        }else{
            if($userDetails == 'false' || $userDetails['status'] == 'fail' ){
                 $userListing = $this->setDefaultUserListing($userDetails);
            }
            if($userDetails['status'] =='success'){
                $userListing = $this->getIpBasedUsers($userDetails);
            }
        }
        return $userListing;
    }
    
    public function setDefaultUserListing(){ 
        $spotlightRealtors = User::whereNotNull('user_avatar_id')
            ->where('user_type','=','realtor')
            ->where('active','=',true)
            ->inRandomOrder()
            ->whereDoesntHave('unmatch_relator', function($q) {
                $q->where('deleted_at', null);
               })
            ->take(3)
            ->get()
            ->load('reviews');  
          /*$spotlightVendor = User::
            where('user_type','=','vendor')
            ->whereNotNull('braintree_id')
            ->where('active','=',true)
            ->inRandomOrder()
            ->take(1)
            ->get();*/
            $spotlightBrokers = User::whereNotNull('user_avatar_id')
            ->where('user_type','=','broker')
            ->where('payment_status', 1)
            ->where('active','=',true)
            ->inRandomOrder()
            ->get()
            ->load('reviews')
            ->filter(function(User $user) {
            return $user->isPayingCustomer();
            })->take(3);
        // $spotlightUsers = ($spotlightRealtors->merge($spotlightBrokers)->merge($spotlightVendor))->shuffle();
        $spotlightUsers = ($spotlightRealtors->merge($spotlightBrokers))->shuffle();
        return $spotlightUsers;
    }
    
    public function getIpBasedUsers($userDetails){
        $state = $userDetails['region'];
        $spotlightRealtors = User::whereNotNull('user_avatar_id')
            ->where('user_type','=','realtor')
            ->where('active','=',true)
            ->where('state', 'LIKE', '%' . $state . '%')
            ->whereDoesntHave('unmatch_relator', function($q) {
                $q->where('deleted_at', null);
               })
            ->inRandomOrder()
            ->take(3)
            ->get()
            ->load('reviews');
        $spotlightBrokers = User::whereNotNull('user_avatar_id')
            ->where('user_type','=','broker')
            ->where('payment_status', 1)
            ->where('active','=',true)
            ->where('state', 'LIKE', '%' . $state . '%')
            ->inRandomOrder()
            ->get()
            ->load('reviews')
            ->take(3);
         /*$spotlightVendor = User::
             where('user_type','=','vendor')
            ->whereNotNull('braintree_id')
            ->where('active','=',true)
            ->where('state', 'LIKE', '%' . $state . '%')
            ->inRandomOrder()
            ->take(1)
            ->get();*/
        if($spotlightRealtors->isEmpty()){
            $spotlightRealtors = User::whereNotNull('user_avatar_id')
                ->where('user_type','=','realtor')
                ->where('active','=',true)
                ->whereDoesntHave('unmatch_relator', function($q) {
                    $q->where('deleted_at', null);
                   })
                ->inRandomOrder()
                ->take(3)
                ->get()
                ->load('reviews');
        }
        /*if($spotlightVendor->isEmpty()){
             $spotlightVendor = User::
            where('user_type','=','vendor')
            ->whereNotNull('braintree_id')
            ->where('active','=',true)
            ->inRandomOrder()
            ->take(1)
            ->get();
        }*/
        if($spotlightBrokers->isEmpty())
        {
            $spotlightBrokers = User::whereNotNull('user_avatar_id')
            ->where('user_type','=','broker')
            ->where('payment_status', 1)
            ->where('active','=',true)
            ->inRandomOrder()
            ->get()
            ->load('reviews')
            ->filter(function(User $user) {
            return $user->isPayingCustomer();
            })->take(3);  
        }
        // $spotlightUsers = ($spotlightRealtors->merge($spotlightBrokers)->merge($spotlightVendor))->shuffle();
        $spotlightUsers = ($spotlightRealtors->merge($spotlightBrokers))->shuffle();
        return $spotlightUsers;
    }
    
    public function fetchGeolocationUsers(Request $request)
    {
       $lattitude = $request->lat;
       $longitude = $request->long;
       $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lattitude . ',' . $longitude . "&key=" . config('GOOGLE_MAPS_API_KEY') . "&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $loc = json_decode(curl_exec($ch), true);
        dd($loc);
        $location = '';
        if(count($loc['results']) != 0) {
            $city = '';
            $state = '';
            foreach($loc['results'][0]['address_components'] as $addressComponent) {
                if(in_array('locality', $addressComponent['types'])) {
                    $city = $addressComponent['short_name'];
                }
                if(in_array('administrative_area_level_1', $addressComponent['types'])) {
                    $state = $addressComponent['short_name'];
                }
            }
            
            $location = $city . ', ' . $state;
            
        }
    //dd($location);
       // return $location;
    }
}
