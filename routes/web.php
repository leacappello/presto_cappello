<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RevisorController;

Route::get('/', [PublicController::class, 'homepage'])->name('homepage');

Route::get('/create/article', [ArticleController::class, 'create'])
    ->name('article.create');

Route::get('/articles', [ArticleController::class, 'index'])
    ->name('article.index');

Route::get('/article/{article}', [ArticleController::class, 'show'])
    ->name('article.show');

Route::get('/category/{category}/articles', [ArticleController::class, 'byCategory'])
    ->name('article.byCategory');

Route::get('/revisor/index', [RevisorController::class, 'index'])
    ->middleware('isRevisor')
    ->name('revisor.index');

Route::patch('/accept/{article}', [RevisorController::class, 'accept'])
    ->middleware('isRevisor')
    ->name('accept');

Route::patch('/reject/{article}', [RevisorController::class, 'reject'])
    ->middleware('isRevisor')
    ->name('reject');

Route::get('/revisor/request', [RevisorController::class, 'becomeRevisor'])
    ->middleware('auth')
    ->name('become.revisor');

Route::get('/make/revisor/{user}', [RevisorController::class, 'makeRevisor'])
    ->name('make.revisor');