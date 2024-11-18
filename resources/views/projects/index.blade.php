<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project_index.css') }}">
</head>
<body>
<header>
    <h1>All Projects</h1>
</header>
<main>
    <ul>
        @foreach ($projects as $project)
            <li>
                <h2>{{ $project->title }}</h2>
                <p>{{ $project->description }}</p>
                @if ($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="project-img">
                @endif

                <!-- Buttons for Edit and Delete (Visible to Admins) -->
                @if(Auth::check() && Auth::user()->is_admin)
                    <div class="project-actions">
                        <!-- Edit Button -->
                        <a href="{{ route('projects.edit', $project) }}" class="button edit-button">Edit</a>

                        <!-- Delete Form -->
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this project?')">
                            @csrf
                            @method('DELETE')
                            <input type="text" name="confirmation_name" placeholder="Type '{{ $project->title }}' to confirm" required>
                            <button type="submit" class="button delete-button">Delete</button>
                        </form>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</main>
</body>
</html>
