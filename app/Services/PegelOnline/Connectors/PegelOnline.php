<?php

namespace App\Services\PegelOnline\Connectors;

class PegelOnline extends \Saloon\Http\Connector
{

    public function resolveBaseUrl(): string
    {
        return 'https://www.pegelonline.wsv.de/webservices/rest-api/v2';
    }

}
