@extends('layouts.app')

@section('content')
    <div class="mt-3 container-fluid">
        <div class="row d-flex align-items-center" style="min-height: 80vh">
            <div class="col-md-8 m-auto">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $user->profile_photo_path }}" width="130">

                            <div class="mt-3">

                                <!-- <button class="btn btn-primary" disabled>{{ __('Change_Password') }}</button> -->

                                <a href="{{ route('profile.change-password') }}" class="btn btn-primary">{{ __('Change_Password') }}</a>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('profile.edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                            </div>
                            <div>
                                <h3>{{ $user->name }}</h3>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
