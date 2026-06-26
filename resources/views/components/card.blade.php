<div class="card h-100">
    <div class="card-body">
        <h5 class="card-title">{{ $article->title }}</h5>

        <p class="card-text">
            {{ Str::limit($article->description, 80) }}
        </p>

        <p class="fw-bold">
            € {{ $article->price }}
        </p>

        <p>
            Categoria:
            <a href="{{ route('article.byCategory', $article->category) }}">
                {{ $article->category->name }}
            </a>
        </p>

        <a href="{{ route('article.show', $article) }}" class="btn btn-primary">
            Dettaglio
        </a>
    </div>
</div>