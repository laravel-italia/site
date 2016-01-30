<p>Ciao, {{ $user->name }}!</p>

<p>Grazie per esserti iscritto a <strong>Laravel-Italia.it</strong>, è un vero piacere averti tra noi!</p>

<p>Tutto quello che devi fare è confermare il tuo account cliccando sul seguente collegamento.</p>

<p><a href="{{ url('auth/confirm/' . $user->confirmation_code) }}">{{ url('auth/confirm/' . $user->confirmation_code) }}</a></p>

<p>Grazie!</p>
<p><b>Lo Staff di Laravel-Italia.it</b></p>
