<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['create']),
        ];
    }

    public function create()
    {
        return view('article.create');
    }

    public function index()
{
    $articles = Article::where('is_accepted', true)
        ->latest()
        ->paginate(6);

    return view('article.index', compact('articles'));
}

    public function show(Article $article)
{
    if (!$article->is_accepted) {
        abort(404);
    }

    return view('article.show', compact('article'));
}

    public function byCategory(Category $category)
{
    $articles = $category->articles()
        ->where('is_accepted', true)
        ->latest()
        ->paginate(6);

    return view('article.byCategory', compact('articles', 'category'));
}

public function searchArticles(Request $request)
{
    $query = $request->input('query');

    if (!$query) {
        return redirect()
            ->route('homepage')
            ->with('message', 'Inserisci un termine di ricerca.');
    }

    $articles = Article::search($query)
        ->get()
        ->where('is_accepted', true);

    return view('article.searched', compact('articles', 'query'));
}

}