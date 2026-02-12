<?php

namespace App\Http\Controllers; // ✅ Zorg dat de controller in de juiste namespace zit

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller; // ✅ Voeg deze toe als je een foutmelding hebt over 'Controller'

class NewsController extends Controller
{
    public function index(): View
    {
        // API-call om nieuwsartikelen op te halen
        $response = Http::get("https://newsapi.org/v2/top-headlines", [
            'apiKey' => env('NEWS_API_KEY'),
            'country' => 'nl',
        ]);

        $articles = $response->json()['articles'] ?? [];

        return view('news.index', compact('articles'));
    }

    public function show($id): View
{
    // API-call om nieuwsartikelen op te halen
    $response = Http::get("https://newsapi.org/v2/top-headlines", [
        'apiKey' => env('NEWS_API_KEY'),
        'country' => 'nl',
    ]);

    $articles = $response->json()['articles'] ?? [];

    // Zoek het artikel met een overeenkomende gecodeerde titel
    $article = collect($articles)->first(function ($article) use ($id) {
        return urlencode($article['title']) === $id;
    });

    if (!$article) {
        abort(404, 'Artikel niet gevonden');
    }

    return view('news.show', compact('article'));
}
}