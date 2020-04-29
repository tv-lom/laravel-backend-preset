<?php

namespace Toyza55k\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class Backend extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'backend';
    }
}
