<x-layout>
    <div class="container py-5">
        <h1>{{ $article->title }}</h1>

        <p class="fs-4 fw-bold">
            € {{ $article->price }}
        </p>

        <p>
            Categoria: {{ $article->category->name }}
        </p>

        <p>
            {{ $article->description }}
        </p>

        <div class="my-4">
            <img 
                src="https://picsum.photos/800/400" 
                class="img-fluid rounded" 
                alt="Immagine segnaposto"
            >
        </div>

        <a href="{{ route('article.index') }}" class="btn btn-secondary">
            Torna agli annunci
        </a>
    </div>
</x-layout>