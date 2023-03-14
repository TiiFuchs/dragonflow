<?php

namespace App\Services\SportMember\Requests;

use Saloon\Enums\Method;

class GetActivities extends \Saloon\Http\Request
{

    protected Method $method = Method::GET;

    public function __construct(
        protected string $teamId,
    ) {}

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return "teams/{$this->teamId}/activities";
    }

}
