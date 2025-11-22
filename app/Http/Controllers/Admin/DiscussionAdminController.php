<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import User model
use App\Models\Conversation; // Import Conversation model
use Illuminate\Support\Facades\Auth; // Import Auth facade
use App\Events\MessageSent;
use App\Notifications\NewMessageNotification;
use App\Models\Message;
use Illuminate\Support\Facades\Cache;

class DiscussionAdminController extends Controller
{
    public function index()
    {


    // Get all users except the current admin RH
    $users = User::where('role', '!=', 1)->get();

    // Fetch conversations where admin_id is the logged-in user
    $conversations = Conversation::where('admin_id', auth()->id())
        ->with(['messages' => function ($query) {
            $query->latest(); // Order messages by latest first
        }])
        ->get()
        ->keyBy('user_id'); // Key by user_id for easy lookup

    // Sort conversations by the creation date of the last message
    $sortedConversations = $conversations->sortByDesc(function ($conversation) {
        return optional($conversation->messages->first())->created_at;
    });




      return view('RH.conversations.index', compact('users','sortedConversations'));
    }
    public function show(User $user)
    {
        // Find or create a conversation between the admin RH and the selected user
        $conversation = Conversation::firstOrCreate([
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
        ]);

        return view('RH.conversations.show', compact('conversation', 'user'));
    }
    public function storeMessage(Request $request, Conversation $conversation)
    {
        // Validate the message input
        $request->validate([
            'message' => 'required|string'
        ]);

        // Create and store the new message
        $message=$conversation->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);
    

        //Broadcast the message
        //Log::info('Broadcasting message: ', ['message' => $message]);
        //broadcast(new MessageSent($message))->toOthers();
        // Find the recipient (fonctionnaire)

        // Notify the recipient of the new message



        //return redirect()->route('conversations.show', $conversation->user_id);


        
        $fonctionnaire = $conversation->user;
        $fonctionnaire->notify(new NewMessageNotification($message));

        
        // Return the new message details in the JSON response
        return response()->json([
            'success' => true,
            'message' => $message->message,
            'sender' => $message->sender->email, // Assuming sender is related and has an email attribute
            'created_at' => $message->created_at->format('d/m/Y H:i')
        ]);
        }

        public function createConversation(Request $request, $userId)
        {
            $adminId = auth()->id();
        
            // Check if a conversation already exists
            $conversation = Conversation::firstOrCreate([
                'admin_id' => $adminId,
                'user_id' => $userId,
            ]);
        
            return redirect()->route('conversations.show', $userId);
        }

        public function getMessages(User $user)
        {

            // Find or create a conversation between the admin RH and the selected user
            $conversation = Conversation::firstOrCreate([
                'admin_id' => auth()->id(),
                'user_id' => $user->id,
            ]);
        
            $messages =  $conversation->messages;//a corrige

            return response()->json($messages);
        }
        /*public function getMessages()
        {
            // Obtenez les messages qui n'ont pas été encore chargés
            $messages =  Message::all();

            return response()->json($messages);
        }*/

        public function getUserStatuses(Request $request)
        {
            $userIds = $request->query('user_ids');
            $statuses = [];

            foreach ($userIds as $id) {
                $isOnline = Cache::has('user-is-online-' . $id);
                $statuses[$id] = $isOnline ? 'online' : 'offline';
            }

            return response()->json($statuses);
        }
        public function getUserStatus($id)
        {
            $user = User::find($id);
            $status = $user->isOnline() ? 'online' : 'offline'; // Assuming you have an `isOnline` method
            return response()->json(['status' => $status]);
        }
        

}
