<?php

namespace App\Services\BrightSky\Data;

use Carbon\Carbon;
use Illuminate\Support\Str;

class Forecast
{

    public Carbon $timestamp;

    public int $sourceId;

    public ?int $cloudCover;

    public ?string $condition;

    public ?float $dewPoint;

    public ?string $icon;

    public ?float $precipitation;

    public ?float $pressureMsl;

    public ?int $relativeHumidity;

    public ?float $sunshine;

    public ?float $temperature;

    public ?int $visibility;

    public ?float $windDirection;

    public ?float $windSpeed;

    public ?float $windGustDirection;

    public ?float $windGustSpeed;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $key = Str::camel($key);

            if ($key === 'timestamp') {
                $value = Carbon::parse($value);
            }

            $this->{$key} = $value;
        }
    }

}
