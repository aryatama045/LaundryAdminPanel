@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        <h2 class="float-left">{{ __('Edit'). ' '. __('Customer') }}</h2>
                        <div class="text-right">
                            <a class="btn btn-light" href="{{ route('customer.index') }}"> {{ __('Back') }} </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form @role('root|admin') @can('customer.update') action="{{ route('customer.update', $customer->id) }}" @endcan @endrole method="POST" enctype="multipart/form-data"> @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <label for="">{{ __('Company') }} </label>
                                <input type="text" class="form-control" name="company"
                                    value="{{ old('company') ?? $customer->user->company }}" placeholder="{{ __('Company') }}">
                                @error('company')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('First_Name') }} <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ?? $customer->user->first_name }}" placeholder="First name">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Last_Name') }} <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ?? $customer->user->last_name }}" placeholder="Last name">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Mobile_number') }} <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') ?? $customer->user->mobile}}" placeholder="Mobile">
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Email') }}</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') ?? $customer->user->email }}" placeholder="Email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if (request()->routeIs('customer.create'))
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Password') }} <strong class="text-danger">*</strong></label>
                                <input type="password" class="form-control" name="password" placeholder="******">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Confirm_Password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="******">
                            </div>
                            @endif
                            <div class="col-12 col-md-6 mb-2 py-2">
                                <label for="">{{ __('Profile_Photo') }}</label>
                                <input type="file" class="form-control-file" name="profile_photo">
                            </div>
                            @can('customer.update')
                            <div class="col-12 col-md-6 mb-2 py-2">
                                <label for=""></label>
                                <button class="btn btn-primary w-100 mt-2 @role('visitor') visitorMessage @endrole">{{ __('Submit') }}</button>
                            </div>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
