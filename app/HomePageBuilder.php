<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomePageBuilder extends Model
{
    protected $table = 'home_page_builder';

    static $rules = [
        'banner' => 'required',
        'section1' => 'required',
        'section2' => 'required',
        'section3' => 'required',
        'section4' => 'required',
        'section5' => 'required',
    ];
    

}
