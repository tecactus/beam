<?php

namespace Beam\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Beam\Events\NeedsAccountActivationNotification;
use Illuminate\Foundation\Auth\User;
use Beam\Support\Facades\ActivationToken;

trait ActivatesUsers
{
    use RedirectsUsers;

    /**
     * Send an account activation notification
     *
     * @return \Illuminate\Http\Response
     */
    public function sendAccountActivationLink(Request $request)
    {
        if (!$request->user()->active) {
            event(new NeedsAccountActivationNotification($request->user()));
            return redirect()->back()->with('info-alert', trans('beam::auth.account_activation_link_sent'));;
        }
        return redirect()->back();
    }

    /**
     * Handle an account activation request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activateAccount(Request $request, $token = null, $email = null)
    {
        $user = User::where('email', $email)->first();

        if (ActivationToken::exists($token, $email) && $user) {

            $user->active = true;

            $user->save();

            ActivationToken::delete($token);

            if (method_exists($this, 'afterActivation')) {
                $this->afterActivation($user);
            }

            return redirect($this->getAuthCheckRedirectPath())->with('success-alert', trans('beam::auth.account_activation_successfully', ['email' => $email]));
        } else {
            return redirect($this->getAuthCheckRedirectPath())->with('error-alert', trans('beam::auth.account_activation_failed'));
        }
    }
}
