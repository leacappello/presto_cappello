<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ArticleController;

Route::get('/', [PublicController::class, 'homepage'])->name('homepage');

Route::get('/create/article', [ArticleController::class, 'create'])
    ->name('article.create');

Route::get('/articles', [ArticleController::class, 'index'])
    ->name('article.index');

Route::get('/article/{article}', [ArticleController::class, 'show'])
    ->name('article.show');

Route::get('/category/{category}/articles', [ArticleController::class, 'byCategory'])
    ->name('article.byCategory');