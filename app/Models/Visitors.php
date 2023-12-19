<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    use HasFactory;
    protected $fillable = [
        'utm_source',
        'utm_medium',
        'utm_content',
        'utm_term',
        'utm_campaign',
        'referrer',
        'dateTime',
        'country',
        'userAgent',
        'deviceInfo',
        'rcrmVisitorId',
        'sessionId',
    ];
}
