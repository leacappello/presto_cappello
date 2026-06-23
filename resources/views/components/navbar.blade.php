@guest
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Registrati</a>
@endguest

@auth
    <a href="{{ route('article.create') }}">Inserisci annuncio</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endauth