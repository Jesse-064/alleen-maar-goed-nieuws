@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="mb-3">{{ $article['title'] ?? 'Geen titel beschikbaar' }}</h1>
                
                <p><strong>Geschreven door:</strong> {{ $article['author'] ?? 'Onbekend' }}</p>
                <p><strong>Publicatiedatum:</strong> {{ $article['published_at'] ?? 'Onbekend' }}</p>

                <img src="{{ $article['image'] ?? 'https://via.placeholder.com/800x400' }}" 
                     alt="Artikel afbeelding" class="img-fluid mb-3">

                <h3>Artikel Inhoud</h3>
                @if(!empty($article['full_text']))
                    <p>{{ $article['full_text'] }}</p>
                @elseif(!empty($article['content']))
                    <p>{{ $article['content'] }}</p>
                @else
                    <p>Geen extra informatie beschikbaar.</p>
                @endif

                <hr>

                <h3>Origineel Artikel</h3>
                @if(!empty($article['url']))
                    <iframe src="{{ $article['url'] }}" width="100%" height="600px" style="border: none;"></iframe>

                    <a href="{{ $article['url'] }}" target="_blank" class="btn btn-primary mt-3">
                        Open in een nieuw tabblad
                    </a>
                @else
                    <p>Geen originele link beschikbaar.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
