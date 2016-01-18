<?php

namespace Smarch\Amazo\Facades;

use Illuminate\Support\Facades\Facade;

class AmazoFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amazo';
    }
}