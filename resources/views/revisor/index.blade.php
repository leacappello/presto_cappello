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

                                <div class="col-6 col-md-4 col-lg-2 mb-3">

                                    <img
                                        src="{{ Storage::url($image->path) }}"
                                        class="img-fluid rounded w-100"
                                        alt="{{ $article_to_check->title }}"
                                        style="height: 160px; object-fit: cover;"
                                    >

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

                    <div class="card">
                        <div class="card-body">

                            <h2>
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

                            <div class="d-flex gap-2">

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