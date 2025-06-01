<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $projects = Project::with(['images', 'mainImage'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Projects/Index', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return Inertia::render('Admin/Projects/Create');
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        // Debug: Log incoming request data
        \Log::info('Project store request data:', [
            'all_data' => $request->all(),
            'files' => $request->allFiles(),
            'has_images' => $request->hasFile('images'),
            'images_count' => $request->hasFile('images') ? count($request->file('images')) : 0
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'technologies' => ['required', 'array'],
            'technologies.*' => ['string', 'max:255'],
            'is_visible' => ['nullable', 'string', 'in:0,1'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        \Log::info('Validated data:', $validated);

        // Create the project
        $project = Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'technologies' => $validated['technologies'],
            'is_visible' => ($validated['is_visible'] ?? '1') === '1',
        ]);

        \Log::info('Project created:', ['project_id' => $project->id]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            \Log::info('Processing images...');
            $firstImageId = null;
            
            foreach ($request->file('images') as $index => $imageFile) {
                \Log::info("Processing image {$index}:", [
                    'original_name' => $imageFile->getClientOriginalName(),
                    'size' => $imageFile->getSize(),
                    'mime_type' => $imageFile->getMimeType()
                ]);

                $path = $imageFile->store('projects/images', 'public');
                \Log::info("Image stored at: {$path}");
                
                $image = $project->images()->create([
                    'image_path' => $path,
                ]);
                
                \Log::info("Image record created:", ['image_id' => $image->id, 'path' => $path]);
                
                // Set first uploaded image as main image
                if (!$firstImageId) {
                    $firstImageId = $image->id;
                }
            }
            
            // Update project with main image
            if ($firstImageId) {
                $project->update(['main_image_id' => $firstImageId]);
                \Log::info("Main image set:", ['main_image_id' => $firstImageId]);
            }
        } else {
            \Log::info('No images to process');
        }

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('success', 'Project created successfully.');
    }

    /**
     * Show the form for editing a project.
     */
    public function edit(Project $project)
    {
        $project->load(['images', 'mainImage']);
        
        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project
        ]);
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'technologies' => ['required', 'array'],
            'technologies.*' => ['string', 'max:255'],
            'is_visible' => ['boolean'],
        ]);

        $project->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Project $project)
    {
        // Delete all associated images from storage
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    /**
     * Toggle project visibility.
     */
    public function toggleVisibility(Project $project)
    {
        $project->update([
            'is_visible' => !$project->is_visible
        ]);

        return redirect()->back();
    }

    /**
     * Upload a single image to a project.
     */
    public function uploadImage(Request $request, Project $project)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048']
        ]);

        $path = $request->file('image')->store('projects/images', 'public');

        $image = $project->images()->create([
            'image_path' => $path,
        ]);

        // If this is the first image, set it as main image
        if (!$project->main_image_id) {
            $project->update(['main_image_id' => $image->id]);
        }

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }

    /**
     * Delete a project image.
     */
    public function deleteImage(Project $project, ProjectImage $image)
    {
        // Check if this image belongs to the project
        if ($image->project_id !== $project->id) {
            abort(404);
        }

        // If this is the main image, unset it
        if ($project->main_image_id === $image->id) {
            $project->update(['main_image_id' => null]);
        }

        // Delete the file from storage
        Storage::disk('public')->delete($image->image_path);

        // Delete the database record
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Set an image as the main image.
     */
    public function setMainImage(Project $project, ProjectImage $image)
    {
        // Check if this image belongs to the project
        if ($image->project_id !== $project->id) {
            abort(404);
        }

        $project->update(['main_image_id' => $image->id]);

        return redirect()->back()->with('success', 'Main image updated successfully.');
    }
} 