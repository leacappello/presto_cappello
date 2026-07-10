<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('homepage') }}">
            PRESTO
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('homepage') }}">
                        {{ __('ui.home') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('article.index') }}">
                        {{ __('ui.allArticles') }}
                    </a>
                </li>

                @isset($categories)
                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ __('ui.categories') }}
                        </a>

                        <ul class="dropdown-menu">

                            @foreach($categories as $category)

                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('article.byCategory', $category) }}"
                                    >
                                        {{ __("ui.{$category->name}") }}
                                    </a>
                                </li>

                            @endforeach

                        </ul>

                    </li>
                @endisset

            </ul>

            <form
                class="d-flex me-3 my-2 my-lg-0"
                role="search"
                action="{{ route('article.search') }}"
                method="GET"
            >
                <input
                    class="form-control me-2"
                    type="search"
                    name="query"
                    value="{{ request('query') }}"
                    placeholder="{{ __('ui.searchPlaceholder') }}"
                    aria-label="{{ __('ui.search') }}"
                >

                <button class="btn btn-outline-light" type="submit">
                    {{ __('ui.search') }}
                </button>
            </form>

            <div class="d-flex align-items-center me-3">
                <x-_locale lang="it" />
                <x-_locale lang="uk" />
                <x-_locale lang="es" />
            </div>

            <ul class="navbar-nav align-items-lg-center">

                @guest

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            {{ __('ui.login') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            {{ __('ui.register') }}
                        </a>
                    </li>

                @endguest

                @auth

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('article.create') }}">
                            {{ __('ui.createArticle') }}
                        </a>
                    </li>

                    @if(auth()->user()->is_revisor)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('revisor.index') }}">
                                {{ __('ui.revisorDashboard') }}

                                <span class="badge bg-danger">
                                    {{ \App\Models\Article::toBeRevisedCount() }}
                                </span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('become.revisor') }}">
                            {{ __('ui.workWithUs') }}
                        </a>
                    </li>

                    <li class="nav-item d-flex align-items-center">
                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                            class="m-0"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-link nav-link text-white text-decoration-none border-0"
                            >
                                {{ __('ui.logout') }}
                            </button>
                        </form>
                    </li>

                @endauth

            </ul>

        </div>

    </div>
</nav>