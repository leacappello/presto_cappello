<div class="card h-100">

    <img
        src="{{ $article->images->isNotEmpty()
            ? Storage::url($article->images->first()->path)
            : 'https://picsum.photos/500/300' }}"
        class="card-img-top"
        alt="{{ $article->title }}"
        style="height: 220px; object-fit: cover;"
    >

    <div class="card-body">

        <h5 class="card-title">
            {{ $article->title }}
        </h5>

        <p class="card-text">
            {{ \Illuminate\Support\Str::limit($article->description, 80) }}
        </p>

        <p class="fw-bold">
            € {{ number_format($article->price, 2, ',', '.') }}
        </p>

        <p>
            {{ __('ui.categories') }}:

            <a href="{{ route('article.byCategory', $article->category) }}">
                {{ __("ui.{$article->category->name}") }}
            </a>
        </p>

        <a
            href="{{ route('article.show', $article) }}"
            class="btn btn-primary"
        >
            {{ __('ui.details') }}
        </a>

    </div>
</div>