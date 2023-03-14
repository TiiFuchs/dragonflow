<?php

namespace App\Jobs;

use App\Services\SportMember\Data\Activity;
use App\Services\Training;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use OpenAI\Client;

class NudgeForTrainingJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Fetch how many members are registered
        /** @var Activity $nextTraining */
        $nextTraining = Activity::trainings()->first();

        if (! $nextTraining->starttime->isTomorrow()) {
            // Only nudge if training is tomorrow
            Log::debug('Training is not tomorrow.');
            return;
        }

        $registrations = $nextTraining->activitiesUsers
            ->filter(fn($registration) => $registration['status_code'] === 1)
            ->count();

        if ((new Training)->participants($registrations)) {
            // There are already enough registrations
            Log::debug('There are already enough participants.');
            return;
        }

        // Nudge in group
        \Telepath::bot()->sendMessage(
            chat_id: config('dragonflow.member_group'),
            text: $this->composeMessageText(),
        );
    }

    protected function composeMessageText(): string
    {
        $result = resolve(Client::class)->completions()->create([
            'model'       => 'text-davinci-003',
            'prompt'      => view('prompts.register_for_training')->render(),
            'max_tokens'  => 150,
            'temperature' => 0.7,
        ]);

        return $result['choices'][0]['text'];
    }

}
