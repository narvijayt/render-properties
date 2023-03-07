<?php

namespace App\Http\Controllers;
use App\VendorCategories;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Controller constructor.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $allcat = VendorCategories::all();
       View::share('allcat', $allcat);
    }
}
