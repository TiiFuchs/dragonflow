<?php

namespace App\Services\SportMember\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetTeams extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'teams';
    }

}
