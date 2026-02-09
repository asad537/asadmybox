<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrmStatusLog extends Model
{
    protected $table = 'crm_status_logs';

    protected $fillable = [
        'crm_email_id',
        'user_name',
        'old_status',
        'new_status',
    ];

    public function email()
    {
        return $this->belongsTo(CrmEmail::class, 'crm_email_id');
    }
}
