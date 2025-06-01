<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EducationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Education/Index', [
            'education' => Education::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Education/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'required|string',
            'is_visible' => 'boolean'
        ]);

        Education::create($validated);

        return redirect()->route('admin.education.index')
            ->with('message', 'Education created successfully.');
    }

    public function edit(Education $education)
    {
        return Inertia::render('Admin/Education/Edit', [
            'education' => $education
        ]);
    }

    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'required|string',
            'is_visible' => 'boolean'
        ]);

        $education->update($validated);

        return redirect()->route('admin.education.index')
            ->with('message', 'Education updated successfully.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->route('admin.education.index')
            ->with('message', 'Education deleted successfully.');
    }

    public function toggleVisibility(Education $education)
    {
        $education->update([
            'is_visible' => !$education->is_visible
        ]);

        return back()->with('message', 'Education visibility updated successfully.');
    }
} 