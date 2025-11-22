<?php
namespace App\Notifications;

use App\Models\Demande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Events\NewNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;
class DemandeStatusConfirmation extends Notification
{
    use Queueable;

    protected $demande;
    protected $status;

    public function __construct(Demande $demande, $status)
    {
        $this->demande = $demande;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toArray($notifiable)
    {
        
        return [
            'user_id' => $this->demande->id_user,
            'user_name' => $this->demande->user->nomFr . ' ' . $this->demande->user->prenomFr,
            'photo' => $this->demande->user->photo,
            'type_demande' => $this->demande->typeDemande->type_demande,
            'demande_id' => $this->demande->id,
            'status' => $this->status,
            'date_debut' => $this->demande->date_debut,
            'nbr_jours' => $this->demande->nbr_jours,
            'date_fin' => $this->demande->date_fin,
        ];
    }
    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'user_id' => $this->demande->id_user,
            'user_name' => $this->demande->user->nomFr . ' ' . $this->demande->user->prenomFr,
            'type_demande' => $this->demande->typeDemande->type_demande,
            'demande_id' => $this->demande->id,
            'status' => $this->status,
            'date_debut' => $this->demande->date_debut,
            'nbr_jours' => $this->demande->nbr_jours,
            'date_fin' => $this->demande->date_fin,
            'photo' => $this->demande->user->photo,
        ]);
    }
}
