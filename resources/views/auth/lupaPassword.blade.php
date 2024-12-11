
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
                    <form role="form" class="pui-form" id="loginform" method="POST" action="{{ route('lupa_password_action') }}">
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

                            <h3>Forgot Password</h3>
                            <p>This is a secure system and you will need to provide tour login detalis to access the
                                site</p>
                        </div>
                        <div class="inputBox">
                            <input type="text" id="email" name="email"
                                class="form-control inputfield @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="Email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger text-white w-100">Send Forgot Password</button>

                    </form>

                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <a class="setVisitorBtn" href="{{ route('login') }}">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>




    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web/js/popper.js') }}"></script>
    <script src="{{ asset('web/js/sweet-alert.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
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

    @stack('scripts')

</body>

</html>

