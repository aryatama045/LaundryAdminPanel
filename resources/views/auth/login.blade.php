
@php

$server  = request()->server('HTTP_SEC_CH_UA_PLATFORM');
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fav icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('web/favIcon.png') }}">
    <!-- custome css -->
    <link rel="stylesheet" href="{{ asset('web/css/login.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.css') }}">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('web/css/toastr.min.css') }}" type="text/css">
    <title>SMP APP</title>

</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-6 login-form-section">
                <div class="login">
                    <form role="form" class="pui-form" id="loginform" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="header text-center">
                            @php
                                $websetting = App\Models\WebSetting::first();
                            @endphp
                            <img src="{{ $websetting->websiteLogoPath ?? asset('web/logo.png') }}" alt="not found"
                                height="75">

                            @error('error')
                                {{ $message }}
                            @enderror


                            <h3>Login</h3>
                            <p>This is a secure system and you will need to provide tour login detalis to access the
                                site</p>

                        </div>

                        @if (session('password'))
                            <div class="bg-danger p-2 mb-1">
                                <span style="color: #fff">{{ session('password') }}</span>
                            </div>
                        @endif

                        <div class="inputBox">
                            <input type="text" id="email" name="email"
                                class="form-control inputfield @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="Email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="inputBox">
                            <div class="input w-100 position-relative">
                                <input type="password" id="password" name="password"
                                    class="form-control inputfield @error('password') is-invalid @enderror"
                                    placeholder="Password">
                                <span class="eye" onclick="showHidePassword()">
                                    <i class="fas fa-eye-slash fa-eye" id="togglePassword"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger text-white w-100">Login</button>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <a class="setVisitorBtn" href="{{ route('lupa_password') }}">
                                    Lupa Password
                                </a>
                            </div>

                            <div class="col-6 d-flex justify-content-end">
                                <a class="setVisitorBtn " href="{{ route('daftar') }}">
                                    Daftar
                                </a>
                            </div>

                        </div>

                    </form>
                </div>

            </div>

            <!-- <div class="col-12 col-md-6 d-none d-md-block"
                style="background: url({{ asset('web/bg/login.jpg') }});overflow: hidden;
            background-size: cover;
            background-position: center;">
            </div> -->
        </div>
    </div>

    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web/js/popper.js') }}"></script>
    <script src="{{ asset('web/js/sweet-alert.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/toastr.min.js') }}"></script>
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
    <script>
         function showHidePassword() {
            const toggle = document.getElementById("togglePassword");
            const password = document.getElementById("password");

            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // toggle the icon
            toggle.classList.toggle("fa-eye-slash");
        }

        const setVisitorCredential = function() {
            var password = document.getElementById("password");
            var email = document.getElementById("email");

            email.value = 'visitor@laundry.com';
            password.value = 'secret@123';
        }
    </script>

</body>

</html>

