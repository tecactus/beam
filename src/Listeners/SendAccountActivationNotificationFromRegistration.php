<?php

namespace Beam\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Beam\Support\Facades\ActivationToken;

class SendAccountActivationNotificationFromRegistration implements ShouldQueue
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
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // here define all the process to create an account confirmation token
        // and send a notification to the user
        // if account activations is enabled
        if (config('beam.enable_activations', false)) {
            $user = $event->user;
            $user->sendAccountActivationNotification(
                ActivationToken::create($user)
            );
        }
    }
}
