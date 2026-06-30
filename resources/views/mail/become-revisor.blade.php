<h1>Richiesta per diventare revisore</h1>

<p>
    L'utente <strong>{{ $user->name }}</strong> ha richiesto di diventare revisore.
</p>

<p>
    <strong>Email:</strong> {{ $user->email }}
</p>

<h3>Messaggio</h3>

<p>
    {{ $userMessage }}
</p>

<hr>

<p>
    Per approvare la richiesta e rendere revisore l'utente, clicca sul link seguente:
</p>

<p>
    <a href="{{ route('make.revisor', $user) }}">
         Rendi revisore {{ $user->name }}
    </a>
</p>