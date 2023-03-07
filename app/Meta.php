<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $primaryKey = "id";

    protected $table = 'meta';
    protected $fillable = ['page_id', 'keyword', 'description'];

}