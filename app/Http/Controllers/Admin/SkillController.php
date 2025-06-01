<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkillController extends Controller
{
    /**
     * Display a listing of skills.
     */
    public function index()
    {
        $skills = Skill::orderBy('name')->get();

        return Inertia::render('Admin/Skills/Index', [
            'skills' => $skills
        ]);
    }

    /**
     * Show the form for creating a new skill.
     */
    public function create()
    {
        return Inertia::render('Admin/Skills/Create');
    }

    /**
     * Store a newly created skill.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'is_visible' => 'boolean',
        ]);

        Skill::create($validated);

        return redirect()->route('admin.skills.index')
            ->with('message', 'Skill created successfully.');
    }

    /**
     * Show the form for editing the specified skill.
     */
    public function edit(Skill $skill)
    {
        return Inertia::render('Admin/Skills/Edit', [
            'skill' => $skill
        ]);
    }

    /**
     * Update the specified skill.
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'is_visible' => 'boolean',
        ]);

        $skill->update($validated);

        return redirect()->route('admin.skills.index')
            ->with('message', 'Skill updated successfully.');
    }

    /**
     * Remove the specified skill.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('message', 'Skill deleted successfully.');
    }

    /**
     * Toggle the visibility of the specified skill.
     */
    public function toggleVisibility(Skill $skill)
    {
        $skill->update([
            'is_visible' => !$skill->is_visible
        ]);

        return back()->with('message', 'Skill visibility updated successfully.');
    }
} 