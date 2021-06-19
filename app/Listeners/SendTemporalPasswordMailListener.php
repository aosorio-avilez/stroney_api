<?php

namespace App\Listeners;

use App\Events\SendResetPassword;
use App\Events\SendTemporalPassword;
use App\Notifications\TemporalPassword;
use Illuminate\Support\Facades\Notification;

class SendTemporalPasswordMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendResetPassword  $event
     * @return void
     */
    public function handle(SendTemporalPassword $event)
    {
        if (env('APP_ENV') != 'testing') {
            Notification::locale('es')->send(
                [$event->user],
                new TemporalPassword($event->user, $event->temporalPassword)
            );
        }
    }
}
