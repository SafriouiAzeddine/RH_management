@extends('Layouts.layout')

@section('content')
<div class="container chat-container">
    <div class="chat-header">
        <div class="user-card">
            <img src="{{ asset('upload_files/photos/' . $admin->photo) }}" alt="User Avatar" class="avatar">
            <div class="user-details">
                <h2>{{ $admin->nomFr}}</h2>
                <span id="{{ $admin->id }}-status" class="unread-indicator-offline">Offline</span>
            </div>
        </div>
    </div>

    <div id="messages" class="messages">      

    </div>
    <form id="message-form" action="{{ route('fonctionnaire.conversations.storeMessage', $conversation->id) }}" method="POST" class="message-form">
        @csrf
        <div class="input-group-custom">
            <textarea name="message" id="message" class="chat-input" rows="1" placeholder="Type a message..." required></textarea>
            <button type="submit" class="send-button-custom">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </form>


</div>
<script>
    $(document).ready(function(){
        // Store the authenticated user ID in a JavaScript variable
        var authUserId = {{ json_encode(auth()->id()) }};
        function loadTrips() {
            $.ajax({
                url: '{{ route('fonctionnaire.conversations.getMessages') }}',
                method: 'GET',
                success: function(data) {
                    console.log(data); // Debugging line to check the data structure
                    var tripsHtml = '';
                    data.forEach(function(message) {

                        var messageClass = message.sender_id === authUserId ? 'sent' : 'received';


                        tripsHtml += `
                            <div class="message-wrapper ${messageClass}">
                                <div class="message">
                                    <div class="message-info">
                                        
                                        <span class="message-time">${new Date(message.created_at).toLocaleString()}</span>
                                    </div>
                                    <p class="message-text">${message.message}</p>
                                </div>
                            </div>
                        `;
                    });
                    $('#messages').html(tripsHtml);
                    scrollToBottom();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching messages:', error);
                }
            });
        }

        // Load trips on page load
        loadTrips();

        // Refresh the list every 5 seconds
        setInterval(loadTrips, 2000);
            // Submit new message using AJAX
        $('#message-form').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var message = $('#message').val();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#message').val(''); // Clear the input field
                    loadTrips(); // Reload messages to include the new one
                },
                error: function(xhr, status, error) {
                    console.error('Error sending message:', error);
                }
            });
    });

    // Scroll to the bottom of the chat container
    function scrollToBottom() {
        var messagesContainer = $('#messages');
        messagesContainer.scrollTop(messagesContainer.prop("scrollHeight"));
    }
});
</script>

<script>
    $(document).ready(function() {
        var adminId= {{ $admin->id }};
    
    function checkUserStatus() {
            $.ajax({
                url: '{{ route("user.status", ":id") }}'.replace(':id', adminId),
                method: 'GET',
                success: function(data) {
                    var statusElement = $('#' + adminId + '-status');
                    if (data.status === 'online') {
                        statusElement.text('Online').removeClass('unread-indicator-offline').addClass('unread-indicator-online');
                    } else {
                        statusElement.text('Offline').removeClass('unread-indicator-online').addClass('unread-indicator-offline');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching user status:', error);
                }
            });
        }

        // Check status on page load
        checkUserStatus();

        // Refresh the status every 10 seconds
        setInterval(checkUserStatus, 2000);
    });
</script>


<style>
    .chat-container {
        max-width: 600px;
        margin: auto;
        background: #e5ddd5;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
        height: 80vh; /* Set a fixed height for the container */
        display: flex;
        flex-direction: column;
    }
    
    .chat-header {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .user-card {
        display: flex;
        align-items: center;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
        background-color: #f0f0f0;
        object-fit: cover;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-details h2 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .status {
        font-size: 14px;
        color: #999;
    }

    .unread-indicator-online {
        color: #25D366; /* WhatsApp green */
    }

    .unread-indicator-offline {
        color: #999;
    }
    .messages {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        margin-bottom: 10px;
    }

    .message-wrapper {
        display: flex;
        margin: 10px 0;
    }

    .message-wrapper.sent {
        justify-content: flex-end;
    }

    .message-wrapper.received {
        justify-content: flex-start;
    }

    .message {
        max-width: 70%;
        padding: 10px;
        border-radius: 10px;
        position: relative;
        word-wrap: break-word;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .message-wrapper.sent .message {
        background-color: #dcf8c6;
    }

    .message-wrapper.received .message {
        background-color: #fff;
        border: 1px solid #ddd;
    }

    .message-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .sender-name {
        font-weight: bold;
        color: #333;
    }

    .message-time {
        font-size: 12px;
        color: #999;
    }

    .message-text {
        margin: 0;
        line-height: 1.4;
    }
    .message-form {
        display: flex;
        align-items: flex-start; 
        padding: 10px;
        border-top: 1px solid #ddd;
    }

    .input-group-custom {
        display: flex;
        align-items: center;
        border-radius: 20px;
        width: 100%;
        padding: 5px;
        background-color: #f9f9f9;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .chat-input {
        flex: 1;
        border: none;
        border-radius: 20px;
        padding: 10px;
        margin-right: 10px;
        resize: none;
        background-color: #f9f9f9;
    }

    .chat-input:focus {
        outline: none;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1), 0 0 5px rgba(0, 123, 255, 0.2);
        background-color: #fff;
    }

    .send-button-custom {
        background-color: #075e54;
        border: none;
        color: white;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px; 
        height: 50px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .send-button-custom:hover {
        background-color: #054c3f;
    }

    .send-button-custom i {
        font-size: 20px;
    }

    
</style>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.10.0/echo.iife.js"></script>



@endsection
