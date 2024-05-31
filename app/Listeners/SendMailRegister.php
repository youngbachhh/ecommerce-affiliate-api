<?php

namespace App\Listeners;

use App\Events\EventRegister;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Mail\Mailer;

class SendMailRegister implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EventRegister  $event
     * @return void
     */
    public function handle(EventRegister $event)
    {
        $user = $event->user;
        $otp = $event->otp;
        $this->mailer->send('emails.register', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
            $message->to($user['email'])
                ->subject('Your OTP Code');
        });
    }
}
