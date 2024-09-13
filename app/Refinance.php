<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RefinanceNotificationRelationships;

class Refinance extends Model
{
    protected $table = 'refinance_form';

    static $rules = [
        'type_of_property' => 'required',
        'estimate_credit_score' => 'required',
        'how_property_used' => 'required',
        'have_second_mortgage' => 'required',
        'borrow_additional_cash' => 'required',
        'employment_status' => 'required',
        'bankruptcy_shortscale_foreclosure' => 'required',
        'proof_of_income' => 'required',
        'average_monthly_income' => 'required',
        'average_monthly_expenses' => 'required',
        'have_an_fha_loan' => 'required',
        'firstName' => 'required',
        'lastName' => 'required',
        'phoneNumber' => 'required|us_phone_regex',
        'streetAddress' => 'required',
        'city' => 'required',
        'state' => 'required',
        'postal_code' => 'required|numeric',
        'g-recaptcha-response' => 'required',
    ];
    
    static $messages = [
        'type_of_property.required' => 'Type of property you are refinancing field is required.',
        'estimate_credit_score.required' => 'Estimate your credit score field is required.',
        'how_property_used.required' => 'How will this property be used field is required.',
        'have_second_mortgage.required' => 'Have second mortgage field is required.',
        'borrow_additional_cash.required' => 'Borrow additional cash field is required.',
        'employment_status.required' => 'Employment status field is required.',
        'bankruptcy_shortscale_foreclosure.required' => 'Bankruptcy, short sale, or foreclosure in the last 3 years field is required.',
        'proof_of_income.required' => 'Proof of income field is required.',
        'average_monthly_income.required' => 'Average monthly income field is required.',
        'average_monthly_expenses.required' => 'Average monthly expenses field is required.',
        'have_an_fha_loan.required' => 'Currently have an FHA loan field is required.',
        'firstName.required' => 'First Name field is required.',
        'lastName.required' => 'Last Name field is required.',
        'phoneNumber.required' => 'The Phone number field is required.',
        'phoneNumber.us_phone_regex' => 'Please enter a valid phone number.',
        'streetAddress.required' => 'Street Address field is required.',
        'city.required' => 'City field is required.',
        'state.required' => 'State field is required.',
        'postal_code.required' => 'Postal Code field is required.',
        'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
    ];

     /**
     * Relationship of Refinance Form which were sent to broker of the particular area.
     * 
     * @since 1.0.0
     * 
     * @return Collection|Object
     */
    public function areLeadsVisible() {
        return $this->hasMany(RefinanceNotificationRelationships::class, 'refinance_form_id', 'id');
    }

}
