<?php

namespace Beam\Foundation\Auth;
use Illuminate\Foundation\Auth\RedirectsUsers as IlluminateRedirectsUsers;

trait RedirectsUsers
{
	use IlluminateRedirectsUsers;
    /**
     * Return redirection path when auth guard is checked
     * @return string
     */
    public function redirectPathWhenLoggedIn()
    {
        return property_exists($this, 'redirectToWhenLoggedIn') ? $this->redirectToWhenLoggedIn : '/home';
    }

    public function getAuthCheckRedirectPath()
    {
    	return auth($this->getGuard())->check() ? $this->redirectPathWhenLoggedIn() : $this->redirectPath();
    }

    public function getGuard()
    {
    	return property_exists($this, 'guard') ? $this->guard : null;
    }
}