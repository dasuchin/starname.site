<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    protected $table = 'social_logins';

    protected $fillable = [
        'user_id',
        'provider',
        'social_id',
        'avatar'
    ];

    /** Relationships */

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}