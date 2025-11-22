<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Récupérer toutes les notifications pour l'utilisateur authentifié
        $notifications = $user->notifications;
        $unreadNotifications = $user->unreadNotifications;

        // Filtrer les notifications en fonction des demandes avec le statut en attente (id_status = 1)
        if(Auth::user()->role=='1'){
            $filteredNotifications = [];
            foreach ($notifications as $notification) {
                $data = $notification->data;
                if (isset($data['demande_id'])) {
                    
                    $demande = Demande::where('id', $data['demande_id'])
                                    ->where('id_status', 1)
                                    ->first();

                    if ($demande) {
                        $filteredNotifications[] = $notification;
                    }
                }
            }
        }elseif(Auth::user()->role=='0'){
            $filteredNotifications = [];
            foreach ($unreadNotifications as $notification) {
                $data = $notification->data;
                if (isset($data['demande_id'])) {

                    $demande = Demande::where('id', $data['demande_id'])->first();

                    if ($demande) {
                        $filteredNotifications[] = $notification;
                    }
                }
            }
        }


        return view('RH.notifications.listnotifications', compact('filteredNotifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Récupérer la notification par ID directement depuis la table des notifications
        $notification = DatabaseNotification::where('id', $id)
                                            ->where('notifiable_id', Auth::id())//recuperer les notification du user auth
                                            ->where('notifiable_type', get_class(Auth::user()))
                                            ->first();

        if (!$notification) {
            return redirect()->route('notifications.index')->withErrors('Notification not found.');
        }

        // Fetch the request details based on the notification
        // Extraire les données de la notification
        $data = $notification->data;
        $demande = isset($data['demande_id']) ? Demande::find($data['demande_id']) : null;


        if (!$demande) {

            return redirect()->route('notifications.index')->withErrors('Request not found.');
            
        }
         // Mark the notification as read
         $notification->markAsRead();

        return view('RH.notifications.show', compact('demande','notification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //mark as read


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


    public function getNotifications(Request $request)
    {
        $user = auth()->user();

        // Retrieve notifications by type
        $demands = $user->unreadNotifications->where('type', '!=', 'App\Notifications\NewMessageNotification')
                                            ->where('type', '!=', 'App\Notifications\NewNotificationPublic');
        $messages = $user->unreadNotifications->where('type', 'App\Notifications\NewMessageNotification');
        $publicMessages = $user->unreadNotifications->where('type', 'App\Notifications\NewNotificationPublic');

        // Prepare response
        $response = [
            'demands' => $demands->map(function($notification) {
                $typeDemande = $notification->data['type_demande'] ?? 'Non spécifié';
                $status = $notification->data['status'] ?? null;
                $userName = $notification->data['user_name'] ?? 'Utilisateur non spécifié';

                $message = isset($status)
                    ? "Votre demande de type $typeDemande a été $status."
                    : "Nouvelle demande de type $typeDemande par l'utilisateur $userName";

                return [
                    'id' => $notification->id,
                    'type' => 'demand',
                    'message' => $message
                ];
            }),
            'messages' => $messages->map(function($notification) {
                $sender = $notification->data['sender'] ?? 'Expéditeur inconnu';
                return [
                    'id' => $notification->id,
                    'type' => 'message',
                    'message' => "Nouveau message de $sender"
                ];
            }),
            'publicMessages' => $publicMessages->map(function($notification) {
                $sender = $notification->data['sender'] ?? 'Expéditeur inconnu';
                return [
                    'id' => $notification->id,
                    'type' => 'public_message',
                    'message' => "Nouveau message public de $sender"
                ];
            }),
            'countDemands' => $demands->count(),
            'countMessages' => $messages->count(),
            'countPublicMessages' => $publicMessages->count()
        ];

        return response()->json($response);
    }

       /* public function getNotificationsDemandes()
        {
            if ($request->ajax()) {
                $messages = Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewMessageNotification');
                
                $response = [
                    
                    'messages' => $messages->map(function($notification) {
                        $sender = $notification->data['sender'] ?? 'Expéditeur inconnu';
                        return [
                            'id' => $notification->id,
                            'type' => 'message',
                            'message' => "Nouveau message de $sender"
                        ];
                    }),

                    'countMessages' => $messages->count()
                ];
    
                return response()->json($response);
            }
        }*/

        //try notification reel time
        // NotificationController.php
    public function notifyMessage(Request $request)
    {
        $user = auth()->user();
        $messages = $user->unreadNotifications->where('type', 'App\Notifications\NewMessageNotification')->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->data['sender'],
                'received' => true
            ];
        });

        return response()->json([
            'received' => $messages->isNotEmpty(),
            'messages' => $messages->pluck('message'),
            'id' => $messages->pluck('id')
        ]);
    }

        
}
