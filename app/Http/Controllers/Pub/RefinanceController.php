<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefinanceController extends Controller
{
    /**
     * Refinance Your Home Loan Form
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function index() {
        return view('pub.refinance-home-loan.index');
    }
}
