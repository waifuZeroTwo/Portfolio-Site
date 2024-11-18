<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Projects Index Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/projects_create.css') }}">
</head>
<body>
<header>
    <h1>Add New Project</h1>
</header>
<main>
    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
        </div>
        <button type="submit">Add Project</button>
    </form>
</main>
</body>
</html>
