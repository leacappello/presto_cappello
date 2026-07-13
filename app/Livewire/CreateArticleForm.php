<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateArticleForm extends Component
{
    use WithFileUploads;

    public $temporary_images = [];

    public $images = [];

    public $title = '';

    public $description = '';

    public $price = '';

    public $category = '';

    public $successMessage = '';

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|min:10',
        'price' => 'required|numeric',
        'category' => 'required|exists:categories,id',
        'images' => 'max:6',
        'images.*' => 'image|max:1024',
    ];

    protected $messages = [
        'title.required' => 'Il titolo è obbligatorio.',
        'title.min' => 'Il titolo deve contenere almeno 3 caratteri.',

        'description.required' => 'La descrizione è obbligatoria.',
        'description.min' => 'La descrizione deve contenere almeno 10 caratteri.',

        'price.required' => 'Il prezzo è obbligatorio.',
        'price.numeric' => 'Il prezzo deve essere un numero.',

        'category.required' => 'La categoria è obbligatoria.',
        'category.exists' => 'La categoria selezionata non è valida.',

        'temporary_images.max' => 'Puoi caricare al massimo 6 immagini.',
        'temporary_images.*.image' => 'Ogni file deve essere un’immagine.',
        'temporary_images.*.max' => 'Ogni immagine non può superare 1 MB.',

        'images.max' => 'Puoi caricare al massimo 6 immagini.',
        'images.*.image' => 'Ogni file deve essere un’immagine.',
        'images.*.max' => 'Ogni immagine non può superare 1 MB.',
    ];

    public function updatedTemporaryImages()
    {
        $this->validate([
            'temporary_images' => 'max:6',
            'temporary_images.*' => 'image|max:1024',
        ]);

        foreach ($this->temporary_images as $image) {
            if (count($this->images) < 6) {
                $this->images[] = $image;
            }
        }

        $this->temporary_images = [];
    }

    public function removeImage($key)
    {
        if (array_key_exists($key, $this->images)) {
            unset($this->images[$key]);

            $this->images = array_values($this->images);
        }
    }

    public function store()
    {
        $this->validate();

        $article = Article::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category,
            'user_id' => auth()->id(),
        ]);

        foreach ($this->images as $image) {
            $article->images()->create([
                'path' => $image->store('images', 'public'),
            ]);
        }

        $this->cleanForm();

        $this->successMessage = 'Annuncio creato correttamente!';
    }

    protected function cleanForm()
    {
        $this->reset([
            'title',
            'description',
            'price',
            'category',
            'temporary_images',
            'images',
        ]);
    }

    public function render()
    {
        return view('livewire.create-article-form', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}