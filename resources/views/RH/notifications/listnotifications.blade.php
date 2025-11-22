@extends('Layouts.layout')

@section('content')
<div class="container">
    <h1>Notifications</h1>
    @if($filteredNotifications)
        <ul>
            @foreach($filteredNotifications as $notification)
                <li>
                    <a href="{{ route('notifications.show', $notification->id) }}">
                        @if(isset($notification->data['status']))
                            Votre demande de type {{ $notification->data['type_demande'] }} a été {{ $notification->data['status'] }}.
                        @else
                            Nouvelle demande de type {{ $notification->data['type_demande'] }} par l'utilisateur {{ $notification->data['user_name'] }}
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucune demande en attente.</p>
    @endif
</div>
@endsection
