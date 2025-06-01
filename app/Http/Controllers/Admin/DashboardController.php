<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'skills' => [
                'total' => Skill::count(),
                'visible' => Skill::where('is_visible', true)->count(),
            ],
            'education' => [
                'total' => Education::count(),
                'visible' => Education::where('is_visible', true)->count(),
            ],
            'projects' => [
                'total' => Project::count(),
                'visible' => Project::where('is_visible', true)->count(),
            ],
            'messages' => [
                'total' => Message::count(),
                'unread' => Message::where('is_read', false)->count(),
            ],
        ];

        $recentMessages = Message::latest()
            ->take(5)
            ->select(['id', 'name', 'email', 'content', 'is_read', 'created_at'])
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentMessages' => $recentMessages,
        ]);
    }
} 