<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SellProperty;

class SellPropertyController extends Controller
{
    /**
     * Sell property page
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function index() {
        return view('sell-property');
    }

    /**
     * Store
     * 
     * @since 1.0.0
     * 
     * @return Response
     */
    public function store(Request $request) {
        
        $validator = \Validator::make($request->all(), SellProperty::$rules, SellProperty::$messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // TODO: Logic to send email to RO and LO
    }
}
