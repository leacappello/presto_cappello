<x-layout>

    <div class="container py-5">

        <div class="row">

            <div class="col-12 col-lg-7 mb-4">

                @if ($article->images->isNotEmpty())

                    <div
                        id="articleCarousel"
                        class="carousel slide"
                        data-bs-ride="carousel"
                    >

                        <div class="carousel-inner">

                           @foreach ($article->images as $image)

                         <div class="carousel-item @if($loop->first) active @endif">

                                <img
                                       src="{{ $image->getUrl(300, 300) }}"
                                       class="d-block w-100 rounded"
                                       alt="{{ $article->title }}"
                                       style="height: 450px; object-fit: cover;"
                                >

                        </div>

                           @endforeach

                        </div>

                        @if ($article->images->count() > 1)

                            <button
                                class="carousel-control-prev"
                                type="button"
                                data-bs-target="#articleCarousel"
                                data-bs-slide="prev"
                            >
                                <span
                                    class="carousel-control-prev-icon"
                                    aria-hidden="true"
                                ></span>

                                <span class="visually-hidden">
                                    Previous
                                </span>
                            </button>

                            <button
                                class="carousel-control-next"
                                type="button"
                                data-bs-target="#articleCarousel"
                                data-bs-slide="next"
                            >
                                <span
                                    class="carousel-control-next-icon"
                                    aria-hidden="true"
                                ></span>

                                <span class="visually-hidden">
                                    Next
                                </span>
                            </button>

                        @endif

                    </div>

                @else

                    <img
                        src="https://picsum.photos/900/600"
                        class="img-fluid rounded w-100"
                        alt="Immagine segnaposto"
                        style="height: 450px; object-fit: cover;"
                    >

                @endif

            </div>

            <div class="col-12 col-lg-5">

                <h1>{{ $article->title }}</h1>

                <p class="fs-3 fw-bold">
                    € {{ number_format($article->price, 2, ',', '.') }}
                </p>

                <p>
                    <strong>{{ __('ui.categories') }}:</strong>

                    <a href="{{ route('article.byCategory', $article->category) }}">
                        {{ __("ui.{$article->category->name}") }}
                    </a>
                </p>

                <p>
                    {{ $article->description }}
                </p>

                <a
                    href="{{ route('article.index') }}"
                    class="btn btn-secondary"
                >
                    {{ __('ui.allArticles') }}
                </a>

            </div>

        </div>

    </div>

</x-layout>