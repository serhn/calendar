<?php

namespace LaravelEnso\Calendar\App\Dynamics\Relations;

use Closure;
use LaravelEnso\Calendar\App\Models\Calendar;
use LaravelEnso\DynamicMethods\App\Contracts\Method;

class Calendars implements Method
{
    public function name(): string
    {
        return 'calendars';
    }

    public function closure(): Closure
    {
        return fn () => $this
            ->hasMany(Calendar::class, 'created_by');
    }
}
