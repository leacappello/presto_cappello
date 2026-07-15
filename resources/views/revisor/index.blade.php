<x-layout>

    <div class="container py-5">

        <h1 class="mb-4">
            {{ __('ui.revisorDashboard') }}
        </h1>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if ($article_to_check)

            <div class="row">

                <div class="col-12 mb-4">

                    @if ($article_to_check->images->isNotEmpty())

                        <div class="row">

                            @foreach ($article_to_check->images as $image)

                                <div class="col-12 col-md-6 col-lg-4 mb-4">

                                    <div class="card h-100 shadow-sm">

                                        <img
                                            src="{{ $image->getUrl(300, 300) }}"
                                            class="card-img-top"
                                            alt="Immagine {{ $loop->iteration }} dell'articolo {{ $article_to_check->title }}"
                                            style="height: 240px; object-fit: cover;"
                                        >

                                        <div class="card-body">

                                            <h5 class="card-title mb-3">
                                                Analisi immagine {{ $loop->iteration }}
                                            </h5>

                                            <div class="mb-4">

                                                <h6 class="fw-bold mb-2">
                                                    Etichette rilevate
                                                </h6>

                                                @if (!empty($image->labels))

                                                    <div class="d-flex flex-wrap gap-2">

                                                        @foreach ($image->labels as $label)

                                                            <span class="badge bg-primary">
                                                                {{ $label }}
                                                            </span>

                                                        @endforeach

                                                    </div>

                                                @else

                                                    <p class="text-muted fst-italic mb-0">
                                                        Nessuna etichetta disponibile.
                                                    </p>

                                                @endif

                                            </div>

                                            <hr>

                                            <h6 class="fw-bold mb-3">
                                                Analisi Safe Search
                                            </h6>

                                            <div class="row align-items-center mb-2">

                                                <div class="col-10">
                                                    Adult
                                                </div>

                                                <div class="col-2 text-center">

                                                    @if ($image->adult)

                                                        <i
                                                            class="{{ $image->adult }}"
                                                            title="Contenuto per adulti"
                                                            aria-label="Contenuto per adulti"
                                                        ></i>

                                                    @else

                                                        <span
                                                            class="text-muted"
                                                            title="Analisi non disponibile"
                                                        >
                                                            -
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                            <div class="row align-items-center mb-2">

                                                <div class="col-10">
                                                    Violence
                                                </div>

                                                <div class="col-2 text-center">

                                                    @if ($image->violence)

                                                        <i
                                                            class="{{ $image->violence }}"
                                                            title="Contenuto violento"
                                                            aria-label="Contenuto violento"
                                                        ></i>

                                                    @else

                                                        <span
                                                            class="text-muted"
                                                            title="Analisi non disponibile"
                                                        >
                                                            -
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                            <div class="row align-items-center mb-2">

                                                <div class="col-10">
                                                    Spoof
                                                </div>

                                                <div class="col-2 text-center">

                                                    @if ($image->spoof)

                                                        <i
                                                            class="{{ $image->spoof }}"
                                                            title="Contenuto artificiale o alterato"
                                                            aria-label="Contenuto artificiale o alterato"
                                                        ></i>

                                                    @else

                                                        <span
                                                            class="text-muted"
                                                            title="Analisi non disponibile"
                                                        >
                                                            -
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                            <div class="row align-items-center mb-2">

                                                <div class="col-10">
                                                    Racy
                                                </div>

                                                <div class="col-2 text-center">

                                                    @if ($image->racy)

                                                        <i
                                                            class="{{ $image->racy }}"
                                                            title="Contenuto provocante"
                                                            aria-label="Contenuto provocante"
                                                        ></i>

                                                    @else

                                                        <span
                                                            class="text-muted"
                                                            title="Analisi non disponibile"
                                                        >
                                                            -
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                            <div class="row align-items-center">

                                                <div class="col-10">
                                                    Medical
                                                </div>

                                                <div class="col-2 text-center">

                                                    @if ($image->medical)

                                                        <i
                                                            class="{{ $image->medical }}"
                                                            title="Contenuto medico"
                                                            aria-label="Contenuto medico"
                                                        ></i>

                                                    @else

                                                        <span
                                                            class="text-muted"
                                                            title="Analisi non disponibile"
                                                        >
                                                            -
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <img
                            src="https://picsum.photos/900/400"
                            class="img-fluid rounded w-100"
                            alt="Immagine segnaposto"
                            style="height: 350px; object-fit: cover;"
                        >

                    @endif

                </div>

                <div class="col-12">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <h2 class="mb-3">
                                {{ $article_to_check->title }}
                            </h2>

                            <p>
                                <strong>Prezzo:</strong>
                                € {{ number_format($article_to_check->price, 2, ',', '.') }}
                            </p>

                            <p>
                                <strong>Categoria:</strong>
                                {{ __("ui.{$article_to_check->category->name}") }}
                            </p>

                            <p>
                                <strong>Descrizione:</strong>
                                {{ $article_to_check->description }}
                            </p>

                            <div class="d-flex flex-wrap gap-2 mt-4">

                                <form
                                    method="POST"
                                    action="{{ route('accept', $article_to_check) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                    >
                                        Accetta
                                    </button>

                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('reject', $article_to_check) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                    >
                                        Rifiuta
                                    </button>

                                </form>

                            </div>

                        </div>

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