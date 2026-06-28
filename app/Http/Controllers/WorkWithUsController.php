<?php

namespace App\Http\Controllers;

use App\Mail\BecomeRevisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WorkWithUsController extends Controller
{
    public function create()
    {
        return view('work-with-us');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|min:10',
        ]);

        Mail::to('admin@presto.it')->send(new BecomeRevisor(auth()->user(), $request->message));

        return redirect()
            ->route('homepage')
            ->with('success', 'Richiesta inviata correttamente.');
    }
}