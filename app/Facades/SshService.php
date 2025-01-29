<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\SshService
 */
class SshService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return self::class;
    }
}
