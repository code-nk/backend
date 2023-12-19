<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignupRecord extends Model
{
    use HasFactory;
    
    protected $table = 'signup_records';

    protected $fillable = [
        'rcrmVisitorId',
        'sessionId',
        'referrer',
        'name',
        'email',
        'utm_source',
        'utm_medium',
        'utm_content',
        'utm_term',
        'utm_campaign',
    ];
}
