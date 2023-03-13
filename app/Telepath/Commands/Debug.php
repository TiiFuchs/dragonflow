<?php

namespace App\Telepath\Commands;

use Telepath\Bot;
use Telepath\Handlers\Message\Command;
use Telepath\Telegram\Update;

class Debug
{

    public function __construct(
        protected Bot $bot
    ) {}

    #[Command('debug')]
    public function __invoke(Update $update)
    {
        $chatId = $update->message->chat->id;

        $this->bot->sendMessage(
            $update->message->from->id,
            "Chat ID: {$chatId}"
        );
    }

}
