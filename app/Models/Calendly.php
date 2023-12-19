<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendly extends Model
{
    protected $table = "calendly_records";
    protected $fillable = [
        'cancel_url',
        'email',
        'name',
        'reschedule_url',
        'rescheduled',
        'status',
        'text_reminder_number',
        'timezone',
        'start_time',
        'membership_user',
        'membership_email',
        'guest_email',
        'end_time',
        'uri',
        'event_id',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'event_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
