
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

    <title>SMP APP</title>

</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-7 login-form-section">
                <div class="card m-3">
                    <div class="card-body ">
                    <form role="form" class="pui-form" id="loginform" method="POST" action="{{ route('daftar') }}">
                        @csrf
                        <div class="header text-center pt-4">
                            @php
                                $websetting = App\Models\WebSetting::first();
                            @endphp

                            <img class="mt-4" src="{{ $websetting->websiteLogoPath ?? asset('web/logo.png') }}" alt="not found" height="75">

                            @error('error')
                                {{ $message }}
                            @enderror

                            <h3>Daftar Customer</h3>
                            <p>Silahkan lengkapi form berikut:</p>
                        </div>

                        @if (session('password'))
                            <div class="bg-danger p-2 mb-1">
                                <span style="color: #fff">{{ session('password') }}</span>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Kode Unik') }} </label>
                                <input type="text" class="form-control" name="kode_unik"
                                    value="{{ old('kode_unik') }}" placeholder="{{ __('Kode Unik') }}">
                                <span class="text-success">Dimana Saya Mendapatkan kode? <a href="#kode_unik" data-toggle="modal" class="text-danger">Klik disini </a></span>
                                @error('kode_unik')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Kode Customer') }} </label>
                                <input type="text" class="form-control" name="kode_customer"
                                    value="{{ old('kode_customer') }}" placeholder="{{ __('Kode Customer') }}">
                                <span class="text-success">Dimana Saya Mendapatkan kode? <a href="#kode_unik" data-toggle="modal" class="text-danger">Klik disini </a></span>
                                @error('kode_customer')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-12 mb-2">
                                <label for="">{{ __('Company') }} </label>
                                <input type="text" class="form-control" name="company"
                                    value="{{ old('company') }}" placeholder="{{ __('Company') }}">
                                @error('company')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('First_Name') }} <strong class="text-danger">*</strong></label>
                                <input required type="text" class="form-control" name="first_name"
                                    value="{{ old('first_name') }}" placeholder="{{ __('First_Name') }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Last_Name') }} <strong class="text-danger">*</strong></label>
                                <input required type="text" class="form-control" name="last_name"
                                    value="{{ old('last_name') }}" placeholder="{{ __('Last_Name') }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Mobile_number') }} <strong class="text-danger">*</strong></label>
                                <input required type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                    placeholder="{{ __('Mobile_number') }}">
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Email') }}</label>
                                <input required type="text" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="{{ __('Email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Password') }} <strong class="text-danger">*</strong></label>
                                <div class="d-flex  align-items-center inputBox">
                                    <div class="input w-100 position-relative">
                                        <input required type="password" id="password" class="form-control" name="password"
                                            placeholder="******">
                                        <span class="eye" onclick="myFunction()">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Confirm_Password') }}</label>
                                <div class="d-flex  align-items-center inputBox">
                                    <div class="input w-100 position-relative">
                                        <input required type="password" class="form-control" name="password_confirmation"
                                            placeholder="******" id="confirmPassword">
                                        <span class="eye" onclick="confirmPassword()">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-12 col-md-6 mb-2 py-2">
                                <label for="">{{ __('Profile_Photo') }}</label>
                                <input type="file" class="form-control-file" name="profile_photo">
                            </div> -->

                        </div>

                        <button class="btn btn-danger w-100 mt-2  text-white">{{ __('Daftar') }}</button>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <a class="setVisitorBtn" href="{{ route('login') }}">
                                    Kembali
                                </a>
                            </div>
                        </div>

                    </form>

                    </div>
                </div>

            </div>

            <!-- <div class="col-12 col-md-6 d-none d-md-block"
                style="background: url({{ asset('web/bg/login.jpg') }});overflow: hidden;
            background-size: cover;
            background-position: center;">
            </div> -->
        </div>
    </div>



<!-- Modal -->
<div class="modal fade" id="kode_unik">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Support Admin </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h2> Silahkan Hubungi Admin untuk mendapatkan kode unik <br>
                    Hubungi Wa: +628XXXX <br>
                    <a href=""> Klik Disini Hubungi WA Admin</a>
                </h2>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('web/js/jquery.min.js') }}"></script>

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


    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function confirmPassword() {
        var x = document.getElementById("confirmPassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>




</body>

</html>

