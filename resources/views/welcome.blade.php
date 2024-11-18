<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<header class="header">
    <div class="container">
        <h1 class="site-title">Welcome to My Portfolio</h1>
        <p class="site-subtitle">Discover my projects and creativity.</p>
        <nav class="nav">
            @auth
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link logout-button">Logout</button>
                </form>

                <!-- Link to Add Project (Only for Admin) -->
                @if(Auth::user()->is_admin)
                    <a href="{{ route('projects.create') }}" class="nav-link">Add Project</a>
                @endif

                <!-- Link to Project Index -->
                <a href="{{ route('projects.index') }}" class="nav-link">View Projects</a>
            @else
                <!-- Login and Register Buttons -->
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-link">Register</a>
            @endauth
        </nav>
    </div>
</header>
<main>
    <section id="about" class="section">
        <div class="container">
            <h2 class="section-title">About Me</h2>
            <p class="section-text">I am a passionate developer eager to showcase my skills and creativity. My work focuses on delivering high-quality solutions with a touch of innovation.</p>
        </div>
    </section>
    <section id="projects" class="section">
        <h2>My Projects</h2>
        <div class="project-list">
            @foreach ($projects as $project)
                <div class="project">
                    <h3>{{ $project->title }}</h3>
                    <p>{{ $project->description }}</p>
                    @if ($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                    @endif

                    <!-- Buttons for Admin to Update or Delete -->
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
                </div>
            @endforeach
        </div>
    </section>
</main>
<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} My Portfolio. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
