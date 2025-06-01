<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\JsonResponse;

class EducationController extends Controller
{
    public function index(): JsonResponse
    {
        $education = Education::where('is_visible', true)
            ->orderByDesc('end_year')
            ->get();

        return response()->json($education);
    }
} 