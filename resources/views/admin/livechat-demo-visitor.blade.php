@php
    use Illuminate\Support\Facades\Session;
@endphp
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
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_img_text_bottom.png') }}" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        --chat-bubble-background: #ffffff;
        --chat-bubble-name: #141212;
        --chat-bubble-message: #2b2b2b;
        --chat-bubble-time: #323232;
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
        font-size: 12px;
        margin: 0 0 4px;
        color: var(--chat-bubble-name);
    }

    .speech-wrapper .bubble .txt .message {
        font-size: 12px;
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
        top: -30px;
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
    }
</style>

<style>
    /* .custom-swal-popup {
        height: auto !important;
        padding: 5px !important;
    }

    .custom-swal-title {
        font-size: 12px !important;
    } */

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

            <div class="speech-wrapper">
                <div class="bubble">
                    <div class="txt">
                        <p class="name">Alex</p>
                        <p class="message">Hey Benni, the
                            party
                            is amazing! Did you try the punch?</p>
                        <span class="timestamp">10:20
                            pm</span>
                    </div>
                    <div class="bubble-arrow"></div>
                </div>
            </div>

            <div class="speech-wrapper">
                <div class="bubble">
                    <div class="txt">
                        <p class="name">Benni</p>
                        <p class="message">Yeah, Alex! The
                            punch
                            is great. Have you seen Jordan?</p>
                        <span class="timestamp">10:21
                            pm</span>
                    </div>
                    <div class="bubble-arrow"></div>
                </div>
            </div>

            <div class="speech-wrapper">
                <div class="bubble">
                    <div class="txt">
                        <p class="name">Jordan</p>
                        <p class="message">I'm here, guys!
                            Just
                            dancing with Taylor. This DJ rocks!</p>
                        <span class="timestamp">10:22
                            pm</span>
                    </div>
                    <div class="bubble-arrow"></div>
                </div>
            </div>
        </div>
        <!-- Wrapper -->
        <!-- Panel Send -->
        <div class="chat__conversation-panel">
            <div class="chat__conversation-sender_container">
                <div class="chat__conversation-sender">
                    <p>Hello, <strong><span
                                id="senderName">{{ Session::has('senderName') ? Session::get('senderName') : 'Name Sender' }}</span></strong>
                    </p>
                    <a href="javascript:void(0)">Change Name Sender Here</a>
                </div>
            </div>
            <div class="chat__conversation-panel__container">
                <input class="chat__conversation-panel__input panel-item" placeholder="Write your message here..."
                    name="content" />
                <button type="button" class="chat__conversation-panel__button panel-item btn-icon send-message-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
            <div class="chat__conversation-panel__container information">
                <p>
                    "Let's keep the vibes positive and the conversation uplifting. Have fun folks! 😊"
                </p>
            </div>
        </div>
        <!-- Panel Send -->
    </div>

    <!-- Sweetalert -->
    <script src="{{ asset('templates/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script>
        // Function to scroll chat container to the bottom
        function scrollToBottom() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

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
                            background-position: center;
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


        setTimeout(() => {
            setChatBackground();
            scrollToBottom();
            swal({
                position: 'center',
                showConfirmButton: false,
                showCloseButton: true,
                allowEscapeKey: false,
                type: 'info',
                title: "You are seeing demo page.",
            })
        }, 100);
    </script>
</body>

</html>
