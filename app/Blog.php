<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $primaryKey = "id";

    protected $table = 'blogs';
    protected $fillable = ['title', 'created_at', 'updated_at'];

    static $rules = ['title' => 'required|unique:blogs|max:255'];

}