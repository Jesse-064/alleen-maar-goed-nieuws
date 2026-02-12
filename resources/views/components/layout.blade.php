<!-- resources/views/components/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Alleen Maar Goed Nieuws' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: black;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .container {
            max-width: 800px;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body class="bg-white">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Alleen Maar Goed Nieuws</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('articles.index') }}">Positief Nieuws</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('articles.fetch') }}">Nieuws Updaten</a></li>
                    @endguest
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('articles.index') }}">Positief Nieuws</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('articles.fetch') }}">Nieuws Updaten</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <main>
            <div>
                {{ $slot }}
            </div>
        </main>
    </div>

    <footer class="text-center mt-5 py-3">
        <p>&copy; {{ date('Y') }} Nieuws App - Geselecteerd op goed nieuws 😊</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
