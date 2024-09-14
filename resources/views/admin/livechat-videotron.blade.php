<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gozadera - Livechat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('images/logo-transparent.png') }}" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.min.js"></script>

</head>
<style>
    body {
        margin: 0;
        padding: 1rem;
        font-family: "Poppins", sans-serif;
    }

    .speech-wrapper {
        padding: 10px 20px;
    }

    .speech-wrapper .bubble {
        height: auto;
        display: block;
        border-radius: 20px;
        position: relative;
    }

    .speech-wrapper .bubble .txt {
        padding: 8px 55px 8px 14px;
    }

    .speech-wrapper .bubble .txt .name {
        font-weight: 900;
        margin: 0 0 4px;
        margin-bottom: 0px;
    }

    .speech-wrapper .bubble .txt .message {
        font-weight: 600;
        margin: 0;
        white-space: wrap;
        word-break: break-word;
    }

    .speech-wrapper .bubble .txt .timestamp {
        font-size: 11px;
        position: absolute;
        bottom: 8px;
        right: 10px;
        text-transform: uppercase;
    }

    .speech-wrapper .bubble .bubble-arrow {
        z-index: -1;
        position: absolute;
        width: 0;
        bottom: 42px;
        left: -10px;
        height: 0;
    }

    .speech-wrapper .bubble .bubble-arrow.alt {
        right: -2px;
        bottom: 40px;
        left: auto;
    }

    .speech-wrapper .bubble .bubble-arrow:after {
        content: "";
        position: absolute;
        border-radius: 0 20px 0;
        width: 22px;
        height: 33px;
        transform: rotate(161deg);
    }

    .speech-wrapper .bubble .bubble-arrow.alt:after {
        transform: rotate(45deg) scaleY(-1);
    }
</style>

<body
    style="{{ $event->videotron_flag_background === 'image'
        ? 'background: url(' . asset('uploads/' . $event->videotron_background_image) . ');background-size:cover'
        : 'background: ' . $event->videotron_color_code }};">

    <div id="chat-container"></div>

    <!-- Sweetalert -->
    <script src="{{ asset('templates/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch and display messages on load
            getMessagesSender();
            scrollToBottom();

            // Set background based on event properties
            @if ($event->videotron_flag_background === 'image')
                document.body.style.background =
                    "url('{{ asset('uploads/' . $event->videotron_background_image) }}')";
                document.body.style.backgroundSize = "cover";
            @else
                document.body.style.background = "{{ $event->videotron_color_code }}";
            @endif

            // Apply styling for bubbles
            const bubbleColor = "{{ $event->bubble_color_code_message_background }}";
            const nameColor = "{{ $event->bubble_color_code_message_name }}";
            const timeColor = "{{ $event->bubble_color_code_message_time }}";
            const textColor = "{{ $event->bubble_color_code_message_text }}";
            const fontSize = "{{ $event->bubble_message_font_size }}";
            const widthBubble = "{{ $event->bubble_message_width }}";

            const bubbleArrowStyle = `
                .speech-wrapper .bubble .bubble-arrow:after {
                    border: 0 solid transparent;
                    border-top: 9px solid ${bubbleColor};
                }
            `;
            const messageNameStyle = `
                .speech-wrapper .bubble .txt .name {
                    color: ${nameColor};
                }
            `;
            const messageTimeStyle = `
                .speech-wrapper .bubble .txt .timestamp {
                    color: ${timeColor};
                }
            `;
            const messageTextStyle = `
                .speech-wrapper .bubble .txt .message {
                    color: ${textColor};
                }
            `;
            const messageFontSizeStyle = `
                .name, .message {
                    font-size: ${fontSize}px;
                }
            `;
            const messageBubbleWidthStyle = `
                .speech-wrapper .bubble {
                    width: ${widthBubble}px;
                }
            `;

            const style = document.createElement('style');
            style.innerHTML = bubbleArrowStyle + messageNameStyle + messageTimeStyle + messageTextStyle + messageFontSizeStyle + messageBubbleWidthStyle;
            document.head.appendChild(style);

            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true
            });

            var channel = pusher.subscribe('chat-' + '{{ $event->id }}');

            channel.bind('message.sent', function(data) {
                renderMessage(data.message);
                scrollToBottom();
            });

            var channelDelete = pusher.subscribe('chatDelete-' + '{{ $event->id }}');

            channelDelete.bind('message.delete', function(data) {
                getMessagesSender();
                scrollToBottom();
            });
            
            var channelDeleteAdmin = pusher.subscribe('chatDeleteAdmin-' + '{{ $event->id }}');

            channelDeleteAdmin.bind('message.deleteAdmin', function(data) {
                getMessagesSender();
                scrollToBottom();
            });

            // Function to fetch messages
            function getMessagesSender() {
                $.ajax({
                    url: "{{ route('all-event.get-chat-videotron', $event->id) }}",
                    method: "GET",
                    success: function(response) {
                        if (response.messages && response.messages.length > 0) {
                            $('#chat-container').empty();
                            response.messages.forEach(function(message) {
                                renderMessage(message);
                            });
                            scrollToBottom();
                        }
                    },
                    error: function() {
                        console.error("Failed to fetch messages");
                    }
                });
            }

            // Function to render a message
            function renderMessage(message) {
                const messageHtml = `
                    <div class="speech-wrapper" data-message-id="${message.id}">
                        <div class="bubble" style="background-color: ${bubbleColor}">
                            <div class="txt">
                                <p class="name" style="color: ${nameColor}">${message.sender_name.toUpperCase()}</p>
                                <p class="message" style="color: ${textColor}">${message.content}</p>
                                <span class="timestamp" style="color: ${timeColor}">${formatTime(message.created_at)}</span>
                            </div>
                            <div class="bubble-arrow"></div>
                        </div>
                    </div>
                `;
                document.getElementById('chat-container').innerHTML += messageHtml;
            }

            // Function to scroll chat container to the bottom
            function scrollToBottom() {
                window.scrollTo(0, document.body.scrollHeight);
            }

            // Function to format time to H:i
            function formatTime(dateTimeString) {
                const date = new Date(dateTimeString);
                return date.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            document.getElementById('chat-container').addEventListener('click', function(e) {
                if (e.target.closest('.speech-wrapper')) {
                    e.preventDefault();
                    const messageId = e.target.closest('.speech-wrapper').getAttribute('data-message-id');
                    showDeleteConfirmation(messageId);
                }
            });

            function showDeleteConfirmation(messageId) {
                swal({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this message?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        deleteMessage(messageId);
                    }
                });
            }

            function deleteMessage(messageId) {
                $.ajax({
                    url: "{{ url('/all-event/event/livechat/delete-chat') }}/" + "{{ $event->id }}" + "/" +
                        messageId,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "DELETE",
                    success: function(response) {
                        if (response.status) {
                            swal({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                showCloseButton: true,
                                allowEscapeKey: false,
                                type: 'success',
                                timer: 5000,
                                title: "Deleted",
                            });
                            getMessagesSender();
                            scrollToBottom();
                        } else {
                            swal({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                showCloseButton: true,
                                allowEscapeKey: false,
                                type: 'error',
                                timer: 5000,
                                title: "Failed to delete the message.",
                            });
                        }
                    },
                    error: function() {
                        swal({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            showCloseButton: true,
                            allowEscapeKey: false,
                            type: 'error',
                            timer: 5000,
                            title: "Failed to delete the message.",
                            customClass: {
                                popup: 'custom-swal-popup',
                                title: 'custom-swal-title',
                                icon: 'custom-swal-icon',
                            }
                        });
                    }
                });
            }

        });
    </script>
</body>

</html>
