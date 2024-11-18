<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Edit Project Specific Style -->
    <link rel="stylesheet" href="{{ asset('css/project_edit.css') }}">
</head>
<body>
<header>
    <h1>Edit Project</h1>
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

    <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ old('description', $project->description) }}</textarea>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            @if ($project->image)
                <p>Current Image:</p>
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" width="150">
            @endif
        </div>
        <div>
            <label for="tags">Select Tags:</label>
            <select name="tags[]" id="tags" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $project->tags->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit">Update Project</button>
    </form>
</main>
</body>
</html>
