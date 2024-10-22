@extends('layouts.app')
@section('content')
    <div class="mt-3 container-fluid">
        <div class="row d-flex align-items-center" style="min-height: 80vh">
            <div class="col-md-8 m-auto">
                <form action="{{ route('profile.change-password') }}" method="POST">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary py-2">
                            <h3 class="m-0 text-white">{{ __('Change_Password') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="mb-0">{{ __('Current_Password') }}</label>
                                <input type="text" name="current_password" placeholder="{{ __('Current_Password') }}"
                                    class="form-control" value="{{ old('current_password') }}">
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-0">{{ __('New_Password') }}</label>
                                <input type="text" name="password" placeholder="{{ __('New_Password') }}" class="form-control" value="{{ old('password') }}">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label class="mb-0">{{ __('Confirm_Password') }}</label>
                                <input type="text" name="password_confirmation" placeholder="{{ __('Confirm_Password') }}" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between py-2">
                            <a href="{{ route('profile.index') }}" class="btn btn-danger">
                               <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                            </a>
                            <button class="btn btn-primary @role('visitor') visitorMessage @endrole">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
