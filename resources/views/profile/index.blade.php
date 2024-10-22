@extends('layouts.app')

@section('content')
    <div class="mt-3 container-fluid">
        <div class="row d-flex align-items-center" style="min-height: 80vh">
            <div class="col-md-8 m-auto">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $user->profile_photo_path }}" width="130">
                            @can('profile.change-password')
                            <div class="mt-3">
                                @role('root')
                                    <button class="btn btn-primary" disabled>{{ __('Change_Password') }}</button>
                                @else
                                <a href="{{ route('profile.change-password') }}" class="btn btn-primary">{{ __('Change_Password') }}</a>
                                @endrole
                            </div>
                            @endcan
                        </div>
                        <div class="col-md-8">
                            @can('profile.edit')
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('profile.edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                            </div>
                            @endcan
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
