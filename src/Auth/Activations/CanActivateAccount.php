<?php

namespace Beam\Auth\Activations;

use Beam\Foundation\Notifications\AccountActivation as AccountActivationNotification;

trait CanActivateAccount
{
    /**
     * Get the e-mail address where account activation links are sent.
     *
     * @return string
     */
    public function getEmailForAccountActivation()
    {
        return $this->email;
    }

    /**
     * Send the account activation notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendAccountActivationNotification($token)
    {
        $notification = config('notification_message', \Beam\Foundation\Notifications\AccountActivation::class);
        $this->notify(new $notification($token, $this->getEmailForAccountActivation()));
    }
}