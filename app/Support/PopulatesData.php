<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait PopulatesData
{

    private function populateData(array $data)
    {
        $properties = (new \ReflectionClass($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $key = Str::snake($property->name);

            if (! isset($data[$key])) {
                continue;
            }

            $value = match ($property->getType()->getName()) {
                CarbonImmutable::class => CarbonImmutable::parse($data[$key]),
                Collection::class      => collect($data[$key]),
                default                => $data[$key]
            };

            $this->{$property->name} = $value;
        }
    }

}
