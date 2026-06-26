<x-layout>
    <div class="container py-5">
        <h1 class="mb-4">
            Annunci categoria: {{ $category->name }}
        </h1>

        <div class="row">
            @forelse ($articles as $article)
                <div class="col-12 col-md-4 mb-4">
                    <x-card :article="$article" />
                </div>
            @empty
                <p>Nessun annuncio per questa categoria.</p>
            @endforelse
        </div>

        {{ $articles->links() }}
    </div>
</x-layout>