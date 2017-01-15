<p>Ciao, {{ $user->name }}!</p>

<p>Ricevi questa mail perchè hai fatto una richiesta di registrazione per "{{ $mapEntry->name }}" sulla Mappa di Laravel-Italia.</p>

<p>Tutto quello che ti rimane da fare è confermare questa richiesta, cliccando su questo link:</p>

<p><a href="{{ url('mappa/conferma/' . $mapEntry->confirmation_token) }}">{{ url('mappa/conferma/' . $mapEntry->confirmation_token) }}</a></p>

<p>Grazie!</p>
<p><b>Lo Staff di Laravel-Italia.it</b></p>
