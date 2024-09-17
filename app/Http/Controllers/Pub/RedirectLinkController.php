<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RedirectLinks;
use Illuminate\Support\Facades\Redirect;

class RedirectLinkController extends Controller
{
    /**
    * Redirect Link
    * 
    * @since 1.0.0
    * 
    * @return html
    */
    // http://127.0.0.1:8000/r/R7NmC9
    // http://127.0.0.1:8000/r/kD0AvE
    // http://127.0.0.1:8000/r/lCPq4j
    // http://127.0.0.1:8000/r/GG6LLV
    // http://127.0.0.1:8000/r/aSxgKz
    public function redirectLink($short_url = '') {
        $app_url = config('app.url');
        $findRedirectLink = RedirectLinks::where('short_url_path', $short_url)->first();
        $segments = explode('/', $findRedirectLink->destination_url_path);
        $getPosition = substr($findRedirectLink->destination_url_path, 0, 28);
        
        if ($getPosition == "profile/leads/property/view/" || $getPosition == "profile/leads/refinance/view") {
            return Redirect::to("$app_url/$findRedirectLink->destination_url_path");
        }

        if ($segments[1] == "refinance-leads") {
            return Redirect::to("$app_url/profile/leads/refinance/view/$segments[3]");

        } else if ($segments[1] == "leads") {
            return Redirect::to("$app_url/profile/leads/property/view/$segments[3]");
        }
    }
}
