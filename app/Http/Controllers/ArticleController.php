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
        // Voer de API-aanroep uit om nieuws op te halen
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'us',
            'category' => 'business',
            'apiKey' => env('NEWS_API_KEY'),
        ]);

        // Log de volledige response om te zien wat er terugkomt
        Log::info('API Response:', $response->json());

        // Controleer of de API-aanroep succesvol was
        if (!$response->successful()) {
            Log::error('API-aanroep mislukt', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return back()->with('error', 'Kon geen nieuws ophalen. Controleer je API-sleutel.');
        }

        // Haal de artikelen uit de response
        $articles = $response->json()['articles'] ?? [];

        if (empty($articles)) {
            Log::warning('Geen nieuwsartikelen gevonden.');
            return back()->with('error', 'Geen nieuwsartikelen gevonden.');
        }

        // Verwerk en sla de artikelen op in de database
        foreach ($articles as $news) {
            if (!isset($news['title'], $news['url'], $news['source']['name'])) {
                continue; // Sla onvolledige artikelen over
            }

            // Voer de sentimentanalyse uit
            $sentiment = $this->analyzeSentiment($news['title'], $news['url']);

            // Log het artikel dat wordt opgeslagen
            Log::info('Artikel wordt opgeslagen:', ['url' => $news['url'], 'title' => $news['title']]);

            // Update of creëer een nieuw artikel
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

        // Redirect naar de artikelpagina met een succesbericht
        return redirect()->route('articles.index')->with('success', 'Nieuws succesvol bijgewerkt!');
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
            'great',
            'fantastic',
            'success',
            'happiness',
            'beautiful',
            'hopeful',
            'gain',
            'prosperous',
            'optimistic',
            'happy',
            'win',
            'progress',
            'breakthrough'
        ];

        $text = mb_strtolower($text);
        $url = mb_strtolower($url);

        // Zoek naar positieve woorden in de titel
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
        // Haal het filter op uit de querystring ('all' of 'positive')
        $filter = $request->query('filter', 'all');

        // Als het filter 'positive' is, haal alleen positieve artikelen op
        $articles = $filter === 'positive'
            ? Article::sentiment('positive')->latest()->get()  // Gebruik de sentiment scope
            : Article::latest()->get();  // Haal alle artikelen op

        // Log de opgehaalde artikelen
        Log::info('Opgehaalde artikelen:', $articles->toArray());

        // Geef de artikelen door aan de view
        return view('articles.index', compact('articles', 'filter'));
    }
}
