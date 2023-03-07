<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $primaryKey = "id";

    protected $table = 'taxonomies';
    protected $fillable = ['name', 'slug', 'created_at', 'updated_at'];

    static $rules = ['name' => 'required|unique:taxonomies|max:255'];

}