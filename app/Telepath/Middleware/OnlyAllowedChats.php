<?php

namespace App\Telepath\Middleware;

use Telepath\Middleware\Middleware;
use Telepath\Telegram\Update;

class OnlyAllowedChats extends Middleware
{

    public function handle(Update $update, callable $next, array $config = [])
    {
        if (! in_array($update->message?->chat->id, config('dragonflow.allowed_chats'))) {
            return null;
        }

        return $next($update);
    }

}
