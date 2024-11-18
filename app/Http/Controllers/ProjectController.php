<?php

namespace App\Http\Controllers;

use App\Models\Project; // Import the Project model
use App\Models\Tag; // Import the Tag model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('id', $request->tag);
            });
        }

        $projects = $query->get();
        $tags = Tag::all();

        return view('projects.index', compact('projects', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $tags = Tag::all(); // Fetch all available tags

        return view('projects.create', compact('tags'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Allow GIFs up to 5 MB
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id', // Ensure all submitted tags exist
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project = Project::create($validated);

        // Attach tags to the new project
        if ($request->has('tags')) {
            $project->tags()->sync($request->tags);
        }

        return redirect()->route('projects.index')->with('success', 'Project added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        // Fetch all available tags
        $tags = Tag::all();

        // Pass the project and tags to the edit view
        return view('projects.edit', compact('project', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id', // Ensure all submitted tags exist in the database
        ]);

        // Update the project data
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($project->image) {
                Storage::delete('public/' . $project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($validated);

        // Synchronize tags
        if ($request->has('tags')) {
            $project->tags()->sync($request->tags);
        } else {
            $project->tags()->detach(); // Remove all tags if none are submitted
        }

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Project $project)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'confirmation_name' => 'required|string',
        ]);

        if ($request->confirmation_name !== $project->title) {
            return redirect()->back()->withErrors(['confirmation_name' => 'Project name does not match.']);
        }

        // Delete the image if it exists
        if ($project->image) {
            Storage::delete('public/' . $project->image);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }
}
