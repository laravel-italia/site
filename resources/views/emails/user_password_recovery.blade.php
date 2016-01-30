<p>Ciao, {{ $user->name }}!</p>

<p>Ricevi questa mail perchè hai fatto una richiesta di recupero della password per accedere a <strong>Laravel-Italia.it</strong></p>

<p>Clicca sul link di seguito per sceglierne una nuova!</p>

<p><a href="{{ url('auth/reset/' . $token) }}">{{ url('auth/reset/' . $token) }}</a></p>

<p>Grazie!</p>
<p><b>Lo Staff di Laravel-Italia.it</b></p>
