<?php

namespace App\Services\SportMember\Data;

use App\Services\SportMember\Connectors\SportMember;
use App\Services\SportMember\Requests\GetActivities;
use App\Support\PopulatesData;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Activity
{

    use PopulatesData;

    public int $id;

    public bool $club;

    public bool $department;

    public string $name;

    public CarbonImmutable $starttime;

    public CarbonImmutable $endtime;

    public string $comment;

    public string $place;

    public string $pickupPlace;

    public CarbonImmutable $pickupTime;

    public int $status;

    public int $registrationType;

    public Collection $actions;

    public string $actionPath;

    public string $actionMethod;

    public Collection $activitiesUsers;

    public Collection $comments;

    public int $maxAttendees;

    public int $noRsvpCount;

    public Collection $noRsvp;

    public bool $ride;

    public string $rideComment;

    public Collection $rides;

    public bool $showRideButton;

    public string $eventType;

    public int $eventTypeId;

    public function __construct(array $data)
    {
        $this->populateData($data);
    }

    /**
     * @return Collection|static[]
     */
    public static function all(): Collection
    {
        return Cache::remember(
            'dragonflow.activites',
            now()->addMinutes(30),
            function () {
                $sportmember = new SportMember(
                    config('dragonflow.sportmember.username'),
                    config('dragonflow.sportmember.password'),
                );

                $response = $sportmember->send(new GetActivities(
                    config('dragonflow.sportmember.team')
                ));

                return $response->dto();
            }
        );
    }

    /**
     * @return Collection|static[]
     */
    public static function trainings(): Collection
    {
        return static::all()
            ->filter(fn(Activity $activity) => $activity->name === 'Training');
    }

}
