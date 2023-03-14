<b>Training am {{ $trainingBegin->format('d.m.Y H:i') }} Uhr - {{ $trainingEnd->format('H:i') }} Uhr</b>

{{ $participantsCheck }} Angemeldete Teilnehmer:innen: <b>{{ $participants }}</b>

<b>Wettervorhersage (DWD)</b>:
{{ $temperatureCheck }} Niedrigste Temperatur: <b>{{ $minimumTemperature }} °C</b>
{{ $windSpeedCheck }} Höchste Windgeschwindigkeit: <b>{{ $maximumWindSpeed }} km/h</b>

<b>Aktuelle Pegeldaten (PegelOnline, {{ $waterLevel->timestamp->format('d.m.Y H:i') }} Uhr):</b>
{{ $waterLevelCheck }} Wasserstand: <b>{{ $waterLevel->value }} {{ $waterLevel->unit }}</b>
{{ $waterFlowrateCheck }} Wasserabfluss: <b>{{ $waterFlowrate->value }} {{ $waterFlowrate->unit }}</b>
ℹ️ Wassertemperatur: <b>{{ $waterTemperature->value }} {{ $waterTemperature->unit }}</b>
ℹ️ Lufttemperatur: <b>{{ $airTemperature->value }} {{ $airTemperature->unit }}</b>

@if ($clearance)
👍🏻 <b>Training kann stattfinden.</b>
@else
👎🏻 <b>Training wird NICHT empfohlen.</b>
@endif
