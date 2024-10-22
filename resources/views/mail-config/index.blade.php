@extends('layouts.app')
@section('content')
    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-xl-8 col-lg-9 mt-2 mx-auto ">
                <form action="{{ route('mail-config.update') }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="m-0">{{ __('Mail Configuration') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="m-0">{{ __('Mail Mailer') }}</label>
                                    <x-input :value="config('app.mail_mailer')" name="mailer" type="text"
                                        placeholder="smtp" />
                                </div>
                                <div class="col-lg-6">
                                    <label class="m-0">{{ __('Mail Host') }}</label>
                                    <x-input :value="config('app.mail_host')" name="host" type="text" placeholder="ex: smtp.gmail.com"/>
                                </div>
                                <div class="col-lg-6">
                                    <label class="m-0">{{ __('Mail Port') }}</label>
                                    <x-input :value="config('app.mail_port')" name="port" type="text" placeholder="ex: 465 "/>
                                </div>
                                <div class="col-md-6">
                                    <label class="m-0">{{ __('Mail User Name') }}</label>
                                    <x-input :value="config('app.mail_username')" name="username" type="text" placeholder="ex: example@gmail.com"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="m-0">{{ __('Mail Password') }}</label>
                                    <x-input :value="config('app.mail_password')" name="password" type="text" placeholder="Your app password"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="m-0">{{ __('Mail Encryption') }}</label>
                                    <x-input :value="config('app.mail_encryption')" name="encryption" type="text" placeholder="tls or ssl "/>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="m-0">{{ __('Mail From Address') }}</label>
                                    <x-input :value="config('app.mail_from_address')" name="from_address" type="text" placeholder="from email address" required />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .infoBtn {
            border: none;
            width: 20px;
            height: 20px;
            border-radius: 100%;
            font-size: 12px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
    </style>
@endsection
