<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telepath\Laravel\Facades\Telepath;
use Telepath\Telegram\BotCommand;

class Install extends Command
{

    protected $signature = 'dragonflow:install';

    protected $description = 'Installs Dragonflow';

    public function handle(): void
    {
        $this->call('telepath:set-webhook');

        $bot = Telepath::bot();
        $bot->setMyCommands($this->botCommands());
    }

    public function botCommands(): array
    {
        return [
            BotCommand::make('check', 'Prüfe Wetter- und Pegeldaten für nächstes Training'),
            BotCommand::make('why', 'Zeige die Prüfbedingungen und die aktuellen Werte an'),
        ];
    }

}
