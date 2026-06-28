<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RevisorController;
use App\Http\Controllers\WorkWithUsController;

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
    ->middleware(['auth', 'isRevisor'])
    ->name('revisor.index');

Route::patch('/accept/article/{article}', [RevisorController::class, 'acceptArticle'])
    ->middleware(['auth', 'isRevisor'])
    ->name('revisor.accept_article');

Route::patch('/reject/article/{article}', [RevisorController::class, 'rejectArticle'])
    ->middleware(['auth', 'isRevisor'])
    ->name('revisor.reject_article');

Route::get('/lavora-con-noi', [WorkWithUsController::class, 'create'])
    ->middleware('auth')
    ->name('work.with.us');

Route::post('/lavora-con-noi', [WorkWithUsController::class, 'store'])
    ->middleware('auth')
    ->name('work.with.us.store');    