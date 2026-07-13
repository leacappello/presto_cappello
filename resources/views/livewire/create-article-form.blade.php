<div>
    @if ($successMessage)
        <div class="alert alert-success">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit.prevent="store">

        <div class="mb-3">
            <label class="form-label">Titolo</label>
            <input 
                type="text" 
                class="form-control" 
                wire:model="title"
            >
            @error('title')
                <p class="text-danger mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Descrizione</label>
            <textarea 
                class="form-control" 
                wire:model="description"
            ></textarea>
            @error('description')
                <p class="text-danger mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Prezzo</label>
            <input 
                type="number" 
                step="0.01" 
                class="form-control" 
                wire:model="price"
            >
            @error('price')
                <p class="text-danger mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select 
                class="form-select" 
                wire:model="category"
            >
                <option value="">Seleziona categoria</option>

                @foreach ($categories as $singleCategory)
                    <option value="{{ $singleCategory->id }}">
                        {{ $singleCategory->name }}
                    </option>
                @endforeach
            </select>

            @error('category')
                <p class="text-danger mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
    <label for="images" class="form-label">
        Immagini
    </label>

    <input
        type="file"
        id="images"
        wire:model="temporary_images"
        class="form-control"
        multiple
    >

    @error('temporary_images')
        <p class="text-danger mt-1">
            {{ $message }}
        </p>
    @enderror

    @error('temporary_images.*')
        <p class="text-danger mt-1">
            {{ $message }}
        </p>
    @enderror
</div>

@if (!empty($images))
    <div class="row mb-4">

        @foreach ($images as $key => $image)

            <div
                class="col-6 col-md-3 mb-3"
                wire:key="image-{{ $key }}"
            >
                <div
                    class="img-preview rounded border"
                    style="
                        background-image: url('{{ $image->temporaryUrl() }}');
                        background-position: center;
                        background-size: cover;
                        background-repeat: no-repeat;
                    "
                ></div>

                <button
                    type="button"
                    class="btn btn-danger btn-sm mt-2"
                    wire:click="removeImage({{ $key }})"
                >
                    Rimuovi
                </button>
            </div>

        @endforeach

    </div>
@endif

        <button type="submit" class="btn btn-primary">
            Crea annuncio
        </button>

    </form>
</div>
