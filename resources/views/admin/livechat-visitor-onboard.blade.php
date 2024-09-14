<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gozadera - Livechat</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>

    <link rel="shortcut icon" href="{{ asset('images/logo-transparent.png') }}" />
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('templates/plugins/sweetalert/sweetalert2.min.js') }}"></script>
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;	
        font-family: Raleway, sans-serif;
    }

    body {
        background: linear-gradient(185deg, #c78500, #000);
    }

    .container {
        min-height: 100vh;
    }

    .screen {
        margin-left: auto;
        margin-right: auto;
        margin-top: 2rem;
        background: linear-gradient(90deg, #bb933f, #8f6000);
        position: relative;	
        height: 600px;
        width: 360px;	
        box-shadow: 0px 0px 24px #59503d;
    }

    .screen__content {
        z-index: 1;
        position: relative;	
        height: 100%;
    }

    .screen__background {	
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);	
        overflow: hidden;
    }

    .screen__background__shape {
        transform: rotate(45deg);
        position: absolute;
    }

    .screen__background__shape1 {
        height: 520px;
        width: 520px;
        background: #614406;	
        top: -50px;
        right: 120px;	
        border-radius: 0 72px 0 0;
    }

    .screen__background__shape2 {
        height: 220px;
        width: 220px;
        background: #8f6000;	
        top: -172px;
        right: 0;	
        border-radius: 32px;
    }

    .screen__background__shape3 {
        height: 540px;
        width: 190px;
        background: linear-gradient(270deg, #8f6000, #8f6000);
        top: -24px;
        right: 0;	
        border-radius: 32px;
    }

    .screen__background__shape4 {
        height: 400px;
        width: 200px;
        background: #8f6000;	
        top: 420px;
        right: 50px;	
        border-radius: 60px;
    }

    .login {
        width: 320px;
        padding: 30px;
        padding-top: 156px;
    }

    .login__field {
        padding: 20px 0px;	
        position: relative;	
    }

    .login__icon {
        position: absolute;
        top: 30px;
        color: #c88600;
    }

    .login__input {
        border: none;
        border-bottom: 2px solid #c88600;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 90%;
        transition: .2s;
        color: #fff;
    }

    .login__input:active,
    .login__input:focus,
    .login__input:hover {
        outline: none;
        border-bottom-color: #c88600;
    }

    .login__submit {
        background: #000000b5;
        font-size: 14px;
        margin-top: 30px;
        padding: 10px 20px;
        border-radius: 26px;
        border: 1px solid #6d6d6f;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 100%;
        color: #c88600;
        box-shadow: 0px 2px 2px #c88600;
        cursor: pointer;
        transition: .2s;
    }

    .login__submit:active,
    .login__submit:focus,
    .login__submit:hover {
        border-color: #c88600;
        outline: none;
    }

    .button__icon {
        font-size: 15px;
        margin-left: auto;
        color: #c88600;
    }

    .social-login {	
        position: absolute;
        height: 140px;
        width: 160px;
        text-align: center;
        bottom: 20px;
        right: 0px;
        color: #fff;
    }

    .social-icons {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-login__icon {
        padding: 20px 10px;
        color: #000;
        text-decoration: none;	
        text-shadow: 0px 0px 8px #464646;
    }

    .social-login__icon:hover {
        transform: scale(1.5);	
    }

    .text-danger{
        color: red;
    }
     /* Media Queries for Responsiveness */
     @media (max-width: 500px) {
        .login__input, .login__submit, .social-login{
            font-size: 10px;
        }

        .login__submit{
            width: 50%;
            padding: 5px 10px;
        }

        .login{
            width: 100%;
        }

        .login__input{
            width: 65%;
        }

        .button__icon{
            font-size: 10px;
        }

        .screen{
            height: 450px;
            width: 100%;
        }

        .social-login{
            width: 105px;
        }
    }
</style>
<body>
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form class="login" method="post" action="{{ route('all-event.livechat-visitor-onboard-action' , $event->id) }}" autocomplete="off">
                    @csrf
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="email" class="login__input" name="email" placeholder="Input your email">
                        @error('email')
                            <small class="mt-2 text-danger float-start">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    @if ($event->flag_table_security)
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input type="password" class="login__input" name="table" placeholder="Input your table code">
                            @error('table')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    @endif
                    <button class="button login__submit">
                        <span class="button__text">Start Livechat</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                </form>
                <div class="social-login">
                    <img src="https://gozaderaindonesia-livechat.my.id/images/logo-transparent.png" style="width: 30%;">
                    <h3 style="color: #000">Gozadera Indonesia</h3>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/gozadera.id/"target="_blank"><i class="social-login__icon fab fa-instagram" ></i></a>
                        <a href="https://www.tiktok.com/@gozaderaid" target="_blank"><i class="social-login__icon fa-brands fa-tiktok"></i></a>
                        <a href="https://maps.app.goo.gl/MSTJ9DRuUCh9PtQp6" target="_blank"><i class="social-login__icon fa fa-map"></i></a>
                    </div>
                </div>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
    
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
</body>
</html>