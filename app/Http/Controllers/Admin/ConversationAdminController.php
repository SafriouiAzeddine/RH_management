<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import User model
use App\Models\Conversation; // Import Conversation model
use Illuminate\Support\Facades\Auth; // Import Auth facade

class ConversationAdminController extends Controller
{
    public function index()
    {
      // Only the admin RH can access this page
      $this->authorize('viewAny', Conversation::class);

      // Get all users except the current admin RH
      $users = User::where('role', '!=', 1)->get();

      return view('conversations.index', compact('users'));
    }
    public function show(User $user)
    {
        // Find or create a conversation between the admin RH and the selected user
        $conversation = Conversation::firstOrCreate([
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
        ]);

        return view('conversations.show', compact('conversation', 'user'));
    }
    public function storeMessage(Request $request, Conversation $conversation)
    {
        // Validate the message input
        $request->validate([
            'message' => 'required|string'
        ]);

        // Create and store the new message
        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('conversations.show', $conversation->user_id);
    }
}
