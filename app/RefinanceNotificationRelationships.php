<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Refinance;

class RefinanceNotificationRelationships extends Model
{
    const PKEY = 'id';
    protected $table = "refinance_lead_notification_relationships";
	protected $primaryKey = self::PKEY;

    protected $fillable = ['refinance_form_id', 'agent_id', 'notification_type'];

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

    /**
     * Relationship of refinance form Id with the refinance form table
     * 
     * @since 1.0.0
     * 
     * @return Collection|Object
     */
    public function refinanceFormDetails() {
        return $this->hasOne(Refinance::class, 'id', 'refinance_form_id');
    }
}
