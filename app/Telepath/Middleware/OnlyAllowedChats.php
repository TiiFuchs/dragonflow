<?php

namespace App\Telepath\Middleware;

use Illuminate\Support\Facades\Log;
use Telepath\Middleware\Middleware;
use Telepath\Telegram\Update;

class OnlyAllowedChats extends Middleware
{

    public function handle(Update $update, callable $next, array $config = [])
    {
        if (! in_array($update->message?->chat->id, config('dragonflow.allowed_chats'))) {
            $name = $update->message?->chat->title ?? trim("{$update->message?->chat->first_name} {$update->message?->chat->last_name}");
            Log::info("Chat not allowed: {$update->message?->chat->id} ({$name})");
            return null;
        }

        return $next($update);
    }

}
