<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container w-25 mt-5">
        <h1 class="text-center">News Finder</h1>
        <form action="/temperature" method="POST" class="my-4">
            @csrf
            <div class="input-group">
                <input type="text" name="place" class="form-control" placeholder="Enter place..." value="{{ old('place') }}">
                <button class="btn btn-primary" type="submit">Fetch News</button>
            </div>
            @error('place')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
            @if($errors->has('error'))
            <div class="text-danger mt-2">{{ $errors->first('error') }}</div>
            @endif
        </form>

        @isset($articles)
        <h3>News for "{{ $place }}"</h3>
        <ul class="list-group mt-3">
            @forelse ($articles as $article)
            <li class="list-group-item">
                <a href="{{ $article['url'] }}" target="_blank">{{ $article['title'] }}</a>
                <p>{{ $article['description'] }}</p>
            </li>
            @empty
            <li class="list-group-item">No news found for this place.</li>
            @endforelse
        </ul>
        @endisset
    </div>
</body>
</html>
