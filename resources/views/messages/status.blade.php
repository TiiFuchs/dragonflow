<b>Training am {{ $trainingBegin->format('d.m.Y H:i') }} Uhr - {{ $trainingEnd->format('H:i') }} Uhr</b>

Angemeldete Teilnehmer:innen: <b>{{ $participants }}</b>

<b>Wettervorhersage (DWD)</b>:
Niedrigste Temperatur: <b>{{ $minimumTemperature }} °C</b>
Höchste Windgeschwindigkeit: <b>{{ $maximumWindSpeed }} km/h</b>

<b>Aktuelle Pegeldaten (PegelOnline, {{ $waterLevel->timestamp->format('d.m.Y H:i') }} Uhr):</b>
Wassertemperatur: <b>{{ $waterTemperature->value }} {{ $waterTemperature->unit }}</b>
Lufttemperatur: <b>{{ $airTemperature->value }} {{ $airTemperature->unit }}</b>
Wasserstand: <b>{{ $waterLevel->value }} {{ $waterLevel->unit }}</b>
Strömung: <b>{{ $waterFlow->value }} {{ $waterFlow->unit }}</b>
