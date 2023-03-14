<?php

namespace App\Services;

class Training
{

    protected bool $clearance = true;

    /**
     * Temperature needs to be at least 3 ºC
     *
     * @param  float  $temperature
     * @return bool
     */
    public function temperature(float $temperature)
    {
        $check = $temperature >= 3;

        $this->clearance = $this->clearance && $check;

        return $check;
    }

    /**
     * Wind speed needs to be at most 30 km/h
     *
     * @param  float  $windSpeed
     * @return bool
     */
    public function windSpeed(float $windSpeed)
    {
        $check = $windSpeed <= 30;

        $this->clearance = $this->clearance && $check;

        return $check;
    }

    /**
     * Water level must not deviate by more than 1.5 m from the mean value.
     *
     * @param  float  $waterLevel
     * @return bool
     */
    public function waterLevel(float $waterLevel): bool
    {
        $meanValue = 177;
        $check = abs($meanValue - $waterLevel) <= 1.5;

        $this->clearance = $this->clearance && $check;

        return $check;
    }

    /**
     * Water flowrate needs to be at most 350 m³/s
     *
     * @param  float  $waterFlow
     * @return bool
     */
    public function waterFlowrate(float $waterFlow)
    {
        $check = $waterFlow <= 350;

        $this->clearance = $this->clearance && $check;

        return $check;
    }

    /**
     * Number of participants needs to be at least 8 plus steersman
     *
     * @param  int  $participants
     * @return bool
     */
    public function participants(int $participants)
    {
        $check = $participants >= 9;

        $this->clearance = $this->clearance && $check;

        return $check;
    }

    public function clearance(): bool
    {
        return $this->clearance;
    }

}
