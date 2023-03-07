<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class NotifyUser extends Model
{
    protected $primaryKey = "id";

    protected $table = 'notify_user';
    protected $fillable = ['email', 'created_at', 'updated_at'];

    protected $rules = ['email' => 'required|unique:notify_user|max:255'];
}