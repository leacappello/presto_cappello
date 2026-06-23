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

        <button type="submit" class="btn btn-primary">
            Crea annuncio
        </button>

    </form>
</div>
