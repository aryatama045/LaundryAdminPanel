@extends('layouts.app')

@section('content')
    <div class="mt-3 container-fluid">
        <div class="row">
            <div class="col-md-8 m-auto">
                <div class="card">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="card-header py-2">
                        <h3 class="m-0">{{ __('Edit').' '. __('Profile') }}</h3>
                    </div>
                    <form  action="{{ route('profile.update') }}"  method="POST"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Company Name') }}</label>
                                        <input class="form-control" type="text" name="first_name"
                                            value="{{ $user->company }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('First_Name') }}</label>
                                        <input class="form-control" type="text" name="first_name"
                                            value="{{ $user->first_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Last_Name') }}</label>
                                        <input class="form-control" type="text" name="last_name"
                                            value="{{ $user->last_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Email_Address') }}</label>
                                        <input class="form-control" type="text" name="email"
                                            value="{{ $user->email }}" @role('root') readonly @endrole>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Mobile_number') }}</label>
                                        <input class="form-control" type="number" name="mobile"
                                            value="{{ $user->mobile }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Profile_Photo') }}</label>
                                        <input class="form-control-file" type="file" name="profile_photo">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('profile.index') }}" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                            </a>
                            <button class="btn btn-primary " type="submit">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
