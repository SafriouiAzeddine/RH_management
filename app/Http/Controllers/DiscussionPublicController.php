<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessagePublic;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewNotificationPublic;
use App\Models\User; 
use Illuminate\Support\Facades\Notification;



class DiscussionPublicController extends Controller
{
    public function index()
    {
    
        return view('discussionpublic.index');
    }
    public function storeMessage(Request $request)
    {
        // Validate the message input
        $request->validate([
            'message' => 'required|string'
        ]);



        // Create and store the new message
        $message = new MessagePublic();
        $message->message = $request->input('message');
        $message->sender_id=auth()->id();
        $message->sender_name=$message->sender->email;
        $message->save();

        // Notify all users except the sender
        $users = User::where('id', '!=', auth()->id())->get();

        foreach ($users as $user) {
            $user->notify(new NewNotificationPublic($message));
        }


        return response()->json([
            'success' => true,
            'status' => 'Message Sent!',
            'message' => $message->message,
            'sender' => $message->sender_name, // Ensure sender relationship is correctly defined
            'created_at' => $message->created_at->format('d/m/Y H:i')
        ]);
    }
    public function getMessages()
    {
        $messages = MessagePublic::all();
        return response()->json($messages);
    }
}
