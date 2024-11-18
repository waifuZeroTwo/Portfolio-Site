<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tags</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tags_index.css') }}">
</head>
<body>
<header>
    <h1>Manage Tags</h1>
    <!-- Back to Home Button -->
    <a href="{{ route('home') }}" class="back-to-home">Back to Home</a>
</header>
<main>
    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul class="errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Create Tag Form -->
    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <label for="name">New Tag:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Add Tag</button>
    </form>

    <!-- List of Tags -->
    <h2>Existing Tags</h2>
    <ul>
        @foreach ($tags as $tag)
            <li>
                {{ $tag->name }}
                <form action="{{ route('tags.destroy', $tag) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this tag?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</main>
</body>
</html>
