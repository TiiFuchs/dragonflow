<?php

namespace App\Services\PegelOnline\Requests;

use App\Services\PegelOnline\Data\Station;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetMeasurements extends Request
{

    protected Method $method = Method::GET;

    public function __construct(
        protected string $stationId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/stations/{$this->stationId}.json";
    }

    protected function defaultQuery(): array
    {
        return [
            'includeTimeseries'         => 'true',
            'includeCurrentMeasurement' => 'true',
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Station::fromResponse($response);
    }


}
