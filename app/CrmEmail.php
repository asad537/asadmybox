<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmEmail extends Model
{
    use SoftDeletes;

    protected $table = 'crm_emails';

    protected $fillable = [
        'product_name',
        'client_name',
        'client_email',
        'client_phone',
        'length',
        'width',
        'height',
        'unit',
        'stock',
        'color',
        'coating',
        'quantity',
        'file_url',
        'message',
        'subject',
        'ip_address',
        'country',
        'is_spam',
        'spam_reason',
        'status', // Added
    ];

    public function statusLogs()
    {
        return $this->hasMany(CrmStatusLog::class, 'crm_email_id');
    }

    public function getCustomerTypeAttribute()
    {
        // Simple optimization: If we've already loaded this, return it.
        // Logic: specific to this instance context?
        if (!$this->client_email) return 'N';

        // Check for any previous emails from this client
        $exists = CrmEmail::where('client_email', $this->client_email)
                          ->where('id', '<', $this->id)
                          ->exists();

        return $exists ? 'RC' : 'N';
    }
}
