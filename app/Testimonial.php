<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $primaryKey = "id";

    protected $table = 'testimonials';
    protected $fillable = ['name', 'description','image','created_at', 'updated_at'];

    static $rules = ['name' => 'required|max:255',
                    'description' => 'required' ];
}