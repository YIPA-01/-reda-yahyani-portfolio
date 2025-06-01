<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::where('is_visible', true)
            ->with(['images' => function ($query) {
                $query->where('id', function ($subquery) {
                    $subquery->select('main_image_id')
                        ->from('projects')
                        ->whereColumn('projects.id', 'project_images.project_id')
                        ->limit(1);
                });
            }])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($projects);
    }

    public function show(Project $project): JsonResponse
    {
        if (!$project->is_visible) {
            abort(404);
        }

        $project->load('images');

        return response()->json($project);
    }
} 