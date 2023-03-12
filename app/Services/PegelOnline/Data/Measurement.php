<?php

namespace App\Services\PegelOnline\Data;

use Carbon\Carbon;
use Saloon\Http\Response;

class Measurement
{

    public function __construct(
        public string $shortname,
        public string $longname,
        public string $unit,
        public string $equidistance,
        public Carbon $timestamp,
        public float $value,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            shortname: $data['shortname'],
            longname: $data['longname'],
            unit: $data['unit'],
            equidistance: $data['equidistance'],
            timestamp: Carbon::parse($data['currentMeasurement']['timestamp']),
            value: $data['currentMeasurement']['value'],
        );
    }

}
