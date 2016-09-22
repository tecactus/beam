<?php

namespace Beam\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Beam\Beam
 */
class Beam extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'beam.main';
    }
}
