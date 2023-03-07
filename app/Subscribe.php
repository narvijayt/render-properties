<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $primaryKey = "id";

    protected $table = 'subscriptions';
    protected $fillable = ['user_id','name','braintree_id','braintree_plan','quantity',
                    'ends_at', 'created_at','updated_at'];
}