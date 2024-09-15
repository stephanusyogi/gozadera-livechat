<!DOCTYPE html>
<html lang="en">
    @include('partials.header')

    @stack('custom_css')

    {{-- <body class="{{ session('color_mode', 'light') == 'dark' ? 'dark-mode' : 'bg-light' }}"> --}}
    <body class="dark-mode">
        
        <!-- Preloader -->
        <div id="preloader">
            <div class="preloader-inner">
                <div class="spinner"></div>
                <div class="logo"><img src="{{ asset('images/logo_img_text_bottom.png') }}" alt="img"></div>
            </div>
        </div>

        @include('partials.navbar')

        @include('partials.sidebar')

        @yield('main')
        
        @include('partials.js')
        
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
            // Color Switcher
            // var colorSwitcher = false;
            // $("#colorSwitch, #colorSwitch2, #colorSwitch3, #colorSwitch4").on(
            //     "change",
            //     function () {
            //         if ($(this).is(":checked")) {
            //             colorSwitcher = $(this).is(":checked");
            //             $("body").addClass("dark-mode");
            //             $("body").removeClass("bg-light");
            //             saveColorModeToSession("dark"); // Save dark mode to session
            //         } else {
            //             colorSwitcher = $(this).is(":checked");
            //             $("body").addClass("bg-light");
            //             $("body").removeClass("dark-mode");
            //             saveColorModeToSession("light"); // Save light mode to session
            //         }
            //     }
            // );

            // function saveColorModeToSession(mode) {
            //     $.ajax({
            //         url: "/save-color-mode",
            //         type: "POST",
            //         data: {
            //             mode: mode,
            //             _token: "{{ csrf_token() }}", // Directly embed CSRF token
            //         },
            //         success: function (response) {
            //             console.log("Color mode saved: " + response);
            //         },
            //         error: function () {
            //             console.log("Error saving color mode.");
            //         },
            //     });
            // }
        </script>
    </body>

</html>