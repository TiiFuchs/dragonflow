<?php

namespace App\Telepath\Commands;

use App\Services\BrightSky\BrightSky;
use App\Services\BrightSky\Data\Forecast;
use App\Services\BrightSky\Requests\GetWeather;
use App\Services\PegelOnline\Connectors\PegelOnline;
use App\Services\PegelOnline\Data\Station;
use App\Services\PegelOnline\Requests\GetMeasurements;
use App\Services\SportMember\Connectors\SportMember;
use App\Services\SportMember\Requests\GetActivities;
use App\Services\Training;
use App\Telepath\Middleware\OnlyAllowedChats;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Telepath\Bot;
use Telepath\Handlers\Message\Command;
use Telepath\Middleware\Attributes\Middleware;
use Telepath\Telegram\Update;

class Check
{

    public function __construct(
        protected Bot $bot,
    ) {}

    #[Command('check')]
    #[Middleware(OnlyAllowedChats::class)]
    public function __invoke(Update $update)
    {
        $check = new Training;

        // Training data
        $training = $this->getTrainingData();

        // Pegel Online data
        $pegelOnlineData = $this->getPegelOnlineData();
        $waterTemperature = $pegelOnlineData->measurements['WT'];
        $airTemperature = $pegelOnlineData->measurements['LT'];
        $waterLevel = $pegelOnlineData->measurements['W'];
        $waterFlowrate = $pegelOnlineData->measurements['Q'];

        // DWD data
        $weatherData = $this->getBrightSkyData(
            $training['starttime'],
            $training['endtime'],
        );
        $minimumTemperature = $weatherData->pluck('temperature')->min();
        $maximumWindSpeed = $weatherData->pluck('windSpeed')->max();

        $this->bot->sendMessage(
            $update->message->chat->id,
            view('messages.status', [
                // Training data
                'trainingBegin'      => $training['starttime'],
                'trainingEnd'        => $training['endtime'],
                'participants'       => $training['participants'],

                // PegelOnline data
                'stationName'        => Str::headline($pegelOnlineData->name),
                'waterTemperature'   => $waterTemperature,
                'airTemperature'     => $airTemperature,
                'waterLevel'         => $waterLevel,
                'waterFlowrate'      => $waterFlowrate,

                // DWD data
                'minimumTemperature' => $minimumTemperature,
                'maximumWindSpeed'   => $maximumWindSpeed,

                // Check results
                'participantsCheck'  => $this->displayCheckResult($check->participants($training['participants'])),
                'temperatureCheck'   => $this->displayCheckResult($check->temperature($minimumTemperature)),
                'windSpeedCheck'     => $this->displayCheckResult($check->windSpeed($maximumWindSpeed)),
                'waterLevelCheck'    => $this->displayCheckResult($check->waterLevel($waterLevel->value)),
                'waterFlowCheck'     => $this->displayCheckResult($check->waterFlowrate($waterFlowrate->value)),

                // Overall check result
                'clearance'          => $check->clearance(),
            ]),
            parse_mode: 'HTML',
        );

    }

    protected function displayCheckResult(bool $value): string
    {
        return $value ? '✅' : '❌';
    }

    /**
     * @return array{ starttime: CarbonImmutable, endtime: CarbonImmutable, participants: int }
     */
    protected function getTrainingData(): array
    {
        $activities = Cache::remember(
            'dragonflow.training',
            now()->addHours(6),
            function () {
                $sportmember = new SportMember(
                    config('dragonflow.sportmember.username'),
                    config('dragonflow.sportmember.password'),
                );

                $response = $sportmember->send(new GetActivities(
                    config('dragonflow.sportmember.team')
                ));

                return $response->json();
            }
        );

        $training = collect($activities)
            ->filter(fn($activity) => $activity['name'] === 'Training')
            ->first();

        return [
            'starttime'    => CarbonImmutable::parse($training['starttime']),
            'endtime'      => CarbonImmutable::parse($training['endtime']),
            'participants' => collect($training['activities_users'])
                ->filter(fn($action) => $action['status_code'] === 1)
                ->count(),
        ];
    }

    protected function getPegelOnlineData(): Station
    {
        $data = Cache::remember(
            'dragonflow.pegelonline',
            now()->addMinutes(15),
            function () {
                $station = config('dragonflow.pegelonline.station');

                $connector = new PegelOnline();
                $response = $connector->send(new GetMeasurements($station));

                return $response->dto();
            }
        );

        return $data;
    }

    /**
     * @return Collection|Forecast[]
     */
    protected function getBrightSkyData(CarbonInterface $from, CarbonInterface $to): Collection
    {
        $from = $from->addSecond()->ceilHour();

        $data = Cache::remember(
            "dragonflow.brightsky.{$from->timestamp}.{$to->timestamp}",
            now()->addMinutes(30),
            function () use ($from, $to) {
                $connector = new BrightSky();
                $response = $connector->send(new GetWeather(
                        lat: config('dragonflow.dwd.latitude'),
                        lon: config('dragonflow.dwd.longitude'),
                        from: $from,
                        to: $to,
                    )
                );

                return collect($response->dto());
            }
        );

        return $data;
    }

}
