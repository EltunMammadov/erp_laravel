<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_logs';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'success',
        'created_at',
    ];
}
