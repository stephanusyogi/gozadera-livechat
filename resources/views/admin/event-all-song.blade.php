<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gozadera - Livechat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    
    <link rel="shortcut icon" href="{{ asset('images/logo-transparent.png') }}" />
</head>
<style>
    body{
        font-family: "Poppins", sans-serif;
    }

    .input {
    display: none;
    }

    .pseudo-check {
    display: inline-block;
    border-radius: 0.4em;
    vertical-align: middle;
    position: relative;
    transition: all 0.3s;
    box-shadow: inset 0 0.05em 0.15em rgba(0, 0, 0, 0.3);
    top: -0.11em;
    width: 0.8em;
    height: 0.8em;
    }

    .checkmark {
    position: relative;
    margin: 25% 20%;
    -webkit-clip-path: polygon(0 56%, 35% 87%, 100% 15%, 85% 0, 34% 56%, 15% 39%);
            clip-path: polygon(0 56%, 35% 87%, 100% 15%, 85% 0, 34% 56%, 15% 39%);
    width: 0.5em;
    height: 0.5em;
    }

    .goo {
    border-radius: 50%;
    background-color: #fff;
    background-color: #39d76e;
    position: absolute;
    left: 15%;
    top: 67%;
    opacity: 0;
    transition: transform 0.5s ease-in, opacity 0.4s 0.1s;
    transform-origin: center;
    transform: scale(0.1);
    width: 0.06em;
    height: 0.09em;
    }

    .item {
    position: relative;
    display: flex;
    color: #456;
    width: 100%;
    cursor: pointer;
    perspective: 1000px;
    }
    .item__content {
    transform: rotateX(-90deg);
    background-color: #fff;
    transform-origin: top left;
    box-sizing: border-box;
    padding: 0.5em;
    margin-bottom: -3.5em;
    width: 100%;    
    border: 1px solid #efefef;
    transition: all 0.5s calc((5 - var(--item)) * .05s) cubic-bezier(0.28, -0.54, 0.45, 2);
    -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
    }
    .item:first-of-type .item__content {
    border-top: none;
    }
    .item__text {
    margin-left: 10px;
    position: relative;
    max-width: calc(100% - 1.8em);
    overflow: hidden;
    height: 30px;
    text-overflow: ellipsis;
    display: inline-block;
    white-space: nowrap;
    font-size: 10px;
    }
    /* .item__text::after {
    content: "";
    display: block;
    height: 2px;
    width: 0%;
    top: 50%;
    left: -2.5%;
    position: absolute;
    background-color: #39d76e;
    transition: all 0.2s 0.1s;
    } */

    .parent .child {
    background-color: pink;
    }
    .parent .child-2 {
    background-color: red;
    }

    .progress {
    background-color: #39d76e;
    width: 0.01%;
    height: 5px;
    position: relative;
    order: -1;
    transition: width 0.4s;
    margin-bottom: 1rem;
    }

    .input:checked + .item .item__text::after {
    width: 105%;
    }
    .input:checked + .item .pseudo-check {
    background: #39d76e;
    }
    .input:checked + .item + .progress {
    width: 20%;
    transition: width 0.4s 0.1s;
    }
    .input:checked + .item .goo {
    background-color: #fff;
    transform: scale(40);
    opacity: 1;
    transition: transform 0.3s cubic-bezier(1, -0.46, 0.41, 1.34), opacity 0;
    }
    .input:checked + .item + .stuff {
    float: right;
    }

    .todos {
    width: 100%;
    box-sizing: border-box;
    max-width: 400px;
    max-height: 400px;
    overflow-y: scroll;
    display: flex;
    flex-wrap: wrap;
    padding: 1em;
    position: relative;
    padding-bottom: 0.5em;
    margin: auto;
    border-radius: 0.1em 0.1em 0.3em 0.3em;
    border-top: 20px solid #c88600;
    background-color: #fff;
    box-shadow: 0 30px 40px rgba(0, 0, 0, 0.4);
    z-index: 2;
    }

    .divider {
    width: 100%;
    height: 2px;
    order: 0;
    }

    .title {
    order: -4;
    width: 100%;
    margin-top: 0;
    margin-bottom: -5px;
    font-size: 0.6rem;
    color: #456;
    text-transform: uppercase;
    padding-bottom: 1rem;
    letter-spacing: 0.02em;
    }

    .toggle {
    display: none;
    }

    .toggle:checked ~ .item .item__content {
    margin-bottom: 0em;
    transform: rotateX(0deg);
    transition: all 0.23s calc(var(--item) * .16s) cubic-bezier(0.28, -0.54, 0.45, 2.1);
    }
    .toggle:checked + .btn-toggle::after {
    top: 35%;
    transform: rotateZ(-135deg);
    }

    .btn-toggle {
    position: absolute;
    top: 1em;
    right: 1em;
    border: 2px solid #89a;
    text-indent: -9999px;
    border-radius: 50%;
    cursor: pointer;
    width: 20px;
    height: 20px;
    }
    .btn-toggle::after {
    content: "";
    display: block;
    border: 2px solid #89a;
    border-top: none;
    border-left: none;
    position: absolute;
    top: 16%;
    left: 24%;
    transition: transform 0.3s;
    transform: rotateZ(45deg);
    width: 8px;
    height: 8px;
    }

    .end {
    display: block;
    opacity: 0;
    pointer-events: none;
    -webkit-clip-path: polygon(0 56%, 35% 87%, 100% 15%, 85% 0, 34% 56%, 15% 39%);
            clip-path: polygon(0 56%, 35% 87%, 100% 15%, 85% 0, 34% 56%, 15% 39%);
    width: 8em;
    height: 8em;
    position: absolute;
    top: 230px;
    right: calc(50% + 0px);
    transform: translate(50%, -50%);
    z-index: 4;
    overflow: hidden;
    transition: opacity 0.1s, all 0 0.4s;
    }
    .end .goo {
    background: linear-gradient(#ff3052, #ff51b6);
    transform: scale(1);
    width: 3em;
    height: 3em;
    }

    .input:checked ~ .input:checked ~ .input:checked ~ .input:checked ~ .input:checked ~ .end {
    opacity: 1;
    top: 33px;
    right: calc(0% + 65px);
    transition: opacity 0.1s, width 0.3s 0.2s cubic-bezier(0.28, -0.54, 0.45, 1.3), height 0.3s 0.2s cubic-bezier(0.28, -0.54, 0.45, 1.3), top 0.3s 0.5s cubic-bezier(0.99, -0.4, 0.14, 1.51), right 0.3s 0.5s cubic-bezier(0.99, -0.4, 0.14, 1.51);
    width: 1em;
    height: 1em;
    }
    .input:checked ~ .input:checked ~ .input:checked ~ .input:checked ~ .input:checked ~ .end .goo {
    transition: all 0.4s;
    left: 35%;
    top: 17%;
    transform: scale(4);
    opacity: 1;
    }

    body {
    padding: 0;
    margin: 0;
    position: relative;
    }

    .viewport {
    font-size: 1.3em;
    display: flex;
    position: absolute;
    width: 100vw;
    height: 100vh;
    max-width: 100vw;
    max-height: 100vh;
    align-items: center;
    overflow: hidden;
    /* background: linear-gradient(to top, #2a037d, #5a3fb9); */
    }
    .viewport::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Black color with 50% opacity */
        z-index: 1; /* Overlay above background, but below content */
        pointer-events: none; /* Make the overlay non-interactive */
    }
    .item__delete{
        float: right;
    }
    .item__delete > button {
        margin-top: 5px;
        border: none;
        background: none;
    }
</style>
<body>
    <div class='viewport'>
        <div class='todos' id="song-container">
          <h3 class='title'>
            Gozadera Livechat - Song Request
            <br>
            <span>"{{ $event->name }}"</span>
          </h3>
          <input class='toggle' id='toggle' type='checkbox'>
          <label class='btn-toggle' for='toggle'>Toggle</label>
        </div>
    </div>  

    <script src="{{ asset('templates/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script>
        function deleteItem(event) {
            event.preventDefault();
            event.stopPropagation();

            const songId = event.currentTarget.dataset.idSong;
            
            swal({
                title: 'Are you sure?',
                text: "Do you really want to delete this item?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = "{{ url('/all-event/event/all-song-request/delete') }}/" + "{{ $event->id }}" + "/" + songId
                }
            });
        }

        function setChatBackground() {
            let viewportDiv = document.querySelector('.viewport');
            @if ($event->visitor_flag_background === 'image')
                viewportDiv.style.background = "url('{{ asset('uploads/' . $event->visitor_background_image) }}')";
                viewportDiv.style.backgroundSize = "cover";
                viewportDiv.style.backgroundPosition = "center";
            @else
                viewportDiv.style.background = "{{ $event->videotron_color_code }}";
            @endif
        }

        document.addEventListener("DOMContentLoaded", function() {
            setChatBackground();
        });
    </script>
    
    <script>
        $(document).ready(function() {
            @if (session('success_flash'))
                swal({
                    toast: true,
                    position: 'top-end',
                    type: 'success',
                    showConfirmButton: false,
                    showCloseButton: true,
                    title: '{!! session('success_flash') !!}'
                });
            @endif
            @if (session('error_flash'))
                swal({
                    toast: true,
                    position: 'top-end',
                    type: 'error',
                    showConfirmButton: false,
                    showCloseButton: true,
                    title: '{!! session('error_flash') !!}'
                });
            @endif
        });
    </script>

    <script>
        $(document).ready(function() {
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true
            });

            var channel = pusher.subscribe('song-request-' + '{{ $event->id }}');
            
            // Fetch initial song requests when page loads
            getSongRequests();

            // Listen for new song request events
            channel.bind('song.requested', function(data) {
                $('#song-container').empty();
                let titleHtml = `
                    <h3 class='title'>
                        Gozadera Livechat - Song Request
                        <br>
                        <span>"{{ $event->name }}"</span>
                    </h3>
                    <input class='toggle' id='toggle' type='checkbox'>
                    <label class='btn-toggle' for='toggle'>
                        Toggle
                    </label>
                `;
                $('#song-container').append(titleHtml);
                data.songRequests.forEach(function(songRequest, index) {
                    renderSongRequest(songRequest, index);
                });
            });

            // Function to fetch song requests from the server
            function getSongRequests() {
                $.ajax({
                    url: "{{ route('all-event.event-all-song-get', $event->id) }}",
                    method: "GET",
                    success: function(response) {
                        if (response.songRequests && response.songRequests.length > 0) {
                            $('#song-container').empty();
                            let titleHtml = `
                                <h3 class='title'>
                                    Gozadera Livechat - Song Request
                                    <br>
                                    <span>"{{ $event->name }}"</span>
                                </h3>
                                <input class='toggle' id='toggle' type='checkbox'>
                                <label class='btn-toggle' for='toggle'>
                                    Toggle
                                </label>
                            `;
                            $('#song-container').append(titleHtml);
                            response.songRequests.forEach(function(songRequest, index) {
                                renderSongRequest(songRequest, index);
                            });
                        }
                    },
                    error: function() {
                        console.error("Failed to fetch song requests");
                    }
                });
            }


            // Function to render a song request dynamically
            function renderSongRequest(songRequest, index) {
                let maxLength = 23;
                let artist = songRequest.artist_name.length > maxLength ? songRequest.artist_name.substring(0, maxLength - 3) + '...' : songRequest.artist_name;
                let songTitle = songRequest.song_name.length > maxLength ? songRequest.song_name.substring(0, maxLength - 3) + '...' : songRequest.song_name;

                let songHtml = `
                    <input class='input' id='ch-${index}' name='ch-${index}' type='checkbox' ${songRequest.flag_done ? 'checked' : ''} onchange='updateFlagDone("${songRequest.id}", this.checked)'>
                    <label class='item' for='ch-${index}' style='--item: ${index}'>
                        <div class='item__content'>
                            <div class='pseudo-check'>
                                <div class='checkmark'>
                                    <div class='goo'></div>
                                </div>
                            </div>
                            <span class='item__text'>
                                <strong>${songRequest.sender_name}</strong>
                                <br>
                                <i>${artist} - ${songTitle}</i>
                            </span>
                             <div class="item__delete">
                                <button onclick="deleteItem(event)" data-id-song="${songRequest.id}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </label>
                `;
                $('#song-container').append(songHtml);
            }
        });
        
        function updateFlagDone(songId, isChecked) {
            const flagDone = isChecked ? 1 : 0;

            $.ajax({
                url: '/all-event/event/all-song-request/update_flag/' + songId, // Adjust the URL to match your route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    flag_done: flagDone
                },
                success: function(response) {
                    swal({
                        toast: true,
                        position: 'top-end',
                        type: 'success',
                        showConfirmButton: false,
                        showCloseButton: true,
                        title: 'Request status updated successfully'
                    });
                },
                error: function(error) {
                    swal({
                        toast: true,
                        position: 'top-end',
                        type: 'error',
                        showConfirmButton: false,
                        showCloseButton: true,
                        title: 'Request status updated unsuccessfully'
                    });
                }
            });
        }

    </script>
</body>
</html>