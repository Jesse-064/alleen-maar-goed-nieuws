@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $article['title'] }}</h1>
        <p><strong>Geschreven door:</strong> {{ $article['author'] ?? 'Onbekend' }}</p>
        <p><strong>Datum:</strong> {{ $article['published_at'] ?? 'Onbekend' }}</p>
        <img src="{{ $article['image'] ?? 'https://via.placeholder.com/800x400' }}" alt="Artikel afbeelding" style="max-width: 100%; height: auto;">
        <p>{{ $article['content'] }}</p>
        <a href="{{ $article['url'] }}" target="_blank" class="btn btn-primary">Lees verder op de originele site</a>
    </div>
@endsection
