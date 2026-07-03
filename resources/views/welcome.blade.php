<x-layout>

    @if (session('message'))
        <div class="container mt-3">
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <div class="container py-5 text-center">

        <h1>Benvenuto su Presto</h1>

        <p>Inserisci o cerca annunci nella piattaforma.</p>

        <a href="{{ route('article.create') }}" class="btn btn-primary">
            Inserisci annuncio
        </a>

    </div>

    <section class="container py-5">

        <h2 class="mb-4">Ultimi annunci</h2>

        <div class="row">

            @forelse($articles as $article)

                <div class="col-12 col-md-4 mb-4">

                    <x-card :article="$article" />

                </div>

            @empty

                <div class="col-12">
                    <p>Nessun annuncio presente.</p>
                </div>

            @endforelse

        </div>

    </section>

</x-layout>
