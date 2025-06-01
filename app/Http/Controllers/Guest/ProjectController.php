<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of visible projects.
     */
    public function index()
    {
        $projects = Project::with(['images', 'mainImage'])
            ->where('is_visible', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Guest/Projects/Index', [
            'projects' => $projects
        ]);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Only show visible projects
        if (!$project->is_visible) {
            abort(404);
        }

        $project->load(['images', 'mainImage']);

        return Inertia::render('Guest/Projects/Show', [
            'project' => $project
        ]);
    }
} 