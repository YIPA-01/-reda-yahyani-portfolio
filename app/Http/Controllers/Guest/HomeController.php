<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Project;
use App\Models\Skill;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display the home page with visible projects.
     */
    public function index()
    {
        $projects = Project::with(['images', 'mainImage'])
            ->where('is_visible', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $education = Education::where('is_visible', true)
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($edu) {
                return [
                    'degree' => $edu->degree . ' in ' . $edu->field,
                    'institution' => $edu->school,
                    'duration' => $edu->start_date->format('Y') . ' - ' . 
                        ($edu->end_date ? $edu->end_date->format('Y') : 'Present'),
                    'description' => $edu->description
                ];
            });

        return Inertia::render('Guest/Home', [
            'projects' => $projects,
            'education' => $education
        ]);
    }
} 