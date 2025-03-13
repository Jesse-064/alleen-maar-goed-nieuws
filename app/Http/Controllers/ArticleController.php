<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Haal nieuwsartikelen op en sla ze op in de database.
     */
    public function fetchNews()
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'us',
            'category' => 'business',
            'apiKey' => env('NEWS_API_KEY'),
        ]);

        Log::info('API Response:', $response->json());

        if (!$response->successful()) {
            Log::error('API-aanroep mislukt', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return back()->with('error', 'Kon geen nieuws ophalen. Controleer je API-sleutel.');
        }

        $articles = $response->json()['articles'] ?? [];

        if (empty($articles)) {
            Log::warning('Geen nieuwsartikelen gevonden.');
            return back()->with('error', 'Geen nieuwsartikelen gevonden.');
        }

        $this->storeArticles($articles);

        return redirect()->route('articles.index')->with('success', 'Nieuws succesvol bijgewerkt!');
    }

    /**
     * Haal alle nieuwsartikelen op zonder beperkingen.
     */
    public function fetchAllNews()
    {
        $response = Http::get('https://newsapi.org/v2/everything', [
            'apiKey' => env('NEWS_API_KEY'),
            'language' => 'en',
            'sortBy' => 'publishedAt',
            'from' => now()->subDays(7)->format('Y-m-d'),
            'pageSize' => 50,
            'q' => 'breaking news' // Nodige parameter om bredere zoekopdrachten toe te staan
        ]);

        if (!$response->successful()) {
            Log::error('API-aanroep mislukt', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return back()->with('error', 'Kon geen nieuws ophalen.');
        }

        $articles = $response->json()['articles'] ?? [];

        if (empty($articles)) {
            return back()->with('error', 'Geen nieuwsartikelen gevonden.');
        }

        $this->storeArticles($articles);

        return redirect()->route('articles.index')->with('success', 'Alle nieuwsartikelen opgehaald!');
    }

    /**
     * Sla artikelen op in de database als ze nog niet bestaan.
     */
    private function storeArticles($articles)
    {
        foreach ($articles as $news) {
            if (!isset($news['title'], $news['url'], $news['source']['name'])) {
                continue;
            }

            $sentiment = $this->analyzeSentiment($news['title'], $news['url']);

            Log::info('Artikel wordt opgeslagen:', ['url' => $news['url'], 'title' => $news['title']]);

            Article::updateOrCreate(
                ['url' => $news['url']],
                [
                    'title' => $news['title'],
                    'content' => $news['description'] ?? 'Geen beschrijving beschikbaar.',
                    'source' => $news['source']['name'],
                    'sentiment' => $sentiment,
                ]
            );
        }
    }

    /**
     * Sentimentanalyse voor een nieuwsartikel.
     */
    private function analyzeSentiment($text, $url)
    {
        if (empty($text) || !is_string($text)) {
            return 'neutral';
        }

        $positiveWords = [
            'great', 'fantastic', 'success', 'happiness', 'beautiful',
            'hopeful', 'gain', 'prosperous', 'optimistic', 'happy',
            'win', 'progress', 'breakthrough'
        ];

        $text = mb_strtolower($text);
        $url = mb_strtolower($url);

        foreach ($positiveWords as $word) {
            if (stripos($text, $word) !== false || stripos($url, $word) !== false) {
                return 'positive';
            }
        }

        return 'neutral';
    }

    /**
     * Toon alle artikelen (of gefilterd op positief nieuws).
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $articles = $filter === 'positive'
            ? Article::where('sentiment', 'positive')->latest()->get()
            : Article::latest()->get();

        Log::info('Opgehaalde artikelen:', $articles->toArray());

        return view('articles.index', compact('articles', 'filter'));
    }
}
