@extends('Layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Conversations</h1>
            <input type="text" id="searchInput" placeholder="Rechercher une conversation..." class="form-control mb-3">
            
            <ul class="list-group" id="conversationList">
                @foreach($sortedConversations as $conversation)
                    @php
                        $lastMessage = $conversation->messages->first();
                        $user = $conversation->user; // The user associated with this conversation
                    @endphp

                    <li class="list-group-item conversation-item" data-user-id="{{ $user->id }}" data-user-name="{{ strtolower($user->nomFr) }}">
                        <a href="{{ route('conversations.show', $user->id) }}" class="d-flex align-items-center w-100 text-decoration-none">
                            <div class="conversation-info d-flex align-items-center w-100">
                                <img src="{{ asset('upload_files/photos/' . $user->photo) }}" alt="User Avatar" class="avatar">
                                <div class="details flex-grow-1">
                                    <div class="user-name">
                                        <strong>{{ $user->nomFr }}</strong>
                                        @if($lastMessage && !$lastMessage->is_read)
                                        <!--offline online-->
                                            <span id="{{ $user->id }}-status" class="unread-indicator-offline"></span>
                                        @endif
                                    </div>
                                    <div class="last-message text-muted">
                                        @if($lastMessage)
                                            {{ \Illuminate\Support\Str::limit($lastMessage->message, 30) }}
                                        @else
                                            Aucun message
                                        @endif
                                    </div>
                                </div>
                                <div class="timestamp text-right text-muted">
                                    @if($lastMessage)
                                        {{ formatTimestamp($lastMessage->created_at) }}
                                    @endif
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach

                @foreach($users as $user)
                    @if(!isset($sortedConversations[$user->id]))
                        <li class="list-group-item conversation-item" data-user-id="{{ $user->id }}" data-user-name="{{ strtolower($user->nomFr) }}">
                            <a href="{{ route('conversations.create', $user->id) }}" class="d-flex align-items-center w-100 text-decoration-none">
                                <div class="conversation-info d-flex align-items-center w-100">
                                    <img src="{{ asset('upload_files/photos/' . $user->photo) }}" alt="User Avatar" class="avatar">
                                    <div class="details flex-grow-1">
                                        <div class="user-name">
                                            <strong>{{ $user->nomFr }}</strong>
                                        </div>
                                        <div class="last-message text-muted">
                                            Aucun message
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    var filter = this.value.toLowerCase();
    var items = document.querySelectorAll('#conversationList .conversation-item');
    items.forEach(function(item) {
        var userName = item.getAttribute('data-user-name');
        if (userName.includes(filter)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
<!-- Pusher -->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<!-- Laravel Echo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>

<script>
    $(document).ready(function () {
        function updateStatuses() {
            var userIds = [];
            $('.conversation-item').each(function () {
                userIds.push($(this).data('user-id'));
            });

            $.ajax({
                url: '{{ route('user.statuses') }}',
                method: 'GET',
                data: { user_ids: userIds },
                success: function (statuses) {
                    for (var userId in statuses) {
                        var statusElement = $('#' + userId + '-status');
                        if (statuses[userId] === 'online') {
                            statusElement.removeClass('unread-indicator-offline').addClass('unread-indicator-online');
                        } else {
                            statusElement.removeClass('unread-indicator-online').addClass('unread-indicator-offline');
                        }
                    }
                }
            });
        }

        // Update statuses every 3 seconds
        setInterval(updateStatuses, 2000);
    });
</script>

<style>
    /* Styles for the conversation list */
    .conversation-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        margin-bottom: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer; /* Pointer cursor to indicate clickable item */
        transition: background-color 0.2s;
    }
    
    .conversation-item:hover {
        background-color: #f1f1f1; /* Light background on hover */
    }
    
    .conversation-info {
        display: flex;
        align-items: center;
        width: 100%;
    }
    
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
        background-color: #f0f0f0;
        object-fit: cover;
    }
    
    .details {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .user-name {
        font-weight: bold;
        color: #225398; /* Changed color to black */
        position: relative;
    }
    
    .unread-indicator-online {
        position: absolute;
        top: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background-color: #25D366; /* WhatsApp green */
        border-radius: 50%;
        box-shadow: 0 0 0 2px #ffffff;
    }
    .unread-indicator-offline {
        position: absolute;
        top: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background-color: rgba(255, 0, 0, 0.688); /* WhatsApp green */
        border-radius: 50%;
        box-shadow: 0 0 0 2px #ffffff;
    }
    
    .last-message {
        font-size: 0.9em;
        color: #888;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .timestamp {
        font-size: 0.8em;
        color: #888;
    }
</style>

@php
function formatTimestamp($timestamp) {
    $now = \Carbon\Carbon::now();
    $timestamp = \Carbon\Carbon::parse($timestamp);
    
    if ($timestamp->isToday()) {
        return $timestamp->format('H:i');
    } elseif ($timestamp->isYesterday()) {
        return 'Hier';
    } elseif ($timestamp->isSameMonth()) {
        return $timestamp->format('j M');
    } else {
        return $timestamp->format('d M Y');
    }
}
@endphp
@endsection
