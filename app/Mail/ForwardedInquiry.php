<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\CrmEmail;

class ForwardedInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CrmEmail $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Fwd: Inquiry from ' . $this->email->client_name . ' - ' . ($this->email->subject ?: 'General Inquiry'))
                    ->view('crm.emails.forward_template');
    }
}
