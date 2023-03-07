<?php

namespace App\Http\Controllers\Pub;

use DB;
use App\User;
use PDOException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Silber\Bouncer\Bouncer;


class SocialReviewsController extends Controller
{
    /**
     * Shows the currently logged on persons reviews
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSocialReviews($type = '')
    {
        $args = array(
            'zws-id'    =>  'X1-ZWz1imr6ozkdmz_8i7yl',
            'screenname'    =>  'Connection Team EXP',
            'count' =>  10,
            'output'    =>  'json',
            'returnTeamMemberReviews'   =>  true
        );
        $queryString = http_build_query($args);
        
        $queryString = (!empty($queryString)) ? "?".$queryString : $queryString;
        
        $url = "http://www.zillow.com/webservice/ProReviews.htm".$queryString;
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $headers = array(
           "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
        
        $responseArray = json_decode($resp);
        // echo '<pre>'; print_r($responseArray); die;
        if($responseArray->message->text == "Request successfully processed"){
            $data['socialReviews'] = $responseArray->response->results;
            return view('pub.socialreviews.zillow', $data);
        }

    }
}