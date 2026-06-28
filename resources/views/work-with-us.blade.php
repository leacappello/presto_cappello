<x-layout>
    <div class="container py-5">
        <h1 class="mb-4">Lavora con noi</h1>

        <p>
            Compila il form per richiedere di diventare revisore degli annunci.
        </p>

        <form method="POST" action="{{ route('work.with.us.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Messaggio</label>
                <textarea
                    name="message"
                    class="form-control"
                    rows="5"
                >{{ old('message') }}</textarea>

                @error('message')
                    <p class="text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Invia richiesta
            </button>
        </form>
    </div>
</x-layout>