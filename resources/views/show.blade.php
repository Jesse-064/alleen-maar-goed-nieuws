@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card shadow-lg p-4">
                    <h1 class="mb-3 text-primary">{{ $article['title'] ?? 'Geen titel beschikbaar' }}</h1>

                    <p><strong>Bron:</strong> {{ $article['source']['name'] ?? 'Onbekend' }}</p>
                    <p><strong>Geschreven door:</strong> {{ $article['author'] ?? 'Onbekend' }}</p>
                    <p><strong>Publicatiedatum:</strong> {{ $article['publishedAt'] ? \Carbon\Carbon::parse($article['publishedAt'])->format('d M Y, H:i') : 'Onbekend' }}</p>

                    @if (!empty($article['urlToImage']))
                        <img src="{{ $article['urlToImage'] }}" class="img-fluid rounded my-3" alt="Artikel afbeelding">
                    @endif

                    <h3 class="mt-4">Artikel Inhoud</h3>
                    <p class="lead">
                        {{ $article['content'] ?? $article['description'] ?? 'Geen extra informatie beschikbaar.' }}
                    </p>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('news.index') }}" class="btn btn-secondary">
                            Terug naar alle nieuwsartikelen
                        </a>

                        @if (!empty($article['url']))
                            <a href="{{ $article['url'] }}" target="_blank" class="btn btn-primary">
                                Lees verder op de originele site
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
