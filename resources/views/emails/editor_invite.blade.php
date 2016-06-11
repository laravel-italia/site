<p>Ciao, {{ $user->name }}!</p>

<p>Sei stato invitato tra gli editor di Laravel-Italia.it! Potrai scrivere e proporre nuovi articoli per il portale.</p>

<p>Tutto quello che devi fare, adesso, è scegliere una password! Clicca sul link di seguito per continuare.</p>

<p><a href="{{ url('admin/invitation/' . $user->confirmation_code) }}">{{ url('admin/invitation/' . $user->confirmation_code) }}</a></p>

<p>Grazie!</p>
<p><b>Lo Staff di Laravel-Italia.it</b></p>
