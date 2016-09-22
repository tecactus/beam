<?php

namespace Beam\Listeners;

use Beam\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Beam\Support\Facades\ActivationToken;

class SendAccountActivationNotification implements ShouldQueue
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        // here define all the process to create an account confirmation token
        // and send a notification to the user
        // if account activations is enabled
        if (config('beam.enable_activations', false)) {
            $user = $event->user;
            if (!$user->active) {
                $user->sendAccountActivationNotification(
                    ActivationToken::create($user)
                );
            }
        }
    }
}
