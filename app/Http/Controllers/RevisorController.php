<?php

namespace App\Http\Controllers;

use App\Models\Article;

class RevisorController extends Controller
{
    public function index()
    {
        $article_to_check = Article::where('is_accepted', null)
            ->oldest()
            ->first();

        return view('revisor.index', compact('article_to_check'));
    }

    public function acceptArticle(Article $article)
    {
        $article->update([
            'is_accepted' => true,
        ]);

        return redirect()
            ->route('revisor.index')
            ->with('success', 'Annuncio accettato correttamente.');
    }

    public function rejectArticle(Article $article)
    {
        $article->update([
            'is_accepted' => false,
        ]);

        return redirect()
            ->route('revisor.index')
            ->with('success', 'Annuncio rifiutato correttamente.');
    }
}
