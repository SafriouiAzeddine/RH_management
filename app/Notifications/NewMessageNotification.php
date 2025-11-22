<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;
use App\Events\NewNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewMessageNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        return [
            'message' => $this->message->message,
            'sender' => $this->message->sender->nomFr,
            'photo' => $this->message->sender->photo,
            'sender_id' => $this->message->sender->id,
            'conversation_id' => $this->message->conversation_id,
            'message_id' => $this->message->id,
        ];
    }

      /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => $this->message->message,
            'sender' => $this->message->sender->nomFr,
            'sender_id' => $this->message->sender->id,
            'conversation_id' => $this->message->conversation_id,
            'message_id' => $this->message->id,
            'photo' => $this->message->sender->photo,
        ]);
    }


}


