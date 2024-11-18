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
    <div class="header-actions">
        <!-- Back to Home Link -->
        <a href="{{ route('home') }}" class="button home-button">Back to Home</a>

        @auth
            @if(Auth::user()->is_admin)
                <!-- Add Project Button -->
                <a href="{{ route('projects.create') }}" class="button add-button">Add Project</a>
            @endif
        @endauth
    </div>
</header>
<main>
    <!-- Filter by Tags -->
    <div class="filter-tags">
        <h3>Filter by Tags:</h3>
        <ul>
            @foreach ($tags as $tag)
                <li>
                    <a href="{{ route('projects.index', ['tag' => $tag->id]) }}" class="tag-filter">{{ $tag->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- List of Projects -->
    <ul>
        @foreach ($projects as $project)
            <li>
                <h2>{{ $project->title }}</h2>
                <p>{{ $project->description }}</p>
                @if ($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="project-img">
                @endif

                <!-- Display Tags for Each Project -->
                <div class="project-tags">
                    @foreach ($project->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                </div>

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
<script src="{{ asset('js/projects_index.js') }}"></script>
</body>
</html>
