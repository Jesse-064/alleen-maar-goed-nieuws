<x-layout :title="$filter === 'positive' ? 'Positief Nieuws' : 'Nieuws'">
    <header class="bg-white mb-4">
        <h1 class="mb-4">{{ $filter === 'positive' ? 'Positief Nieuws' : 'Alle Nieuws' }}</h1>
    </header>

    <!-- Filter links -->
    <div class="mb-3">
    <form action="{{ route('articles.fetch') }}" method="GET">

<div class="mb-3">
    <label for="category" class="form-label">Select Category</label>
    <select name="category" id="category" class="form-select">
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
        @endforeach
    </select>
</div>
</form>
        <button type="submit" class="btn btn-primary">Fetch News</button>
        <a href="{{ route('articles.index', ['filter' => 'positive']) }}" class="btn btn-primary @if($filter === 'positive') disabled @endif">Positief Nieuws</a>
        <a href="{{ route('articles.index', ['filter' => 'all']) }}" class="btn btn-secondary @if($filter === 'all') disabled @endif">Alle Nieuws</a>
    </div>

    <!-- Button to fetch all news articles -->
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
                    <h5><a href="{{ $article->url }}" target="_blank">{{ $article->title }}</a></h5>
                    <p>{{ $article->content }}</p>
                    <small class="text-muted">Bron: {{ $article->source }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</x-layout>