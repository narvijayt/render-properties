<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LeadNotificationRelationships;

class BuySellProperty extends Model
{
    protected $table = 'buy_sell_property';

    static $rules = [
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
     * Relationship of Buy/Sell Property which were sent to realtors and broker of the particular area.
     * 
     * @since 1.0.0
     * 
     * @return Collection|Object
     */
    public function areLeadsVisible() {
        return $this->hasMany(LeadNotificationRelationships::class, 'property_form_id', 'id');
    }
}
