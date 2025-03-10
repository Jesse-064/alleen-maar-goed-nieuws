<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function show($id)
    {
        // API-call om het nieuwsbericht op te halen
        $article = Http::get("https://jouw-nieuws-api.com/articles/{$id}")->json();

        // Stuur het artikel naar de view
        return view('news.show', ['article' => $article]);
    }
}
