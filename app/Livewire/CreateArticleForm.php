<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Livewire\Component;

class CreateArticleForm extends Component
{
    public $title = '';
    public $description = '';
    public $price = '';
    public $category = '';

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|min:10',
        'price' => 'required|numeric',
        'category' => 'required|exists:categories,id',
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
    ];

    public $successMessage = '';

    public function store()
    {
        $this->validate();

        Article::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category,
            'user_id' => auth()->id(),
        ]);

        $this->reset(['title', 'description', 'price', 'category']);

        $this->successMessage = 'Annuncio creato correttamente!';
    }

    public function render()
    {
        return view('livewire.create-article-form', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}