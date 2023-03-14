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

    #[Command('test')]
    public function chatId(Update $update)
    {
        $tii = $update->message->from->id;
        if ($tii !== 397304) {
            return;
        }

        $chatId = $update->message->chat->id;

        $this->bot->sendMessage(
            $tii,
            "Chat ID is: {$chatId}"
        );
    }

}
