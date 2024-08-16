<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BuyProperty;

class BuyPropertyController extends Controller
{
    /**
     * Buy property page
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    public function index() {
        return view('buy-property');
    }

    /**
     * Store
     * 
     * @since 1.0.0
     * 
     * @return Response
     */
    public function store(Request $request) {
        
        $validator = \Validator::make($request->all(), BuyProperty::$rules, BuyProperty::$messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // TODO: Logic to send email to RO and LO
    }
}
