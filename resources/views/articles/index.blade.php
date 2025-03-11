@extends('layouts.app')

@section('title', $filter === 'positive' ? 'Positief Nieuws' : 'Nieuws')

@section('content')
    <h1 class="mb-4">{{ $filter === 'positive' ? 'Positief Nieuws' : 'Alle Nieuws' }}</h1>

    <!-- Filter links -->
    <div class="mb-3">
        <a href="{{ route('articles.index', ['filter' => 'positive']) }}" class="btn btn-primary @if($filter === 'positive') disabled @endif">Positief Nieuws</a>
        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Alle Nieuws</a>
    </div>

    <!-- Knop om alle nieuwsartikelen op te halen -->
    <form action="{{ route('articles.fetchAll') }}" method="POST" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-success">Haal alle nieuwsartikelen op</button>
    </form>

    @if($articles->isEmpty())
        <p class="text-muted">Geen nieuws gevonden. Probeer de nieuwsupdate-knop.</p>
    @else
        <ul class="list-group">
            @foreach($articles as $article)
                <li class="list-group-item">
                    <h5>
                    <a href="{{ route('articles.show', ['id' => $article->id]) }}">
                            {{ $article->title }}
                        </a>
                    </h5>
                    <p>{{ $article->content }}</p>
                    <small class="text-muted">Bron: {{ $article->source }}</small>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
