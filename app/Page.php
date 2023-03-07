<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $primaryKey = "id";

    protected $table = 'pages';
    protected $fillable = ['title', 'created_at', 'updated_at'];

    static $rules = ['title' => 'required|unique:pages|max:255'];

}