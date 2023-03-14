<?php

namespace App\Services\SportMember\Connectors;

use Saloon\Http\Connector;

class SportMember extends Connector
{

    public function __construct(string $username, string $password)
    {
        $this->withBasicAuth($username, $password);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.holdsport.dk/v1';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

}
