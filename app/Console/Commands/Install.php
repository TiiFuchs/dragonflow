<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telepath\Bot;
use Telepath\Laravel\Facades\Telepath;
use Telepath\Telegram\BotCommand;
use Telepath\Telegram\BotCommandScopeChat;
use Telepath\Telegram\BotCommandScopeDefault;

class Install extends Command
{

    protected $signature = 'dragonflow:install';

    protected $description = 'Installs Dragonflow';

    public function handle(): void
    {
        $this->call('telepath:set-webhook');

        $bot = Telepath::bot();

        $this->setCommands($bot);
    }

    public function botCommands(): array
    {
        return [
            BotCommand::make('check', 'Prüfe Wetter- und Pegeldaten für nächstes Training'),
            BotCommand::make('why', 'Zeige die Prüfbedingungen und die aktuellen Werte an'),
        ];
    }

    protected function setCommands(Bot $bot): void
    {
        $success = $bot->setMyCommands([], BotCommandScopeDefault::make());
        foreach (config('dragonflow.allowed_chats') as $chat) {
            $success = $success &&
                $bot->setMyCommands($this->botCommands(), BotCommandScopeChat::make($chat));
        }

        if ($success) {
            $this->info('Bot Commands set');
        } else {
            $this->warn('Bot Commands could not be set');
        }
    }

}
