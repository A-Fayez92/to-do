<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailProvider extends Model
{
    protected $fillable = [
        'name',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'timeout',
        'local_domain',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
