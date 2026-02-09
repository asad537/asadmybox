<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\TransportManager;

class CustomMailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Configure SwiftMailer transport after mailer is resolved
        $this->app->resolving('swift.transport', function ($transport) {
            if ($transport instanceof \Swift_SmtpTransport) {
                if (config('mail.timeout')) {
                    $transport->setTimeout(config('mail.timeout'));
                }
                
                if (config('mail.stream')) {
                    $streamOptions = config('mail.stream');
                    $transport->setStreamOptions($streamOptions);
                }
            }
        });
    }
}
