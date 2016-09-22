<?php

namespace Beam\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Beam\Auth\Activations\ActivationTokenRepository
 */
class ActivationToken extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'activations.repository';
    }
}
