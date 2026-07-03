<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('homepage') }}">
            PRESTO
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('homepage') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('article.index') }}">
                        Tutti gli annunci
                    </a>
                </li>

                {{-- Questo dropdown lo completeremo nella User Story 2 --}}
                @isset($categories)
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">

                            Categorie

                        </a>

                        <ul class="dropdown-menu">

                            @foreach($categories as $category)

                                <li>

                                    <a class="dropdown-item"
                                       href="{{ route('article.byCategory', $category) }}">

                                        {{ $category->name }}

                                    </a>

                                </li>

                            @endforeach

                        </ul>

                    </li>
                @endisset

            </ul>

            <ul class="navbar-nav">

                @guest

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            Registrati
                        </a>
                    </li>

                @endguest

@auth

    <li class="nav-item">
        <a class="nav-link" href="{{ route('article.create') }}">
            Inserisci annuncio
        </a>
    </li>

    @if(auth()->user()->is_revisor)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('revisor.index') }}">
                Dashboard Revisore
            </a>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('become.revisor') }}">
            Lavora con noi
        </a>
    </li>

    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf

            <button
                type="submit"
                class="btn btn-link nav-link text-white text-decoration-none border-0 p-0">
                Logout
            </button>
        </form>
    </li>

@endauth

            </ul>

        </div>

    </div>
</nav>