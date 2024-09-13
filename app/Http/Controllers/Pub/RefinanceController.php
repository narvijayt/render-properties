<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Refinance;
use App\Events\RefinanceLeadNotificationEvent;

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


    /**
     * Store
     * 
     * @since 1.0.0
     * 
     * @return Response
     */
    public function store(Request $request) {
        try {

            // Validate forms fields
            $validator = \Validator::make($request->all(), Refinance::$rules, Refinance::$messages);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Save Refinance Form
            $refinanceForm = new Refinance;
            $refinanceForm->type_of_property = $request->type_of_property;
            $refinanceForm->estimate_credit_score = $request->estimate_credit_score;
            $refinanceForm->how_property_used = $request->how_property_used;
            $refinanceForm->have_second_mortgage = $request->have_second_mortgage;
            $refinanceForm->borrow_additional_cash = $request->borrow_additional_cash;
            $refinanceForm->employment_status = $request->employment_status;
            $refinanceForm->bankruptcy_shortscale_foreclosure = $request->bankruptcy_shortscale_foreclosure;
            $refinanceForm->proof_of_income = $request->proof_of_income;
            $refinanceForm->average_monthly_income = $request->average_monthly_income;
            $refinanceForm->average_monthly_expenses = $request->average_monthly_expenses;
            $refinanceForm->currently_have_fha_loan = $request->have_an_fha_loan;
            $refinanceForm->firstName = $request->firstName;
            $refinanceForm->lastName = $request->lastName;
            $refinanceForm->email = $request->email;
            $refinanceForm->phone_number = $request->phoneNumber;
            $refinanceForm->street_address = $request->streetAddress;
            $refinanceForm->street_address_line_2 = $request->streetAddressLine2;
            $refinanceForm->city = $request->city;
            $refinanceForm->state = $request->state;
            $refinanceForm->postal_code = $request->postal_code;
    
            if ($refinanceForm->save()) {

                // Trigger the event
                event(new RefinanceLeadNotificationEvent($refinanceForm));

                // TODO: Redirect to Thankyou page
                return redirect()->back()->with('success', 'Form Submitted Successfully!');

            } else {
                return redirect()->back()->with('error', 'An unexpected error occurred while submitting the form.');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }

    }
}
