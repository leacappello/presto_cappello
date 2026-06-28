<x-layout>
    <div class="container py-5">

        <h1 class="mb-4">Dashboard Revisore</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($article_to_check)

            <div class="card">
                <div class="card-body">

                    <h2>{{ $article_to_check->title }}</h2>

                    <p>
                        <strong>Prezzo:</strong>
                        € {{ $article_to_check->price }}
                    </p>

                    <p>
                        <strong>Categoria:</strong>
                        {{ $article_to_check->category->name }}
                    </p>

                    <p>
                        <strong>Descrizione:</strong>
                        {{ $article_to_check->description }}
                    </p>

                    <div class="d-flex gap-2">

                        <form method="POST" action="{{ route('revisor.accept_article', $article_to_check) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success">
                                Accetta
                            </button>
                        </form>

                        <form method="POST" action="{{ route('revisor.reject_article', $article_to_check) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-danger">
                                Rifiuta
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        @else

            <p>Non ci sono annunci da revisionare.</p>

        @endif

    </div>
</x-layout>