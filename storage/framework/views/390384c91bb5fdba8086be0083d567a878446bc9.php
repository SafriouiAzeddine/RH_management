

<?php $__env->startSection('content'); ?>
<div class="container chat-container">
    <div class="chat-header">
        <div class="user-card">
            
            <div class="user-details">
                <h2>Discussion Public</h2>

            </div>
        </div>
    </div>

    <div id="messages" class="messages">

    </div>

    <script>
        $(document).ready(function(){
            // Store the authenticated user ID in a JavaScript variable
            var authUserId = <?php echo e(json_encode(auth()->id())); ?>;
            function loadTrips() {
                $.ajax({
                    url: '<?php echo e(route('message.getMessages')); ?>',
                    method: 'GET',
                    success: function(data) {
                        console.log(data); // Debugging line to check the data structure
                        var tripsHtml = '';
                        data.forEach(function(message) {

                            var messageClass = message.sender_id === authUserId ? 'sent' : 'received';
                            var senderName = message.sender_id === authUserId ? 'You' : message.sender_name;
                   

    
                            tripsHtml += `
                                <div class="message-wrapper ${messageClass}">
                                    <div class="message">
                                        <div class="message-info">
                                            <strong>${senderName} </strong>
                                            
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
    
            // Refresh the list every 3 seconds
            setInterval(loadTrips, 5000);

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


    <form id="message-form" action="<?php echo e(route('message.storeMessage')); ?>" method="POST" class="message-form">
        <?php echo csrf_field(); ?>
        <div class="input-group-custom">
            <textarea name="message" id="message" class="chat-input" rows="1" placeholder="Type a message..." required></textarea>
            <button type="submit" class="send-button-custom">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </form>

</div>

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
    
    .status.online {
        color: #25D366; /* WhatsApp green */
    }
    
    .status.offline {
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



<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Application_RH_v17_08_vf\Application_RH_v26_07\resources\views/discussionpublic/index.blade.php ENDPATH**/ ?>