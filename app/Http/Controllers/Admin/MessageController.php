<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    /**
     * Display a listing of messages.
     */
    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Messages/Index', [
            'messages' => $messages
        ]);
    }

    /**
     * Show a specific message and mark it as read.
     */
    public function show(Message $message)
    {
        // Mark message as read if it hasn't been read
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return Inertia::render('Admin/Messages/Show', [
            'message' => $message
        ]);
    }

    /**
     * Delete the specified message.
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    /**
     * Toggle message read status.
     */
    public function toggleRead(Message $message)
    {
        $message->update([
            'is_read' => !$message->is_read
        ]);

        return redirect()->back();
    }

    /**
     * Store a new message (from contact form).
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