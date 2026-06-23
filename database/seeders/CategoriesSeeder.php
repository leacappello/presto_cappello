<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elettronica',
            'Abbigliamento',
            'Casa',
            'Giardino',
            'Motori',
            'Sport',
            'Libri',
            'Musica',
            'Arredamento',
            'Altro',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
