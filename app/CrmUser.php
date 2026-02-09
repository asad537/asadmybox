<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CrmUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'crm_users';

    protected $fillable = [
        'name', 'email', 'password', 'role', 'allowed_ip',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSales()
    {
        return $this->role === 'sales';
    }
}
