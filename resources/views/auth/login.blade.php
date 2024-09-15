<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Meta Tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="description" content="Gozadera Indonesia Livechat">

        <!-- Favicon and touch Icons -->
        <link href="{{ asset('images/logo_img_text_bottom.png') }}" rel="shortcut icon" type="image/png">

        <!-- Page Title -->
        <title>Gozadera - Livechat</title>
        
        <!-- Styles Include -->
        <link rel="stylesheet" href="{{ asset('templates/assets/css/main.css') }}" id="stylesheet">
        
    </head>

        <style>
            #video-background {
                position: fixed;
                top: 0;
                left: 0;
                min-width: 100%;
                min-height: 100%;
                width: auto;
                height: auto;
                z-index: -1;
                background-size: cover;
                object-fit: cover;
                overflow: hidden;
            }

            .bg-video .vh-100, .bg-video #preloader, bg-video .login-form {
                position: relative;
                z-index: 1;
            }

            .card-form{
                background-color: rgb(12 11 11 / 82%)!important;
            }

        </style>

    <body class="bg-video" style="background-image: url('{{ asset('images/auth-bg.jpg') }}');background-size: cover;background-position: bottom;">
        {{-- <video autoplay playsinline muted loop id="video-background">
            <source src="https://videos.pexels.com/video-files/2022396/2022396-hd_1920_1080_30fps.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video> --}}
        <!-- Preloader -->
        <div id="preloader">
            <div class="preloader-inner">
                <div class="spinner"></div>
                <div class="logo"><img src="{{ asset('images/logo.jpg') }}" alt="img"></div>

            </div>
        </div>
        
        <!-- Login Form -->
        <div class="login-form row align-items-center justify-content-center vh-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6">
                <div class="card-form card rounded-2 border-0 p-5 m-0">

                    <div class="card-header border-0 p-0 text-center">
                        <a href="#" class="w-100 d-inline-block mb-5">
                            <img src="{{ asset('images/logo-transparent.png') }}" alt="img">
                            <h1 style="letter-spacing: 5px;color:#c88600;">Gozadera</h1>
                        </a>
                        <p class="fs-14 text-white my-4">Welcome back, Please login using your account.</p>
                    </div>

                    <div class="card-body p-0">
                        @error('auth')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <form class="form-horizontal" method="POST" action="{{ route('auth.action') }}" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control @if ($errors->has('username')) is-invalid text-danger @elseif(old('username') && !$errors->has('username')) is-valid text-success @endif" value="{{ old('username') }}" name="username" value="" placeholder="Username" required>
                                @error('username')
                                    <small class="mt-2 text-danger float-start">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
            
                            <div class="form-group">
                                <input type="password" class="form-control @if ($errors->has('pass')) is-invalid text-danger @elseif(old('pass') && !$errors->has('pass')) is-valid text-success @endif" value="{{ old('pass') }}" name="pass" value="" placeholder="Password" required>
                                @error('pass')
                                    <small class="mt-2 text-danger float-start">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
            
                            <button type="submit" class="btn btn-dark w-100 text-uppercase text-white rounded-2 lh-34 ff-heading fw-bold shadow">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Core JS -->
        <script src="{{ asset('templates/assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('templates/assets/js/bootstrap.bundle.min.js') }}"></script>

        <!-- jQuery UI Kit -->
        <script src="{{ asset('templates/plugins/jquery_ui/jquery-ui.1.12.1.min.js') }}"></script>
        
        <!-- ApexChart -->
        
        
        <!-- Peity  -->
        <script src="{{ asset('templates/plugins/peity/jquery.peity.min.js') }}"></script>
        <script src="{{ asset('templates/plugins/peity/piety-init.js') }}"></script>

        <!-- Select 2 -->
        <script src="{{ asset('templates/plugins/select2/js/select2.min.js') }}"></script>

        <!-- Datatables -->
        <script src="{{ asset('templates/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('templates/plugins/datatables/js/datatables.init.js') }}"></script>
        
        

        <!-- Date Picker -->
        <script src="{{ asset('templates/plugins/flatpickr/flatpickr.min.js') }}"></script>

        <!-- Dropzone -->
        <script src="{{ asset('templates/plugins/dropzone/dropzone.min.js') }}"></script>
        <script src="{{ asset('templates/plugins/dropzone/dropzone_custom.js') }}"></script>
        
        <!-- TinyMCE -->
        <script src="{{ asset('templates/plugins/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('templates/plugins/prism/prism.js') }}"></script>
        <script src="{{ asset('templates/plugins/jquery-repeater/jquery.repeater.js') }}"></script>

        

        

        <!-- Sweet Alert -->
        <script src="{{ asset('templates/plugins/sweetalert/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('templates/plugins/sweetalert/sweetalert2-init.js') }}"></script>
        <script src="{{ asset('templates/plugins/nicescroll/jquery.nicescroll.min.js') }}"></script>

        <!-- Snippets JS -->
        <script src="{{ asset('templates/assets/js/snippets.js') }}"></script>

        <!-- Theme Custom JS -->
        <script src="{{ asset('templates/assets/js/theme.js') }}"></script>
        
        <script>
            $(document).ready(function() {
                @if (session('success_flash'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        type: 'success',
                        showConfirmButton: false,
                        showCloseButton: true,
                        title: '{{ session('success_flash') }}'
                    });
                @endif
                @if (session('error_flash'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        type: 'error',
                        showConfirmButton: false,
                        showCloseButton: true,
                        title: '{{ session('error_flash') }}'
                    });
                @endif
            });
        </script>
    </body>
</html>