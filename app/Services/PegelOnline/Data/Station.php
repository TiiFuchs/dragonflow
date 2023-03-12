<?php

namespace App\Services\PegelOnline\Data;

use Saloon\Http\Response;

class Station
{

    public function __construct(
        public string $uuid,
        public string $number,
        public string $name,
        public float $km,
        public string $agency,
        public float $longitude,
        public float $latitude,
        public string $water,
        public ?array $measurements,
    ) {}

    public static function fromResponse(Response $response)
    {
        $measurements = [];
        foreach ($response->json('timeseries') as $timeseries) {
            $shortname = $timeseries['shortname'];
            $measurements[$shortname] = Measurement::fromArray($timeseries);
        }

        return new static(
            uuid: $response->json('uuid'),
            number: $response->json('number'),
            name: $response->json('longname'),
            km: $response->json('km'),
            agency: $response->json('agency'),
            longitude: $response->json('longitude'),
            latitude: $response->json('latitude'),
            water: $response->json('water.longname'),
            measurements: $measurements,
        );
    }

}
