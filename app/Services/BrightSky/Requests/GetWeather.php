<?php

namespace App\Services\BrightSky\Requests;

use App\Services\BrightSky\Data\Forecast;
use Carbon\CarbonInterface;
use Saloon\Http\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetWeather extends Request
{

    protected Method $method = Method::GET;

    public function __construct(
        protected string $lat,
        protected string $lon,
        protected CarbonInterface $from,
        protected CarbonInterface $to,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'weather';
    }

    protected function defaultQuery(): array
    {
        return [
            'tz'   => 'Europe/Berlin',
            'lat'  => $this->lat,
            'lon'  => $this->lon,
            'date' => $this->from->toIso8601String(),
            'last_date'   => $this->to->toIso8601String(),
        ];
    }

    /**
     * @param  Response  $response
     * @return Forecast[]
     */
    public function createDtoFromResponse(Response $response): array
    {

        $data = $response->json();

        $forecasts = [];
        foreach ($data['weather'] as $weather) {
            $forecasts[] = new Forecast($weather);
        }

        return $forecasts;

    }


}
