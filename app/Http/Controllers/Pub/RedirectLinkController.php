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
    public function redirectLink($short_url = '') {
        $app_url = config('app.url');
        $findRedirectLink = RedirectLinks::where('short_url_path', $short_url)->first();
        return Redirect::to("$app_url/$findRedirectLink->destination_url_path");
    }
}
