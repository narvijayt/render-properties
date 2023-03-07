<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $primaryKey = "id";

    protected $table = 'states';
    protected $fillable = ['state_code', 'name'];
}