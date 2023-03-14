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

    public static function temperatureDescription(): string
    {
        return 'Temperatur ≥ 3 ºC';
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

    public static function windSpeedDescription(): string
    {
        return 'Windgeschwindigkeit ≤ 30 km/h';
    }

    /**
     * Water level needs to be at most 230 cm
     *
     * @param  float  $waterLevel
     * @return bool
     */
    public function waterLevel(float $waterLevel): bool
    {
        $check = $waterLevel <= 230;

        $this->clearance = $this->clearance && $check;

        return $check;
    }

    public static function waterLevelDescription(): string
    {
        return 'Wasserstand ≤ 230 cm';
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

    public static function waterFlowrateDescription(): string
    {
        return 'Wasserabfluss ≤ 350 m³/s';
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

    public static function participantsDescription(): string
    {
        return 'Anzahl Teilnehmer:innen ≥ 9';
    }

    public function clearance(): bool
    {
        return $this->clearance;
    }

}
