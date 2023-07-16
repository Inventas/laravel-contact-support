<?php

namespace Inventas\ContactSupport\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Inventas\ContactSupport\ContactSupport
 */
class ContactSupport extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Inventas\ContactSupport\ContactSupport::class;
    }
}
