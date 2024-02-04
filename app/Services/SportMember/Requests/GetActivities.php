<?php

namespace App\Services\SportMember\Requests;

use App\Services\SportMember\Data\Activity;
use Illuminate\Support\Collection;
use Saloon\Http\Response;
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

    /**
     * @param  Response  $response
     * @return Collection|Activity[]
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        $result = [];

        foreach ($response->json() as $activityData) {
            $result[] = new Activity($activityData);
        }

        return collect($result);
    }


}
