<?php

namespace App\Telepath\Middleware;

use Telepath\Middleware\Middleware;
use Telepath\Telegram\Update;

class OnlyAllowedUsers extends Middleware
{

    public function handle(Update $update, callable $next, array $config = [])
    {
        if (! in_array($update->message->from->id, config('weather.allowed_users'))) {
            return null;
        }

        return $next($update);
    }

}
