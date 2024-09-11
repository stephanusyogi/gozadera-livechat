@php
    use Illuminate\Support\Facades\Session;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, height=device-height,  initial-scale=1.0, user-scalable=no,user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gozadera - Livechat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo-transparent.png') }}" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.min.js"></script>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Poppins", sans-serif;

        --chat-background: rgb(10 14 14 / 62%);
        --chat-panel-background: #131719;
        --chat-send-button-background: #aa9160;
        --chat-text-color: #a3a3a3;

        --chat-bubble-background: #cbcbcb;
        --chat-bubble-name: #141212;
        --chat-bubble-message: #2b2b2b;
        --chat-bubble-time: #323232;
        --chat-bubble-width: 250px;
        --chat-bubble-font-size: 16px;
    }

    #chat {
        max-width: 600px;
        margin: 25px auto;
        box-sizing: border-box;
        padding: 1em;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        height: 90vh;
    }

    #chat .chat__conversation-title {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .rounded-img {
        width: 50px;
    }

    .rounded-img img {
        border-radius: 50%;
        width: 100%;
    }

    #chat .chat__conversation-title h4 {
        margin: 0;
        color: #c88600;
    }

    #chat .chat__conversation-title .divider {
        display: block;
        height: 30px;
        width: 1px;
        background-color: #717171;
    }

    #chat .btn-icon {
        position: relative;
        cursor: pointer;
    }

    #chat .btn-icon svg {
        stroke: #fff;
        fill: #fff;
        width: 50%;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    #chat .chat__conversation-panel {
        background: var(--chat-panel-background);
        border-radius: 12px;
        padding: 0 1em;
        height: 40px;
        border: 1px solid grey;
        position: absolute;
        bottom: 70px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        box-sizing: border-box;
    }

    #chat .chat__conversation-panel__container {
        display: flex;
        flex-direction: row;
        align-items: center;
        height: 100%;
    }

    #chat .chat__conversation-panel__container .panel-item:not(:last-child) {
        margin: 0 1em 0 0;
    }

    #chat .chat__conversation-panel__button {
        background: grey;
        height: 20px;
        width: 30px;
        border: 0;
        padding: 0;
        outline: none;
        cursor: pointer;
    }

    #chat .chat__conversation-panel .send-message-button {
        background: var(--chat-send-button-background);
        height: 30px;
        min-width: 30px;
        border-radius: 50%;
        transition: 0.3s ease;
    }

    #chat .chat__conversation-panel .send-message-button:active {
        transform: scale(0.97);
    }

    #chat .chat__conversation-panel .send-message-button svg {
        margin: 1px -1px;
    }

    #chat .chat__conversation-panel__input {
        width: 100%;
        height: 100%;
        outline: none;
        position: relative;
        color: var(--chat-text-color);
        font-size: 13px;
        background: transparent;
        border: 0;
        resize: none;
    }

    #chat .information {
        margin-top: 10px;
        justify-content: center;
        text-align: center;
    }

    #chat .information>p {
        margin-bottom: 0;
        font-size: 10px;
        color: #717171;
    }

    .chat__conversation-wrapper {
        height: 50vh;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .chat__conversation-wrapper::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #bdbdbd;
    }

    .chat__conversation-wrapper::-webkit-scrollbar {
        width: 6px;
        background-color: #f5f5f5;
    }

    .chat__conversation-wrapper::-webkit-scrollbar-thumb {
        background-color: #000000;
    }

    .speech-wrapper {
        padding: 10px 20px;
        float: right;
    }

    .speech-wrapper .bubble {
        width: 280px;
        letter-spacing: 1px;
        height: auto;
        display: block;
        background: var(--chat-bubble-background) !important;
        border-radius: 4px;
        position: relative;
    }

    .speech-wrapper .bubble .txt {
        padding: 8px 55px 8px 14px;
    }

    .speech-wrapper .bubble .txt .name {
        font-weight: 600;
        font-size: var(--chat-bubble-font-size);
        margin: 0 0 4px;
        color: var(--chat-bubble-name);
    }

    .speech-wrapper .bubble .txt .message {
        font-size: var(--chat-bubble-font-size);
        margin: 0;
        font-weight: 500;
        color: var(--chat-bubble-message);
    }

    .speech-wrapper .bubble .txt .timestamp {
        font-size: 8px;
        position: absolute;
        bottom: 8px;
        right: 10px;
        text-transform: uppercase;
        color: var(--chat-bubble-time);
    }

    .speech-wrapper .bubble .bubble-arrow {
        position: absolute;
        width: 0;
        bottom: 34px;
        right: 0px;
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
        border: 0 solid transparent;
        border-top: 9px solid var(--chat-bubble-background);
        border-radius: 15px 0 0;
        width: 15px;
        height: 30px;
        transform: rotate(215deg);
    }

    .speech-wrapper .bubble .bubble-arrow.alt:after {
        transform: rotate(45deg) scaleY(-1);
    }

    .chat__conversation-sender_container {
        position: absolute;
        top: -70px;
    }

    .chat__conversation-sender_container .chat__conversation-sender {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        height: 100%;
        gap: 1rem;
    }

    .chat__conversation-sender p {
        margin: 0;
        font-size: 10px;
        color: #a9a9a9;
    }

    .chat__conversation-sender a {
        margin-bottom: 0;
        font-size: 10px;
        color: #a9a9a9;
        background-color: #2f2f2f;
        padding: 5px;
        border-radius: 5px;
    }

    @media only screen and (max-width: 600px) {
        #chat {
            max-width: 300px;
        }

        #chat .chat__conversation-panel__input {
            font-size: 10px;
        }

        #chat .information>p {
            font-size: 8px;
        }

        #chat .chat__conversation-panel {
            bottom: 60px;
        }

        #chat .chat__conversation-panel .send-message-button {
            height: 25px;
            min-width: 25px;
        }

        #chat .btn-icon svg {
            width: 35%;
        }

        .speech-wrapper .bubble {
            width: 100%;
        }

        .speech-wrapper .bubble .txt .message {
            font-size: 10px;
        }
    }

    @media only screen and (max-width: 426px) {
        .rounded-img {
            width: 30px;
        }

        #chat .chat__conversation-title h4 {
            font-size: 12px;
        }

        .speech-wrapper .bubble .txt .name,
        .speech-wrapper .bubble .txt .message {
            font-size: 10px;
        }

        .chat__conversation-sender{
            flex-wrap: wrap;
        }
    }
</style>

<style>
    .custom-swal-popup {
        height: auto !important;
        padding: 5px !important;
    }

    .custom-swal-title {
        font-size: 12px !important;
    }

    .swal2-popup {
        background-color: #333 !important;
        color: #fff !important;
    }

    .swal2-input {
        background-color: #555 !important;
        color: #fff !important;
    }

    .swal2-title {
        color: #fff !important;
    }

    .swal2-popup.swal2-toast {
        box-shadow: unset
    }
</style>

<body>
    <div id="chat">
        <!-- Title -->
        <div class="chat__conversation-title">
            <div class="rounded-img">
                <img src="{{ asset('images/logo-transparent.png') }}" alt="" />
            </div>
            <div class="divider"></div>
            <h4>Livechat App</h4>
        </div>
        <!-- Title -->

        <!-- Wrapper -->
        <div class="chat__conversation-wrapper" id="chat-container">
        </div>
        <!-- Wrapper -->
        <!-- Panel Send -->
        <div class="chat__conversation-panel">
            <div class="chat__conversation-sender_container">
                <div class="chat__conversation-sender">
                    <p>Hello, <strong><span id="senderName">{{ Session::has('senderName') ? Session::get('senderName') : 'Name Sender' }}</span></strong>
                    </p>
                    <div class="sender__action">
                        <a onclick="changeName(event, this)" href="javascript:void(0)">Change Name Sender Here</a>
                        <a onclick="requestSong(event, this)" href="javascript:void(0)">Request     Song</a>
                    </div>
                </div>
            </div>
            <form onsubmit="sendMessage(event, this)" action="{{ route('all-event.send-chat', $event->id) }}" method="POST" class="chat__conversation-panel__container" autocomplete="off">
                @csrf
                <input type="hidden" name="sender_name" value="{{ Session::has('senderName') ? Session::get('senderName') : '' }}">
                <input type="hidden" name="sender_email" value="{{ Session::has('senderEmail') ? Session::get('senderEmail') : '' }}">
                <input type="hidden" name="sender_table" value="{{ Session::has('senderTable') ? Session::get('senderTable') : '' }}">
                <input class="chat__conversation-panel__input panel-item" placeholder="Write your message here..."
                    name="content" />
                <button type="submit" class="chat__conversation-panel__button panel-item btn-icon send-message-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
            <div class="chat__conversation-panel__container information">
                <p>
                    "Let's keep the vibes positive and the conversation uplifting.
                    <br />Remember, kindness goes a long way, so let's sprinkle it
                    generously in our livechat, Have fun folks! 😊"
                </p>
            </div>
        </div>
        <!-- Panel Send -->
    </div>

    <!-- Sweetalert -->
    <script src="{{ asset('templates/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script>
        // Check if sender_name is empty
        const senderNameInput = document.querySelector('input[name="sender_name"]');
        const senderEmailInput = document.querySelector('input[name="sender_email"]');
        const senderTableInput = document.querySelector('input[name="sender_table"]');
        const contentInput = document.querySelector('input[name="content"]');

        if (senderNameInput.value.trim() === '') {
            showAlert('Sender name must be filled.', 'error');
        }

        // Function to send a message
        function sendMessage(event, form) {
            event.preventDefault();

            if (!validateForm()) {
                return;
            }

            const formData = new FormData(form);
            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 429) {
                            throw new Error('Too Many Requests');
                        } else if (response.status === 422) {
                            return response.json().then(data => {
                                throw new Error(JSON.stringify(data.errors));
                            });
                        }

                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    getMessagesSender();
                    form.reset();
                })
                .catch(error => {
                    form.reset();
                    if (error.message === 'Too Many Requests') {
                        showAlert(
                            'You have reached the maximum number of messages. Please wait 2 minutes and try again.', 'error');
                    } else {
                        try {
                            const errors = JSON.parse(error.message);
                            for (const field in errors) {
                                errors[field].forEach(errorMessage => {
                                    showAlert(errorMessage, 'error');
                                });
                            }
                        } catch (e) {
                            console.error('Error:', error);
                        }
                    }
                });
        }

        function requestSong(event, element){
            event.preventDefault();
            const senderName = $('input[name="sender_name"]').val().trim();

            if (senderName === '') {
                showAlert('Sender name must be filled.', 'error');
                return;
            } else if (senderName.length > 20) {
                showAlert('Sender name must not exceed 20 characters.', 'error');
                return
            }

            swal({
                title: 'Request a Song',
                html: `
                    <input type="text" id="song_name" class="swal2-input" placeholder="Song Name">
                    <input type="text" id="artist_name" class="swal2-input" placeholder="Artist Name">
                `,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                focusConfirm: false,
                preConfirm: () => {
                    const songName = document.getElementById('song_name').value.trim();
                    const artistName = document.getElementById('artist_name').value.trim();

                    // Input validation
                    if (!songName || !artistName) {
                        showAlert('Both song name and artist name must be filled.', 'error');
                        return false;
                    } else if (songName.length > 30) {
                        showAlert('Song name must not exceed 30 characters.', 'error');
                        return false;
                    } else if (artistName.length > 30) {
                        showAlert('Artist name must not exceed 30 characters.', 'error');
                        return false;
                    }
                    return { songName, artistName };
                }
            }).then((result) => {
                if (result.value) {
                    const { songName, artistName } = result.value;

                    storeSongRequest(senderName, songName, artistName);
                }
            });

        }

        function storeSongRequest(senderName, songName, artistName) {
            $.ajax({
                url: "{{ route('all-event.event-all-song-send', $event->id) }}",
                method: "POST",
                data: {
                    sender_name: senderName,
                    sender_email: document.querySelector('input[name="sender_email"]').value,
                    song_name: songName,
                    artist_name: artistName,
                    _token: "{{ csrf_token() }}" // Add CSRF token if necessary
                },
                success: function(response) {
                    if (response.status) {
                        showAlert('Your song request has been submitted successfully.', 'info');
                    }
                },
                error: function() {
                    showAlert('An error occurred while submitting your request.', 'error');
                }
            });
        }


        // Function to change sender's name
        function changeName(event, element) {
            event.preventDefault();

            swal({
                title: 'Enter your name',
                input: 'text',
                inputPlaceholder: 'Enter your name',
                showCancelButton: true,
                inputValidator: (value) => {
                    return !value && 'You need to write something!';
                }
            }).then((result) => {
                if (result.value) {
                    const name = result.value;
                    senderNameInput.value = name;
                    document.getElementById('senderName').textContent = name;
                }
            });
        }

        // Function to fetch messages
        function getMessagesSender() {
            $.ajax({
                url: "{{ route('all-event.get-chat-visitor', $event->id) }}",
                method: "GET",
                success: function(response) {
                    if (response.messages && response.messages.length > 0) {
                        document.getElementById('chat-container').innerHTML = '';
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
                    <div class="speech-wrapper">
                        <div class="bubble">
                            <div class="txt">
                                <p class="name">${message.sender_name}</p>
                                <p class="message">${message.content}</p>
                                <span class="timestamp">${formatTime(message.created_at)}</span>
                            </div>
                            <div class="bubble-arrow"></div>
                        </div>
                    </div>
                `;
            document.getElementById('chat-container').innerHTML += messageHtml;
        }

        // Function to scroll chat container to the bottom
        function scrollToBottom() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Function to format time to H:i
        function formatTime(dateTimeString) {
            const date = new Date(dateTimeString);
            return date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Function to show alert
        function showAlert(message, type) {
            swal({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                allowEscapeKey: false,
                type: type,
                timer: 5000,
                title: message,
            });
        }

        function validateForm() {
            let isValid = true;

            const senderName = $('input[name="sender_name"]').val().trim();
            const content = $('input[name="content"]').val().trim();

            if (senderName === '') {
                showAlert('Sender name must be filled.', 'error');
                isValid = false;
            } else if (senderName.length > 20) {
                showAlert('Sender name must not exceed 20 characters.', 'error');
                isValid = false;
            }

            if (content === '') {
                showAlert('Message must not be empty.', 'error');
                isValid = false;
            } else if (content.length > 100) {
                showAlert('Message must not exceed 100 characters.', 'error');
                isValid = false;
            }

            return isValid;
        }

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        var channel = pusher.subscribe('chatDelete-' + '{{ $event->id }}');

        channel.bind('message.delete', function(data) {
            getMessagesSender();
            scrollToBottom();
        });

        // Function to set chat background
        function setChatBackground() {
            @if ($event->visitor_flag_background === 'image')
                document.body.style.background =
                    "url('{{ asset('uploads/' . $event->visitor_background_image) }}')";
                document.body.style.backgroundSize = "cover";
                document.body.style.backgroundPosition = "center";

                const visitorBackground = document.createElement('style');
                visitorBackground.innerHTML = `
                        #chat {
                            background: linear-gradient(0deg, rgb(0 0 0), rgb(0 0 0 / 31%)),
                            url('{{ asset('uploads/' . $event->visitor_background_image) }}');
                            background-size: cover;
                        }
                    `;
                document.head.appendChild(visitorBackground);
            @else
                document.body.style.background = "{{ $event->videotron_color_code }}";
                const visitorBackground = document.createElement('style');
                visitorBackground.innerHTML = `
                        #chat {
                            background: #535353;
                        }
                    `;
                document.head.appendChild(visitorBackground);
            @endif
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Initialize chat background
            setChatBackground();

            // Fetch and display messages
            getMessagesSender();

            scrollToBottom();
        });
    </script>


</body>

</html>
