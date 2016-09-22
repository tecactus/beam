<?php

if (! function_exists('beam_session_alert')) {
    /**
     * Get current Beam session alert.
     *
     * @return array
     */
    function beam_session_alert()
    {
    	$session = null;

    	if (session('success-alert')) {
    		$session = [
    			'class' =>'alert-success',
    			'message' => session('success-alert')
    		];
    	}

    	if (session('info-alert')) {
			$session = [
				'class' =>'alert-info',
				'message' => session('info-alert')
			];
    	}

    	if (session('warning-alert')) {
    		$session = [
    			'class' =>'alert-warning',
    			'message' => session('warning-alert')
    		];
    	}

    	if (session('error-alert')) {
    		$session = [
    			'class' =>'alert-danger',
    			'message' => session('error-alert')
    		];
    	}

        return $session;
    }
}