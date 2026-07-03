<x-layout>

    <div class="container py-5">

        <h1 class="mb-4">Dashboard Revisore</h1>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
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

                        <form method="POST" action="{{ route('accept', $article_to_check) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success">
                                Accetta
                            </button>
                        </form>

                        <form method="POST" action="{{ route('reject', $article_to_check) }}">
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

            <div class="alert alert-info">
                Non ci sono annunci da revisionare.
            </div>

        @endif

    </div>

</x-layout>