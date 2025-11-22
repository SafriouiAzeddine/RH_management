<?php

namespace App\Http\Controllers;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;



class NotificationMessageController extends Controller
{
    public function markAsRead($id)
    {
        $notification = DatabaseNotification::where('id', $id)
                                            ->where('notifiable_id', Auth::id())
                                            ->where('notifiable_type', get_class(Auth::user()))
                                            ->first();
    
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }

    public function redirectNotification($id)
    {
        // Retrieve the notification by ID directly from the notifications table
        $notification = DatabaseNotification::where('id', $id)
                                            ->where('notifiable_id', Auth::id())
                                            ->where('notifiable_type', get_class(Auth::user()))
                                            ->first();

        if ($notification) {
            $notification->markAsRead();

            // Redirect based on the notification type
            if ($notification->type === 'App\Notifications\NewNotificationPublic') {
                return redirect()->route('message.index');
            } else {
                // Check user role and redirect accordingly
                if (auth()->user()->role == '1') {
                    return redirect()->route('conversations.show', ['user' => $notification->data['sender_id']]);
                } elseif (auth()->user()->role == '0') {
                    return redirect()->route('fonctionnaire.conversations.show');
                }
            }
        }

        return redirect()->back()->withErrors(['notification' => 'Notification not found or unauthorized access.']);
    }
}
