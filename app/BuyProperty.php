<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyProperty extends Model
{
    static $rules = [
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required|email',
        'city' => 'required',
        'state' => 'required',
        'postal_code' => 'required',
    ];
    
    static $messages = [
        'firstName.required' => 'First Name field is required.',
        'lastName.required' => 'Last Name field is required.',
        'email.required' => 'The User Email must be a valid email address.',
        'city.required' => 'City field is required.',
        'state.required' => 'State field is required.',
        'postal_code.required' => 'Postal Code field is required.',
    ];

}
