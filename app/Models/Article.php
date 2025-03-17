<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // Toegestane mass assignment velden
    protected $fillable = [
        'title',
        'content',
        'url',
        'source',
        'sentiment'
    ];

    // Zorg ervoor dat timestamps werken
    public $timestamps = true;

    // Zorg ervoor dat de 'url' uniek is bij het opslaan
    public static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            // Controleer of het artikel al bestaat op basis van de URL
            $existing = Article::where('url', $article->url)->exists(); // Gebruik exists() om efficiënter te controleren
            if ($existing) {
                throw new \Exception('Artikel met deze URL bestaat al.');
            }
        });
    }

    // Scope om alleen positieve artikelen op te halen
    public function scopeSentiment($query, $sentiment)
    {
        return $query->where('sentiment', $sentiment);
    }
}
