<?php

namespace TeamZac\BluePay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Teamzac\BluePay\Client
 */
class BluePay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bluepay';
    }
}
