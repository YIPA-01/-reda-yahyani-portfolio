<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a new message from the contact form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'content' => ['required', 'string']
        ]);

        Message::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Message sent successfully. We will get back to you soon!');
    }
} 