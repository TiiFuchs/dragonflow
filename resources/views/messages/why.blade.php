<b>Aktuelle Prüfbedingungen:</b>

{{ $participantsCheck }} {{ $participantsDescription }} <b>({{ $participants }})</b>

<b>Wettervorhersage (DWD)</b>:
{{ $temperatureCheck }} {{ $temperatureDescription }} <b>({{ $minimumTemperature }} ºC)</b>
{{ $windSpeedCheck }} {{ $windSpeedDescription }} <b>({{ $maximumWindSpeed }} km/h)</b>

<b>Aktuelle Pegeldaten (PegelOnline, {{ $waterLevel->timestamp->format('d.m.Y H:i') }} Uhr):</b>
{{ $waterLevelCheck }} {{ $waterLevelDescription }} <b>({{ $waterLevel->value }} {{ $waterLevel->unit }})</b>
{{ $waterFlowrateCheck }} {{ $waterFlowrateDescription }} <b>({{ $waterFlowrate->value }} {{ $waterFlowrate->unit }})</b>
