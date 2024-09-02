<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class LeadNotificationRelationships extends Model
{
    const PKEY = 'id';
    protected $table = "lead_notification_relationships";
	protected $primaryKey = self::PKEY;

    protected $fillable = ['property_form_id', 'agent_id', 'notification_type'];

    /**
     * Relationship of Agent Id with the users table
     * 
     * @since 1.0.0
     * 
     * @return Collection|Object
     */
    public function getAgentDetails() {
        return $this->hasOne(User::class, 'user_id', 'agent_id');
    }
}
