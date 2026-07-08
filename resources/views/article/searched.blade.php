<x-layout>
    <div class="container py-5">

        <h1 class="mb-4">
            Risultati ricerca per: "{{ $query }}"
        </h1>

        <div class="row">

            @forelse($articles as $article)

                <div class="col-12 col-md-4 mb-4">
                    <x-card :article="$article" />
                </div>

            @empty

                <div class="col-12">
                    <p>Nessun annuncio trovato per questa ricerca.</p>
                </div>

            @endforelse

        </div>

    

    </div>
</x-layout>