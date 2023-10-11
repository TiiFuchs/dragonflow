<?php

namespace App\Telepath\Commands;

use App\Mail\TrainingCancellation;
use App\Mail\TrainingConfirmation;
use App\Telepath\Middleware\OnlyAllowedChats;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Telepath\Bot;
use Telepath\Handlers\Message\Command;
use Telepath\Middleware\Attributes\Middleware;

#[Middleware((OnlyAllowedChats::class))]
class TrainingNotification
{

    public function __construct(
        protected Bot $bot,
    ) {}

    #[Command('zusage')]
    public function confirmation(): void
    {

        $this->sendMessage(view('messages.training-confirmation')->render());

        $this->sendMail(new TrainingConfirmation());

    }

    #[Command('absage')]
    public function cancellation(): void
    {

        $this->sendMessage(view('messages.training-cancellation')->render());

        $this->sendMail(new TrainingCancellation());

    }

    protected function sendMessage(string $text): void
    {
        $chatId = config('dragonflow.member_group');

        if ($chatId === null) {
            Log::warning('dragonflow.member_group config variable is not set.');
            return;
        }

        $this->bot->sendMessage($chatId, $text, parse_mode: 'MarkdownV2');
    }

    protected function sendMail(Mailable $mail): void
    {
        $address = config('dragonflow.mail_to');

        if ($address === null) {
            Log::warning('dragonflow.mail_to config variable is not set.');
            return;
        }

        Mail::to($address)->send($mail);
    }

}
