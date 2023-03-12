<?php

namespace App\Services\BrightSky;

use Saloon\Http\Connector;

class BrightSky extends Connector
{

    public function resolveBaseUrl(): string
    {
        return 'https://api.brightsky.dev/';
    }

}
