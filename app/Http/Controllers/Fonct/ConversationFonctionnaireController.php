<?php
namespace App\Http\Controllers\Fonct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Events\MessageSent; // Make sure this path is correct
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewMessageNotification;

class ConversationFonctionnaireController extends Controller
{
    public function show()
    {
        // Get authenticated fonctionnaire
        $fonctionnaire = auth()->user();
        // Get the admin details
        $admin = User::where('role', 1)->first();
        
        // Find or create a conversation between the fonctionnaire and the admin RH (role_id = 1)
        $conversation = Conversation::firstOrCreate([
            'admin_id' => 1, // Assuming the admin RH has role_id = 1
            'user_id' => $fonctionnaire->id,
        ]);

        return view('fonctionnaire.conversations.show', compact('conversation', 'fonctionnaire','admin'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        // Validate the message input
        $request->validate([
            'message' => 'required|string'
        ]);



        // Create and store the new message
        $message = $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        // Broadcast the message
        //broadcast(new MessageSent($message))->toOthers();
        

        // Notify the admin RH of the new message
        $admin = User::where('role', '1')->first(); // Assuming the admin RH has ID 1
        //$admin->notify(new NewMessageNotification($message));

        // Return the new message details in the JSON response
        return response()->json([
            'success' => true,
            'message' => $message->message,
            'sender' => $message->sender->email, // Ensure sender relationship is correctly defined
            'created_at' => $message->created_at->format('d/m/Y H:i')
        ]);
    }


    public function getMessages()
    {
        // Get authenticated fonctionnaire
        $fonctionnaire = auth()->user();
        // Get the admin details
        $admin = User::where('role', 1)->first();
        
        // Find or create a conversation between the fonctionnaire and the admin RH (role_id = 1)
        $conversation = Conversation::firstOrCreate([
            'admin_id' => 1, // Assuming the admin RH has role_id = 1
            'user_id' => $fonctionnaire->id,
        ]);
        $messages =  $conversation->messages;

        return response()->json($messages);
    }
}
/*
<?php
namespace App\Http\Controllers\Fonct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Events\MessageSent; // Make sure this path is correct
use Illuminate\Support\Facades\Auth;

class ConversationFonctionnaireController extends Controller
{
    public function show()
    {
        // Get authenticated fonctionnaire
        $fonctionnaire = auth()->user();
        
        // Find or create a conversation between the fonctionnaire and the admin RH (role_id = 1)
        $conversation = Conversation::firstOrCreate([
            'admin_id' => 1, // Assuming the admin RH has role_id = 1
            'user_id' => $fonctionnaire->id,
        ]);

        return view('fonctionnaire.conversations.show', compact('conversation', 'fonctionnaire'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        // Validate the message input
        $request->validate([
            'message' => 'required|string'
        ]);

        // Create and store the new message
        $message = $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        // Notify the admin RH of the new message
        $admin = User::where('role', '1')->first(); // Assuming the admin RH has ID 1
        $admin->notify(new NewMessageNotification($message));

        // Broadcast the message
        //Log::info('Broadcasting message: ', ['message' => $message]);
        //broadcast(new MessageSent($message))->toOthers();

        // Return the new message details in the JSON response
        return response()->json([
            'success' => true,
            'message' => $message->message,
            'sender' => $message->sender->email, // Ensure sender relationship is correctly defined
            'created_at' => $message->created_at->format('d/m/Y H:i')
        ]);
    }
}
*/