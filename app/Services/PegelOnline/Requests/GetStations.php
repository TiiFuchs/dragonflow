<?php

namespace App\Services\PegelOnline\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetStations extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/stations.json';
    }

}
