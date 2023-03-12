<b>Aktuelle Pegeldaten:</b>
Wassertemperatur: <b>{{ $waterTemperature->value }} {{ $waterTemperature->unit }}</b>
Lufttemperatur: <b>{{ $airTemperature->value }} {{ $airTemperature->unit }}</b>
Wasserstand: <b>{{ $waterLevel->value }} {{ $waterLevel->unit }}</b>
Strömung: <b>{{ $waterFlow->value }} {{ $waterFlow->unit }}</b>

<i>Quelle: PegelOnline am {{ $waterLevel->timestamp->format('d.m.Y H:i') }} Uhr @ {{ $stationName }}</i>

<b>Vorhersage für Training</b>:
Niedrigste Temperatur: <b>{{ $minimumTemperature }} °C</b>
Höchste Windgeschwindigkeit: <b>{{ $maximumWindSpeed }} km/h</b>

<i>Quelle: DWD für {{ $trainingBegin->format('d.m.Y H:i') }} Uhr - {{ $trainingEnd->format('H:i') }} Uhr</i>
