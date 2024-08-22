<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadNotificationRelationships extends Model
{
    const PKEY = 'id';
    protected $table = "lead_notification_relationships";
	protected $primaryKey = self::PKEY;

    protected $fillable = ['property_form_id', 'agent_id', 'notification_type'];
}
