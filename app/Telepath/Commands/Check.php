<?php

namespace App\Telepath\Commands;

use App\Services\BrightSky\BrightSky;
use App\Services\BrightSky\Data\Forecast;
use App\Services\BrightSky\Requests\GetWeather;
use App\Services\PegelOnline\Connectors\PegelOnline;
use App\Services\PegelOnline\Data\Station;
use App\Services\PegelOnline\Requests\GetMeasurements;
use App\Telepath\Middleware\OnlyAllowedUsers;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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
    #[Middleware(OnlyAllowedUsers::class)]
    public function __invoke(Update $update)
    {
        $pegelOnlineData = $this->getPegelOnlineData();
        $weatherData = $this->getBrightSkyData();

        $minimumTemperature = $weatherData->pluck('temperature')->min();
        $maximumWindSpeed = $weatherData->pluck('windSpeed')->max();

        $this->bot->sendMessage(
            $update->message->chat->id,
            view('messages.status', [
                'trainingBegin'      => new Carbon('monday 19:00'),
                'trainingEnd'        => new Carbon('monday 21:00'),

                // PegelOnline data
                'stationName'        => Str::headline($pegelOnlineData->name),
                'waterTemperature'   => $pegelOnlineData->measurements['WT'],
                'airTemperature'     => $pegelOnlineData->measurements['LT'],
                'waterLevel'         => $pegelOnlineData->measurements['W'],
                'waterFlow'          => $pegelOnlineData->measurements['Q'],

                // DWD data
                'minimumTemperature' => $minimumTemperature,
                'maximumWindSpeed'   => $maximumWindSpeed,
            ]),
            parse_mode: 'HTML',
        );

    }

    protected function getPegelOnlineData(): Station
    {
        $station = config('weather.pegelonline.station');

        $connector = new PegelOnline();
        $response = $connector->send(new GetMeasurements($station));

        return $response->dto();
    }

    /**
     * @return Collection|Forecast[]
     */
    protected function getBrightSkyData(): Collection
    {

        $from = new Carbon('monday 20:00'); // 19-20 Uhr
        $to = new Carbon('monday 21:00');   // 20-21 Uhr

        $connector = new BrightSky();
        $response = $connector->send(new GetWeather(
            lat: config('weather.dwd.latitude'),
            lon: config('weather.dwd.longitude'),
            from: $from,
            to: $to,
        ));

        return collect($response->dto());
    }

}
