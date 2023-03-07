<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class SocialReview extends Model
{
    protected $primaryKey = "id";

    protected $table = 'users_social_reviews';
    protected $fillable = ['userid', 'created_at', 'updated_at'];

    static $rules = ['userid' => 'required|unique:users_social_reviews'];

}