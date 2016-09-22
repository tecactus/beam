<?php

namespace Beam;

use Illuminate\Routing\Router;

class Beam {

	protected $router;
	
	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	public function routes()
	{
		// Authentication Routes...
        $this->router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
        $this->router->post('login', 'Auth\LoginController@login');
        $this->router->post('logout', 'Auth\LoginController@logout');

        // Registration Routes...
        $this->router->get('register', 'Auth\RegisterController@showRegistrationForm');
        $this->router->post('register', 'Auth\RegisterController@register');

        // Activation Routes...
        $this->router->get('activate', 'Auth\ActivationController@sendAccountActivationLink');
        $this->router->get('activate/{token}/{email}', 'Auth\ActivationController@activateAccount');

        // Password Reset Routes...
        $this->router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
        $this->router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
        $this->router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
        $this->router->post('password/reset', 'Auth\ResetPasswordController@reset');
	}
}